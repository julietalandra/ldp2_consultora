<?php
session_start();
// Control de sesión
if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/library.php';
$MiConexion = ConexionBD();

// Listado de usuarios ordenados por Apellido, Nombre (ya ordenados en la consulta SQL)
$ListadoUsuarios  = Listar_Usuarios($MiConexion);
$CantidadUsuarios = count($ListadoUsuarios);
?>

<?php require_once 'includes/header.inc.php'; ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3"><strong>Usuarios</strong> Listado general.</h1>

        <div class="row">
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill">
                    
                    <div class="card-header">
                        <h4 class="text-info">Visualizando <?php echo $CantidadUsuarios; ?> registros</h4>
                        <hr />
                    </div>

                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Apellido y Nombre</th>
                                <th>Rol</th>
                                <th>Usuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < $CantidadUsuarios; $i++): ?>
                                <?php $IdEnc = base64_encode($ListadoUsuarios[$i]['ID']); ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td>
                                        <img src="img/avatars/<?php echo $ListadoUsuarios[$i]['FOTO']; ?>" 
                                             width="36" height="36" class="rounded-circle me-2" 
                                             alt="<?php echo $ListadoUsuarios[$i]['FOTO']; ?>">
                                        <?php echo $ListadoUsuarios[$i]['APELLIDO'] . ' ' . $ListadoUsuarios[$i]['NOMBRE']; ?>
                                    </td>
                                    <td><?php echo $ListadoUsuarios[$i]['ROL']; ?></td>
                                    <td><?php echo $ListadoUsuarios[$i]['USUARIO']; ?></td>
                                    <td>
                                        <!-- Enlaces con ID encriptados en base64 -->
                                        <a class="btn btn-primary btn-sm success" href="editar_usuario.php?ID_USUARIO=<?php echo $IdEnc; ?>">
                                            <span data-feather="edit"></span> Editar
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="borrar_usuario.php?ID_USUARIO=<?php echo $IdEnc; ?>">
                                            <span data-feather="delete"></span> Borrar
                                        </a>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

<?php require_once 'includes/footer.inc.php'; ?>
