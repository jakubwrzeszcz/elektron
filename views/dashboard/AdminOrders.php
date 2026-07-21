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
                <img src="" class="nav-logo" alt="Ikona zamówienia">
                <div class="page-header-text">
                    <h1>Zarządzanie zamówieniami</h1>
                    <p>Przeglądanie zamówień z bazy danych</p>
                </div>
            </div>

            <div class="search-box">
                <form method="POST" action="admin.php?podstrona=zamowienia" class="search-form">
                    <input type="text" name="zamowienia" class="search-input" placeholder="Wpisz nr zamówienia do wyszukania..." required>
                    <button type="submit" class="search-button">Szukaj</button>
                </form>
            </div>

            <?php if (isset($no_records) && $no_records === true || empty($orders_list)): ?>
                <div class="search-box">
                    <p style="color: var(--font_color); margin: 0; text-align: center; font-weight: bold;">
                        Brak zarejestrowanych zamówień w bazie danych.
                    </p>
                </div>
            <?php else: ?>
                
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Numer zamówienia</th>
                                <th>NIP</th>
                                <th>REGON</th>
                                <th>KRS</th>
                                <th>Nazwa Firmy</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders_list as $order): ?>
                                <tr>
                                    <td><?= $order['id_zamownienia'] ?></td>
                                    <td><?= $order['nip'] ?></td>
                                    <td><?= $order['regon'] ?></td>
                                    <td><?= $order['krs'] ?></td>
                                    <td><?= $order['nazwa_firmy'] ?></td>
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