<?php
    class ProfileController {
        public function index() {
            require_once "config.php";
            session_start();
            require_once "permission.php";
            requireLogin();
            requireAccountType(['klient', 'firma']);

            if($_SESSION['typ_sesji'] === 'klient') {
                if($wynik = mysqli_query($polaczenie, "SELECT klient.imie, klient.nazwisko, wojewodztwo.wojewodztwo, miejscowosc.nazwa_miejscowosci, ulica.nazwa_ulicy, kod_pocztowy.kod_pocztowy, adres.numer_firmy FROM klient
                    JOIN adres ON adres.id_adres = klient.id_adres
                    JOIN wojewodztwo ON wojewodztwo.id_wojewodztwo = adres.id_wojewodztwo
                    JOIN miejscowosc ON miejscowosc.id_miejscowosc = adres.id_miejscowosc
                    JOIN ulica ON ulica.id_ulicy = adres.id_ulicy
                    JOIN kod_pocztowy ON kod_pocztowy.id_kod_pocztowy = adres.id_kod_pocztowy

                    WHERE klient.adres_email = '{$_SESSION['adres_email']}'")) {
                        if(mysqli_num_rows($wynik) > 0) {
                            $row = mysqli_fetch_array($wynik);
                        }
                }
            } elseif($_SESSION['typ_sesji'] === 'firma') {
                if($wynik = mysqli_query($polaczenie, "SELECT firma.nip, firma.regon, firma.krs, firma.nazwa_firmy, wojewodztwo.wojewodztwo, miejscowosc.nazwa_miejscowosci, ulica.nazwa_ulicy, kod_pocztowy.kod_pocztowy, adres.numer_firmy FROM firma

                JOIN adres ON adres.id_adres = firma.id_adres
                JOIN wojewodztwo ON wojewodztwo.id_wojewodztwo = adres.id_wojewodztwo
                JOIN miejscowosc ON miejscowosc.id_miejscowosc = adres.id_miejscowosc
                JOIN ulica ON ulica.id_ulicy = adres.id_ulicy
                JOIN kod_pocztowy ON kod_pocztowy.id_kod_pocztowy = adres.id_kod_pocztowy

                WHERE firma.nip = {$_SESSION['nip']}")) {
                    if(mysqli_num_rows($wynik) > 0) {
                        $row = mysqli_fetch_array($wynik);
                    }
                }
            }
            mysqli_close($polaczenie);
            require __DIR__ . '/../views/profile/Profile.php';
        }
    }
?>