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

  public function getKey(): string
  {
    $data = array("grant_type"=>"client_credentials");
    $base = "https://opensandbox.ayainnovation.com";
    $path = "/token";
    $headers = array(
      "Authorization"=>"Basic WUc0WktjN1hXYjVDS0xPZUg4VGVRQjJLVVdRYTp0emtaT1J0X3hRb2FFOWNhVnhMbHRUOWt4SDhh",
      "Content-Type"=>"application/x-www-form-urlencoded"
    );
    $relt = api($data, $base, $path, $headers);
    return $relt;
  }
}

function api($payload, $base, $path, $headers) {
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_URL, $base . $path);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
  curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

  $response = curl_exec($ch);

  $err = curl_error($ch);
  curl_close($ch);
  if ($err) {
    throw $err;
  } else {
    return $response;
  }
}