<?php 
    require_once "config.php";

    $parametry = [  
        'miasta' => [ 
            'tabela' => 'miejscowosc', 
            'id_kolumna' => 'id_miejscowosc', 
            'wartosc_kolumna' => 'nazwa', 
            'powrot_url' => 'admin.php?podstrona=miasta' 
        ], 
        
        'ulice' => [ 
            'tabela' => 'ulica', 
            'id_kolumna' => 'id_ulicy', 
            'wartosc_kolumna' => 'nazwa_ulicy', 
            'powrot_url' => 'admin.php?podstrona=ulice' 
        ],

        'kod_pocztowy' => [ 
            'tabela' => 'kod_pocztowy', 
            'id_kolumna' => 'id_kod_pocztowy', 
            'wartosc_kolumna' => 'kod_pocztowy', 
            'powrot_url' => 'admin.php?podstrona=kod_pocztowy' 
        ],

        'firmy' => [
            'tabela' => 'firma', 
            'id_kolumna' => 'nip', 
            'wartosc_kolumna' => 'nazwa_firmy', 
            'powrot_url' => 'admin.php?podstrona=firmy' 
        ]
    ];

    $strona = $_GET['podstrona'] ?? 'start'; 
    switch($strona) { 
        case 'miasta': 
            $edycja = "miasta"; 
            break; 
        case 'ulice': 
            $edycja = "ulice"; 
            break;
        case 'kod_pocztowy': 
            $edycja = "kod_pocztowy"; 
            break;
        case 'firmy': 
            $edycja = "firmy"; 
            break; 
        default: 
            header("Location: admin.php?podstrona=blad");
            exit; 
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
            <a href="admin.php?podstrona=firmy" class="menu-link">Zarządzanie firmami</a>
            <a href="admin.php?podstrona=faktury" class="menu-link">Przeglądanie faktur</a>
            <a href="wylogowanie.php" class="menu-link">Wyloguj</a>
        </div>
        <div class="main-content">
            <div class="page-header">
                <div class="page-header-text">
                    <h1>Usuwanie</h1>
                    <p>Usuwanie rekordów z bazy danych.</p>
                </div>
            </div>
            <div class="search-box">
                <?php
                    if($edycja === "firmy") {
                        if(isset($_GET['ID'])) {
                            (string)$id = $_GET['ID'];
                            if($result = mysqli_query ($polaczenie, "DELETE FROM {$parametry[$edycja]['tabela']} WHERE {$parametry[$edycja]['id_kolumna']}=".$id)) {
                                header("Location: {$parametry[$edycja]['powrot_url']}");
                            } else {
                                echo "<p style='color: #e74c3c'>Nie udało usunąć się danych z bazy.</p>";
                            }
                        }
                    }
                    elseif(isset($_GET['ID'])) {
                        $id = $_GET['ID'];
                        if($result = mysqli_query ($polaczenie, "DELETE FROM {$parametry[$edycja]['tabela']} WHERE {$parametry[$edycja]['id_kolumna']}=".$id)) {
                            header("Location: {$parametry[$edycja]['powrot_url']}");
                        } else {
                            echo "<p style='color: #e74c3c'>Nie udało usunąć się danych z bazy.</p>";
                        }
                    }
                ?>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Wszelkie prawa zastrzeżone &copy; 2025-2026 Jakub Wrzeszcz</p>
    </div>

</body>
</html>

