<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../layout/nav.php'; ?>
<h2>Crear usuario</h2>

<?php if (!empty($errors)): ?><!--Si hay errores de validación, se muestran en una alerta -->
    <div class="alert alert-danger"><!-- Si hay errores de validación, se muestran en una alerta -->
        <ul class="mb-0"><!-- Lista de errores -->
            <?php foreach ($errors as $error): ?><!-- Recorre los errores y los muestra -->
                <li><?= htmlspecialchars($error) ?></li><!--Muestra cada error -->
            <?php endforeach; ?><!-- Fin del bucle -->
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?controller=user&action=store"><!-- Formulario para crear un nuevo usuario -->
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="name" class="form-control"
            value="<?= $oldData['name'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
            value="<?= $oldData['email'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control"
            value="<?= $oldData['password'] ?? '' ?>" required>
    </div>
    <div class="form-group mb-3">
        <label for="rol">Rol</label>
        <select name="rol" class="form-select" aria-label="Default select example">
            <option value="">Seleccione un rol</option>
            <option value="admin">Admin</option>
            <option value="seller">Seller</option>
            <option value="<?= $oldData['role'] && $oldData['role'] ? 'selected' : '' ?>" required>
            </option>
        </select>
    </div>
    <button class="btn btn-primary">Guardar</button>
</form>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>