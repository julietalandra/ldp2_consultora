<?php
session_start();
// Control de sesión
if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/library.php';
$MiConexion = ConexionBD();

// Listado de proyectos ordenados por FechaCarga ASC (ya ordenados en library.php)
$ListadoProyectos  = Listar_Proyectos($MiConexion);
$CantidadProyectos = count($ListadoProyectos);
?>
<?php require_once 'includes/header.inc.php'; ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3"><strong>Proyectos</strong> Listado general.</h1>

        <div class="row">
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h4 class="text-info">Visualizando <?php echo $CantidadProyectos; ?> registros</h4>
                    </div>

                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Denominación</th>
                                <th class="d-none d-md-table-cell">Fecha Carga</th>
                                <th class="d-none d-md-table-cell">Empresa</th>
                                <th>Estado</th>
                                <th class="d-none d-md-table-cell">Líder</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < $CantidadProyectos; $i++): ?>
                                <?php
                                // Color del badge según ID del estado
                                $estadoId = $ListadoProyectos[$i]['ESTADO_ID'];
                                switch ($estadoId) {
                                    case 1:
                                        $colorBadge = 'info'; // Análisis Iniciado
                                        break;
                                    case 2:
                                        $colorBadge = 'warning'; // En Desarrollo
                                        break;
                                    case 3:
                                        $colorBadge = 'success'; // Terminado
                                        break;
                                    case 4:
                                        $colorBadge = 'danger'; // Cancelado
                                        break;
                                    default:
                                        $colorBadge = 'secondary';
                                }

                                // Determinar la bandera de país basándonos en el nombre del país
                                $paisNombre = strtoupper($ListadoProyectos[$i]['PAIS']);
                                if (strpos($paisNombre, 'ARG') !== false) {
                                    $bandera = 'ARG.jpg';
                                } elseif (strpos($paisNombre, 'URU') !== false) {
                                    $bandera = 'URU.jpg';
                                } elseif (strpos($paisNombre, 'CHI') !== false) {
                                    $bandera = 'CHI.jpg';
                                } elseif (strpos($paisNombre, 'BRA') !== false || strpos($paisNombre, 'BR') !== false) {
                                    $bandera = 'BRA.jpg';
                                } else {
                                    $bandera = 'default.jpg';
                                }

                                // ID encriptado en base64 para las acciones
                                $idEncriptado = base64_encode($ListadoProyectos[$i]['ID']);
                                ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo htmlspecialchars($ListadoProyectos[$i]['DENOMINACION']); ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo $ListadoProyectos[$i]['FECHA_CARGA']; ?></td>
                                    <td class="d-none d-md-table-cell">
                                        <img src="img/countries/<?php echo $bandera; ?>" width="36" height="36" class="rounded-circle me-2" alt="<?php echo htmlspecialchars($ListadoProyectos[$i]['PAIS']); ?>">
                                        <?php echo htmlspecialchars($ListadoProyectos[$i]['EMPRESA']); ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo $colorBadge; ?>">
                                            <?php echo strtoupper(htmlspecialchars($ListadoProyectos[$i]['ESTADO'])); ?>
                                        </span>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <img src="img/avatars/<?php echo htmlspecialchars($ListadoProyectos[$i]['LIDER_FOTO']); ?>" width="36" height="36" class="rounded-circle me-2" alt="Líder">
                                        <?php echo htmlspecialchars($ListadoProyectos[$i]['LIDER_NOMBRE'] . ' ' . $ListadoProyectos[$i]['LIDER_APELLIDO']); ?>
                                    </td>
                                    <td>
                                        <!-- Editar: enlace dinámico -->
                                        <a class="btn btn-primary btn-sm success" href="editar_proyecto.php?ID_PROYECTO=<?php echo $idEncriptado; ?>&ESTADO=<?php echo $ListadoProyectos[$i]['ESTADO_ID']; ?>">
                                            <span data-feather="edit"></span> Editar
                                        </a>

                                        <!-- Cancelar: Solo visible si el usuario es Administrador (Nivel 1) -->
                                        <?php if ($_SESSION['Usuario_Nivel'] == 1): ?>
                                            <a class="btn btn-warning btn-sm" href="cancelar_proyecto.php?ID_PROYECTO=<?php echo $idEncriptado; ?>&ESTADO=4">
                                                <span data-feather="alert-triangle"></span> Cancelar
                                            </a>
                                        <?php endif; ?>
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
