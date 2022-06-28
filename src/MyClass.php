<?php declare(strict_types=1);

namespace Aaron\FirstComposerPackage;

class MyClass 
{
  public string $key;
  public string $secret;
  public string $phone;
  public string $password;
  private string $prefix;
  private string $base;
  private bool $production;
  private string $decryptKey;
  private string $accesstoken;
  private string $usertoken;

  public function __construct(string $key, string $secret, string $phone, string $password, bool $production = false, string $decryptKey)
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

  public function getKey(): string
  {
    try {
      $base = "https://opensandbox.ayainnovation.com";
      $path = "/token";

      $data = array("grant_type"=>"client_credentials");

      $headers = array();
      $headers[] = "Authorization: Basic " . base64_encode("$this->key:$this->secret");

      $relt = api($data, $base, $path, $headers);
      return $relt->access_token;
    } catch ( Exception $e ) {
      print_r($e);
    }
  }
}

function api(array $payload, string $base, string $path, array $headers): object
{
  $ch = curl_init($base . $path);

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
  //curl_setopt($ch, CURLOPT_VERBOSE, true);

  $response = curl_exec($ch);

  $err = curl_error($ch);
  curl_close($ch);
  if ($err) {
    throw $err;
  } else {
    $response = json_decode($response);
    return $response;
  }
}