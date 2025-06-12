<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController
{
    private function safeSessionStart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function showLogin()
    {
        $error = '';
        include __DIR__ . '/../views/auth/login.php';
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $error = '';

        if (!$email || !$password) {
            $error = 'Email y contraseña son requeridos.';
            include __DIR__ . '/../views/auth/login.php';
            return;
        }

        $userModel = new User();
        $user = $userModel->getByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $this->safeSessionStart();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'] ?? 'seller';

            header("Location: index.php?controller=home&action=index");
            exit;
        } else {
            $error = 'Credenciales incorrectas.';
            include __DIR__ . '/../views/auth/login.php';
        }
    }

    public function logout()
    {
        $this->safeSessionStart();
        session_unset();
        session_destroy();

        if (ini_get("session.use_cookies")) {
            setcookie(session_name(), '', time() - 42000, '/');
        }

        header("Location: index.php?controller=auth&action=showLogin");
        exit;
    }

    public function forgotPassword()
    {
        include __DIR__ . '/../views/auth/forgot_password.php';
    }

    public function sendResetEmail()
    {
        $email = $_POST['email'] ?? '';
        if (empty($email)) {
            die("Correo requerido");
        }

        $userModel = new User();
        $user = $userModel->getByEmail($email);

        if (!$user) {
            die("Usuario no encontrado");
        }

        $token = bin2hex(random_bytes(16));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $userModel->saveResetToken($user['id'], $token, $expiry);

        $resetUrl = "http://localhost:8888/practica_hosting/public/index.php?controller=auth&action=resetForm&token=$token";

        $resetLink = "
            <a href='$resetUrl' 
               style='display:inline-block;padding:10px 20px;font-size:16px;color:#fff;
                      background-color:#28a745;text-decoration:none;border-radius:5px;'>
               Recuperar contraseña
            </a>
        ";

        $subject = 'Recuperación de contraseña';
        $body = "
            <p>Hola <strong>{$user['name']}</strong>,</p>
            <p>Has solicitado restablecer tu contraseña.</p>
            <p>Haz clic en el siguiente botón para continuar:</p>
            <p>$resetLink</p>
            <p>Este enlace expirará en 1 hora.</p>
        ";

        try {
            require_once __DIR__ . '/../src/Services/MailService.php';
            $mailer = new MailService();
            $mailer->send($email, $user['name'], $subject, $body);

            $type = "success";
            $message = "Se ha enviado un correo con el enlace de recuperación.";
            $redirectUrl = "index.php?controller=auth&action=showLogin";

        } catch (Exception $e) {
            $type = "danger";
            $message = "Error al enviar el correo: " . $e->getMessage();
            $redirectUrl = "index.php?controller=auth&action=forgotPassword";
        }

        require __DIR__ . '/../views/shared/message.php';
        exit;
    }

    public function resetForm()
    {
        $token = $_GET['token'] ?? '';
        include __DIR__ . '/../views/auth/reset_password.php';
    }

    public function resetPassword()
    {
        $token = $_POST['token'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByToken($token);

        if (!$user || strtotime($user['token_expiry']) < time()) {
            $type = "danger";
            $message = "Token inválido o expirado.";
            $redirectUrl = "index.php?controller=auth&action=showLogin";
            require __DIR__ . '/../views/shared/message.php';
            exit;
        }

        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $userModel->updatePassword($user['id'], $hashed);
        $userModel->clearResetToken($user['id']);

        $type = "success";
        $message = "Contraseña actualizada correctamente.";
        $redirectUrl = "index.php?controller=auth&action=showLogin";
        require __DIR__ . '/../views/shared/message.php';
        exit;
    }
}
