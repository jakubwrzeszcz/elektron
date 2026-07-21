<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Elektron | Logowanie</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <script src="https://www.google.com/recaptcha/api.js?render=6LdD0IMsAAAAALlC1-TNJl0ZGD_7zrGIHUWmJ7Dj"></script>
</head>
<body>
    <main>
        <div class="container">     
            <div class="login-box">
                <h1 class="form-header">Logowanie do sklepu Elektron</h1>
                <form id="demo-form" class="loginForm" action="/elektron/logowanie" method="post">
                    <select class="form-input fieldLogin" name="typ_logowania" id="typ_logowania">
                        <option value="">--wybierz typ konta--</option>
                        <option value="klient">Klient</option>
                        <option value="firma">Firma</option>
                    </select>
                    <label>Podaj email</label>
                    <input class="form-input fieldLogin" type="text" name="login" required>
                    <label>Podaj hasło</label>
                    <input class="form-input fieldLogin" type="password" name="password" required>
                    <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                    <button id="submit-btn" class="button button-add" type="submit">Zaloguj</button>
                </form>
                    <?php
                        if(isset($_SESSION['blad'])){
                            echo '<p style="color: #e74c3c">' . $_SESSION['blad'] . '</p>';
                        }
                    ?>
                <a class='form link' href="typ_logowania#">Nie masz konta? Zarejestruj się</a>
            </div>
        </div>
    </main>

    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz | Elektron Sp. z o.o.</p>
    </footer>
</body>
</html>

<script>
    document.getElementById('submit-btn').addEventListener('click', function() {
        grecaptcha.execute('6LdD0IMsAAAAALlC1-TNJl0ZGD_7zrGIHUWmJ7Dj', {action: 'login'}).then(function(token) {
            document.getElementById('recaptcha_token').value = token;
            if(document.getElementById('demo-form').checkValidity()) {
                document.getElementById('demo-form').submit()
            }
        });
    });
</script>