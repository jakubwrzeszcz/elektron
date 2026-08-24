<?php
    class ProductsController {

        private $database;

        public function __construct() {
            global $polaczenie;
            require_once "config.php";
            require_once "permission.php";
            require_once "utils.php";
            require_once __DIR__ . '/../models/ProductModel.php';

            $this->database = $polaczenie;
        }

        public function getAllProducts() {
            $productModel = new ProductModel($this->database);

            try {
                $product_list = $productModel->getAllProducts();
                $no_records = empty($product_list);
            } catch (Exception $e) {
                $product_list = [];
                $no_records = true;
                $error_message = $e->getMessage();
            }

            require __DIR__ . '/../views/Products.php';
            echo require __DIR__ . '/../views/Products.php';

        }

        public function getAdminAllProducts() {
            $productModel = new ProductModel($this->database);

            try {
                $product_list = $productModel->getAdminAllProducts();
                $no_records = empty($product_list);
            } catch (Exception $e) {
                $product_list = [];
                $no_records = true;
                $error_message = $e->getMessage();
            }

            require __DIR__ . '/../views/dashboard/AdminProducts.php';
        }

        public function createProductForm() {
            require_once "config.php";
            require_once "permission.php";
            require __DIR__ . '/../views/dashboard/AdminCreateProductForm.php';
        }

        public function createProduct() {
            $productName = $_POST['productName'];
            $netPrice = str_replace(',', '.', $_POST['netPrice']);
            $grossPrice = str_replace(',', '.', $_POST['grossPrice']);
            $description = $_POST['description'];
            $isAvailable = $_POST['isAvailable'];
            $productModel = new ProductModel($this->database);
            $success = false;

            try {
                $productModel->insertProduct($productName, $grossPrice, $netPrice, $description, $isAvailable);
                $success = true;
            } catch (Exception $e) {
                $success = false;
                $error_message = $e->getMessage();
            }

            require __DIR__ . '/../views/dashboard/AdminCreateProductForm.php';
        }

        public function removeProduct() {
            $productID = $_POST['productID'];
            $productModel = new ProductModel($this->database);
            $_SESSION['flash_success_remove'] = false;

            try {
                $productModel->deleteProduct($productID);
                $_SESSION['flash_success_remove'] = true;
            } catch (Exception $e) {
                $_SESSION['flash_success_remove'] = false;
                $error_message = $e->getMessage();
            }

            header("Location: /elektron/admin/produkty");
            exit;
        }

        public function editProductForm() {
            $productID = (int)$_POST['productID'];
            $productModel = new ProductModel($this->database);

            try {
                $result = $productModel->getProductByID($productID);
                $product_row = !empty($result) ? $result[0] : null;
                $no_records = is_null($product_row);
            } catch (Exception $e) {
                $product_row = null;
                $no_records = true;
                $error_message = $e->getMessage();
            }
            require __DIR__ . '/../views/dashboard/AdminEditProductForm.php';
        }

        public function updateProduct() {
            $productID = (int)$_POST['productID'];
            $productName = $_POST['productName'];
            $grossPrice = str_replace(',', '.', $_POST['grossPrice']);
            $netPrice = str_replace(',', '.', $_POST['netPrice']);
            $description = $_POST['description'];
            $isAvailable = $_POST['isAvailable'];
            $_SESSION['flash_success_update'] = false;

            $productModel = new ProductModel($this->database);

            try {
                $productModel->updateProduct($productID, $productName, $grossPrice, $netPrice, $description, $isAvailable);
                $_SESSION['flash_success_update'] = true;
            } catch (Exception $e) {
                $_SESSION['flash_success_update'] = false;
                $error_message = $e->getMessage();
            }

            header("Location: /elektron/admin/produkty");
            exit;
        }
    }
?>