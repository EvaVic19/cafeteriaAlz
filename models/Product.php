<?php
require_once __DIR__ . '/../config/database.php'; // Conexión con la base de datos

class Product
{
    private $db;
    private $id;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Permite establecer el ID del producto
    public function setId($id)
    {
        $this->id = $id;
    }

    // Elimina el producto con el ID previamente establecido
    public function delete()
    {
        if (!isset($this->id)) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT 
                products.id, products.name, products.reference, products.price, 
                products.weight, products.category_id, products.stock, 
                products.created_at, categories.name AS category_name 
            FROM products 
            LEFT JOIN categories ON products.category_id = categories.id 
            ORDER BY products.id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name, $reference, $price, $weight, $category_id, $stock)
    {
        $stmt = $this->db->prepare("
            INSERT INTO products (name, reference, price, weight, category_id, stock) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$name, $reference, $price, $weight, $category_id, $stock]);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $reference, $price, $weight, $category_id, $stock)
    {
        $stmt = $this->db->prepare("
            UPDATE products 
            SET name = ?, reference = ?, price = ?, weight = ?, category_id = ?, stock = ? 
            WHERE id = ?
        ");
        return $stmt->execute([$name, $reference, $price, $weight, $category_id, $stock, $id]);
    }

    public function getCategories()
    {
        $stmt = $this->db->query("SELECT id, name FROM categories ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function increaseStock($product_id, $quantity)
    {
        $stmt = $this->db->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
        return $stmt->execute([$quantity, $product_id]);
    }
}
