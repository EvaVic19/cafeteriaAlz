<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../layout/nav.php'; ?>
<h2>Crear Producto</h2>

<form method="POST" action="index.php?controller=product&action=store"><!-- Formulario para crear un nuevo producto -->
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="name" class="form-control"
            value="<?= $oldData['name'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Referencia</label>
        <input type="text" name="reference" class="form-control"
            value="<?= $oldData['reference'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Precio</label>
        <input type="number" name="price" class="form-control"
            value="<?= $oldData['price'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Peso</label>
        <input type="number" name="weight" class="form-control"
            value="<?= $oldData['weight'] ?? '' ?>" required>
    </div>
    <div class="form-group mb-3">
        <label for="category_id">Categoría</label>
        <select id="category_id" name="category_id" class="form-select" aria-label="Default select example">
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= (isset($oldData['category_id']) && $oldData['category_id'] == $category['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control"
            value="<?= $oldData['stock'] ?? '' ?>" required>
    </div>
    <button class="btn btn-primary">Guardar</button>
</form>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>