<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../layout/nav.php'; ?>

<!-- SECCIÓN HERO A PANTALLA COMPLETA SIN BORDES -->
<section class="container-fluid d-flex align-items-center justify-content-center text-dark p-0 m-0"
         style="background-image: url('./img/welcome_coffee.jpg');
                background-size: cover;
                background-position: center;
                min-height: 100vh;
                font-family: 'Playfair Display', serif;">

    <!-- Caja de contenido -->
    <div class="bg-white bg-opacity-75 p-5 rounded text-center shadow" style="max-width: 800px;">
        <h1 class="display-3 fw-bold text-black mb-3">
            Bienvenido a Cafetería Alianza
        </h1>
        <p class="fs-4 fw-bold text-black-50">
            L'art de vivre, une tasse à la fois
        </p>
        <a class="btn btn-secondary btn-lg mt-4" href="index.php?controller=category&action=index">
            Ir a Categorías
        </a>
    </div>
</section>




<?php require_once __DIR__ . '/../layout/footer.php'; ?>
