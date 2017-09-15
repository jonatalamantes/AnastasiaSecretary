<?php     

class AESCipher
{
    private static $encryptMethod = 'AES-256-CBC';
    private $key;
    private $iv;

    public function __construct(){
        $this->key = hash('sha256', 'RinTohsaka<3');
        $this->iv = substr(hash('sha256', 'Anastasia<3'), 0, 16);
    }

    public function decrypt($string){
        return openssl_decrypt($string, self::$encryptMethod, $this->key, 0, $this->iv);
    }

    public function encrypt($string){
        $output = openssl_encrypt($string, self::$encryptMethod, $this->key, 0, $this->iv);
        return $output;
    }
}

/*
$a = new AESCipher();
echo $a->encrypt('secret');
echo "\n";
*/

?>