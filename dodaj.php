<?php 
    require_once "config.php";
    require_once "utils.php";

    session_start();
    requireAdminLogin();
    $endpoint = adminEndpoint($_GET['podstrona'] ?? 'start');


    if (isset($_POST['nazwa_firmy'], $_POST['nip'], $_POST['regon'], $_POST['krs'], $_POST['wojewodztwo'], $_POST['miasto'], $_POST['ulica'], $_POST['numer_firmy'], $_POST['kod_pocztowy'])) {
        $nazwa_firmy = $_POST['nazwa_firmy'];
        $nip = $_POST['nip'];
        $krs = $_POST['krs'];
        $regon = $_POST['regon'];
        $wojewodztwo = $_POST['wojewodztwo'];
        $miasto = $_POST['miasto'];
        $ulica = $_POST['ulica'];
        $numer_firmy = $_POST['numer_firmy'];
        $kod_pocztowy = $_POST['kod_pocztowy'];

        if($adres = mysqli_query($polaczenie, "INSERT INTO adres (id_wojewodztwo, id_ulicy, id_kod_pocztowy, numer, id_miejscowosc) VALUES ('$wojewodztwo', '$ulica', '$kod_pocztowy', '$numer_firmy', '$miasto')")) {
            $id_adres = mysqli_insert_id($polaczenie);
            if($firma = mysqli_query($polaczenie, "INSERT INTO firma (nip, regon, krs, nazwa_firmy, id_adres) VALUES ('$nip', '$regon', '$krs', '$nazwa_firmy', $id_adres)")) {
                header("Location: admin.php?podstrona=firmy");
                exit();
            } else {
                echo "<p style='color: #e74c3c'>Nie udało się dodać firmy.</p>"; 
            }
        }
    }

    if (isset($_POST['firma'], $_POST['produkty'], $_POST['ilosc_produktu'], $_POST['dostawca'])) {
        $firma_nip = $_POST['firma'];
        $produkt = $_POST['produkty'];
        $ilosc = $_POST['ilosc_produktu'];
        $dostawca = $_POST['dostawca'];
        mysqli_begin_transaction($polaczenie);

        if(!mysqli_query($polaczenie, "INSERT INTO zamowienia(id_zamownienia, nip, id_produktu, data_wyslania, data_zamowienia, status) VALUES (NULL, '$firma_nip', $produkt, NULL, CURRENT_DATE(), 2)")) {
            die("ZAMÓWIENIE ERROR: " . mysqli_error($polaczenie));
        }

        $id_zamowienia = mysqli_insert_id($polaczenie);
        $sql = mysqli_query($polaczenie, "SELECT cena_brutto FROM produkty WHERE id_produktu = $produkt");
        $row = mysqli_fetch_assoc($sql);

        if(!$row) {
            die("BRAK PRODUKTU");
        }

        $cena_brutto = $row['cena_brutto'];

        if(!mysqli_query($polaczenie, "INSERT INTO pozycje_zamowienia (id_pozycji, id_zamowienia, id_produktu, ilosc, cena_brutto) VALUES (NULL, $id_zamowienia, $produkt, $ilosc, $cena_brutto)")) {
            die("POZYCJA ERROR: " . mysqli_error($polaczenie));
        }

        mysqli_commit($polaczenie);

        if(!mysqli_query($polaczenie, "INSERT INTO faktura (id_faktury, typ, id_dostawcy, id_zamowienia) VALUES (NULL, 'FV', $dostawca, $id_zamowienia)")) {
            die("POZYCJA ERROR: " . mysqli_error($polaczenie));
        }

        mysqli_commit($polaczenie);

        header("Location: admin.php?podstrona=faktury");
        exit();
    }
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
        <div class="menu">
            <div class="menu-logo">
                <img src="img/elektron.svg" alt="logo">
            </div>
            <a href="admin.php?podstrona=miasta" class="menu-link">Zarządzanie miastami</a>
            <a href="admin.php?podstrona=ulice" class="menu-link">Zarządzanie ulicami</a>
            <?php
                if(can('firmy.manage')) {
                    echo '<a href="admin.php?podstrona=firmy" class="menu-link">Zarządzanie firmami</a>';
                }

                if(can('faktury.manage')) {
                    echo '<a href="admin.php?podstrona=faktury" class="menu-link">Zarządzanie fakturami</a>';
                }

                if(can('produkty.manage')) {
                    echo '<a href="admin.php?podstrona=produkty" class="menu-link">Zarządzanie produktami</a>';
                }

                if(can('zamowienia.manage')) {
                    echo '<a href="admin.php?podstrona=zamowienia" class="menu-link">Zarządzanie zamówieniami</a>';
                }

                if(can('pracownicy.manage')) {
                    echo '<a href="admin.php?podstrona=pracownicy" class="menu-link">Zarządzanie pracownikami</a>';
                }
            ?>
            <a href="admin.php?podstrona=profil" class="menu-link">Profil</a>
            <a href="wylogowanie.php" class="menu-link">Wyloguj</a>
        </div>
        <main>
            <div class="page-header">
                <div class="page-header-text">
                    <h1>Dodawanie</h1>
                    <p>Dodawanie rekordów z bazy danych.</p>
                </div>
            </div>
            <div class="search-box">
                <?php
                    if($endpoint != "firmy" && $endpoint != "faktury" ) {
                        echo "<form method='POST' action='/elektron/dodaj.php?podstrona=$endpoint'>
                            <input class='search-input' type='text' name='pole' placeholder='Wpisz $endpoint' required>";
                        if(isset($_POST['pole'])) {
                            $zmienna = $_POST['pole'];
                            if($result = mysqli_query($polaczenie, "INSERT INTO {$parametry[$endpoint]['tabela']} VALUES (NULL, '".$zmienna."')")) {
                                header("Location: {$parametry[$endpoint]['powrot_url']}");
                            } else {
                                echo "<p style='color: #e74c3c'>Błąd w dodaniu $endpoint do bazy danych.</p>";
                            }
                        }
                    } elseif($endpoint === "firmy") {
                            echo '<form method="POST" action="/elektron/dodaj.php?podstrona=firmy"><h3 style="color: #f39c12">Dane firmy</h3>

                                <input class="search-input" type="text" name="nazwa_firmy" placeholder="Wpisz nazwę firmy"><br><br>
                                <input class="search-input" type="text" name="nip" placeholder="Wpisz NIP firmy"><br><br>
                                <input class="search-input" type="text" name="regon" placeholder="Wpisz REGON firmy"><br><br>
                                <input class="search-input" type="text" name="krs" placeholder="Wpisz KRS firmy"><br><br>';

                            echo '<select name="wojewodztwo" class="search-input" required><option value="">-- wybierz województwo --</option>';
                                    
                            $wojewodztwo = mysqli_query($polaczenie, "SELECT * FROM wojewodztwo ORDER BY wojewodztwo");
                            while ($row = mysqli_fetch_assoc($wojewodztwo)) {
                                echo "<option value='{$row['id_wojewodztwo']}'>{$row['wojewodztwo']}</option>";
                            }

                            echo '</select><br><br><select name="miasto" class="search-input" required><option value="">-- wybierz miasto --</option>';
                            
                            $miasto = mysqli_query($polaczenie, "SELECT * FROM miejscowosc ORDER BY nazwa");
                            while ($row = mysqli_fetch_assoc($miasto)) {
                                echo "<option value='{$row['id_miejscowosc']}'>{$row['nazwa']}</option>";
                            }
                            
                            echo '</select><a style="margin-left: 10px" href="/elektron/dodaj.php?podstrona=miasta" class="button">Dodaj miasto</a><br><br>';
                            echo '<select name="ulica" class="search-input" required><option value="">-- wybierz ulice --</option>';

                            $ulice = mysqli_query($polaczenie, "SELECT * FROM ulica ORDER BY nazwa_ulicy");
                            while ($row = mysqli_fetch_assoc($ulice)) {
                                echo "<option value='{$row['id_ulicy']}'>{$row['nazwa_ulicy']}</option>";
                            }

                            echo '</select><a style="margin-left: 10px" href="/elektron/dodaj.php?podstrona=ulice" class="button">Dodaj ulice</a><br><br>';
                            echo '<input class="search-input" name="numer_firmy" type="number" size=20 placeholder="Wpisz numer ulicy adresu firmy"><br><br>';
                            echo '<select name="kod_pocztowy" class="search-input" required>
                                    <option value="">-- wybierz kod pocztowy --</option>';

                            $kod_pocztowy = mysqli_query($polaczenie, "SELECT * FROM kod_pocztowy ORDER BY kod_pocztowy");
                            while ($row = mysqli_fetch_assoc($kod_pocztowy)) {
                                echo "<option value='{$row['id_kod_pocztowy']}'>{$row['kod_pocztowy']}</option>";
                            }

                            echo '</select><a style="margin-left: 10px" href="/elektron/dodaj.php?podstrona=kod_pocztowy" class="button">Dodaj kod pocztowy</a><br><br>';
                        }
                        elseif($endpoint === "faktury") {
                            echo '<form method="POST" action="dodaj.php?podstrona=faktury"><h3 style="color: #f39c12">Dane faktury</h3>';
                            echo '<select name="firma" class="search-input" required><option value="">-- wybierz firmę --</option>';
                            
                            $firma = mysqli_query($polaczenie, "SELECT nip, nazwa_firmy FROM firma ORDER BY nazwa_firmy");
                            while ($row = mysqli_fetch_assoc($firma)) {
                                echo "<option value='{$row['nip']}'>{$row['nazwa_firmy']} ({$row['nip']})</option>";
                            }
                                    
                            echo '</select><a style="margin-left: 10px" href="/elektron/dodaj.php?podstrona=firmy" class="button">Dodaj firmę</a><br><br>';
                            echo '<select name="produkty" class="search-input" required><option value="">-- wybierz produkt --</option>';
                                    
                            $produkty = mysqli_query($polaczenie, "SELECT produkty.id_produktu, produkty.nazwa FROM produkty WHERE produkty.czy_dostepne = 'TAK'");
                            while ($row = mysqli_fetch_assoc($produkty)) {
                                echo "<option value='{$row['id_produktu']}'>{$row['nazwa']}</option>";
                            }

                            echo '</select><br><br>';
                            echo '<input class="search-input" name="ilosc_produktu" type="number" size=30 placeholder="Wpisz ilość zamawianego produktu"><br><br>';
                            echo '<select name="dostawca" class="search-input" required><option value="">-- wybierz dostawcę --</option>';
                                    
                            $dostawca = mysqli_query($polaczenie, "SELECT * FROM dostawca");
                            while ($row = mysqli_fetch_assoc($dostawca)) {
                                echo "<option value='{$row['id_dostawcy']}'>{$row['nazwa_dostawcy']} ({$row['cena_brutto']})</option>";
                            }

                            echo '</select><br><br>';


                        }
                ?>
                    <div class="buttons">
                        <input href='' type='submit' class="button" value='Dodaj'>
                        <input type='button' class="button button-back" value='Powrót' onClick='javascript:history.back()'>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <div class="footer">
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz</p>
    </div>

</body>
</html>

