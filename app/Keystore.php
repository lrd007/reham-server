
<?php


/* 
* NOTE:  Here you use the returned resource value 
*doSimleEncrypt() will encrypt a key and write it to secret.pooh in the  in the given path
*parseKeyStore() will read the key from the file froom the given path
*
*
*
*/
//$obj=new KeyStore();
//TO SIMPLE ENCRYPT THE KEY AND STORE IT INTO THE FILE ONE TIME ACTIVITY
//$obj->doSimleEncrypt('222222222222222222222222','C:/wamp/www/cgn/');
//TO PARSE THE RESOURCE FILE
//$obj->parseKeyStore('C:/wamp/www/cgn/');

class KeyStore
{

    function doSimleEncrypt($keyToBeEncrypted, $keyStorePath)
    {
        $hexData = ($keyToBeEncrypted);
        $encData = $this->xor_this($keyToBeEncrypted);
        $myfile = fopen($keyStorePath . "keystore.pooh", "w") or die("Unable to open file!");
        fwrite($myfile, $encData);
        fflush($myfile);
        fclose($myfile);
    }
    function parseKeyStore($keyStorePath)
    {
        //dd($keyStorePath . "keystore.pooh");
        $myfile = fopen($keyStorePath . "keystore.pooh", "r") or die("Unable to open file!");
        //dd($myfile);
        //$data=$this->xor_this(fread($myfile,filesize($keyStorePath."secret.pooh")));
        //$decData=$this->xor_this(fread($myfile,filesize($keyStorePath."secret.pooh")));
        $decData = $this->xor_this(fread($myfile, filesize($keyStorePath . "keystore.pooh")));
        //echo $decData;
        //$decData=pack('H*',$data);
        fclose($myfile);
        //echo $decData;
        return $decData;
    }
    function xor_this($text)
    {
        $key = 'frtkj';
        $i = 0;
        $encrypted = '';
        foreach (str_split($text) as $char) {
            $encrypted .= chr(ord($char) ^ ord($key[$i++ % strlen($key)]));
        }
        return $encrypted;
    }

    function encryptData($payload, $key)
    {
        //$block = mcrypt_get_block_size ( 'tripledes', 'ecb' ); wont't work in php 7.x version

        $chiper = "des-ede3";  //Algorthim used to encrypt
        if ((strlen($payload) % 8) != 0) {
            //Perform right padding
            $payload = $this->rightPadZeros($payload);
        }
        //dd($payload);
        // dd(openssl_cipher_iv_length($chiper));
        //dd($key);
        //$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($chiper));
        //dd($iv);
        //     $encrypted = openssl_encrypt($payload, $chiper, $key, OPENSSL_RAW_DATA, $iv);
        $encrypted = openssl_encrypt($payload, $chiper, $key, OPENSSL_RAW_DATA);
        // dd($encrypted);
        $encrypted = unpack('C*', ($encrypted));
        $encrypted = $this->byteArray2Hex($encrypted);
        return strtoupper($encrypted);
    }

    function decryptData($data, $key)
    {
        // $data = mcrypt_decrypt ( MCRYPT_3DES, $key, $data, MCRYPT_MODE_ECB); wont't work in php 7.x version
        $chiper = "des-ede3";  //Algorthim used to decrypt
        $data = $this->hex2ByteArray($data);
        $data = $this->byteArray2String($data);
        $data = base64_encode($data);
        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($chiper));
        //  $decrypted = openssl_decrypt($data, $chiper, $key, OPENSSL_ZERO_PADDING, $iv);
        $decrypted = openssl_decrypt($data, $chiper, $key, OPENSSL_ZERO_PADDING);
        return $decrypted;
    }

    function hex2ByteArray($hexString)
    {
        $string = hex2bin($hexString);
        return unpack('C*', $string);
    }

    function byteArray2String($byteArray)
    {
        $chars = array_map("chr", $byteArray);
        return join($chars);
    }

    function pkcs5_pad($message)
    {
        $message_padded = $message;
        if (strlen($message_padded) % 8) {
            $message_padded = str_pad(
                $message_padded,
                strlen($message_padded) + 8 - strlen($message_padded) % 8,
                "\0"
            );
        }
    }

    function rightPadZeros($Str)
    {
        if (null == $Str) {
            return null;
        }
        $PadStr = $Str;

        for ($i = strlen($Str); ($i % 8) != 0; $i++) {
            $PadStr .= "^";
        }
        return $PadStr;
    }

    function byteArray2Hex($byteArray)
    {
        $chars = array_map("chr", $byteArray);
        $bin = join($chars);
        return bin2hex($bin);
    }
}


?>