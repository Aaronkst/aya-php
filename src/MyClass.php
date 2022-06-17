<?php

namespace Aaron\FirstComposerPackage;

class MyClass {
  public $variable;

  public function setVar($val): bool 
  {
    $this->variable = $val;
    return true;
  }

  public function getVar(): string 
  {
    return $this->variable;
  }
}