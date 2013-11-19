<?php


// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();

/**
$countryName = "UK"; 
$stateOrProvinceName = "London"; 
$localityName = "Blah"; 
$organizationName = "Blah1"; 
$organizationalUnitName = "Blah2"; 
$commonName = "Joe Bloggs"; 
$emailAddress = "openssl@example.com"; 

$dn = array( 
  "countryName" => $countryName, 
  "stateOrProvinceName" => $stateOrProvinceName, 
  "localityName" => $localityName, 
  "organizationName" => $organizationName, 
  "organizationalUnitName" => $organizationalUnitName, 
  "commonName" => $commonName, 
  "emailAddress" => $emailAddress 
); 

$badPriv = 'foo'; 

// generate a bad csr 
$badCsr = openssl_csr_new($dn, $badPriv); 

// generate private key 
$priv = openssl_pkey_new(); 
echo $priv . "<br />";

// generate csr 
$csr = openssl_csr_new($dn, $priv); 

$badCsrDetails = openssl_pkey_get_details(openssl_csr_get_public_key($badCsr)); 
$privDetails = openssl_pkey_get_details($priv); 
$csrDetails = openssl_pkey_get_details(openssl_csr_get_public_key($csr)); 

echo md5($badCsrDetails['rsa']['n']); 
echo "<br />Does not match<br />"; 
echo md5($privDetails['rsa']['n']); 
echo "<br />Matches<br />"; 
echo md5($csrDetails['rsa']['n']); 
echo "<br />"; 
?> 

 


// Fill in data for the distinguished name to be used in the cert
// You must change the values of these keys to match your name and
// company, or more precisely, the name and company of the person/site
// that you are generating the certificate for.
// For SSL certificates, the commonName is usually the domain name of
// that will be using the certificate, but for S/MIME certificates,
// the commonName will be the name of the individual who will use the
// certificate.
$dn = array(
    "countryName" => "CN",
    "stateOrProvinceName" => "安徽省",
    "localityName" => "合肥市",
    "organizationName" => "合肥英塔信息技术有限公司",
//    "organizationalUnitName" => "信息安全技术",
    "commonName" => "王维林",
//    "emailAddress" => "wangwl1983@gmail.com"
);

// Generate a new private (and public) key pair
$privkey = openssl_pkey_new(array(
    "private_key_bits" => 2048
));

// Generate a certificate signing request
$csr = openssl_csr_new($dn, $privkey);

// You will usually want to create a self-signed certificate at this
// point until your CA fulfills your request.
// This creates a self-signed cert that is valid for 365 days
$sscert = openssl_csr_sign($csr, null, $privkey, 3657, array(
    'digest_alg' => 'sha1'
), time());

// Now you will want to preserve your private key, CSR and self-signed
// cert so that they can be installed into your web server, mail server
// or mail client (depending on the intended use of the certificate).
// This example shows how to get those things into variables, but you
// can also store them directly into files.
// Typically, you will send the CSR on to your CA who will then issue
// you with the "real" certificate.
openssl_x509_export_to_file($sscert, dirname(__FILE__). DIRECTORY_SEPARATOR ."root.der");
openssl_pkey_export_to_file($privkey, dirname(__FILE__). DIRECTORY_SEPARATOR ."root.key", "ailaopo");

// Show any errors that occurred here
while (($e = openssl_error_string()) !== false) {
    echo $e . "\n";
}
?>
 * 
 */
