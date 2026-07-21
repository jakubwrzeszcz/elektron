<?php

class CartController {

    private function init(): void {
        session_start();
        if (!isset($_SESSION['koszyk'])) {
            $_SESSION['koszyk'] = [];
        }
    }

    private function getProductId(): ?int {
        $id = (int)($_POST['produkt_id'] ?? 0);
        if ($id <= 0) {
            return null;
        }
        return $id;
    }

    public function index() {
        $this->init();
        require_once __DIR__ . '/../config.php';

        $koszyk = $_SESSION['koszyk'];
        $produkty = [];
        $suma = 0;

        if (!empty($koszyk)) {

            $ids = implode(',', array_keys($koszyk));

            $wynik = mysqli_query($polaczenie, "
                SELECT id_produktu, nazwa, cena_brutto
                FROM produkty
                WHERE id_produktu IN ($ids)
            ");

            while ($row = mysqli_fetch_assoc($wynik)) {
                $ilosc = $koszyk[$row['id_produktu']];
                $razem = $ilosc * $row['cena_brutto'];
                $row['ilosc'] = $ilosc;
                $row['razem'] = $razem;
                $produkty[] = $row;
                $suma += $razem;
            }
        }
        require __DIR__ . '/../views/cart/Cart.php';
    }

    public function add() {
        $this->init();

        $id = $this->getProductId();
        if (!$id) {
            header("Location: /elektron/koszyk");
            exit;
        }

        $_SESSION['koszyk'][$id] = ($_SESSION['koszyk'][$id] ?? 0) + 1;
        header("Location: /elektron/koszyk");
        exit;
    }

    public function remove() {
        $this->init();

        $id = $this->getProductId();
        if (!$id) {
            header("Location: /elektron/koszyk");
            exit;
        }
        unset($_SESSION['koszyk'][$id]);
        header("Location: /elektron/koszyk");
        exit;
    }

    public function decrease() {
        $this->init();

        $id = $this->getProductId();
        if (!$id) {
            header("Location: /elektron/koszyk");
            exit;
        }

        if (isset($_SESSION['koszyk'][$id])) {
            $_SESSION['koszyk'][$id]--;
            if ($_SESSION['koszyk'][$id] <= 0) {
                unset($_SESSION['koszyk'][$id]);
            }
        }
        header("Location: /elektron/koszyk");
        exit();
    }

    public function increase() {

        $this->init();
        $id = $this->getProductId();
        if (!$id) {
            header("Location: /elektron/koszyk");
            exit;
        }

        $_SESSION['koszyk'][$id] = ($_SESSION['koszyk'][$id] ?? 0) + 1;
        header("Location: /elektron/koszyk");
        exit;
    }
}