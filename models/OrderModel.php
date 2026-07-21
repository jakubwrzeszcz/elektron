<?php
    require_once "Models.php";

    class OrderModel extends Models {
        public function getAllOrders(): array {
            $sql = 'SELECT zamowienia.id_zamownienia, zamowienia.nip, firma.regon, firma.krs, firma.nazwa_firmy FROM zamowienia JOIN firma ON firma.nip = zamowienia.nip';

            return $this->executeQuery($sql);
        }
    }
?>