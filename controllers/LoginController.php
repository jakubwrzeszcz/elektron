<?php
    class LoginController {
        public function index() {
            session_start();
            require_once "config.php";
            require __DIR__ . '/../views/login/LoginForm.php';
        }

        enum accountType {
            case "klient";
            case "firma";
        }

        public function login() {
            global $polaczenie;
            session_start();
            require_once "config.php";

            if($_SESSION['zalogowany'] = true && ($_SESSION['typ_sesji'] = "klient" || $_SESSION['typ_sesji'] = "firma")) {
                header('Location: /elektron/');
                exit();
            }

            if ((!isset($_POST['login'])) || (!isset($_POST['password']))) {
                header('Location: /elektron/logowanie');
                exit();
            }

            if(isset($_POST['login'], $_POST['password'], $_POST['recaptcha_token'])) {
                $login = $_POST['login'];
                $password = $_POST['password'];
                $account_type = $_POST['typ_logowania'];
                
                if(verifyCaptcha($_POST['recaptcha_token'])) {
                    $_SESSION['blad'] = '<span style="color:red">Błąd w captcha v3!</span>';
                    header("Location: /elektron/logowanie");
                    exit();
                }
                
                if($account_type === 'klient') {
                    if($result = mysqli_query($polaczenie, "SELECT * FROM klient WHERE adres_email='$login'")) {
                        if(mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            if(password_verify($password, $row['haslo'])) {
                                $_SESSION['zalogowany'] = true;
                                $_SESSION['typ_sesji'] = $account_type;
                                $_SESSION['imie'] = $row['imie'];
                                $_SESSION['nazwisko'] = $row['nazwisko'];
                                $_SESSION['adres_email'] = $row['adres_email'];
                                unset($_SESSION['blad']);
                                mysqli_close($polaczenie);
                                header('Location: /elektron/produkty');
                                exit();
                            } else {
                                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                                header("Location: /elektron/logowanie");
                                mysqli_close($polaczenie);
                                exit();
                            }
                        } else {
                            $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                            header("Location: /elektron/logowanie");
                            mysqli_close($polaczenie);
                            exit();
                        }
                    } else {
                        $_SESSION['blad'] = '<span style="color:red">Blad zapytania!</span>';
                        header("Location: /elektron/logowanie");
                        mysqli_close($polaczenie);
                        exit();
                    }
                } elseif($account_type == 'firma') {
                    if($result = mysqli_query($polaczenie, "SELECT * FROM firma WHERE firma.nip = '$login'")) {
                        $row = mysqli_fetch_assoc($result);
                        if(mysqli_num_rows($result) > 0) {
                            if(password_verify($password, $_POST['haslo'])) {
                                $_SESSION['zalogowany'] = true;
                                $_SESSION['typ_sesji'] = $account_type;
                                $_SESSION['nip'] = $row['nip'];
                                $_SESSION['regon'] = $row['regon'];
                                $_SESSION['krs'] = $row['krs'];
                                unset($_SESSION['blad']);
                                mysqli_close($polaczenie);
                                header('Location: /elektron/produkty');
                                exit();
                            } else {
                                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                                header("Location: /elektron/logowanie");
                                mysqli_close($polaczenie);
                                exit();
                            }
                        } else {
                            $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                            header("Location: /elektron/logowanie");
                            mysqli_close($polaczenie);
                            exit();
                        }
                    } else {
                        $_SESSION['blad'] = '<span style="color:red">Blad zapytania!</span>';
                        header("Location: /elektron/logowanie");
                        mysqli_close($polaczenie);
                        exit();
                    }
                }
            }
        }
    }

?>