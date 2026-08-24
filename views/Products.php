<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Elektron | Produkty</title>
    <link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body>
    
    <div class="container">
        <?php require __DIR__ . '/menu.php'; ?>

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
                                name='produkt_id'
                                value='{$row['id_produktu']}'
                                class='button add-to-cart-btn'>
                                Dodaj do koszyka
                            </button>
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

<script>
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            const idProduktu = this.getAttribute('value');

            fetch('/elektron/koszyk/dodaj', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'produkt_id=' + encodeURIComponent(idProduktu)
            })
            .then(response => response.text())
            .then(data => {
                this.textContent = 'Dodano! ✓';
                this.style.backgroundColor = '#2ecc71';

                setTimeout(() => {
                    this.textContent = 'Dodaj do koszyka';
                    this.style.backgroundColor = ''; 
                }, 1500);
            })
            .catch(error => console.error('Błąd:', error));
        });
    });
</script>