<?php

$ENCRYPTION_KEY = "my key";
$ENCRYPTION_ALGORITHM = 'aes-256-cbc';

// BEGIN FUNCTIONS ***************************************************************** 
function Encrypt($ClearTextData) {
    // This function encrypts the data passed into it and returns the cipher data with the IV embedded within it.
    // The initialization vector (IV) is appended to the cipher data with 
    // the use of two colons serve to delimited between the two.
    global $ENCRYPTION_KEY;
    global $ENCRYPTION_ALGORITHM;

    if (in_array($ENCRYPTION_ALGORITHM, openssl_get_cipher_methods()))
    {
        $InitializationVector  = openssl_random_pseudo_bytes(openssl_cipher_iv_length($ENCRYPTION_ALGORITHM));

        $EncryptionKey = base64_decode($ENCRYPTION_KEY);

        $EncryptedText = openssl_encrypt($ClearTextData, $ENCRYPTION_ALGORITHM, $EncryptionKey, $options=0, $InitializationVector);


    }

    return base64_encode($EncryptedText . '::' . $InitializationVector);
}


function Decrypt($CipherData) {
    // This function decrypts the cipher data (with the IV embedded within) passed into it 
    // and returns the clear text (unencrypted) data.
    // The initialization vector (IV) is appended to the cipher data by the EncryptThis function (see above).
    // There are two colons that serve to delimited between the cipher data and the IV.
    global $ENCRYPTION_KEY;
    global $ENCRYPTION_ALGORITHM;

    if (in_array($ENCRYPTION_ALGORITHM, openssl_get_cipher_methods()))
    {
        $EncryptionKey = base64_decode($ENCRYPTION_KEY);
        list($Encrypted_Data, $InitializationVector) = array_pad(explode('::', base64_decode($CipherData), 2), 2, null);
        return openssl_decrypt($Encrypted_Data, $ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
    
    }   
}

// END FUNCTIONS ***************************************************************** 

$out= "Text: <br>"; 

$text = "my message";

$out .= $text;

$encrypted = Encrypt($text);

$out .= "<br> <br> Encrypted: <br>".$encrypted;

$decrypted = Decrypt($encrypted);

$out .= "<br> <br> Decrypted: <br>".$decrypted;

echo $out;

?>
