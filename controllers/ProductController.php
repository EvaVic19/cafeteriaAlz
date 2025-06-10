<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product;
    }

    public function index()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $products = $this->productModel->getAll();
        require_once __DIR__ . '/../views/products/index.php';
    }

    public function create()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $categoryModel = new Category();
        $categories = $categoryModel->getAll();

        $errors = [];
        $oldData = [];
        include __DIR__ . '/../views/products/create.php';
    }

    public function store($name, $reference, $price, $weight, $category_id, $stock)
    {
        $errors = [];

        if (empty($name)) $errors[] = "El nombre es obligatorio.";
        if (empty($reference)) $errors[] = "La referencia es obligatoria.";
        if (empty($price)) $errors[] = "El precio es obligatorio.";
        if (empty($weight)) $errors[] = "El peso es obligatorio.";
        if (empty($category_id)) $errors[] = "La categoría es obligatoria.";
        if (empty($stock)) $errors[] = "El stock es obligatorio.";

        if (count($errors) > 0) {
            $oldData = ['name' => $name, 'reference' => $reference, 'price' => $price, 'weight' => $weight, 'stock' => $stock];
            include __DIR__ . '/../views/products/create.php';
        } else {
            $productModel = new Product();
            $productModel->create($name, $reference, $price, $weight, $category_id, $stock);
            header("Location: index.php?controller=product&action=index&success=1");
            exit;
        }
    }

    public function edit($id)
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $productModel = new Product();
        $product = $productModel->find($id);

        if (!$product) {
            die("Producto no encontrado.");
        }

        $categories = $productModel->getCategories();
        include __DIR__ . '/../views/products/edit.php';
    }

    public function update($id)
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $errors = [];

        $name = $_POST['name'] ?? '';
        $reference = $_POST['reference'] ?? '';
        $price = $_POST['price'] ?? '';
        $weight = $_POST['weight'] ?? '';
        $category_id = $_POST['category_id'] ?? '';
        $stock = $_POST['stock'] ?? '';

        if (empty($name)) $errors[] = "El nombre es obligatorio.";
        if (empty($reference)) $errors[] = "La referencia es obligatoria.";
        if (!is_numeric($price)) $errors[] = "El precio debe ser numérico.";
        if (!is_numeric($weight)) $errors[] = "El peso debe ser numérico.";
        if (!is_numeric($category_id)) $errors[] = "Seleccione una categoría válida.";
        if (!is_numeric($stock)) $errors[] = "El stock debe ser un número.";

        $productModel = new Product();
        $categories = $productModel->getCategories();

        if (!empty($errors)) {
            $product = compact('id', 'name', 'reference', 'price', 'weight', 'category_id', 'stock');
            include __DIR__ . '/../views/products/edit.php';
            return;
        }

        $productModel->update($id, $name, $reference, $price, $weight, $category_id, $stock);
        header("Location: index.php?controller=product&action=index&updated=true");
        exit;
    }

    // ✅ Método para eliminar productos (solo si es admin)
    public function delete()
    {
        session_start();

        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=product&action=index");
            exit;
        }

        if (isset($_GET['id'])) {
            $productId = intval($_GET['id']);
            $productModel = new Product();
            $productModel->setId($productId);

            if ($productModel->delete()) {
                header("Location: index.php?controller=product&action=index&deleted=true");
                exit;
            } else {
                echo "<script>alert('Error al eliminar el producto'); window.location.href='index.php?controller=product&action=index';</script>";
            }
        } else {
            echo "<script>alert('ID de producto no especificado'); window.location.href='index.php?controller=product&action=index';</script>";
        }
    }
}

