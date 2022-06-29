# AYA Online Merchant

## Installation

`npm install aya-online-merchant --save`

## Initialization

`use Aya\OnlineMerchant\AyaOnlineMerchant;`

`$AyaOnlineMerchant = new AyaOnlineMerchant( $key, $secret, $phone, $password, $decryptKey, $production );`

#### Config Values

These are the options needed to setup the AyaOnlineMerchant Client to use in your application.

    {
      key: "Foo", //required, provided by Aya Pay
      secret: "Bar", //required, provided by Aya Pay
      phone: "09123456789", //required, provided by Aya Pay, phone number without country code
      password: "123456", //required, provided by Aya Pay, 6-digit number string
      decryptKey: "Foobar", //required, provided by Aya Pay
      production: true //optional, defaults to false, declares the environment
    }

## Methods

### Create Payment Request (createTransaction)

This method is used to push a payment request to your customer so they can make a payment to complete a purchase via Aya Pay.

#### v1

`createTransaction(string $customerPhone, string $amount, string $externalTransactionId, string $externalAdditionalData);`

    $result = $AyaOnlineMerchant->createTransaction(
      "09123456789", //required, customer's phone number
      "1000", //required, payment amount
      "externalTransactionId", //required, your unique order number
      "externalAdditionalData", //required, remark
    );

#### v2

v2 is used when you have dedicated business agreements set up with Aya Pay for special flows.

`createTransaction(string $customerPhone, string $amount, string $externalTransactionId, string $externalAdditionalData, bool $v2, string $serviceCode, int $timelimit);`

    $result = $AyaOnlineMerchant->createTransaction(
      "09123456789", //required, customer's phone number
      "1000", //required, payment amount
      "externalTransactionId", //required, your unique order number
      "externalAdditionalData", //required, remark
      true, //enable v2 usage
      "servicecode", //required, provided by Aya Pay
      15 //optional, minutes
    );

### Create QR (createQR)

#### v1

This method is used to request a string to generate a QR which your customer can scan and make payment to you via Aya Pay.

`createQR(string $amount, string $externalTransactionId, string $externalAdditionalData);`

    $result = $AyaOnlineMerchant->createQR(
      "1000", //required, payment amount
      "externalTransactionId", //required, your unique order number
      "externalAdditionalData", //required, remark
    );

#### v2

v2 is used when you have dedicated business agreements set up with Aya Pay for special flows.

`createQR(string $amount, string $externalTransactionId, string $externalAdditionalData, bool $v2, string $serviceCode, int $timelimit);`

    $result = AyaOnlineMerchant->createQR(
      "1000", //required, payment amount
      "externalTransactionId", //required, your unique order number
      "externalAdditionalData", //required, remark
      true, //enable v2 usage
      "servicecode", //required, provided by Aya Pay
      15, //optional, minutes
    );

### Refund Payment (refundPayment)

This method is used to refund a payment made by customer to their Aya Pay wallet.

`refundPayment(string $externalTransactionId, string $referenceNumber);`

    $result = AyaOnlineMerchant->refundPayment(
      "externalTransactionId", //required, your unique order number
      "referenceNumber", //required, reference number from Aya when creating transaction (or) Qr
    );

### Decrypt Payment (decryptPayment)

This method is used to decrypt the data we send to your application server after a successful payment made by the customer to you.

`$data = $AyaOnlineMerchant->decryptPayment("encryptedPaymentData");`
