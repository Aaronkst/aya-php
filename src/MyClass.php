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

function api($payload, $base, $path, $headers) {
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_URL, $base . $path);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array($payload)));

  $response = curl_exec($ch);

  $err = curl_error($ch);
  curl_close($ch);
  if ($err) {
    throw $err;
  } else {
    return $response;
  }
}