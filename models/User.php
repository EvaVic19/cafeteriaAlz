<?php
require_once __DIR__ . '/../config/database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Obtener todos los usuarios
    public function getAll()
    {
        $stmt = $this->db->query("SELECT id, name, email, password, role FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear nuevo usuario
    public function create($name, $email, $pass, $role)
    {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $pass, $role]);
    }

    // Buscar usuario por ID
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT id, name, email, password, role FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar datos del usuario
    public function update($id, $name, $email, $role)
    {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $role, $id]);
    }

    // Eliminar usuario
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Buscar usuario por email (para login o recuperación)
    public function getByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Guardar token de recuperación y su expiración
    public function saveResetToken($userId, $token, $expiry)
    {
        $stmt = $this->db->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE id = ?");
        return $stmt->execute([$token, $expiry, $userId]);
    }

    // Buscar usuario por token
    public function findByToken($token)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE reset_token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar contraseña del usuario
    public function updatePassword($userId, $hashedPassword)
    {
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashedPassword, $userId]);
    }

    // Eliminar el token de recuperación después de usarlo
    public function clearResetToken($userId)
    {
        $stmt = $this->db->prepare("UPDATE users SET reset_token = NULL, token_expiry = NULL WHERE id = ?");
        return $stmt->execute([$userId]);
    }
}

    

