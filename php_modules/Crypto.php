<?php

class Crypto {

    private static $ENCRYPTION_ALGORITHM = 'aes-256-cbc';

    // BEGIN FUNCTIONS ***************************************************************** 
    public static function encrypt($ClearTextData, $encryption_key) {
        // This function encrypts the data passed into it and returns the cipher data with the IV embedded within it.
        // The initialization vector (IV) is appended to the cipher data with 
        // the use of two colons serve to delimited between the two.
        $ENCRYPTION_ALGORITHM = self::$ENCRYPTION_ALGORITHM;

        if (in_array($ENCRYPTION_ALGORITHM, openssl_get_cipher_methods()))
        {
            $InitializationVector  = openssl_random_pseudo_bytes(openssl_cipher_iv_length($ENCRYPTION_ALGORITHM));

            $EncryptionKey = base64_decode($encryption_key);

            $EncryptedText = openssl_encrypt($ClearTextData, $ENCRYPTION_ALGORITHM, $EncryptionKey, $options=0, $InitializationVector);

        }

        return base64_encode($EncryptedText . '::' . $InitializationVector);
    }


    public static function decrypt($CipherData, $encryption_key) {
        // This function decrypts the cipher data (with the IV embedded within) passed into it 
        // and returns the clear text (unencrypted) data.
        // The initialization vector (IV) is appended to the cipher data by the EncryptThis function (see above).
        // There are two colons that serve to delimited between the cipher data and the IV.
        $ENCRYPTION_ALGORITHM = self::$ENCRYPTION_ALGORITHM;

        if (in_array($ENCRYPTION_ALGORITHM, openssl_get_cipher_methods()))
        {
            $EncryptionKey = base64_decode($encryption_key);
            list($Encrypted_Data, $InitializationVector) = array_pad(explode('::', base64_decode($CipherData), 2), 2, null);
            return openssl_decrypt($Encrypted_Data, $ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
        
        }   
    }

    // END FUNCTIONS ***************************************************************** 
    }


?>