<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Elektron | Panel Administracyjny</title>
    <link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body>
    <div class="container">
        <?php require __DIR__ . '../../menu.php'; ?>

        <main>
            <header class="topbar">
                <form method="POST" action="/elektron/admin/produkty">
                    <input type="text" name="produkt" class="search-input" placeholder="Wpisz produkt do wyszukania...">
                    <button type="submit" class="search-button">Szukaj</button>
                </form>
                <div class="topbar-icons">
                    <span><a style="text-decoration: none" href="/elektron/admin/profil">👤</a></span>
                </div>
            </header>

            <?php if (isset($_SESSION['flash_success_remove']) && $_SESSION['flash_success_remove'] === true): ?>
                <div style="color: #27ae60; background-color: #e8f8f5; border: 1px solid #27ae60; padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; font-weight: bold;">
                    Produkt został pomyślnie usunięty do bazy danych!
                </div>
                <?php unset($_SESSION['flash_success_remove']);?>
            <?php elseif (isset($error_message)): ?>
                <div style="color: #c0392b; background-color: #f9ead9; border: 1px solid #c0392b; padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; font-weight: bold;">
                    Błąd podczas usuwania produktu: <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['flash_success_update']) && $_SESSION['flash_success_update'] === true): ?>
                <div style="color: #27ae60; background-color: #e8f8f5; border: 1px solid #27ae60; padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; font-weight: bold;">
                    Produkt został pomyślnie zapisany do bazy danych!
                </div>
                <?php unset($_SESSION['flash_success_update']);?>
            <?php elseif (isset($error_message)): ?>
                <div style="color: #c0392b; background-color: #f9ead9; border: 1px solid #c0392b; padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; font-weight: bold;">
                    Błąd podczas zapisywania produktu: <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <div class="buttons">
                <a href="/elektron/admin" class="button button-back">Powrót do menu</a>
                <a href="/elektron/admin/produkt/dodaj" class="button button-add">Dodaj nowy produkt</a>
            </div>

           <section class='products'>
                <?php
                    if($no_records) {
                        echo "<p style='color: #e74c3c'>Nie znaleziono wpisanego produktu.</p>";
                    }

                    foreach ($product_list as $row) {
                        echo "
                        <div class='product'>
                            <h3>{$row['nazwa']}</h3>
                            <h4>Brutto: {$row['cena_brutto']} PLN</h4>
                            <h4>Netto: {$row['cena_netto']} PLN</h4>
                            <h4>Dostępne: {$row['czy_dostepne']}</h4>
                            <p>{$row['opis']}</p>
                            <div class='buttons'>
                                <form method='post' action='/elektron/admin/produkt/edytuj'>                            
                                    <button
                                        name='productID'
                                        class='button button-add'
                                        type='submit'
                                        value='{$row['id_produktu']}'>
                                        Edytuj produkt
                                    </button>
                                </form>
                                <form method='post' action='/elektron/admin/produkt/usun'>   
                                    <button
                                        name='productID'
                                        class='button button-remove'
                                        type='submit'
                                        value='{$row['id_produktu']}'>
                                        Usuń produkt
                                    </button>
                                </form>
                            </div>
                        </div>";
                    } 
                ?>
            </section>

        </main>
    </div>

    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz | Elektron Sp. z o.o.</p>
    </footer>

</body>
</html>