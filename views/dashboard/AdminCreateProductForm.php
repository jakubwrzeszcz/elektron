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
                    <h1>Dodawanie produktów</h1>
                </div>
            </div>

            <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                <?php if (isset($success) && $success === true): ?>
                    <div style="color: #27ae60; background-color: #e8f8f5; border: 1px solid #27ae60; padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; font-weight: bold;">
                        Produkt został pomyślnie dodany do bazy danych!
                    </div>
                <?php elseif (isset($error_message)): ?>
                    <div style="color: #c0392b; background-color: #f9ead9; border: 1px solid #c0392b; padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; font-weight: bold;">
                        Błąd podczas dodawania produktu: <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
     
            <div class="login-box">
                <form id="demo-form" class="loginForm" action="/elektron/admin/produkt/dodaj" method="post">
                    <label for="productName">Nazwa produktu</label>
                    <input class="form-input" type="text" name="productName" required>
                    <label for="netPrice">Podaj cenę brutto</label>
                    <input class="form-input" type="number" name="grossPrice" step="0.01" min="0.01" id="grossPrice" required>
                    <label for="grossPrice">Podaj cenę netto</label>
                    <input class="form-input" type="number" id="netPrice" step="0.01" name="netPrice" required>
                    <label for="description">Opis</label>
                    <textarea class="form-input" name="description" required></textarea>
                    <label for="isAvailable">Dostępność</label>
                    <select class="form-input" name="isAvailable" id="isAvailable">
                        <option class="form-input" value="TAK">TAK</option>
                        <option class="form-input" value="NIE">NIE</option>
                    </select>
                    <button id="submit-btn" class="button button-add" type="sumbit">Dodaj produkt</button>

                </form>
                    <?php
                        if(isset($_SESSION['blad'])){
                            echo '<p style="color: #e74c3c">' . $_SESSION['blad'] . '</p>';
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