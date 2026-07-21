<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Elektron | Panel Administracyjny</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div class="container">
        <?php require __DIR__ . '../../menu.php'; ?>
        <main>
            <div class="page-header">
                <img src="img/faktura.svg" class="nav-logo" alt="Ikona raportów">
                <div class="page-header-text">
                    <h1>Dashboard Elektron &copy;</h1>
                </div>
            </div>

            <div class="search-box">
                <h2 style="color: var(--secondary_color); margin: 0 0 15px 0; font-size: 18px;">Wygeneruj nowy dokument finansowy / magazynowy</h2>
                <form class="search-form" method="GET" action="generuj.php">
                    <select class="form-input" name="typ_raportu" style="flex: 1; color: black; font-weight: bold;">
                        <option value="sprzedaz">Raport sprzedaży i marży (Ogólny)</option>
                        <option value="b2b">Rejestr faktur i sprzedaży B2B</option>
                        <option value="rma">Analiza strat: Zwroty, Uszkodzenia i RMA</option>
                        <option value="magazyn">Wycena zapasów magazynowych (Remanent)</option>
                    </select>
                    
                    <select class="form-input" name="miesiac" style="width: 150px; color: black; font-weight: bold;">
                        <option value="05">Maj 2026</option>
                        <option value="04">Kwiecień 2026</option>
                        <option value="03">Marzec 2026</option>
                    </select>
                    
                    <button type="submit" class="search-button">Generuj PDF / CSV</button>
                </form>
            </div>

            <div class="products" style="margin: 0 0 30px 0; gap: 40px;">
                
                <div class="product" style="min-height: auto;">
                    <h3>📊 Finanse: Maj 2026</h3>
                    <h4>Przychód całkowity: 248 500.00 PLN</h4>
                    <h4>Średnia marża na sprzęcie: 12.4%</h4>
                    <p>Najwyższy obrót wygenerowała podkategoria <em>Karty Graficzne</em>, jednak najwyższą czystą marżę procentową (aż 38%) odnotowano na <em>Okablowaniu i akcesoriach sieciowych</em>. Faktury B2B stanowiły 64% wszystkich transakcji.</p>
                </div>

                <div class="product" style="min-height: auto;">
                    <h3>📉 Logistyka i Serwis: Maj 2026</h3>
                    <h4>Koszt zatwierdzonych RMA: 8 420.00 PLN</h4>
                    <h4>Wskaźnik zwrotów (Return Rate): 1.8%</h4>
                    <p>Głównym powodem strat były zwroty 14-dniowe płyt głównych (często zgłaszane niekompatybilności z procesorami przez klientów detalicznych). Koszt logistyczny obsługi przesyłek zwrotnych wyniósł 1 200 PLN.</p>
                </div>

            </div>

            <div class="categories" style="padding: 0;">
                <h2 style="color: var(--secondary_color); margin-bottom: 15px; font-size: 20px;">Wygenerowane raporty gotowe do pobrania</h2>
                
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Nazwa pliku</th>
                                <th>Okres</th>
                                <th>Data wygenerowania</th>
                                <th>Rozmiar / Format</th>
                                <th>Akcja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Raport_Sprzedazy_Maj_2026.pdf</td>
                                <td>01.05.2026 - 31.05.2026</td>
                                <td>Dzisiaj, 04:00 (Automatycznie)</td>
                                <td>2.4 MB / PDF</td>
                                <td><a href="#pobierz" class="button" style="padding: 4px 10px; font-size: 14px;">Pobierz</a></td>
                            </tr>
                            <tr>
                                <td>Rejestr_VAT_B2B_Kwiecien.csv</td>
                                <td>01.04.2026 - 30.04.2026</td>
                                <td>01.05.2026</td>
                                <td>420 KB / CSV</td>
                                <td><a href="#pobierz" class="button" style="padding: 4px 10px; font-size: 14px;">Pobierz</a></td>
                            </tr>
                            <tr>
                                <td>Podsumowanie_RMA_I_Kwartal_2026.pdf</td>
                                <td>01.01.2026 - 31.03.2026</td>
                                <td>01.04.2026</td>
                                <td>4.1 MB / PDF</td>
                                <td><a href="#pobierz" class="button" style="padding: 4px 10px; font-size: 14px;">Pobierz</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz | Elektron Sp. z o.o.</p>
    </footer>

</body>
</html>