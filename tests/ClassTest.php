<?php

namespace Aaron\FirstComposerPackage;

use PHPUnit\Framework\TestCase;

final class ClassTest extends TestCase
{
  public function testMyClass()
  {
      $obj = new MyClass();
  
      $set = $obj->setVar("MyValue");
      print_r("\n".$set);
      $this->assertSame($set, true);

      $get = $obj->getVar();
      print_r("\n".$get);
      $this->assertSame($get, "MyValue");

      $api = $obj->getKey();
      print_r("\n".$api);
  }
}