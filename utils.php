<?php
    function licz_wartosc_brutto($ilosc, $cena_netto) {
        $wynik = $ilosc * $cena_netto;
        return $wynik;
    }

    function licz_cene_netto($ilosc, $cena_brutto) {
        $wynik = $ilosc * $cena_brutto;
        return $wynik;
    }

    function licz_vat($wartosc_brutto, $wartosc_netto, $vat_dostawy) {
        $wynik = ($wartosc_brutto - $wartosc_netto) + $vat_dostawy;
        return $wynik;
    }

    function licz_do_zaplaty($wartosc_brutto, $cena_dostawy) {
        $wynik = $wartosc_brutto + $cena_dostawy;
        return $wynik;
    }

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
        ]
    ];
?>