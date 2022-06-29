<?php

namespace Aaron\FirstComposerPackage;

use PHPUnit\Framework\TestCase;

final class ClassTest extends TestCase
{
  public function testMyClass()
  {
      $obj = new MyClass("YG4ZKc7XWb5CKLOeH8TeQB2KUWQa", "tzkZORt_xQoaE9caVxLltT9kxH8a", "09250154050", "054177", "SHEOYhNW1sLGPotkLiUL7661dyPj5FNN");

      $decrypt = $obj->decryptPayment("JhremAIziIGYOzz1Z4DQUk17ESvPwbUdHxVWWbdiuEvU8qghEtXcXNf0AWFOxM/rsvaxwylr4xMa/7s4pi0ko3YgSoOeZI3pGwzGsJml0rE8duSzWkaiAQQxEAKDFK4tpTVAQywsWVov+wtdKphVAuzfmwFalnLFdhRRD+m5tNohYVxQxWdGsJKfG7sSHUludDxKI4R0nXohxSL9mRCbQji/dhD47YAro5C2NOwaGUChRlzOhshTZKaV3z+0cr2e+LnlBVn0NWHTrZX3dcJHvYJt+bzFBnoBKPzrLcAoj7THUthMXDSP8qCpuoHSoA9I9azPwH01qJFlg5sGLwckOAG96sAKzMCLg6ZGPL8Lm5Qxz3QMzPvy2qVZmKF5DTgz1JbJ578LvnzsBACdzKUTaCHfRo06apMnDo9JPxNLiHNVDhKQyQXqwL+f9eWFVQKu1gmCDuu0+srgH2EWMp83JwA9qHIWH8WIDqNXuqrF5eAIO48X62BRQFjGtUDkoQFMHCtKBBEKmi+MSo/9ubTaAQZcRHlq6PIq9he8pE6P4zTXVVHqtJmRxXb7N1R5PRlhHRco2FrdRBUuQ5fic/Nel+aYv1cmZWzbYvdLwS63JfHxAXNXth9+8RxJF6PEg51rWcjiY1jyFcKCNK+KHAudC+nsqVNZNXaOoQo5JYH5dJLcEuwSTsfx2Mjy6G9+/2SfjFNhKx7YS7M0AN8ShFFqK75Z7TMvOIsfMqH9J1mm44rRRn8aEr5u03blgm/ALzwW8mjM4VClPHWxGzXQmdZuISeNu5ztiBXuXEQVtoYqycjyERjj/NEC/ecPBm0w1XQmU3ODn5OxKcs7Vk+ieXf1iw==");
      print_r("\nDecrypted Data\n\n");
      print_r($decrypt);
      $this->assertEquals($decrypt->transRefId, "62a6b7ba6ecc248dc619b7f7");

      $qr = $obj->createQR("1000", "MyQr", "PHP Package Test");
      print_r("\nQR Data\n\n");
      print_r($qr);
      $this->assertEquals($qr->err, 200);
  }
}