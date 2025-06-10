<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../layout/nav.php'; ?>

<div class="container mt-4">
    <h2>Registrar Venta</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>


    <form action="index.php?controller=sale&action=store" method="POST">
        <div class="mb-3">
            <label for="product_id" class="form-label">Producto</label>
            <select name="product_id" id="product_id" class="form-select" required>
                <option value="">Seleccione un producto</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?= $product['id'] ?>"
                        <?= isset($_GET['id']) && $_GET['id'] == $product['id'] ? 'selected' : '' ?>>
                        <?= $product['name'] ?> (Stock: <?= $product['stock'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Cantidad</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Venta</button>
    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>