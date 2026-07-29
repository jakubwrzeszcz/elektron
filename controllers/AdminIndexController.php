<?php
    class AdminIndexController {
        private $database;

        public function __construct() {
            global $polaczenie;
            require_once "config.php";
            require_once "permission.php";
            require_once "utils.php";

            $this->database = $polaczenie;

            requireAdminLogin();
        }

        public function index() {
            require __DIR__ . '/../views/dashboard/AdminIndex.php';
        }

        public function getAdminInvoices() {
            require_once __DIR__ . '/../models/InvoiceModel.php';
            $invoiceModel = new InvoiceModel($this->database);

            try {
                $invoices_list = $invoiceModel->getAllInvoices();
                $no_records = empty($invoices_list);
            } catch (Exception $e) {
                $invoices_list = [];
                $no_records = true;
                $error_message = $e->getMessage();
            }

            require __DIR__ . '/../views/dashboard/AdminInvoice.php';
        }

        public function getAdminInvoicesByNIP() {
            $nip = $_POST['nip'];
            require_once __DIR__ . '/../models/InvoiceModel.php';
            $invoiceModel = new InvoiceModel($this->database);

            try {
                $invoices_list = $invoiceModel->getInvoiceByNIP($nip);
                $no_records = empty($invoices_list);
            } catch (Exception $e) {
                $invoices_list = [];
                $no_records = true;
                $error_message = $e->getMessage();
            }

            require __DIR__ . '/../views/dashboard/AdminInvoice.php';
        }

        public function profile() {
            require_once __DIR__ . '/../models/PersonModel.php';
            $profileModel = new ProfileModel($this->database);
            $no_records = false;

            try {
                $row = $profileModel->getProfile();
                $no_records = empty($row);
            } catch (Exception $e) {
                $row = [];
                $no_records = true;
                $error_message = $e->getMessage();
            }

            require __DIR__ . '/../views/dashboard/AdminProfile.php';
        }
        
        public function workers() {
            requirePermission('pracownicy.manage');
            require_once __DIR__ . '/../models/PersonModel.php';
            $personModel = new WorkerModel($this->database);

            try {
                $personRow = $personModel->getWorkers();
                $no_records = empty($personRow);
            } catch (Exception $e) {
                $personRow = [];
                $no_records = true;
                $error_message = $e->getMessage();
            }

            require __DIR__ . '/../views/dashboard/AdminWorkers.php';
        }

        public function getAllOrders() {
            requirePermission('zamowienia.manage');
            require_once __DIR__ . '/../models/OrderModel.php';
            $orderModel = new OrderModel($this->database);

            try {
                $orders_list = $orderModel->getAllOrders();
                $no_records = empty($orders_list);
            } catch (Exception $e) {
                $orders_list = [];
                $no_records = true;
                $error_message = $e->getMessage();
            }

            require __DIR__ . '/../views/dashboard/AdminOrders.php';
        }

        public function getAdminInvoiceDetail() {
            requirePermission('faktury.manage');
            $id = (int)$_GET['id'];
            require_once __DIR__ . '/../models/InvoiceModel.php';
            $invoiceModel = new InvoiceModel($this->database);

            try {
                $invoice_detail = $invoiceModel->getInvoiceAdminDetail($id);
                $no_records = empty($invoice_detail);
            } catch (Exception $e) {
                $invoice_detail = [];
                $no_records = true;
                $error_message = $e->getMessage();
            }
                
            if(!empty($invoice_detail)) {
                $header = $invoice_detail[0];
                $cena_dostawy = $header['cena_dostawy'];
                $cena_netto_dostawy = round($cena_dostawy / 1.23, 2);

                $suma_netto = 0;
                $suma_brutto = 0;
                foreach ($invoice_detail as $item) {
                    $suma_netto += $item['ilosc'] * $item['cena_netto'];
                    $suma_brutto += $item['ilosc'] * $item['cena_produktu_brutto'];
                }

                $vat = licz_vat($suma_brutto, $suma_netto, $cena_dostawy - $cena_netto_dostawy);
                $do_zaplaty = licz_do_zaplaty($suma_brutto, $cena_dostawy);

                require __DIR__ . '/../views/dashboard/AdminInvoiceDetail.php';
            } else {
                require __DIR__ . '/../views/dashboard/AdminInvoiceDetail.php';
            }
        }

        public function getAllCompanies() {
            global $polaczenie;
            require_once "config.php";
            require_once "permission.php";
            //require_once "../models/CompanyModel.php";
            requireAdminLogin();
            requirePermission('firmy.manage');

            $no_records = false;

            $sql = "SELECT nip, krs, regon, nazwa_firmy, wojewodztwo.wojewodztwo, miejscowosc.nazwa_miejscowosci, ulica.nazwa_ulicy, kod_pocztowy.kod_pocztowy, adres.numer_firmy FROM firma JOIN adres ON firma.id_adres = adres.id_adres JOIN wojewodztwo ON wojewodztwo.id_wojewodztwo = adres.id_wojewodztwo JOIN miejscowosc ON miejscowosc.id_miejscowosc = adres.id_miejscowosc JOIN ulica ON ulica.id_ulicy = adres.id_ulicy JOIN kod_pocztowy ON kod_pocztowy.id_kod_pocztowy = adres.id_kod_pocztowy;";
                    
            $result = mysqli_query($polaczenie, $sql);
            
            $companies_list = [];
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $companies_list[] = $row;
                }
            } else {
                $no_records = true;
            }
            mysqli_close($polaczenie);
            require __DIR__ . '/../views/dashboard/AdminCompanies.php';
        }
    }
?>