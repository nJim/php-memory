<?php

include './utils.php';

$colors = generateColorArray();   // 92mb usage to build colors array.
// unsetNonGreen($colors);        // 184mb peak usage (2x)
// loopAndCount($colors);         // 92mb peak usage (1x)
// foreachUnsetCount($colors);    // 276mb peak usage (3x)
// nativeCount($colors);          // 92mb peak usage (1x)
// arrayFilterCount($colors);     // 156 peak usage (1.6x)
// arrayDiffCount($colors);       // 191mb peak usage (2.1x)
getPeakMemory();

// 184mb peak usage (2x)
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

// 92mb peak usage (1x)
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

// 276mb peak usage (3x)
function foreachUnsetCount($data) {
  foreach ($data as $k => $color) {
    if ($data[$k] == 'green') {
      unset($data[$k]);
    }
  }
  return count($data);
}

// 92mb usage to build colors array.
function nativeCount($data) {
  $counts = array_count_values($data);
  unset($counts['green']);
  return array_sum($counts);
}

// 156.08 mb.
function arrayFilterCount($data) {
  $items = array_filter($data, function ($color) {
    return $color != 'green';
  });
  return count($items);
}

// 191mb peak usage (2.1x)
function arrayDiffCount($data) {
  return count(array_diff($data, ['green']));
}

// Creates a long array of primary colors in random order.
function generateColorArray() {
  $length = 1000000;
  $colors = ['red', 'yellow', 'green'];
  $arr = [];
  for ($i = 0; $i < $length; $i++) {
    $arr[] = $colors[array_rand($colors)];
  }
  return $arr;
}
