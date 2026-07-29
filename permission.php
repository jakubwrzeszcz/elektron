<?php

    session_start();

    function can(string $permission): bool {
        if (($_SESSION['typ_sesji'] ?? null) !== 'pracownik') {
            return false;
        }
        return in_array($permission, $_SESSION['perms'] ?? [], true);
    }

    function requirePermission(string $permission): void {
        if (!can($permission)) {
            http_response_code(403);
            exit("<div class='welcome'>
                    <img src='img/elektron.svg' alt='logo' class='big-logo'>
                    <h1>Panel administracyjny <span>elektron.pl</span></h1>
                    <p style='color: #e74c3c'>Brak dostępu do żądanego zasobu</p>
                </div>");
        }
    }

    function requireLogin(): void {
        if (!$_SESSION['zalogowany'] || !isset($_SESSION['typ_sesji']) ) {
            header('Location: /elektron/logowanie');
            exit;
        }
    }

    function requireAdminLogin(): void {
        if (!$_SESSION['zalogowany'] || $_SESSION['typ_sesji'] != "pracownik" ) {
            header('Location: /elektron/admin/logowanie');
            exit;
        }
    }

    function isWorkerAdminLogin(): bool {
        if (!isset($_SESSION['zalogowany']) || !$_SESSION['zalogowany'] || $_SESSION['typ_sesji'] != "pracownik" ) {
            return false;
        }
        return true;
    }

    function requireAccountType(string|array $types): void {
        $current = $_SESSION['typ_sesji'] ?? null;
        $allowed = (array) $types;

        if (!in_array($current, $allowed, true)) {
            http_response_code(403);
            exit('Brak dostępu');
        }
    }

    function getWorkerPermissions(string $stanowisko): array {
        return match ($stanowisko) {
            'Księgowy/a' => [
                'faktury.manage',
                'zamowienia.manage',
                'firmy.manage',
            ],
            'Magazynier/ka' => [
                'produkty.manage',
                'zamowienia.manage',
            ],
            'Technik/czka' => [
                'zamowienia.manage',
            ],
            'Elektryk/czka' => [
                'zamowienia.manage',
            ],
            'Administrator' => [
                'zamowienia.manage',
                'faktury.manage',
                'produkty.manage',
                'firmy.manage',
                'pracownicy.manage',
            ],
            default => [],
        };
    }

    
?>