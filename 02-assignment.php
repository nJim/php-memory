<?php

/**
 * Variable assignment
 *
 * PHP will assign values to many variables with a reference. This allows
 * multiple variables to share a space in memory; however these are not actually
 * referenced variables. When a value changes, PHP will create a copy in memory
 * to track the now-divergent values; a process called called copy-on-write.
 *
 * The example below illustrates reference counting using strings. In PHP 7
 * static strings and immutable arrays are stored as interned values and are
 * more performant. The lesson below is still valid even though the simple
 * example produces different results in PHP 7.
 */

// Variable assignment.
echo "Creating variable through simple assignment.\n";
$a = 'Time';  // Create a variable $a.
$b = $a;      // Assignment shares memory value in memory, refcount++
$c = $b;      // Assignment shares memory value in memory, refcount++

xdebug_debug_zval('a', 'b', 'c');

// Altering one of the variables.
echo "\n\nChanging on of the variables will copy the value on write.\n";
$b = 'Space';

xdebug_debug_zval('a', 'b', 'c');
