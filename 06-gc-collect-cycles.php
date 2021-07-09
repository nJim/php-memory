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

for ($i=0; $i < 100; $i++) {
  echo "At iteration: " . $i * 100 . " ";
  getMemoryUsage();
  for ($j=0; $j < 100; $j++) {
    familyTree();
  }
}

function familyTree() {
  $jim = new Person();
  $gwen = new Person();
  $jim->child = $gwen;
  $gwen->parent = $jim;
}
