<?php
    $serwer = "db";
    $login = "root";
    $haslo = "root";
    $baza = "elektron";

    $polaczenie = @mysqli_connect($serwer, $login, $haslo, $baza);
    if(mysqli_connect_errno()) {
        echo("<p style='color:red;'>Błąd połączenia z bazą danych. Skontaktuj się z administratorem.");
        exit(404);
    }
    mysqli_set_charset($polaczenie, "utf8");
    global $polaczenie;

    function verifyCaptcha($token): bool {
        $post_data = http_build_query(
            array(
                'secret' => "6LdD0IMsAAAAAGqkMwexhYaqFD7g_jtOM5c0jbBJ",
                'response' => $token,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            )
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $post_data
            )
        );
        $context  = stream_context_create($opts);
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        if($response === false) {
            return false;
        }
        $result = json_decode($response);
        return $result->success;
    }
?>