<?php

// After leaving function, the refcount for the $list variable decreases by 1 to
// have a refcount=0. At this point, the garbage collector takes over and
// deallocates the unused memory.

echo "Initial usage: " . round(memory_get_usage()/1024,2) . " kb\n";
dataParty();
echo "Ending usage: " . round(memory_get_usage()/1024,2) . " kb\n";

function dataParty() {
  $list = range(0, 100000);
  echo "Usage within function: " . round(memory_get_usage()/1024,2) . " kb\n";
}
