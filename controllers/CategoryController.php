<?php
require_once __DIR__ . '/../models/Category.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category;
    }

    // Función para validar si el usuario es admin
    private function checkAdminRole()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=category&action=index&unauthorized=true");
            exit;
        }
    }

    public function index()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../views/categories/index.php';
    }

    public function create()
    {
        $this->checkAdminRole(); // Solo admin puede acceder
        include __DIR__ . '/../views/categories/create.php';
    }

    public function store($name, $description)
    {
        $this->checkAdminRole(); // Solo admin puede guardar

        $errors = [];

        if (empty($name)) {
            $errors[] = "El nombre de la categoría es obligatorio.";
        }

        if (empty($description)) {
            $errors[] = "La descripción de la categoría es obligatoria.";
        }

        if (count($errors) > 0) {
            $oldData = ['name' => $name, 'description' => $description];
            include __DIR__ . '/../views/categories/create.php';
        } else {
            $this->categoryModel->create($name, $description);
            header("Location: index.php?controller=category&action=index&success=1");
            exit;
        }
    }

    public function edit($id)
    {
        $this->checkAdminRole(); // Solo admin puede editar

        $category = $this->categoryModel->find($id);
        if (!$category) {
            die("Categoría no encontrada.");
        }

        include __DIR__ . '/../views/categories/edit.php';
    }

    public function update($id)
    {
        $this->checkAdminRole(); // Solo admin puede actualizar

        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        $errors = [];
        if (empty($name)) $errors[] = "El nombre es obligatorio.";

        if (!empty($errors)) {
            $category = ['id' => $id, 'name' => $name, 'description' => $description];
            include __DIR__ . '/../views/categories/edit.php';
            return;
        }

        $this->categoryModel->update($id, $name, $description);

        header("Location: index.php?controller=category&action=index&updated=true");
        exit;
    }

    public function delete($id)
    {
        $this->checkAdminRole(); // Solo admin puede eliminar

        $this->categoryModel->delete($id);
        header("Location: index.php?controller=category&action=index&deleted=true");
        exit;
    }
}
