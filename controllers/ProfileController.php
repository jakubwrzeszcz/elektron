<?php
    class ProfileController {

        private $database;

        public function __construct() {
            global $polaczenie;
            require_once "config.php";
            require_once "permission.php";
            require_once "utils.php";
            require_once "permission.php";
            require_once __DIR__ . '/../models/PersonModel.php';

            session_start();
            $this->database = $polaczenie;
        }

        public function index() {
            requireLogin();
            requireAccountType(['klient', 'firma']);

            if($_SESSION['typ_sesji'] === 'klient') {
                $profileModel = new ProfileModel($this->database);
                $no_records = false;

                try {
                    $row = $profileModel->getProfileUser();
                    $no_records = empty($row);
                } catch (Exception $e) {
                    $row = [];
                    $no_records = true;
                    $error_message = $e->getMessage();
                }
            }

            // } elseif($_SESSION['typ_sesji'] === 'firma') {
            //     if($wynik = mysqli_query($polaczenie, "SELECT firma.nip, firma.regon, firma.krs, firma.nazwa_firmy, wojewodztwo.wojewodztwo, miejscowosc.nazwa_miejscowosci, ulica.nazwa_ulicy, kod_pocztowy.kod_pocztowy, adres.numer_firmy FROM firma

            //     JOIN adres ON adres.id_adres = firma.id_adres
            //     JOIN wojewodztwo ON wojewodztwo.id_wojewodztwo = adres.id_wojewodztwo
            //     JOIN miejscowosc ON miejscowosc.id_miejscowosc = adres.id_miejscowosc
            //     JOIN ulica ON ulica.id_ulicy = adres.id_ulicy
            //     JOIN kod_pocztowy ON kod_pocztowy.id_kod_pocztowy = adres.id_kod_pocztowy

            //     WHERE firma.nip = {$_SESSION['nip']}")) {
            //         if(mysqli_num_rows($wynik) > 0) {
            //             $row = mysqli_fetch_array($wynik);
            //         }
            //     }
            // }
            require __DIR__ . '/../views/profile/Profile.php';
        }
    }
?>