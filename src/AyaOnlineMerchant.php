<?php declare(strict_types=1);

namespace Aya\OnlineMerchant;

function api(array $payload, string $base, string $path, array $headers): object
{
  $ch = curl_init("https://$base$path");

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
  //curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

  $response = curl_exec($ch);

  $err = curl_error($ch);
  curl_close($ch);
  if ($err) {
    throw $err;
  } else {
    $response = json_decode($response);
    if(isset($response->err) && $response->err !== 200) throw new \Exception($response->message);
    return $response;
  }
}

class AyaOnlineMerchant 
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

  public function __construct(string $key, string $secret, string $phone, string $password, string $decryptKey, bool $production = false)
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

  private function getAccessToken(): bool
  {
    try {
      $path = "/token";

      $data = array("grant_type"=>"client_credentials");

      $headers = array();
      $headers[] = "Authorization: Basic " . base64_encode("$this->key:$this->secret");

      $relt = api($data, $this->base, $path, $headers);
      $this->accesstoken = $relt->access_token;
      return TRUE;
    } catch ( Exception $e ) {
      print_r($e);
      throw $e;
    }
  }

  private function getUserToken(): bool
  {
    try {
      $token = $this->getAccessToken();
      if($token !== TRUE) throw new \Exception("Access Token Failure");
      $path = "$this->prefix/thirdparty/merchant/login";

      $data = array(
        "phone"=>$this->phone,
        "password"=>$this->password
      );

      $headers = array();
      $headers[] = "Token: Bearer $this->accesstoken";

      $relt = api($data, $this->base, $path, $headers);
      $this->usertoken = $relt->token->token;
      return TRUE;
    } catch ( Exception $e ) {
      print_r($e);
      throw $e;
    }
  }

  public function createTransaction(
    string $customerPhone, 
    string $amount, 
    string $externalTransactionId, 
    string $externalAdditionalData, 
    bool $v2 = false, 
    string $serviceCode = "", 
    int $timelimit = 0
  ): object
  {
    try {
      if($v2 && $serviceCode === "") throw new \Exception("Service Code required for V2 API");
      
      $token = $this->getUserToken();
      if($token !== TRUE) throw new \Exception("User Token Failure");
      
      $path = $v2 ? "$this->prefix/thirdparty/merchant/v2/requestPushPayment" : "$this->prefix/thirdparty/merchant/requestPayment";

      $data = array(
        "customerPhone"=>$customerPhone,
        "amount"=>$amount,
        "currency"=>"MMK",
        "externalTransactionId"=>$externalTransactionId,
        "externalAdditionalData"=>$externalAdditionalData,
        "serviceCode"=>$serviceCode,
        "timelimit"=>$timelimit ? $timelimit : ""
      );

      $headers = array();
      $headers[] = "Token: Bearer $this->accesstoken";
      $headers[] = "Authorization: Bearer $this->usertoken";

      $relt = api($data, $this->base, $path, $headers);
      return $relt;
    } catch ( Exception $e ) {
      print_r($e);
      throw $e;
    }
  }

  public function createQR(
    string $amount, 
    string $externalTransactionId, 
    string $externalAdditionalData, 
    bool $v2 = false, 
    string $serviceCode = "", 
    int $timelimit = 0
  ): object
  {
    try {
      if($v2 && $serviceCode === "") throw new \Exception("Service Code required for V2 API");

      $token = $this->getUserToken();
      if($token !== TRUE) throw new \Exception("User Token Failure");

      $path = $v2 ? "$this->prefix/thirdparty/merchant/v2/requestQRPayment" : "$this->prefix/thirdparty/merchant/requestQRPayment";

      $data = array(
        "amount"=>$amount,
        "currency"=>"MMK",
        "externalTransactionId"=>$externalTransactionId,
        "externalAdditionalData"=>$externalAdditionalData,
        "serviceCode"=>$serviceCode,
        "timelimit"=>$timelimit ? $timelimit : ""
      );

      $headers = array();
      $headers[] = "Token: Bearer $this->accesstoken";
      $headers[] = "Authorization: Bearer $this->usertoken";

      $relt = api($data, $this->base, $path, $headers);
      return $relt;
    } catch ( Exception $e ) {
      print_r($e);
      throw $e;
    }
  }

  public function refundPayment(
    string $referenceNumber, 
    string $externalTransactionId,
  ): object
  {
    try {
      $token = $this->getUserToken();
      if($token !== TRUE) throw new \Exception("User Token Failure");

      $path = "$this->prefix/thirdparty/merchant/refundPayment";

      $data = array(
        "externalTransactionId"=>$externalTransactionId,
        "referenceNumber"=>$referenceNumber
      );

      $headers = array();
      $headers[] = "Token: Bearer $this->accesstoken";
      $headers[] = "Authorization: Bearer $this->usertoken";

      $relt = api($data, $this->base, $path, $headers);
      return $relt;
    } catch ( Exception $e ) {
      print_r($e);
      throw $e;
    }
  }

  public function decryptPayment (string $data): object
  {
    try {
      $cipher ="AES-256-ECB";
      $chiperRaw = base64_decode($data);
      $decyptedData = openssl_decrypt($chiperRaw, $cipher, $this->decryptKey, OPENSSL_RAW_DATA);
      return json_decode($decyptedData);
    } catch ( Exception $e ) {
      print_r($e);
      throw $e;
    }
  }
}