<?php

namespace Aaron\FirstComposerPackage;

use PHPUnit\Framework\TestCase;

final class ClassTest extends TestCase
{
  public function testMyClass()
  {
      $obj = new MyClass();

      $api = $obj->getKey();
      print_r("\n".$api);
  }
}