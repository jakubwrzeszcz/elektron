<?php
    class LoginController {
        private $database;

        public function __construct() {
            global $polaczenie;
            require_once "config.php";
            require_once "permission.php";
            require_once "utils.php";
            
            session_start();
            $this->database = $polaczenie;
        }

        public function index() {
            require __DIR__ . '/../views/LoginForm.php';
        }

        public function login() {
            require_once __DIR__ . '/../models/PersonModel.php';
            $pearsonModel = new ProfileModel($this->database);


            // if($_SESSION['zalogowany'] = true && ($_SESSION['typ_sesji'] = "klient" || $_SESSION['typ_sesji'] = "firma")) {
            //     header('Location: /');
            //     exit();
            // }

            if ((!isset($_POST['login'])) || (!isset($_POST['password']))) {
                header('Location: /logowanie');
                exit();
            }

            if(isset($_POST['login'], $_POST['password'], $_POST['recaptcha_token'])) {
                $login = $_POST['login'];
                $password = $_POST['password'];
                $account_type = AccountType::tryFrom($_POST['typ_logowania'] ?? '');
                
                if(verifyCaptcha($_POST['recaptcha_token'])) {
                    $_SESSION['blad'] = '<span style="color:red">Błąd w captcha!</span>';
                    header("Location: /logowanie");
                    exit();
                }

                if(!$account_type) {
                    $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy typ konta!</span>';
                    header("Location: /logowanie");
                    exit();
                }

                $user = $pearsonModel->getUserByCredentails($login, $account_type);
                // this [0] is used cause i used while Models.php:19-21
                $password_hash = $user[0]['haslo'];

                if($user && password_verify($password, $password_hash)) {
                    $_SESSION['zalogowany'] = true;
                    $_SESSION['typ_sesji'] = $account_type->value;
                    $_SESSION['imie'] = $user[0]['imie'];
                    $_SESSION['nazwisko'] = $user[0]['nazwisko'];
                    $_SESSION['adres_email'] = $user[0]['adres_email'];
                    unset($_SESSION['blad']);
                    session_write_close();
                    mysqli_close($this->database);
                    header('Location: /elektron/produkty');
                    exit();
                } else {
                    $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                    header("Location: /elektron/logowanie");
                    mysqli_close($this->database);
                    exit();
                }
                
                // if($account_type === 'klient') {
                //     if($result = mysqli_query($polaczenie, "SELECT * FROM klient WHERE adres_email='$login'")) {
                //         if(mysqli_num_rows($result) > 0) {
                //             $row = mysqli_fetch_assoc($result);
                //             if(password_verify($password, $row['haslo'])) {
                //                 $_SESSION['zalogowany'] = true;
                //                 $_SESSION['typ_sesji'] = $account_type;
                //                 $_SESSION['imie'] = $row['imie'];
                //                 $_SESSION['nazwisko'] = $row['nazwisko'];
                //                 $_SESSION['adres_email'] = $row['adres_email'];
                //                 unset($_SESSION['blad']);
                //                 mysqli_close($polaczenie);
                //                 header('Location: /elektron/produkty');
                //                 exit();
                //             } else {
                //                 $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                //                 header("Location: /elektron/logowanie");
                //                 mysqli_close($polaczenie);
                //                 exit();
                //             }
                //         } else {
                //             $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                //             header("Location: /elektron/logowanie");
                //             mysqli_close($polaczenie);
                //             exit();
                //         }
                //     } else {
                //         $_SESSION['blad'] = '<span style="color:red">Blad zapytania!</span>';
                //         header("Location: /elektron/logowanie");
                //         mysqli_close($polaczenie);
                //         exit();
                //     }
                // } elseif($account_type == 'firma') {
                //     if($result = mysqli_query($polaczenie, "SELECT * FROM firma WHERE firma.nip = '$login'")) {
                //         $row = mysqli_fetch_assoc($result);
                //         if(mysqli_num_rows($result) > 0) {
                //             if(password_verify($password, $_POST['haslo'])) {
                //                 $_SESSION['zalogowany'] = true;
                //                 $_SESSION['typ_sesji'] = $account_type;
                //                 $_SESSION['nip'] = $row['nip'];
                //                 $_SESSION['regon'] = $row['regon'];
                //                 $_SESSION['krs'] = $row['krs'];
                //                 unset($_SESSION['blad']);
                //                 mysqli_close($polaczenie);
                //                 header('Location: /elektron/produkty');
                //                 exit();
                //             } else {
                //                 $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                //                 header("Location: /elektron/logowanie");
                //                 mysqli_close($polaczenie);
                //                 exit();
                //             }
                //         } else {
                //             $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                //             header("Location: /elektron/logowanie");
                //             mysqli_close($polaczenie);
                //             exit();
                //         }
                //     } else {
                //         $_SESSION['blad'] = '<span style="color:red">Blad zapytania!</span>';
                //         header("Location: /elektron/logowanie");
                //         mysqli_close($polaczenie);
                //         exit();
                //     }
                // }
            }
        }
    }

?>