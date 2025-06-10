<?php
require_once __DIR__ . '/../config/database.php';

class Category
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
        // Asegura que PDO lance excepciones en caso de error
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Obtener todas las categorías
    public function getAll()
    {
        $sql = "SELECT id, name, description FROM categories ORDER BY id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear nueva categoría
    public function create($name, $description)
    {
        $sql = "INSERT INTO categories (name, description) VALUES (:name, :description)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':name' => htmlspecialchars(trim($name)),
            ':description' => htmlspecialchars(trim($description))
        ]);
    }

    // Buscar una categoría por ID
    public function find($id)
    {
        $sql = "SELECT * FROM categories WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar una categoría
    public function update($id, $name, $description)
    {
        $sql = "UPDATE categories SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':name' => htmlspecialchars(trim($name)),
            ':description' => htmlspecialchars(trim($description)),
            ':id' => $id
        ]);
    }

    // Eliminar una categoría
    public function delete($id)
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
