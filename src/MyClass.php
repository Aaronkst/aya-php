<?php

namespace Aaron\FirstComposerPackage;

class MyClass 
{
  public readonly string $key;
  public readonly string $secret;
  public readonly string $phone;
  public readonly string $password;
  private readonly string $prefix;
  private readonly string $base;
  private readonly boolean $production;
  private readonly string $decryptKey;
  private string $accesstoken;
  private string $usertoken;

  public function _construct(string $key, string $secret, string $phone, string $password, boolean $production = false, string $decryptKey)
  {
    $this->key = $key;
    $this->secret = $secret;
    $this->phone = $phone;
    $this->password = $password;
    $this->prefix = $production ? implode("", ["/merchant","/1.0.0"]) : implode("", ["/om","/1.0.0"]);
    $this->base = $production ? implode(".", ["api","ayapay","com"]) : implode(".", ["opensandbox","ayainnovation","com"]);
    $this->production = $production;
    $this->decryptKey = $decryptKey;
  }

  public function getKey()
  {
    $data: array = array("grant_type"=>"client_credentials");
    $base: string = "https://opensandbox.ayainnovation.com";
    $path: string = "/token";
    $headers: array = array(
      "Authorization"=>"Basic WUc0WktjN1hXYjVDS0xPZUg4VGVRQjJLVVdRYTp0emtaT1J0X3hRb2FFOWNhVnhMbHRUOWt4SDhh",
      "Content-Type"=>"application/x-www-form-urlencoded"
    );
    $relt = api($data, $base, $path, $headers);
    return $relt;
  }
}

function api(array $payload, string $base, string $path, array $headers): array 
{
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_URL, $base . $path);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
  curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

  print_r(http_build_query($payload));

  $response = curl_exec($ch);

  $err = curl_error($ch);
  curl_close($ch);
  if ($err) {
    throw $err;
  } else {
    return $response;
  }
}