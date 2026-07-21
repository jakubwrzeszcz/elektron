<?php
    require_once "config.php";
    require_once "permission.php";
    require_once "utils.php";

    requireLogin();
    requirePermission('faktury.manage');
?>

<div class="page-header">
    <img src="img/faktura.svg" style="height: 100px" class="nav-logo" alt="Ikona faktury">
    <div class="page-header-text">
        <h1>Przeglądanie faktur</h1>
        <p>Dodawanie, przeglądanie, edycja faktur z bazy danych.</p>
    </div>
</div>

<div class="search-box">
    <form method="POST" action="admin.php?podstrona=faktury" class="search-form">
        <input type="text" name="nip" class="search-input" placeholder="Wpisz NIP firmy do wyszukania..." required>
        <button type="submit" class="search-button">Szukaj</button>
    </form>
</div>
        
<div class="data-table">
<?php
    if($_GET['tryb'] === "przegladaj" && isset($_GET['ID'])) {
        $id_faktury = (int)$_GET['ID'];
        $sql = "SELECT 
            faktura.id_faktury,
            faktura.id_dostawcy,
            faktura.typ,
            dostawca.nazwa_dostawcy,
            dostawca.cena_brutto AS cena_dostawy,
            zamowienia.nip,
            firma.regon,
            firma.krs,
            firma.nazwa_firmy,
            miejscowosc.nazwa_miejscowosci AS miejscowosc,
            ulica.nazwa_ulicy,
            adres.numer_firmy,
            kod_pocztowy.kod_pocztowy,
            produkty.nazwa AS produkt,
            produkty.cena_netto,
            pozycje_zamowienia.cena_brutto AS cena_produktu_brutto,
            pozycje_zamowienia.ilosc,
            zamowienia.data_wyslania,
            zamowienia.data_zamowienia

            FROM faktura
                    
            JOIN dostawca 
                ON dostawca.id_dostawcy = faktura.id_dostawcy

            JOIN zamowienia 
                ON zamowienia.id_zamownienia = faktura.id_zamowienia

            JOIN pozycje_zamowienia 
                ON pozycje_zamowienia.id_zamowienia = zamowienia.id_zamownienia

            JOIN produkty 
                ON produkty.id_produktu = pozycje_zamowienia.id_produktu

            JOIN status_zamowienia 
                ON status_zamowienia.id_status_zamowienia = zamowienia.status

            JOIN firma 
                ON firma.nip = zamowienia.nip

            JOIN adres 
                ON adres.id_adres = firma.id_adres

            JOIN miejscowosc 
                ON miejscowosc.id_miejscowosc = adres.id_miejscowosc

            JOIN ulica 
                ON ulica.id_ulicy = adres.id_ulicy

            JOIN kod_pocztowy 
                ON kod_pocztowy.id_kod_pocztowy = adres.id_kod_pocztowy

            WHERE faktura.id_faktury = $id_faktury";

        if($wynik = mysqli_query($polaczenie, $sql)) {
            if(mysqli_num_rows($wynik) > 0) {

                // pierwszy rekord tylko do danych nagłówka
                $header = mysqli_fetch_assoc($wynik);

                $cena_dostawy = $header['cena_dostawy'];
                $cena_netto_dostawy = round($cena_dostawy / 1.23, 2);

                // reset wskaźnika
                mysqli_data_seek($wynik, 0);

                echo "
                <style>
                    .fv_header {
                        display: flex;
                        color: white;
                        text-align: center;
                        align-items: center;
                    }

                    .right {
                        display: flex;
                        align-items: center;
                        gap: 30px;
                        margin: 0px 30px;
                        flex-wrap: wrap; 
                    }

                    .section {
                        margin: 50px 0px;
                    }
                </style>

                <script>
                    const sb = document.querySelector('.search-box');

                    if (sb) {
                        sb.style.display = 'none';
                    }

                    window.onload = function () {
                        alert('Pamiętaj, aby umieścić fakturę w Krajowym Systemie e-Faktur.');
                    }
                </script>

                <div class='invoice'>
                    <div class='fv_header'>
                        <div class='left'>";

                        if($header['typ'] === 'FV') {
                            echo "<h1>Faktura VAT</h1>";
                        }
                        elseif($header['typ'] === 'FK') {
                            echo "<h1>Faktura Korekta</h1>";
                        }

                        echo "
                        </div>

                        <div class='right'>
                            <p><b>Numer:</b> FV/{$header['id_faktury']}/2026</p>
                            <p><b>Data wystawienia:</b> {$header['data_zamowienia']}</p>
                            <p><b>Data sprzedaży:</b> {$header['data_wyslania']}</p>
                            <p><b>Forma płatności:</b> Przelew</p>
                            <p><b>Dostawca:</b> {$header['nazwa_dostawcy']}</p>
                        </div>
                    </div>
                    <div class='section'>
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
                                    {$header['nazwa_firmy']}<br>
                                    ul. {$header['nazwa_ulicy']} {$header['numer_firmy']}<br>
                                    {$header['kod_pocztowy']} {$header['miejscowosc']}<br>
                                    NIP: {$header['nip']}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class='section'>
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
                ";
                $suma_netto = 0;
                $suma_brutto = 0;

                while($row = mysqli_fetch_assoc($wynik)) {

                    $netto = $row['ilosc'] * $row['cena_netto'];
                    $brutto = $row['ilosc'] * $row['cena_produktu_brutto'];

                    $suma_netto += $netto;
                    $suma_brutto += $brutto;

                    echo "
                    <tr>
                        <td>{$row['produkt']}</td>
                        <td>{$row['ilosc']}</td>
                        <td>{$row['cena_netto']} PLN</td>
                        <td>" . number_format($netto, 2) . " PLN</td>
                        <td>23%</td>
                        <td>{$row['cena_produktu_brutto']} PLN</td>
                        <td>" . number_format($brutto, 2) . " PLN</td>
                    </tr>";
                }

                $vat = licz_vat($suma_brutto, $suma_netto, $cena_dostawy - $cena_netto_dostawy);
                $do_zaplaty = licz_do_zaplaty($suma_brutto,$cena_dostawy);

                            echo "
                                <tr>
                                    <td>Dostawca: {$header['nazwa_dostawcy']}</td>
                                    <td>1</td>
                                    <td>{$cena_netto_dostawy} PLN</td>
                                    <td>{$cena_netto_dostawy} PLN</td>
                                    <td>23%</td>
                                    <td>{$cena_dostawy} PLN</td>
                                    <td>{$cena_dostawy} PLN</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class='summary'>
                        <table>
                            <tr>
                                <th colspan='2'>Podsumowanie</th>
                            </tr>
                            <tr>
                                <td>VAT 23%</td>
                                <td>{$vat} PLN</td>
                            </tr>
                            <tr>
                                <td>Do zapłaty</td>
                                <td>{$do_zaplaty} PLN</td>
                            </tr>
                        </table>
                    </div>
                </div>";
            }
        }
    }
    elseif(empty($_POST['nip']) != 1) {
        $nip_szukaj = $_POST['nip'];
        if($result = mysqli_query($polaczenie, "SELECT faktura.id_faktury, zamowienia.nip, zamowienia.data_wyslania, status_zamowienia.status , zamowienia.data_zamowienia FROM `faktura` JOIN zamowienia ON zamowienia.id_zamownienia = faktura.id_zamowienia JOIN status_zamowienia ON status_zamowienia.id_status_zamowienia = zamowienia.status WHERE zamowienia.nip = $nip_szukaj")) {
            if(mysqli_num_rows($result) > 0) {
                echo <<<'EOD'
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
                EOD;
                while($row = mysqli_fetch_array($result)) {
                    echo "
                    <tr>
                        <td>{$row['id_faktury']}</td>
                        <td>{$row['nip']}</td>
                        <td>{$row['data_zamowienia']}</td>
                        <td>{$row['data_wyslania']}</td>
                        <td>{$row['status']}</td>
                        <td><a href='admin.php?podstrona=faktury&tryb=przegladaj&ID={$row['id_faktury']}' style='color: #3498db; margin-right: 10px;'>Szczegóły faktury</a></td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color: #e74c3c'>Nie znaleziono faktury z podanym NIPem.</p>";
            }
        }
    }
    elseif($result = mysqli_query($polaczenie, "SELECT faktura.id_faktury, zamowienia.nip, zamowienia.data_wyslania, status_zamowienia.status , zamowienia.data_zamowienia FROM `faktura` JOIN zamowienia ON zamowienia.id_zamownienia = faktura.id_zamowienia JOIN status_zamowienia ON status_zamowienia.id_status_zamowienia = zamowienia.status ORDER BY faktura.id_faktury")) {
        echo <<<'EOD'
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
        EOD;
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>
                    <td>FV/{$row['id_faktury']}/2026</td>
                    <td>{$row['nip']}</td>
                    <td>{$row['data_zamowienia']}</td>
                    <td>{$row['data_wyslania']}</td>
                    <td>{$row['status']}</td>
                    <td><a href='admin.php?podstrona=faktury&tryb=przegladaj&ID={$row['id_faktury']}' style='color: #3498db; margin-right: 10px;'>Szczegóły faktury</a></td>
                </tr>";
        }
    echo '</tbody></table>';
}
    mysqli_close($polaczenie);
?>
</div>

<div class="buttons">
    <a href="admin.php" class="button button-back">Powrót do menu</a>
    <a href="admin.php?podstrona=faktury" class="button">Pokaż wszystkie faktury</a>
    <a href="/elektron/dodaj.php?podstrona=faktury" class="button button-add">Dodaj nową fakturę</a>
</div>