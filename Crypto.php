<?php

class Crypto
{
    public static function encrypt_decrypt($method, $value)
    {
        $privateKey = 'bcb04b7e103a0cd8b54763051cef)(*&^%$#@08bc55abe029fdebae5e1d417e2ffb2a00a3';
        $encryptionMethod = "AES-256-CBC";  // AES is used by the U.S. gov't to encrypt top secret documents.
        $ivlen = openssl_cipher_iv_length($encryptionMethod);
        $publicKey = hash('md5', $privateKey);
        $iv = substr(hash('md5', $ivlen), 0, 16);

        // $iv = substr($secretHash, 0, 16); //To guarantee unique encrypted text
        // $secretHash = "25c6c7ff35b9979b15151cef)(*&^%$#@08bc55abe029fdef2136cd13b0ff";

        $result = false;
        if ($method == 'encrypt') {
            $result = base64_encode(openssl_encrypt($value, $encryptionMethod, $publicKey, 0, $iv));
        } else if ($method == 'decrypt') {
            $result = openssl_decrypt(base64_decode($value), $encryptionMethod, $publicKey, 0, $iv);
        }

        return $result;
    }
}
?>
