<?php
require_once __DIR__ . '/../models/Sale.php';
require_once __DIR__ . '/../models/Product.php';

class SaleController
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $saleModel = new Sale();
        $sales = $saleModel->getAll();

        include __DIR__ . '/../views/sales/index.php';
    }

    public function create($productId = null)
    {
        require_once __DIR__ . '/../models/Product.php';
        $productModel = new Product();

        $products = $productModel->getAll(); // para el select
        require_once __DIR__ . '/../views/sales/create.php';
    }


    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = (int) $_POST['product_id'];
            $quantity = (int) $_POST['quantity'];

            $saleModel = new Sale();
            $result = $saleModel->createSale($product_id, $quantity);

            if ($result === true) {
                header("Location: index.php?controller=sale&action=index");
                exit;
            } else {
                $error = $result; // <- este mensaje puede ser de stock insuficiente u otro
                $productModel = new Product();
                $products = $productModel->getAll();
                include __DIR__ . '/../views/sales/create.php';
            }
        }
    }
}