<?php

include './utils.php';

getMemoryUsage();
familyTree();
getMemoryUsage();

// Example 1: Circular reference keeps memory even out of scope.
// Allocated memory won't be free until end of script or until
class Person {
  public $child;
  public $parent;
  public $data;
  public function __construct() {
    $this->data = range(1, 10000);
  }
}

function familyTree() {
  $jim = new Person();
  $gwen = new Person();
  $jim->child = $gwen;
  $gwen->parent = $jim;
  getMemoryUsage();
}

// Fix 1: Create a dereferencing method
// class Person {
//   public $child;
//   public $parent;
//   public $data;
//   public function __construct() {
//     $this->data = range(1, 10000);
//   }
//   function __destruct() {
//     $this->child = NULL;
//     $this->parent = NULL;
//   }
// }

// Fix 2: Create a dereferencing method
// Some language use a programming construct of 'weak references' where the
// child reference does not protect the referenced object from garbage
// collection; but this feature doesn't exist in PHP although some have contrib:
// https://github.com/colder/php-weakref
