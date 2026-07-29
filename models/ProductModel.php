<?php
    require_once "Models.php";

    class ProductModel extends Models {
        public function getAllProducts(): array {
            $sql = "SELECT produkty.id_produktu, produkty.nazwa, produkty.opis, produkty.cena_brutto FROM produkty WHERE produkty.czy_dostepne = 'TAK'";
            return $this->executeQuery($sql);
        }

        public function getAdminAllProducts(): array {
            $sql = "SELECT produkty.id_produktu, produkty.nazwa, produkty.opis, produkty.cena_netto, produkty.cena_brutto, produkty.czy_dostepne FROM produkty";
            return $this->executeQuery($sql);
        }

        public function getProductByID(int $productID) {
            $sql = "SELECT produkty.id_produktu, produkty.nazwa, produkty.opis, produkty.cena_netto, produkty.cena_brutto, produkty.czy_dostepne FROM produkty WHERE produkty.id_produktu = $productID";
            return $this->executeQuery($sql);
        }

        public function insertProduct(string $productName, int $grossPrice, int $netPrice, string $description, string $isAvailable) {
            $sql = "INSERT INTO `produkty`(`id_produktu`, `nazwa`, `opis`, `cena_netto`, `cena_brutto`, `czy_dostepne`) VALUES(NULL, '$productName', '$description', $netPrice, $grossPrice, '$isAvailable')";
            return $this->executeUpsertQuery($sql);
        }

        public function deleteProduct(int $productID) {
            $sql = "DELETE FROM `produkty` WHERE produkty.id_produktu = $productID";
            return $this->executeDeleteQuery($sql);
        }

        public function updateProduct(int $productID, string $productName, int $grossPrice, int $netPrice, string $description, string $isAvailable) {
            $sql = "UPDATE `produkty` SET `nazwa`='$productName', `opis`='$description', `cena_netto`=$netPrice, `cena_brutto`=$grossPrice,`czy_dostepne`='$isAvailable' WHERE `id_produktu`=$productID";
            return $this->executeUpsertQuery($sql);
        }
    }
?>