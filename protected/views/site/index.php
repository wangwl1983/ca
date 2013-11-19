<?php

$certPath = Yii::getPathOfAlias('webroot.ssl');
$publicKeyFile = $certPath . DIRECTORY_SEPARATOR . 'server.pem';
$privateKeyFile = $certPath . DIRECTORY_SEPARATOR . 'server.key';
$clientPublicKeyFile = $certPath . DIRECTORY_SEPARATOR . 'client.pem';

$publicKey = openssl_pkey_get_public('file://' . $publicKeyFile);
$privateKey = openssl_pkey_get_private('file://' . $privateKeyFile, 'ailaopo');
$clientPublicKey = openssl_pkey_get_public('file://' . $clientPublicKeyFile);

$data = 'Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!';

//if (openssl_private_encrypt($data, $encryptData, $privateKey)) {
//    echo $encryptData;
//} else {
//    echo 'Error';
//}
//echo '<br />';
//if (openssl_private_decrypt($encryptData, $decryptedData, $privateKey)) {
//    echo $decryptedData;
//} else {
//    echo 'Error';
//}

$xml = new DOMDocument('1.0', 'gbk');

$root = $xml->createElement('data');
$xml->appendChild($root);

$key = $xml->createElement('key');
$root->appendChild($key);

openssl_seal($data, $sealed_data, $ekeys, array($clientPublicKey, $publicKey));
$data = $xml->createCDATASection(base64_encode($sealed_data));
$key->appendChild($data);



//$xml->addChild('data', $sealed_data);

file_put_contents('ab.xml', $xml->saveXML());

$xmlfile = new DOMDocument();
$xmlfile->load('ab.xml');

$k = $xmlfile->getElementsByTagName('key');
$rsaKey = base64_decode($k->item(0)->textContent);

openssl_open($rsaKey, $open_data, $ekeys[1], $privateKey);

echo $open_data;
$target = file_get_contents('ab.xml');
openssl_sign($target, $signature, $privateKey);
echo $signature;
echo $target;
$t = openssl_verify($target, $signature, $publicKey);
var_dump($t);
while ($e = openssl_error_string())
    echo $e;

echo '<br />';
echo base64_encode('Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!Hello PKI!');

//var_dump($dat  = DataEncryption::EncryptData('DFuf'));
//var_dump(DataEncryption::DecryptData($dat));

//throw new Exception("Fuck");
        