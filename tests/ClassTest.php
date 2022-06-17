<?php

namespace Aaron\FirstComposerPackage;

use PHPUnit\Framework\TestCase;

final class ClassTest extends TestCase
{
  public function testMyClass()
  {
      $obj = new MyClass();
  
      $set = $obj->setVar("MyValue");
      $this->assertSame($set, true);

      $get = $obj->getVar();
      $this->assertSame($get, "MyValue");
  }
}