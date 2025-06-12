<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Restablecer Contraseña</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($token) && $token): ?>
        <form action="/auth/resetPassword" method="POST" class="col-md-6 offset-md-3">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required minlength="6">
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="6">
            </div>

            <button type="submit" class="btn btn-primary w-100">Restablecer</button>
        </form>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            Token inválido o expirado. Solicita un nuevo enlace de recuperación.
        </div>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>


