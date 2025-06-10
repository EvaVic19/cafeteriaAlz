<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../layout/nav.php'; ?>

<!-- Sección principal con imagen de fondo y texto encima -->
<section class="hero-section d-flex align-items-center justify-content-center text-dark" style="
    background-image: url('./img/welcome_coffee.jpg');
    background-size: cover;
    background-position: center;
    height: 100vh;
    position: relative;
    padding: 4rem 10rem;
    margin: 0;
    ">

    <!-- Capa clara para mejorar la legibilidad del texto -->
    <div style="
        background-color: rgba(255, 255, 255, 0.83);
        padding: 3rem;
        border-radius: 1rem;
        text-align: center;
        max-width: 800px;
    ">
        <h1 class="display-3 fw-bold">Bienvenido a Cafetería Alianza</h1>
        <p class="lead mt-3">Disfruta del mejor café y un ambiente acogedor</p>
        <a class="link-dark link-opacity-75-hover btn btn-lg mt-4 text-white" style="background-color: rgba(231, 137, 14, 0.94); box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4)" href="index.php?controller=category&action=index">Ir a Categorias</a>
    </div>

</section>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
