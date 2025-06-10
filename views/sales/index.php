<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../layout/nav.php'; ?>

<div class="container mt-4">
    <h2>Historial de Ventas</h2>
    <div class="table-responsive shadow rounded">
        <table class="table table-hover table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha de Venta</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td><?= htmlspecialchars($sale['product_name']) ?></td>
                        <td><?= $sale['quantity'] ?></td>
                        <td><?= $sale['sale_date'] ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="index.php?controller=product&action=index" class="btn btn-info text-white mt-4">Volver</a>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>