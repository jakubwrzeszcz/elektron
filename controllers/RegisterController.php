<?php
    require_once "config.php";

    class RegisterController {
        public function index() {
            require __DIR__ . '/../views/registration/registration.php';
        }

        public function register() {
            session_start();
            if ((!isset($_POST['login'])) || (!isset($_POST['password']))) {
                $_SESSION['blad'] = '<span style="color:red">Brak loginu lub hasła</span>';
                header('Location: rejestracja-formularz.php');
                exit();
            }

            if(verifyCaptcha($_POST['recaptcha_token'])) {
                $_SESSION['blad'] = '<span style="color:red">Błąd w captcha v3!</span>';
                header("Location: rejestracja-formularz.php");
                exit();
            }

            if(isset($_POST['imie'], $_POST['nazwisko'], $_POST['adres_email'], $_POST['login'], $_POST['password'], $_POST['typ_logowania'])) {
                if($_POST['typ_logowania'] == "klient") {
                    $imie = mysqli_real_escape_string($polaczenie, $_POST['imie']);
                    $nazwisko = mysqli_real_escape_string($polaczenie, $_POST['nazwisko']);
                    $adres_email = mysqli_real_escape_string($polaczenie, $_POST['adres_email']);
                    $login = mysqli_real_escape_string($polaczenie, $_POST['login']);
                    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    
                    $sprawdz = mysqli_query($polaczenie, "SELECT * FROM `klient` WHERE `login`='$login' OR `adres_email`='$adres_email'");
                    if(mysqli_num_rows($sprawdz) > 0) {
                        $_SESSION['blad'] = '<span style="color:red">Użytkownik o podanym loginie lub email już istnieje!</span>';
                        header("Location: logowanie-formularz.php");
                        exit();
                    }
                    // TODO: Unable to type an address for specific user.
                    $query = "INSERT INTO `klient` (`imie`, `nazwisko`, `id_adres`, `adres_email`, `login`, `haslo`) 
                            VALUES ('$imie', '$nazwisko', 1, '$adres_email', '$login', '$password_hash')";
                    
                    $result = mysqli_query($polaczenie, $query);
                    
                    if($result) {
                        if(mysqli_affected_rows($polaczenie) == 1) {
                            $_SESSION['blad'] = '<span style="color:green">Udało się dodać użytkownika. Proszę się zalogować, aby móc korzystać z serwisu.</span>';
                            header("Location: logowanie-formularz.php");
                            exit();
                        } else {
                            $_SESSION['blad'] = '<span style="color:red">Nie udało się dodać użytkownika (0 wierszy)</span>';
                            header("Location: rejestracja-formularz.php");
                            exit();
                        }
                    } else {
                        $error = mysqli_error($polaczenie);
                        $_SESSION['blad'] = '<span style="color:red">Błąd zapytania: ' . $error . '</span>';
                        header("Location: rejestracja-formularz.php");
                        exit();
                    }
                } else {
                    $_SESSION['blad'] = '<span style="color:red">Nieobsługiwany typ konta: ' . $_POST['typ_logowania'] . '</span>';
                    header("Location: rejestracja-formularz.php");
                    exit();
                }
            } else {
                $_SESSION['blad'] = '<span style="color:red">Błąd przetwarzania formularza. Brakujące pola.</span>';
                header("Location: rejestracja-formularz.php");
                exit();
            }

            mysqli_close($polaczenie);
        }
    }

?>