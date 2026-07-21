<?php
    require_once "Models.php";

    class InvoiceModel extends Models {
        public function getAllInvoices(): array {
            $sql = "SELECT faktura.id_faktury, zamowienia.nip, zamowienia.data_wyslania, status_zamowienia.status, zamowienia.data_zamowienia 
                    FROM `faktura` 
                    JOIN zamowienia ON zamowienia.id_zamownienia = faktura.id_zamowienia 
                    JOIN status_zamowienia ON status_zamowienia.id_status_zamowienia = zamowienia.status 
                    ORDER BY faktura.id_faktury";
            return $this->executeQuery($sql);
        }

        public function getInvoiceAdminDetail(int $id_faktury): array {
            $id = (int)$id_faktury;
            $sql = "SELECT 
                        faktura.id_faktury, faktura.id_dostawcy, faktura.typ,
                        dostawca.nazwa_dostawcy, dostawca.cena_brutto AS cena_dostawy,
                        zamowienia.nip, firma.regon, firma.krs, firma.nazwa_firmy,
                        miejscowosc.nazwa_miejscowosci AS miejscowosc, ulica.nazwa_ulicy,
                        adres.numer_firmy, kod_pocztowy.kod_pocztowy,
                        produkty.nazwa AS produkt, produkty.cena_netto,
                        pozycje_zamowienia.cena_brutto AS cena_produktu_brutto, pozycje_zamowienia.ilosc,
                        zamowienia.data_wyslania, zamowienia.data_zamowienia
                    FROM faktura
                    JOIN dostawca ON dostawca.id_dostawcy = faktura.id_dostawcy
                    JOIN zamowienia ON zamowienia.id_zamownienia = faktura.id_zamowienia
                    JOIN pozycje_zamowienia ON pozycje_zamowienia.id_zamowienia = zamowienia.id_zamownienia
                    JOIN produkty ON produkty.id_produktu = pozycje_zamowienia.id_produktu
                    JOIN status_zamowienia ON status_zamowienia.id_status_zamowienia = zamowienia.status
                    JOIN firma ON firma.nip = zamowienia.nip
                    JOIN adres ON adres.id_adres = firma.id_adres
                    JOIN miejscowosc ON miejscowosc.id_miejscowosc = adres.id_adres
                    JOIN ulica ON ulica.id_ulicy = adres.id_ulicy
                    JOIN kod_pocztowy ON kod_pocztowy.id_kod_pocztowy = adres.id_kod_pocztowy
                    WHERE faktura.id_faktury = $id";
            return $this->executeQuery($sql);
        }

        public function getInvoiceByNIP(string $nip): array {
            $sql = "SELECT faktura.id_faktury, zamowienia.nip, zamowienia.data_wyslania, status_zamowienia.status, zamowienia.data_zamowienia 
                    FROM `faktura` 
                    JOIN zamowienia ON zamowienia.id_zamownienia = faktura.id_zamowienia 
                    JOIN status_zamowienia ON status_zamowienia.id_status_zamowienia = zamowienia.status 
                    WHERE zamowienia.nip = '$nip'";   
            return $this->executeQuery($sql);
        }
    }
?>