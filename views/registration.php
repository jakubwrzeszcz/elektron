<?php
    session_start();
    require_once "config.php";
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Elektron | Rejestracja</title>
    <link rel="stylesheet" href="../style.css" type="text/css">
    <script src="https://www.google.com/recaptcha/api.js?render=6LdD0IMsAAAAALlC1-TNJl0ZGD_7zrGIHUWmJ7Dj"></script>
</head>
<body>
    <main>
        <div class="container">     
            <div class="login-box">
                <h1 class="form-header">Rejestracja do sklepu Elektron</h1>
                <form id="demo-form" class="loginForm" action="rejestracja.php" method="post">
                    <select class="form-input fieldLogin" name="typ_logowania" id="typ_logowania">
                        <option value="">--wybierz typ konta--</option>
                        <option value="klient">Klient</option>
                        <option value="firma">Firma</option>
                    </select>
                    <section id="pola_klient" class="form-section" style="display: none">
                        <label for="imie">Imię</label>
                        <input class="form-input fieldLogin" type="text" name='imie'>
                        <label for="nazwisko">Nazwisko</label>
                        <input class="form-input fieldLogin" type="text" name="nazwisko">
                        <label for="adres_email">Adres email</label>
                        <input class="form-input fieldLogin" type="email" name="adres_email">
                        <label for="login">Login</label>
                        <input class="form-input fieldLogin" type="text" name="login">
                    </section>

                    <section id="pola_firma" class="form-section" style="display: none">
                        <label>Nazwa firmy</label>
                        <input class="form-input fieldLogin" type="text">
                        <label for="nip">NIP</label>
                        <input class="form-input fieldLogin" name="nip" type="text">
                        <label for="regon">REGON</label>
                        <input class="form-input fieldLogin" name="regon" type="text">
                        <label for="krs">KRS</label>
                        <input class="form-input fieldLogin" name="krs" type="text">
                        <label for="wojewodztwo">Województwo</label>
                        <input class="form-input fieldLogin" name="wojewodztwo" type="text">
                        <label for="miejsctowosc">Miejscowość</label>
                        <input class="form-input fieldLogin" name="miejsctowosc" type="text">
                        <label for="ulica">Ulica</label>
                        <input class="form-input fieldLogin" name="ulica" type="text">
                        <label for="numer">Numer adresu</label>
                        <input class="form-input fieldLogin" name="numer" type="text">
                    </section>

                    <label>Podaj hasło</label>
                    <input class="form-input fieldLogin" type="password" id="password" name="password" onpaste="return false" >
                    <label>Powtórz hasło</label>
                    <input class="form-input fieldLogin" type="password" id="passwordRepeat" name="passwordRepeat" onpaste="return false">
                    <div name="conditions" style="display: none"></div>
                    <label id="passwordInfo" style="display: none"></label>
                    <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                    <button id="submit-btn" class="button button-add" type="submit">Zarejestruj</button>
                </form>
                    <?php
                        if(isset($_SESSION['blad'])){
                            echo '<p style="color: #e74c3c">' . $_SESSION['blad'] . '</p>';
                        }
                    ?>
                <a class='form link' href="logowanie.php">Masz konto? Zaloguj się</a>
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

    document.getElementById('typ_logowania').addEventListener('change', function() {
        const value = this.value;
        const klient = document.getElementById('pola_klient');
        const firma = document.getElementById('pola_firma');

        if (value === 'klient') {
            klient.style.display = 'flex';
            klient.style.flexDirection = 'column';
            klient.style.gap = '10px';
            firma.style.display = 'none';
        } else if (value === 'firma') {
            klient.style.display = 'none';
            firma.style.display = 'flex';
            firma.style.flexDirection = 'column';
            firma.style.gap = '10px';
        } else if (value === '') {
            klient.style.display = 'none';
            firma.style.display = 'none';
        }
    });

    function validatePassword() {
        const minLength = 14;
        const maxLength = 64;
        const passwordLength = document.getElementById('password').value.length;
        const minOk = passwordLength >= minLength;
        const maxOk = passwordLength <= maxLength;

        document.getElementById('passwordInfo').innerHTML = `
            <ul>
                <li>${minOk ? '✅' : '❌'} Co najmniej ${minLength} znaków</li>
                <li>${maxOk ? '✅' : '❌'} Maksymalnie ${maxLength} znaki</li>
            </ul>
        `;
        document.getElementById('passwordInfo').style.display = 'block';
    }

    document.getElementById('password').addEventListener('input', validatePassword);
    
    document.getElementById("passwordRepeat").addEventListener('focus', function() {
        document.getElementById('passwordInfo').style.display = 'none';
    });

    document.getElementById("passwordRepeat").addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const passwordRepeat = document.getElementById('passwordRepeat').value;

        if(passwordRepeat == password) {
            document.getElementById("passwordInfo").innerHTML = "<span style='color: green'>Hasła są takie same</span>";
            document.getElementById("passwordInfo").style.display = "block";
        } else {
            document.getElementById("passwordInfo").innerHTML = "<span style='color: red'>Hasła nie są takie same</span>";
            document.getElementById("passwordInfo").style.display = "block";
        }
    });
</script>