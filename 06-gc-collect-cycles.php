<?php

include './utils.php';

class Person {
  public $child;
  public $parent;
  public $data;
  public function __construct() {
    $this->data = range(1, 1000);
  }
}

/**
 * Call the familyTree function 10,000 times, reporting the current memory usage
 * after each 100 iterations. Each times the function is called, more memory is
 * leaked due to the circular reference issue.
 *
 * PHP tracks referenced objects in a buffer. When 5k items are added to this
 * buffer, PHP will pause all execution and clean up any circular references.
 * This is why we see memory decrease at iterations 2.5k, 5k, and 7.5k. We also
 * see the program literally pause while this is happening.
 */
for ($i=0; $i < 100; $i++) {
  echo "At iteration: " . $i * 100 . " ";
  getMemoryUsage();
  for ($j=0; $j < 100; $j++) {
    familyTree();
  }
}

/**
 * Example circular reference function.
 *
 * Create two objects with references to each other. This will create a memory
 * leak when the function ends as the ref count for the objects never hits zero.
 */
function familyTree() {
  $jim = new Person();
  $gwen = new Person();
  $jim->child = $gwen;
  $gwen->parent = $jim;
}
