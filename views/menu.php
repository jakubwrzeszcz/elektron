<div class="menu">
    <div class="menu-logo">
        <img src="../img/elektron.svg" alt="logo">
    </div>
    <a href="/elektron/admin" class="menu-link">Strona Główna</a>
    
    <?php if(can('firmy.manage')): ?>
        <a href="/elektron/admin/firmy" class="menu-link">Zarządzanie firmami</a>
    <?php endif; ?>

    <?php if(can('faktury.manage')): ?>
        <a href="/elektron/admin/faktury" class="menu-link">Zarządzanie fakturami</a>
    <?php endif; ?>

    <?php if(can('produkty.manage')): ?>
        <a href="/elektron/admin/produkty" class="menu-link">Zarządzanie produktami</a>
    <?php endif; ?>

    <?php if(can('zamowienia.manage')): ?>
        <a href="/elektron/admin/zamowienia" class="menu-link">Zarządzanie zamówieniami</a>
    <?php endif; ?>

    <?php if(can('pracownicy.manage')): ?>
        <a href="/elektron/admin/pracownicy" class="menu-link">Zarządzanie pracownikami</a>
    <?php endif; ?>

    <?php if(isset($_SESSION['typ_sesji']) && $_SESSION['typ_sesji'] == "pracownik"): ?>
        <a href="/elektron/admin/profil" class="menu-link">Profil</a>
    <?php else: ?>
        <a href="/elektron/profil" class="menu-link">Profil</a>
    <?php endif; ?>

    <a href="/elektron/wylogowanie" class="menu-link">Wyloguj</a>
</div>