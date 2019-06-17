<?php

namespace App;

use phpseclib\Crypt\AES;
use phpseclib\Crypt\Random;

class Crypt
{
    public function Show($f3)
    {
        $cipher = new AES();
        $cipher->setKey('abcdefghijklmnop');

        //$randomString = Random::string($cipher->getBlockLength() >> 3);
        //$randomStringBase64 = base64_encode($randomString);

        $randomStringBase64 = "p6dgpyQgJ/yQoo02UnVz+g==";
        echo $randomStringBase64 ."<br />";

        $cipher->setIV(base64_decode($randomStringBase64));
        $cipher->disablePadding();

        $plaintext = "Emilie è riuscita";

        $encrypt = $cipher->encrypt($plaintext);
        $encryptBase64 = base64_encode($encrypt);
        echo $encryptBase64 ."<br />";

        $decrypt = $cipher->decrypt(base64_decode($encryptBase64));
        echo $decrypt ."<br />";
    }
}
