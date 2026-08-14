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
    <link rel="stylesheet" href="style.css" type="text/css">
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

                <?php if (empty($produkty)): ?>
                    <p>Koszyk jest pusty</p>
                <?php else: ?>

                <table>
                    <tr>
                        <th>Produkt</th>
                        <th>Ilość</th>
                        <th>Cena</th>
                        <th>Razem</th>
                        <th>Akcje</th>
                    </tr>

                    <?php foreach ($produkty as $p): ?>
                        <tr>
                            <td><?= $p['nazwa'] ?></td>
                            <td><?= $p['ilosc'] ?></td>
                            <td><?= $p['cena_brutto'] ?></td>
                            <td><?= $p['razem'] ?></td>
                            <td>
                                <form method="POST" action="/elektron/koszyk/add">
                                    <input type="hidden" name="produkt_id" value="<?= $p['id_produktu'] ?>">
                                    <button>+</button>
                                </form>

                                <form method="POST" action="/elektron/koszyk/decrease">
                                    <input type="hidden" name="produkt_id" value="<?= $p['id_produktu'] ?>">
                                    <button>-</button>
                                </form>

                                <form method="POST" action="/elektron/koszyk/remove">
                                    <input type="hidden" name="produkt_id" value="<?= $p['id_produktu'] ?>">
                                    <button>Usuń</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <p><b>Suma: <?= $suma ?> PLN</b></p>

                <?php endif; ?>
                    <a class='link' href="/elektron/produkty">⬅ Wróć do produktów</a>
            </section>
        </main>
    </div>

    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz | Elektron Sp. z o.o.</p>
    </footer>

</body>
</html>