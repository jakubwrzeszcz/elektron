<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Elektron | Panel Administracyjny</title>
    <link rel="stylesheet" href="../style.css" type="text/css">
    <script src="https://www.google.com/recaptcha/api.js?render=6LdD0IMsAAAAALlC1-TNJl0ZGD_7zrGIHUWmJ7Dj"></script>
</head>
<body>
    <main>
        <div class="container">     
            <div class="login-box">
                <h1 class="form-header">Logowanie do panelu administracyjnego</h1>
                <h3 class='warning'>Jeśli nie jesteś pracownikiem sklepu, nie loguj się do tego panelu. <a href="/elektron/login">Kliknij tutaj</a></h3>
                <form id="demo-form" class="loginForm" action="/elektron/admin/logowanie" method="post">
                    <label>Podaj email</label>
                    <input class="form-input fieldLogin" type="text" name="login" required>
                    <label for="">Podaj hasło</label>
                    <input class="form-input fieldLogin" type="password" name="password" required>
                    <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                    <button id="submit-btn" class="button button-add" type="button">Zaloguj</button>
                </form>
                    <?php
                        if(isset($_SESSION['blad'])){
                            echo '<p style="color: #e74c3c">' . $_SESSION['blad'] . '</p>';
                        }
                    ?>
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