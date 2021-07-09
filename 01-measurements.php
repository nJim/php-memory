<?php

/*
 * Measuring Memory Usage
 *
 * PHP includes two functions for checking memory usages without the use of
 * profiling tools or testing environments. These tools do not provide a high
 * level of fidelity in measurement and may be report inconsistent values; but
 * it's still a great way to get a sense of the current state of your script.
 *
 * memory_get_usage(bool $real_usage = false): int
 *   Returns the amount of memory, in bytes, that's currently being allocated.
 *   https://www.php.net/manual/en/function.memory-get-usage.php
 *
 * memory_get_peak_usage(bool $real_usage = false): int
 *   Returns the peak of memory, in bytes, that's been allocated to your script.
 *   https://www.php.net/manual/en/function.memory-get-peak-usage.php
 */

// Get initial memory usage.
echo "Initial usage: " . round(memory_get_usage()/1024,2) . " kb\n";

// Allocate some memory.
$list = range(0, 100000);
echo "After creating list: " . round(memory_get_usage()/1024,2) . " kb\n";

// Deallocate memory.
unset($list);
echo "After un-setting list: " . round(memory_get_usage()/1024,2) . " kb\n";

// Report peak usage.
echo "Peak usage: " . round(memory_get_peak_usage()/1024,2) . " kb\n";
