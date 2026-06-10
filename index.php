<?php
session_start();
// Control de sesión: redirige si no existe la variable de sesión
if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}
?>
<?php require_once 'includes/header.inc.php'; ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Has ingresado al panel de administración.</h1>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Elige tu opción desde el menú.</h5>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php require_once 'includes/footer.inc.php'; ?>
