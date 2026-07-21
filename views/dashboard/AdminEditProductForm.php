<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Elektron | Panel Administracyjny</title>
    <link rel="stylesheet" href="../../style.css" type="text/css">
</head>
<body>
    <div class="container">
        <?php require __DIR__ . '../../menu.php'; ?>
        <main>
            <div class="page-header">
                <img src="../../img/faktura.svg" style="height: 100px" class="nav-logo" alt="Ikona produktu">
                <div class="page-header-text">
                    <h1>Edytowanie produktu</h1>
                </div>
            </div>

            <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                <?php if (isset($success) && $success === true): ?>
                    <div style="color: #27ae60; background-color: #e8f8f5; border: 1px solid #27ae60; padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; font-weight: bold;">
                        Zmiany zostały pomyślnie zapisane!
                    </div>
                <?php elseif (isset($error_message)): ?>
                    <div style="color: #c0392b; background-color: #f9ead9; border: 1px solid #c0392b; padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; font-weight: bold;">
                        Błąd: <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
     
            <div class="login-box">
                <?php if (isset($product_row) && $product_row): ?>
                    
                    <form id="demo-form" class="loginForm" action="/elektron/admin/produkt/aktualizuj" method="post">
                        <input type="hidden" name="productID" value="<?php echo $product_row['id_produktu']; ?>">
                        <label for="productName">Nazwa produktu</label>
                        <input class="form-input" type="text" id="productName" name="productName" value="<?php echo htmlspecialchars($product_row['nazwa']); ?>" required>
                        <label for="grossPrice">Podaj cenę brutto</label>
                        <input class="form-input" type="number" name="grossPrice" step="0.01" min="0.01" id="grossPrice" value="<?php echo $product_row['cena_brutto']; ?>" required>
                        <label for="netPrice">Podaj cenę netto</label>
                        <input class="form-input" type="number" id="netPrice" step="0.01" name="netPrice" value="<?php echo $product_row['cena_netto']; ?>" required>
                        <label for="description">Opis</label>
                        <textarea class="form-input" id="description" name="description" required><?php echo htmlspecialchars($product_row['opis']); ?></textarea>
                        <label for="isAvailable">Dostępność</label>
                        <select class="form-input" name="isAvailable" id="isAvailable">
                            <option value="TAK" <?php echo ($product_row['czy_dostepne'] === 'TAK') ? 'selected' : ''; ?>>TAK</option>
                            <option value="NIE" <?php echo ($product_row['czy_dostepne'] === 'NIE') ? 'selected' : ''; ?>>NIE</option>
                        </select>
                        <button id="submit-btn" class="button button-add" type="submit">Zapisz zmiany</button>
                    </form>
                
                <?php else: ?>
                    <p style="color: #e74c3c; text-align: center; font-weight: bold;">Nie znaleziono produktu o podanym ID lub wystąpił błąd ładowania.</p>
                <?php endif; ?>
                <?php
                    if(isset($_SESSION['blad'])){
                        echo '<p style="color: #e74c3c">' . $_SESSION['blad'] . '</p>';
                        unset($_SESSION['blad']); // Dobra praktyka: czyść błąd po wyświetleniu
                    }
                ?>
            </div>

            <div class="buttons">
                <a href="/elektron/admin" class="button button-back">Powrót do menu</a>
            </div>
        </main>
    </div>

    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz | Elektron Sp. z o.o.</p>
    </footer>
</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const grossInput = document.getElementById("grossPrice");
        const netInput = document.getElementById("netPrice");

        grossInput.addEventListener("input", function() {
            let grossPrice = parseFloat(grossInput.value);

            if (!isNaN(grossPrice) && grossPrice > 0) {
                let netPrice = grossPrice / 1.23;
                netInput.value = netPrice.toFixed(2);
            } else {
                netInput.value = "";
            }
        });
    });
</script>