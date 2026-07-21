<?php 
    require_once "config.php";
    require_once "utils.php";
    $endpoint = adminEndpoint($_GET['podstrona'] ?? 'start');
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
                    <h1>Edytowanie</h1>
                    <p>Edycja rekordów z bazy danych.</p>
                </div>
            </div>
            <div class="search-box">
                <?php
                    echo "<form method='POST' action='/elektron/edytuj.php?podstrona=$endpoint'>";
                        $id = $_GET['ID'];
                        if($result = mysqli_query($polaczenie, "SELECT * FROM {$parametry[$endpoint]['tabela']} WHERE {$parametry[$endpoint]['id_kolumna']}=".$id)) {
                            if(mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<input class='search-input' type='text' name='ID' value='".$row["{$parametry[$endpoint]['id_kolumna']}"]."'>
                                    <input class='search-input' type='text' name='pole' value='".$row["{$parametry[$endpoint]['wartosc_kolumna']}"]."'>";
                                }
                            } else {
                                echo "<p style='color: #e74c3c'>Brak podanego ID.</p>";
                                }
                            } else {
                                header("Location: {$parametry[$endpoint]['powrot_url']}");
                            }
                            
                        if(isset($_POST['pole']) && isset($_POST['ID'])) {
                            if($result = mysqli_query($polaczenie,"UPDATE {$parametry[$endpoint]['tabela']} SET {$parametry[$endpoint]['wartosc_kolumna']}='{$_POST['pole']}' WHERE {$parametry[$endpoint]['id_kolumna']}={$_POST['ID']}")) {
                                header("Location: {$parametry[$endpoint]['powrot_url']}");
                            }
                        }
                    ?>
                    <input type='submit' class="button" value='Zaktualizuj'>
                    <input type='button' class="button button-back" value='Powrót' onClick='javascript:history.back()'>
                </form>
            </div>
        </main>
    </div>

    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz</p>
    </footer>

</body>
</html>

