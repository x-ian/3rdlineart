<?php
if (file_exists('./includes/keys/key.php')) {
    // echo 'includes/keys/key.php exists';
include ('includes/keys/key.php');
} else if (file_exists('./keys/key.php')) {
    // echo 'keys/key.php exists';
include ('keys/key.php');
} else {
    // echo 'maybe have keys?';
    include('../includes/keys/key.php');
}
//encrypt

// echo "in crypt_functions..., enckey = $enckey";

function base64_url_encode($input) {
    return strtr(base64_encode($input), '+/=', '-_,');
}

function base64_url_decode($input) {
    return base64_decode(strtr($input, '-_,', '+/='));
}

function encrypt_x ($string, $key){   
    $string = rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $string, MCRYPT_MODE_ECB),'+/=', '-_,'));
    return $string;
}

//decrypt

function decrypt_x ($string, $key){
    $string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($string, '-_,', '+/='), MCRYPT_MODE_ECB));
    return $string;
}

function hasword ($string, $salt){
    $string = encrypt($string, '$1$'.$salt.'$');
    return $string;
}

function dehasword ($string, $salt){
    $str = decrypt($string, '$1$'.$salt.'$');
    return $str;
}

$iv="HELLOWORLD123456";  // same iv as python
$padding = "\0";  //same padding as python

// echo '<br>in crypt functions<br>';

function decrypt2($data, $key) {
    global $iv;
    $cypher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, ''); // was CBC

    if(is_null($iv)) {
        $ivlen = mcrypt_enc_get_iv_size($cypher);
        $iv = substr($data, 0, $ivlen);
        $data = substr($data, $ivlen);
    }

    // initialize encryption handle
    if (mcrypt_generic_init($cypher, $key, $iv) != -1) {
            // decrypt
            # $ddata = base64_decode($data, '-_,', '+/=');
            $decrypted = mdecrypt_generic($cypher, $data);

            // clean up
            mcrypt_generic_deinit($cypher);
            mcrypt_module_close($cypher);
            return $decrypted;
    }

    return false;
}

function encrypt2($data, $key) {
    global $iv;
    $cypher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, ''); // was CBC

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
    $string = rtrim(decrypt2(base64_decode($string), $key));
//    $string = rtrim(decrypt2(base64_decode($string, '-_,', '+/='), $key));
    return $string;
}

function encrypt ($string, $key){   
    $string = rtrim(base64_encode(encrypt2($string, $key)));
//    $string = rtrim(base64_encode(encrypt2($string, $key), '+/=', '-_,'));    
    return $string;
}

?>