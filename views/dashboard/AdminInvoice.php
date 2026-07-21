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
                <img src="img/faktura.svg" style="height: 100px" class="nav-logo" alt="Ikona faktury">
                <div class="page-header-text">
                    <h1>Zarządzanie fakturami</h1>
                    <p>Dodawanie, edycja i usuwanie faktur z bazy danych</p>
                </div>
            </div>

            <div class="search-box">
                <form method="POST" action="/elektron/admin/faktury" class="search-form">
                    <input type="text" name="nip" class="search-input" placeholder="Wpisz NIP firmy do wyszukania..." required>
                    <button type="submit" class="search-button">Szukaj</button>
                </form>
            </div>

            <?php if ((isset($no_records) && $no_records === true) || empty($invoices_list)): ?>
                <div class="search-box" style="margin-top: 20px;">
                    <p style="color: var(--font_color); margin: 0; text-align: center; font-weight: bold;">
                        Brak zarejestrowanych faktur w bazie danych dla podanych kryteriów.
                    </p>
                </div>
            <?php else: ?>
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Numer faktury</th>
                                <th>NIP firmy</th>
                                <th>Data zamówienia</th>
                                <th>Data wysłania</th>
                                <th>Status</th>
                                <th>Akcja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invoices_list as $row): ?>
                                <tr>
                                    <td>FV/<?= htmlspecialchars($row['id_faktury']) ?>/2026</td>
                                    <td><?= htmlspecialchars($row['nip']) ?></td>
                                    <td><?= htmlspecialchars($row['data_zamowienia']) ?></td>
                                    <td><?= htmlspecialchars($row['data_wyslania']) ?></td>
                                    <td><?= htmlspecialchars($row['status']) ?></td>
                                    <td>
                                        <a href="/elektron/admin/faktury/szczegoly?id=<?= $row['id_faktury'] ?>" style="color: #3498db; font-weight: bold;">Szczegóły</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <div class="buttons">
                <a href="/elektron/admin" class="button button-back">Powrót do menu</a>
                <a href="/elektron/dodaj.php?podstrona=faktury" class="button button-add">Dodaj nową fakturę</a>
            </div>
            
        </main>
    </div>

    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz | Elektron Sp. z o.o.</p>
    </footer>
</body>
</html>