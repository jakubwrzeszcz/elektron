<?php
    require_once "Router.php";

    $router->get('/', ['IndexController', 'index']);

    // Login routes
    $router->get('/logowanie', ['LoginController', 'index']);
    $router->post('/logowanie', ['LoginController', 'login']);

    // Logout route
    $router->get('/wylogowanie', ['LogoutController', 'logout']);

    // Registration routes
    $router->get('/rejestracja', ['RegisterController', 'index']);
    $router->post('/rejestracja', ['RegisterController', 'register']);

    // Products route
    $router->get('/produkty', ['ProductsController', 'getAllProducts']);

    // Profile route
    $router->get('/profil', ['ProfileController', 'index']);

    // Cart routes
    $router->get('/koszyk', ['CartController', 'index']);
    $router->post('/koszyk/dodaj', ['CartController', 'add']);
    $router->post('/koszyk/usun', ['CartController', 'remove']);
    $router->post('/koszyk/zmniejsz', ['CartController', 'decrease']);
    $router->post('/koszyk/zwieksz', ['CartController', 'increase']);

    // Invoice routes
    $router->get('/faktury', ['InvoiceController', 'index']);
    $router->get('/faktury/dodaj', ['InvoiceController', 'create']);
    $router->post('/faktury/dodaj', ['InvoiceController', 'store']);

    // Company routes
    $router->get('/firmy', ['CompanyController', 'index']);
    $router->post('/firmy/dodaj', ['CompanyController', 'store']);

    // ADMIN ROUTES //
    $router->get('/admin', ['AdminIndexController', 'index']);
    $router->get('/admin/logowanie', ['AdminLoginController', 'index']);
    $router->post('/admin/logowanie', ['AdminLoginController', 'login']);

    $router->get('/admin/produkty', ['ProductsController', 'getAdminAllProducts']);
    $router->get('/admin/produkt/dodaj', ['ProductsController', 'createProductForm']);
    $router->post('/admin/produkt/dodaj', ['ProductsController', 'createProduct']);
    $router->post('/admin/produkt/usun', ['ProductsController', 'removeProduct']);
    $router->post('/admin/produkt/edytuj', ['ProductsController', 'editProductForm']);
    $router->post('/admin/produkt/aktualizuj', ['ProductsController', 'updateProduct']);

    $router->get('/admin/profil', ['AdminIndexController', 'profile']);
    $router->get('/admin/pracownicy', ['AdminIndexController', 'workers']);
    $router->get('/admin/zamowienia', ['AdminIndexController', 'getAllOrders']);

    $router->get('/admin/faktury', ['AdminIndexController', 'getAdminInvoices']);
    $router->post('/admin/faktury', ['AdminIndexController', 'getAdminInvoicesByNIP']);
    $router->get('/admin/faktury/szczegoly', ['AdminIndexController', 'getAdminInvoiceDetail']);
    
    $router->get('/admin/firmy', ['AdminIndexController', 'getAllCompanies']);
?>