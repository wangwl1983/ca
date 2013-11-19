<?php

/**
 * Description of Crypto
 *
 * @author wangwl
 */
class Crypto {

    private static function loadCerts(&$cert) {
        $certFile = "file://" . dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ssl' . DIRECTORY_SEPARATOR . 'client.pem';
        $cert = openssl_pkey_get_public($certFile);
        if ($cert != false) {
            return true;
        } else {
            return false;
        }
    }

    private static function loadKey(&$key) {
        $keyFile = "file://" . dirname(__FILE__) . DIRECTORY_SEPARATOR . "ssl" . DIRECTORY_SEPARATOR . 'server.key';
        $key = openssl_pkey_get_private($keyFile, 'ailaopo');
        if ($key != false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $plainText
     * @param string $cipherText
     * @return boolean
     */
    public static function Encrypt($plainText, &$cipherText) {
        $key = $iv = null;
        if (self::AESEncrypt($plainText, $encryptedData, $key, $iv)) {
            if (self::RSAEncrypt($key, $encryptedKey)) {
                $keyString = base64_encode($encryptedKey);
                $ivString = base64_encode($iv);
                $dataString = base64_encode($encryptedData);
                $cipherText = $keyString . "\n" . $ivString . "\n" . $dataString;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 
     * @param string $cipherText
     * @param string $plainText
     * @return boolean
     */
    public static function Decrypt($cipherText, &$plainText) {
        $dataArray = explode("\n", $cipherText);
        if (count($dataArray) != 3) {
            return false;
        }
        $encryptedKey = base64_decode($dataArray[0]);
        if (self::RSADecrypt($encryptedKey, $key)) {
            $encryptedData = base64_decode($dataArray[2]);
            $iv = base64_decode($dataArray[1]);
            if (self::AESDecrypt($encryptedData, $plainText, $key, $iv)) {
                return true;
            } else {
                return false;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param string $plainText
     * @param string $cipherText
     * @param string $key
     * @param string $iv
     * @return boolean
     */
    private static function AESEncrypt($plainText, &$cipherText, &$key, &$iv) {
        $key = openssl_random_pseudo_bytes(16);
        $iv = openssl_random_pseudo_bytes(16);
        $cipherText = openssl_encrypt($plainText, 'aes-128-cbc', $key, OPENSSL_RAW_DATA, $iv);
        if ($cipherText != false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param string $cipherText
     * @param string $plainText
     * @param string $key
     * @param string $iv
     * @return boolean
     */
    private static function AESDecrypt($cipherText, &$plainText, $key, $iv) {

        $plainText = openssl_decrypt($cipherText, 'aes-128-cbc', $key, OPENSSL_RAW_DATA, $iv);
        if ($plainText != false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param string $plainText
     * @param string $CipherText
     * @return boolean
     */
    private static function RSAEncrypt($plainText, &$CipherText) {
        if (self::loadCerts($key)) {
            if (openssl_public_encrypt($plainText, $CipherText, $key, OPENSSL_PKCS1_OAEP_PADDING)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 
     * @param string $cipherText
     * @param string $plainText
     * @return boolean
     */
    private static function RSADecrypt($cipherText, &$plainText) {
        if (self::loadKey($key)) {
            if (openssl_private_decrypt($cipherText, $plainText, $key, OPENSSL_PKCS1_OAEP_PADDING)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
