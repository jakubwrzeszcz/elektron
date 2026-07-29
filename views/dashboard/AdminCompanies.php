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
                <img src="../img/company.svg" class="nav-logo" alt="Ikona firmy">
                <div class="page-header-text">
                    <h1>Zarządzanie firmami</h1>
                    <p>Wyświetlanie firm z bazy danych</p>
                </div>
            </div>

            <div class="search-box">
                <form method="POST" action="admin.php?podstrona=firmy" class="search-form">
                    <input type="text" name="nip" class="search-input" placeholder="Wpisz NIP firmy do wyszukania..." size=10 min=10000000000 max=9999999999 required>
                    <button type="submit" class="search-button">Szukaj</button>
                </form>
            </div>

            <?php if ((isset($no_records) && $no_records === true) || empty($companies_list)): ?>
                <div class="search-box" style="margin-top: 20px;">
                    <p style="color: var(--font_color); margin: 0; text-align: center; font-weight: bold;">
                        Brak zarejestrowanych firmie w bazie danych dla podanych kryteriów.
                    </p>
                </div>
            <?php else: ?>
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>NIP</th> 
                                <th>KRS</th>
                                <th>REGON</th>
                                <th>Nazwa firmy</th>
                                <th>Województwo</th>
                                <th>Miejscowość</th>
                                <th>Ulica</th>
                                <th>Numer</th>
                                <th>Kod pocztowy</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($companies_list as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nip']) ?></td>
                                    <td><?= htmlspecialchars($row['krs']) ?></td>
                                    <td><?= htmlspecialchars($row['regon']) ?></td>
                                    <td><?= htmlspecialchars($row['nazwa_firmy']) ?></td>
                                    <td><?= htmlspecialchars($row['wojewodztwo']) ?></td>
                                    <td><?= htmlspecialchars($row['nazwa_miejscowosci']) ?></td>
                                    <td><?= htmlspecialchars($row['nazwa_ulicy']) ?></td>
                                    <td><?= htmlspecialchars($row['numer_firmy']) ?></td>
                                    <td><?= htmlspecialchars($row['kod_pocztowy']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

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