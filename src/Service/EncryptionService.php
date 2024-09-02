<?php
namespace App\Service;

class EncryptionService {

    private $cipher = 'AES-128-CBC'; // Algorithme de chiffrmement
    private $key; // Clé de chiffrement à partir du .env(.env.local)
    private $iv ; // 'Vecteur d'initialisation'


    // Récupérer la clé  à l'instanciation de la classe 
    public function __construct(){
        $this->key = $_ENV['APP_KEY'];
    }

    // Chiffrer
    public function encrypt($data){
        $iv = random_bytes(openssl_cipher_iv_length($this->cipher));  
            // IV aléatoire taille appropriée pour l'algorithme          
        $encryptedData = openssl_encrypt($data, $this->cipher, $this->key, 0, $iv);
            // Chiffrer en utilisation $données, algo, clé, options, IV
        return base64_encode($iv . $encryptedData);
            // Encodage en base64 de l'IV et des données chiffrées
    }

    // Déchiffrer
    public function decrypt($encryptedData) {
        $data = base64_decode($encryptedData);
            // Décoder depuis base64
        $ivLength = openssl_cipher_iv_length($this->cipher);
            // Récupérer la taille de l'IV
        $iv = substr($data, 0, $ivLength);
            // Récupérer l'IV
        $ciphertext = substr($data, $ivLength);
            // Récupérer les données chiffrées
        return openssl_decrypt($ciphertext, $this->cipher, $this->key, 0, $iv);
            // Déchiffrer en utilisant les données chiffrées, l'algo, la clé, les options, l'IV
    }
    
}