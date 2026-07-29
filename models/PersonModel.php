<?php
    require_once "Models.php";

    
    enum AccountType: string {
        case KLIENT = "klient";
        case FIRMA = "firma";
    }

    class ProfileModel extends Models {
        // Worker
        public function getProfile(): array {
            $sql = "SELECT 
                pracownicy.imie, pracownicy.nazwisko, stanowiska.nazwa_stanowiska, wojewodztwo.wojewodztwo, ulica.nazwa_ulicy, kod_pocztowy.kod_pocztowy, adres.numer_firmy, miejscowosc.nazwa_miejscowosci
                FROM pracownicy
                JOIN adres ON adres.id_adres = pracownicy.id_adres
                JOIN wojewodztwo ON wojewodztwo.id_wojewodztwo = adres.id_wojewodztwo
                JOIN ulica ON ulica.id_ulicy = adres.id_ulicy
                JOIN kod_pocztowy ON kod_pocztowy.id_kod_pocztowy = adres.id_kod_pocztowy
                JOIN miejscowosc ON miejscowosc.id_miejscowosc = adres.id_miejscowosc
                JOIN stanowiska ON stanowiska.id_stanowiska = pracownicy.id_stanowiska
                WHERE pracownicy.adres_email = '{$_SESSION['adres_email']}'";
            return $this->executeQuery($sql);
        }

<<<<<<< Updated upstream
        public function getProfileUser(): array {
            $sql = "SELECT klient.imie, klient.nazwisko, wojewodztwo.wojewodztwo, miejscowosc.nazwa_miejscowosci, ulica.nazwa_ulicy, kod_pocztowy.kod_pocztowy, adres.numer_firmy FROM klient
                    JOIN adres ON adres.id_adres = klient.id_adres
                    JOIN wojewodztwo ON wojewodztwo.id_wojewodztwo = adres.id_wojewodztwo
                    JOIN miejscowosc ON miejscowosc.id_miejscowosc = adres.id_miejscowosc
                    JOIN ulica ON ulica.id_ulicy = adres.id_ulicy
                    JOIN kod_pocztowy ON kod_pocztowy.id_kod_pocztowy = adres.id_kod_pocztowy

                    WHERE klient.adres_email = '{$_SESSION['adres_email']}'";
            return $this->executeQuery($sql);
        }


        public function getUserByCredentails(string $login, AccountType $type) {
=======
        enum AccountType: string {
            case KLIENT = "klient";
            case FIRMA = "firma";
        }

        public function getUserByCredentails(string $email, AccountType $type) {
>>>>>>> Stashed changes
            switch($type) {
                case AccountType::KLIENT:
                    $sql = "SELECT imie, nazwisko, adres_email, login, haslo FROM klient WHERE adres_email='$login'";
                    break;
                case AccountType::FIRMA:
                    $sql = "SELECT * FROM firma WHERE firma.nip = '$login'";
                    break;
            }
            return $this->executeQuery($sql);
        }
    }

    class WorkerModel extends Models {
        public function getWorkers(): array {
            $sql = 'SELECT imie, nazwisko, telefon, adres_email, wojewodztwo.wojewodztwo, miejscowosc.nazwa_miejscowosci, ulica.nazwa_ulicy, kod_pocztowy.kod_pocztowy, adres.numer_firmy, stanowiska.nazwa_stanowiska FROM pracownicy JOIN stanowiska ON pracownicy.id_stanowiska = stanowiska.id_stanowiska JOIN adres ON pracownicy.id_adres = adres.id_adres JOIN wojewodztwo ON wojewodztwo.id_wojewodztwo = adres.id_wojewodztwo JOIN miejscowosc ON miejscowosc.id_miejscowosc = adres.id_miejscowosc JOIN ulica ON ulica.id_ulicy = adres.id_ulicy JOIN kod_pocztowy ON kod_pocztowy.id_kod_pocztowy = adres.id_kod_pocztowy';
            return $this->executeQuery($sql);
        }
    }
?>