<?php
namespace App\Service;

class EncryptionService {

    private $cipher = 'AES-128-CBC';
    private $key;
    private $iv ;

    public function __construct(){
        $this->key = $_ENV['APP_KEY'];
    }

    public function encyrpt($data){
        $iv = random_bytes(openssl_cipher_iv_length($this->cipher));
        $encryptedData = openssl_encrypt($data, $this->cipher, $this->key, 0, $iv);
        return base64_encode($iv . $encryptedData);
    }

    public function decrypt($encryptedData) {
        $data = base64_decode($encryptedData);
        $ivLength = openssl_cipher_iv_length($this->cipher);
        $iv = substr($data, 0, $ivLength);
        $ciphertext = substr($data, $ivLength);
        return openssl_decrypt($ciphertext, $this->cipher, $this->key, 0, $iv);
    }
    
}