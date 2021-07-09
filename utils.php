<?php

// xdebug_debug_zval('node');

function getPeakMemory() {
  echo 'Peak usage: ' . convert(memory_get_peak_usage()) . ".\n";
}

function getMemoryUsage() {
  echo "Usage: " . convert(memory_get_usage()) . "\n";
}

function convert($size) {
  $unit=array('b','kb','mb','gb','tb','pb');
  return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}
