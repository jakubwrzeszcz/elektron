<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Elektron | Panel Administracyjny</title>
    <link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body>
    <div class="container">
        <div class="menu">
            <div class="menu-logo">
                <img src="img/elektron.svg" alt="logo">
            </div>
            <?php
                if($_SESSION['typ_sesji'] === 'klient') {
                    echo "
                        <p class='profile-label'>Imie: " . $_SESSION['imie'] . "</p>
                        <p class='profile-label'>Nazwisko: " . $_SESSION['nazwisko'] . "</p>
                        <p class='profile-label'>Email: " . $_SESSION['adres_email'] . "</p>
                    ";
                } elseif($_SESSION['typ_sesji'] === 'firma') {
                    echo "
                        <p class='profile-label'>NIP: " . $_SESSION['nip'] . "</p>
                        <p class='profile-label'>REGON: " . $_SESSION['regon'] . "</p>
                        <p class='profile-label'>KRS: " . $_SESSION['krs'] . "</p>
                    ";
                }
            ?>
            <a class="menu-link" href="/elektron/produkty">Produkty</a>
            <a class="menu-link" href="/elektron/koszyk">Koszyk</a>
            <a class="menu-link" href="javascript: history.back()">Powrót</a>
            <a class="menu-link" href="/elektron/wylogowanie">Wyloguj</a>
        </div>
        <main>
            <div class="page-header">
                <img src="img/faktura.svg" class="nav-logo" alt="Ikona profilu">
                <div class="page-header-text">
                    <h1>Przeglądanie profilu</h1>
                </div>
            </div>
            <section class='profile-container'>
                <?php
                    foreach ($row as $pearsonRow):

                    echo "
                    <section class='profile-wrapper'>
                    <div class='profile-cardheader'>
                            <div class='profile-avatar'>
                                <img src='../img/name-icon.svg' alt='Pracownik'>
                            </div>
                            <div class='profile-summary'>
                                <h1>";
                                    if($_SESSION['typ_sesji'] == 'klient') {
                                        echo "{$pearsonRow['imie']} {$pearsonRow['nazwisko']}";
                                    } else if($_SESSION['typ_sesji'] == 'firma') {
                                        echo "{$pearsonRow['nazwa_firmy']}";
                                    }
                    echo        "</h1>
                                <span class='badge-role'>Klient</span>
                            </div>
                        </div>

                        <div class='profile-grid'>
                            <div class='profile-section-box'>
                                <h2>
                                    <img src='../img/town.svg' alt='Adres' class='section-icon'> 
                                    Dane adresowe
                                </h2>
                                
                                <div class='info-row'>
                                    <div class='info-group'>
                                        <label>Ulica i numer</label>
                                        <p>{$pearsonRow['nazwa_ulicy']} {$pearsonRow['numer_firmy']}</p>
                                    </div>
                                    <div class='info-group'>
                                        <label>Kod pocztowy</label>
                                        <p>{$pearsonRow['kod_pocztowy']}</p>
                                    </div>
                                    <div class='info-group'>
                                        <label>Miejscowość</label>
                                        <p>{$pearsonRow['nazwa_miejscowosci']}</p>
                                    </div>
                                    <div class='info-group'>
                                        <label>Województwo</label>
                                        <p>{$pearsonRow['wojewodztwo']}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>";
                    endforeach;
                ?>
            </section>
        </main>
    </div>
    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz | Elektron Sp. z o.o.</p>
    </footer>
</body>
</html>