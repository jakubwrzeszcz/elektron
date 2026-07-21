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
            <div class="page-header">
                <img src="../img/name-icon.svg" class="nav-logo" alt="Ikona profilu">
                <div class="page-header-text">
                    <h1>Przeglądanie profilu</h1>
                </div>
            </div>
            <section class='profile-container'>
                <?php
                    echo "
                    <section class='profile-wrapper'>
                    <div class='profile-cardheader'>
                            <div class='profile-avatar'>
                                <img src='../img/name-icon.svg' alt='Pracownik'>
                            </div>
                            <div class='profile-summary'>
                                <h1>{$row['imie']} {$row['nazwisko']}</h1> <span class='badge-role'>{$row['nazwa_stanowiska']}</span>
                            </div>
                        </div>

                        <div class='profile-grid'>
                            <div class='profile-section-box'>
                                <h2>
                                    <img src='../img/company.svg' alt='Firma' class='section-icon'> 
                                    <span>Stanowisko i uprawnienia</span>
                                </h2>
                                <div class='info-group'>
                                    <label>Obecne stanowisko</label>
                                    <p>{$row['nazwa_stanowiska']}</p>
                                </div>
                            </div>

                            <div class='profile-section-box'>
                                <h2>
                                    <img src='../img/town.svg' alt='Adres' class='section-icon'> 
                                    Dane adresowe
                                </h2>
                                
                                <div class='info-group full-width'>
                                    <label>Ulica i numer</label>
                                    <p>{$row['nazwa_ulicy']} {$row['numer_firmy']}</p>
                                </div>
                                
                                <div class='info-row'>
                                    <div class='info-group'>
                                        <label>Kod pocztowy</label>
                                        <p>{$row['kod_pocztowy']}</p>
                                    </div>
                                    <div class='info-group'>
                                        <label>Miejscowość</label>
                                        <p>{$row['nazwa_miejscowosci']}</p>
                                    </div>
                                </div>

                                <div class='info-group'>
                                    <label>Województwo</label>
                                    <p>{$row['wojewodztwo']}</p>
                                </div>
                            </div>
                        </div>
                    </section>";
                ?>
            </section>
        </main>
    </div>
    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz | Elektron Sp. z o.o.</p>
    </footer>
</body>
</html>