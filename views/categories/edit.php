<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../layout/nav.php'; ?>

<h2>Editar Categoría</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?controller=category&action=update&id=<?= $category['id'] ?>">
    <div class="mb-3">
        <label class="form-label">Nombre de la categoría</label>
        <input type="text" name="name" class="form-control"
            value="<?= htmlspecialchars($category['name']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($category['description']) ?></textarea>
    </div>

    <!-- Aquí puedes dejar el select de reasignación si lo vas a usar -->

    <button class="btn btn-primary">Actualizar</button>
</form>


<?php require_once __DIR__ . '/../layout/footer.php'; ?>
