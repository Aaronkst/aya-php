<?php

namespace Aaron\FirstComposerPackage;

use PHPUnit\Framework\TestCase;

final class ClassTest extends TestCase
{
  public function testMyClass()
  {
      $obj = new MyClass("YG4ZKc7XWb5CKLOeH8TeQB2KUWQa", "tzkZORt_xQoaE9caVxLltT9kxH8a", "09250154050", "hehe", false, "decryptkey");

      $api = $obj->getKey();
      $this->assertNotNull($api);
  }
}