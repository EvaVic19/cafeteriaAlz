<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card p-4 shadow-lg border-0" style="width: 100%; max-width: 400px;">

        <h4 class="mb-4 text-center">Restablecer contraseña</h4>

        <form action="index.php?controller=auth&action=sendResetEmail" method="POST" autocomplete="off">
            <div class="mb-3">
                <label for="email" class="form-label">Introduce tu correo electrónico:</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    placeholder="ejemplo@correo.com"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Enviar enlace de recuperación
            </button>
        </form>

        <!-- Mensaje si fue enviado -->
        <?php if (!empty($_GET['sent'])): ?>
            <div class="alert alert-success mt-3 text-center p-2">
                Si el correo está registrado, recibirás un enlace de recuperación.
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>