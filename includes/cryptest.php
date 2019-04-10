<?php
include "crypt_function.php";
echo "encrypted Reviewer";
$enc_role = encrypt("Reviewer", $enckey);
echo "<br>$enc_role";
$dec_role = decrypt($enc_role, $enckey);
echo "<br>$dec_role";

echo decrypt('vC3zlc0Pxo+3JTQXxJU/Xw==', $enckey);
