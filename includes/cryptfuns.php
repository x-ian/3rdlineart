<?php
$enc = $argv[1]; // "x3OZjCAL944N/awRHSrmRBy9P4VLTptbkFdEl2Ao8gk=";
$encdec = $argv[2];
$secret = "332SECRETabc1234"; // same secret as python
$secret = md5("bigbullets");
    
$iv="HELLOWORLD123456";  // same iv as python
$padding = "\0";  //same padding as python

function decrypt_data($data, $key) {
    global $iv;
    $cypher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, ''); // CBC instead of ECB

    if(is_null($iv)) {
        $ivlen = mcrypt_enc_get_iv_size($cypher);
        $iv = substr($data, 0, $ivlen);
        $data = substr($data, $ivlen);
    }

    // initialize encryption handle
    if (mcrypt_generic_init($cypher, $key, $iv) != -1) {
            // decrypt
            $decrypted = mdecrypt_generic($cypher, $data);

            // clean up
            mcrypt_generic_deinit($cypher);
            mcrypt_module_close($cypher);

            return $decrypted;
    }

    return false;
}

function encrypt_data($data, $key) {
    global $iv;
    $cypher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');

    if(is_null($iv)) {
        $ivlen = mcrypt_enc_get_iv_size($cypher);
        $iv = substr($data, 0, $ivlen);
        $data = substr($data, $ivlen);
    }
    // $key = substr($key, 0, mcrypt_enc_get_key_size($cypher));

    // initialize encryption handle
    if (mcrypt_generic_init($cypher, $key, $iv) != -1) {
            // decrypt
            $encrypted = mcrypt_generic($cypher, $data);

            // clean up
            mcrypt_generic_deinit($cypher);
            mcrypt_module_close($cypher);

            return $encrypted;
    }

    return false;
}

function decrypt($string, $key) {
    $string = str_replace(' ', '+', $string);
    $string = rtrim(decrypt_data(base64_decode($string), $key));
    return $string;
}

function encrypt ($string, $key){   
    $string = rtrim(base64_encode(encrypt_data($string, $key)));
    return $string;
}

 
if ($encdec == 'dec') {
    print decrypt($enc, $secret);
} else if ($encdec == 'enc') {
    print encrypt($enc, $secret);
} else {
    $x = encrypt($enc, $secret);
    // print $x;
    print decrypt_data($x, $secret);
}
?>
