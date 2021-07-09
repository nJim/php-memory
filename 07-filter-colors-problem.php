<?php

include './utils.php';

/**
 * Memory usage for different counting approaches.
 *
 * generateColorArray();        // 92mb usage to build colors array.
 * unsetNonGreen($colors);      // 184mb peak usage (2x)
 * loopAndCount($colors);       // 92mb peak usage (1x)
 * foreachUnsetCount($colors);  // 276mb peak usage (3x)
 * nativeCount($colors);        // 92mb peak usage (1x)
 * arrayFilterCount($colors);   // 156 peak usage (1.6x)
 * arrayDiffCount($colors);     // 191mb peak usage (2.1x)
 */
$colors = generateColorArray();
// unsetNonGreen($colors);
// loopAndCount($colors);
// foreachUnsetCount($colors);
// nativeCount($colors);
// arrayFilterCount($colors);
// arrayDiffCount($colors);
getPeakMemory();

/**
 * Example 1: Unset green and count.
 *
 * For loop to unset all non-green elements in the colors array and count the
 * remaining items. This requires altering the $data item, so a second instance
 * of this value is stored in memory. See topics about copy-on-write.
 *
 * 184mb peak usage (2x)
 */
function unsetNonGreen($data) {
  $count = 0;
  $items = count($data);
  for ($i = 0; $i < $items; $i++) {
    if ($data[$i] == 'green') {
      unset($data[$i]);
    }
  }
  return $count;
}

/**
 * Example 2: Loop and count.
 *
 * Loop through the colors array and count all of the non-green items. This
 * approach does not change the values in $data, so it may continue to share
 * memory with the colors array. See topics about copy-on-write.
 *
 * 92mb peak usage (2x)
 */
function loopAndCount($data) {
  $count = 0;
  $items = count($data);
  for ($i = 0; $i < $items; $i++) {
    if ($data[$i] != 'green') {
      $count++;
    }
  }
  return $count;
}

/**
 * Example 3: Foreach be like what?
 *
 * This is the same approach as example 1, but employs a foreach instead of the
 * for-loop. This is creating yet another allocation for the colors data in
 * memory and results in triple the peak memory usage.
 *
 * 276mb peak usage (3x)
 */
function foreachUnsetCount($data) {
  foreach ($data as $k => $color) {
    if ($data[$k] == 'green') {
      unset($data[$k]);
    }
  }
  return count($data);
}

/**
 * Example 4: Native function array_count_values
 *
 * Native PHP functions are written in lower level languages and often often
 * more efficient since they can skip processes managed in the PHP interpreter.
 * But the filter and diff examples below also remind us that not all functions
 * are created equally and we need to understand what functions we are calling.
 *
 * 92mb peak usage (1x)
 */
function nativeCount($data) {
  $counts = array_count_values($data);
  unset($counts['green']);
  return array_sum($counts);
}

/**
 * Example 5: Native function array_filter
 *
 * 156mb peak usage (1.6x)
 */
function arrayFilterCount($data) {
  $items = array_filter($data, function ($color) {
    return $color != 'green';
  });
  return count($items);
}

/**
 * Example 6: Native function array_filter
 *
 * 191mb peak usage (2.1x)
 */
function arrayDiffCount($data) {
  return count(array_diff($data, ['green']));
}

/**
 * Creates a long array of primary colors in random order.
 *
 * 92mb usage to build colors array
 */
function generateColorArray() {
  $length = 1000000;
  $colors = ['red', 'yellow', 'green'];
  $arr = [];
  for ($i = 0; $i < $length; $i++) {
    $arr[] = $colors[array_rand($colors)];
  }
  return $arr;
}
