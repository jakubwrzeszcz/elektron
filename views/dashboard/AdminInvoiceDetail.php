
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Elektron | Panel Administracyjny</title>
    <link rel="stylesheet" href="../../style.css" type="text/css">
    <style>
        .invoice {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.02);
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-top: 20px;
        }
        .fv_header {
            display: flex;
            color: white;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--secondary_color, #f39c12);
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .fv_header .right {
            display: flex;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap; 
        }
        .fv_header p {
            margin: 5px 0;
        }
        .section {
            margin: 40px 0px;
        }
        .summary-box {
            max-width: 400px;
            margin-left: auto;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php require __DIR__ . '../../menu.php'; ?>
        
        <main>
            <div class="page-header">
                <img src="../../img/faktura.svg" style="height: 100px" class="nav-logo" alt="Ikona faktury">
                <div class="page-header-text">
                    <h1>Zarządzanie fakturami</h1>
                    <p>Dodawanie, edycja i usuwanie faktur z bazy danych</p>
                </div>
            </div>

            <div class="invoice-container">
                <?php if (isset($no_records) && $no_records == true): ?>
                    <div class="koszyk">
                        <h2>Błąd: Nie znaleziono dokumentu</h2>
                        <p>Szukana faktura nie istnieje w bazie danych lub została usunięta.</p>
                        <a href="/elektron/admin/faktury">Powrót do panelu</a>
                    </div>
                <?php else: ?>
                    <div class="fv_header">
                        <div class="left">
                            <?php if ($header['typ'] === 'FV'): ?>
                                <h1>Faktura VAT</h1>
                            <?php elseif ($header['typ'] === 'FK'): ?>
                                <h1>Faktura Korekta</h1>
                            <?php endif; ?>
                        </div>

                        <div class="fv-header-meta">
                            <p><b>Numer:</b> FV/<?= $header['id_faktury'] ?>/2026</p>
                            <p><b>Data wystawienia:</b> <?= $header['data_zamowienia'] ?></p>
                            <p><b>Data sprzedaży:</b> <?= $header['data_wyslania'] ?></p>
                            <p><b>Forma płatności:</b> Przelew</p>
                            <p><b>Dostawca:</b> <?= $header['nazwa_dostawcy'] ?></p>
                        </div>
                    </div>

                    <div class="invoice-section data-table">
                        <table>
                            <tr>
                                <th>Sprzedawca</th>
                                <th>Nabywca</th>
                            </tr>
                            <tr>
                                <td>
                                    Elektron Sp. z o.o.<br>
                                    ul. Klienta 10<br>
                                    90-100 Łódź<br>
                                    NIP: 7613002289
                                </td>
                                <td>
                                    <?= $header['nazwa_firmy'] ?><br>
                                    ul. <?= $header['nazwa_ulicy'] ?> <?= $header['numer_firmy'] ?><br>
                                    <?= $header['kod_pocztowy'] ?> <?= $header['miejscowosc'] ?><br>
                                    NIP: <?= $header['nip'] ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="invoice-section data-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nazwa towaru/usługi</th>
                                    <th>Ilość</th>
                                    <th>Cena netto</th>
                                    <th>Wartość netto</th>
                                    <th>VAT</th>
                                    <th>Cena brutto</th>
                                    <th>Wartość brutto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($invoice_detail as $row): ?>
                                    <?php 
                                        $netto = $row['ilosc'] * $row['cena_netto'];
                                        $brutto = $row['ilosc'] * $row['cena_produktu_brutto'];
                                        ?>
                                    <tr>
                                        <td><?= $row['produkt'] ?></td>
                                        <td><?= $row['ilosc'] ?></td>
                                        <td><?= number_format($row['cena_netto'], 2) ?> PLN</td>
                                        <td><?= number_format($netto, 2) ?> PLN</td>
                                        <td>23%</td>
                                        <td><?= number_format($row['cena_produktu_brutto'], 2) ?> PLN</td>
                                        <td><?= number_format($brutto, 2) ?> PLN</td>
                                    </tr>
                                <?php endforeach; ?>

                                <tr>
                                    <td>Dostawca: <?= $header['nazwa_dostawcy'] ?></td>
                                    <td>1</td>
                                    <td><?= number_format($cena_netto_dostawy, 2) ?> PLN</td>
                                    <td><?= number_format($cena_netto_dostawy, 2) ?> PLN</td>
                                    <td>23%</td>
                                    <td><?= number_format($cena_dostawy, 2) ?> PLN</td>
                                    <td><?= number_format($cena_dostawy, 2) ?> PLN</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="invoice-summary-box data-table">
                        <table>
                            <tr>
                                <th colspan="2">Podsumowanie</th>
                            </tr>
                            <tr>
                                <td>VAT 23%</td>
                                <td><?= number_format($vat, 2) ?> PLN</td>
                            </tr>
                            <tr>
                                <td><strong>Do zapłaty</strong></td>
                                <td><strong><?= number_format($do_zaplaty, 2) ?> PLN</strong></td>
                            </tr>
                        </table>
                    </div>
                <?php endif; ?> 
            </div>
        </main>
    </div>

    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz | Elektron Sp. z o.o.</p>
    </footer>
</body>
</html>

<script>
    const sb = document.querySelector('.search-box');

    if (sb) {
        sb.style.display = 'none';
    }

    window.onload = function () {
        alert('Pamiętaj, aby umieścić fakturę w Krajowym Systemie e-Faktur.');
    }
</script>