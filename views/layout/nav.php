<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php?controller=home&action=index#">Inicio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuNavbar">
            <?php if (isset($_SESSION['user_id'])): ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?controller=user&action=index">Usuarios</a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['admin', 'seller'])): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?controller=product&action=index">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?controller=category&action=index">Categoría</a>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php
                    $roleName = 'Usuario';
                    if (isset($_SESSION['user_role'])) {
                        $roleName = ($_SESSION['user_role'] === 'admin') ? 'Administrador' : 'Vendedor';
                    }
                    ?>
                    <li class="nav-item">
                        <span class="navbar-text me-2 text-white">
                            Bienvenido <?= $roleName ?>, <?= htmlspecialchars($_SESSION['user_name']) ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="index.php?controller=auth&action=logout">
                            Cerrar sesión
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="index.php?controller=auth&action=showLogin">
                            Iniciar sesión
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">