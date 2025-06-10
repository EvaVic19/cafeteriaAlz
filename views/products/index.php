<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../layout/nav.php'; ?>
<h2>Listado de Productos</h2>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
    <a href="index.php?controller=product&action=create" class="link-light link-opacity-60-hover btn btn-success mb-2 text-white" style="box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.36)">Nuevo Producto</a>
<?php endif; ?>

<a href="index.php?controller=sale&action=index" class="link-light link-opacity-60-hover btn btn-info mb-2 text-white" style="box-shadow: 1px 2px 4px rgba(0,0,0,0.36)">
    <i class="bi bi-clock-history"></i> Historial de ventas
</a>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Producto registrado correctamente.</div>
<?php elseif (isset($_GET['updated'])): ?>
    <div class="alert alert-success">Producto actualizado.</div>
<?php elseif (isset($_GET['deleted'])): ?>
    <div class="alert alert-success">Producto eliminado.</div>
<?php endif; ?>

<div class="table-responsive shadow rounded">
    <table class="table table-hover table-striped align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Referencia</th>
                <th>Precio</th>
                <th>Peso</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['reference']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['weight']) ?></td>
                    <td><?= htmlspecialchars($product['category_name'] ?? 'Sin categoría') ?></td>
                    <td><?= htmlspecialchars($product['stock']) ?></td>
                    <td><?= date('Y-m-d', strtotime($product['created_at'])) ?></td>
                    <td>
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <a href="index.php?controller=product&action=edit&id=<?= $product['id'] ?>"
                                class="btn btn-warning btn-sm text-white"
                                style="box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.36)">
                                Editar
                            </a>

                            <a href="index.php?controller=product&action=delete&id=<?= $product['id'] ?>"
                                class="btn btn-danger btn-sm text-white"
                                style="box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.36)"
                                onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                Eliminar
                            </a>
                        <?php endif; ?>

                        <a href="index.php?controller=sale&action=create&id=<?= $product['id'] ?>"
                            class="btn btn-primary btn-sm text-white"
                            style="box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.36)">
                            Registrar Venta
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div style="margin-bottom: 5rem;"></div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>