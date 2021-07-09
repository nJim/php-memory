<?php

/**
 * Variables by reference
 *
 * A PHP reference is an alias, which allows two different variables to write to
 * the same value. This concept is similar to pointers in low level languages,
 * although PHP ZVALS add additional abstraction to referencing values.
 */

echo "Creating variable by reference.\n";
$a = 'Time';
$b = &$a;
$c = &$b;

xdebug_debug_zval('a', 'b', 'c');

echo "\n\nChanging one of the values alters all values.\n";
$b = 'Space';

xdebug_debug_zval('a', 'b', 'c');
