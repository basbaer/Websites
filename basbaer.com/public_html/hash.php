<?php

    setcookie("myCookie", "cookieValue", time() + 60 * 3);

    print_r($_COOKIE);
    
    //php hash function
    $hash = password_hash("password", PASSWORD_DEFAULT);

    echo $hash;

    echo "<br> <br>";

    $hash2 = password_hash("password", PASSWORD_DEFAULT);

    echo $hash2;

    echo "<br> <br>";
   
    if (password_verify('password', '$2y$10$EZSKowrwFw.I56pIuIbaHuOyJryXk0nm8Danw.iq8F5mBq07USAcC')) {
        echo 'Password is valid!';
    } else {
        echo 'Invalid password.';
    }




?>