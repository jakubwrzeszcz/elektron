<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Elektron | Koszyk</title>
    <link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body>
    
    <div class="container">
        <div class="menu">
            <div class="menu-logo">
                <img src="img/elektron.svg" alt="logo">
            </div>
            <a href="#" class="menu-link">Rutery</a>
            <a href="#" class="menu-link">Przełączniki</a>
            <a href="#" class="menu-link">Wyłączniki nadprądowe</a>
            <a href="#" class="menu-link">Wyłączniki różnicowoprądowe</a>
            <a href="#" class="menu-link">Elektronika</a>
            <a href="#" class="menu-link">Komputery jednopłytkowe</a>
        </div>

        <main>
            <div class="page-header">
                <img src="img/faktura.svg" class="nav-logo" alt="Ikona koszyka">
                <div class="page-header-text">
                    <h1>Przeglądanie koszyka</h1>
                </div>
            </div>

            <section class="koszyk">
                <h2 style="color: white">Zawartość koszyka</h2>

                <?php if (empty($produkty)): var_dump($produkty)?>
                    <!-- <p>Koszyk jest pusty</p> -->
                <?php else: ?>

                <table class="cart-table">
                    <thead>
                        <tr>
                            <th class="col-product">Produkt</th>
                            <th class="col-qty">Ilość</th>
                            <th class="col-price">Cena</th>
                            <th class="col-total">Razem</th>
                            <th class="col-actions">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produkty as $p): ?>
                            <tr>
                                <td class="col-product"><?= htmlspecialchars($p['nazwa']) ?></td>
                                <td class="col-qty"><?= $p['ilosc'] ?></td>
                                <td class="col-price"><?= number_format($p['cena_brutto'], 2) ?> PLN</td>
                                <td class="col-total"><?= number_format($p['razem'], 2) ?> PLN</td>
                                <td class="col-actions">
                                    <div class="actions-cell">
                                        <form method="POST" action="/elektron/koszyk/zwieksz">
                                            <input type="hidden" name="produkt_id" value="<?= $p['id_produktu'] ?>">
                                            <button type="submit" class="button button-add" title="Zwiększ ilość">+</button>
                                        </form>

                                        <form method="POST" action="/elektron/koszyk/zmniejsz">
                                            <input type="hidden" name="produkt_id" value="<?= $p['id_produktu'] ?>">
                                            <button type="submit" class="button button-back" title="Zmniejsz ilość">-</button>
                                        </form>

                                        <form method="POST" action="/elektron/koszyk/usun">
                                            <input type="hidden" name="produkt_id" value="<?= $p['id_produktu'] ?>">
                                            <button type="submit" class="button button-remove">Usuń</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <p><b>Suma: <?= $suma ?> PLN</b></p>

                <?php endif; ?>
            </section>
            <a class='link' href="/elektron/produkty">⬅ Wróć do produktów</a>
        </main>
    </div>

    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz | Elektron Sp. z o.o.</p>
    </footer>

</body>
</html>