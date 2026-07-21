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
                <img src="" class="nav-logo" alt="Ikona pracowników">
                <div class="page-header-text">
                    <h1>Zarządzanie pracownikami</h1>
                    <p>Dodawanie, edycja i usuwanie pracowników z bazy danych</p>
                </div>
            </div>

            <?php if (isset($no_records) && $no_records === true || empty($personRow)): ?>
                <div class="search-box">
                    <p style="color: var(--font_color); margin: 0; text-align: center; font-weight: bold;">
                        Brak zarejestrowanych pracowników w bazie danych.
                    </p>
                </div>
            <?php else: ?>
                
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Imię i Nazwisko</th>
                                <th>Stanowisko</th>
                                <th>Kontakt</th>
                                <th>Adres zamieszkania</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($personRow as $worker): ?>
                                <tr>
                                    <td>
                                        <strong><?= $worker['imie'] ?> <?= $worker['nazwisko'] ?></strong>
                                    </td>
                                    
                                    <td>
                                        <strong><?= $worker['nazwa_stanowiska'] ?></strong>
                                    </td>
                                    
                                    <td>
                                        <div>📧 <?= $worker['adres_email'] ?></div>
                                        <div style="font-size: 13px; color: var(--font_color); margin-top: 4px;">
                                            📞 <?= $worker['telefon'] ?>
                                        </div>
                                    </td>
                                    
                                    <td style="font-size: 14px; line-height: 1.4;">
                                        <div>
                                            ul. <?= $worker['nazwa_ulicy'] ?> <?= $worker['numer_firmy'] ?>
                                        </div>
                                        <div>
                                            <?= $worker['kod_pocztowy'] ?> <?= $worker['nazwa_miejscowosci'] ?>
                                        </div>
                                        <div style="font-size: 11px; color: #7f8c8d; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Woj. <?= $worker['wojewodztwo'] ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>

            <div class="buttons">
                <a href="/elektron/admin" class="button button-back">Powrót do menu</a>
                <a href="/elektron/dodaj.php?podstrona=pracownicy" class="button button-add">Dodaj nowego pracownika</a>
            </div>
            
        </main>
    </div>

    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz | Elektron Sp. z o.o.</p>
    </footer>

</body>
</html>