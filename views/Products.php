<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Elektron | Produkty</title>
    <link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body>
    
    <div class="container">
        <?php require __DIR__ . '../../menu.php'; ?>

        <main>
            <header class="topbar">
                <form method="POST" action="produkty.php">
                    <input type="text" name="produkt" class="search-input" placeholder="Wpisz produkt do wyszukania...">
                    <button type="submit" class="search-button">Szukaj</button>
                </form>
                <div class="topbar-icons">
                    <span><a style="text-decoration: none" href="/elektron/koszyk">🛒</a></span>
                    <span><a style="text-decoration: none" href="/elektron/profil">👤</a></span>
                </div>
            </header>

            <form action="koszyk-logika.php" method="POST">
                <section class='products'>
                    <?php
                        if($no_records) {
                            echo "<p style='color: #e74c3c'>Nie znaleziono wpisanego produktu.</p>";
                        }

                        foreach ($product_list as $row) {
                            echo "
                            <div class='product'>
                                <h3>{$row['nazwa']}</h3>
                                <h4>Cena: {$row['cena_brutto']} PLN</h4>
                                <p>{$row['opis']}</p>
                                <button
                                    type='button'
                                    href='edytuj.php'
                                    value='{$row['id_produktu']}'
                                    class='button'>
                                    Dodaj do koszyka
                                </button>
                            </div>";
                        } 
                    ?>
                </section>
            </form>
        </main>
    </div>

    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz | Elektron Sp. z o.o.</p>
    </footer>

</body>
</html>