<?php
session_start();
// Control de sesión
if (empty($_SESSION['Usuario_Nombre'])) {
    header('Location: cerrarsesion.php');
    exit;
}

require_once 'funciones/library.php';
$MiConexion = ConexionBD();

// Cargo los selectores desde la BD
$ListadoEmpresas  = Listar_Empresas($MiConexion);
$CantidadEmpresas = count($ListadoEmpresas);
$ListadoLideres   = Listar_Lideres($MiConexion);
$CantidadLideres  = count($ListadoLideres);

$Mensaje = '';
$Estilo  = '';

if (!empty($_POST['BotonRegistrar'])) {
    // Limpieza de datos en $_POST
    foreach ($_POST as $clave => $valor) {
        $_POST[$clave] = trim(strip_tags($valor));
    }

    Validar_Proyecto();

    if (empty($_SESSION['Mensaje'])) {
        if (Insertar_Proyecto($MiConexion)) {
            $Mensaje = 'Registro cargado correctamente.';
            $Estilo  = 'success';
            $_POST   = array(); // Limpia el formulario en caso de éxito
        } else {
            $Mensaje = 'No se pudo guardar el proyecto.';
            $Estilo  = 'danger';
        }
    } else {
        $Mensaje = $_SESSION['Mensaje'];
        $Estilo  = 'danger';
        $_SESSION['Mensaje'] = ''; // Limpia el mensaje de la sesión
    }
}
?>
<?php require_once 'includes/header.inc.php'; ?>

<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 mb-3"><strong>Proyectos</strong> Cargar nuevo.</h1>
        </div>
        
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <?php if (!empty($Mensaje)): ?>
                            <h4 class="text-<?php echo $Estilo; ?>">
                                <?php if ($Estilo == 'success'): ?>
                                    <i class="align-middle" data-feather="check-square"></i>
                                <?php else: ?>
                                    <i class="align-middle me-2" data-feather="alert-circle"></i>
                                <?php endif; ?>
                                <?php echo $Mensaje; ?>
                            </h4>
                        <?php endif; ?>
                        
                        <h4 class="text-info">
                            Los campos con <i class="align-middle me-2" data-feather="command"></i> son obligatorios
                        </h4> 
                    </div>

                    <form action="" method="POST">
                        <div class="card-body">
                            <h5 class="card-title mb-0">Denominación <i class="align-middle me-2" data-feather="command"></i></h5>
                            <input type="text" class="form-control" name="Denominacion" 
                                   placeholder="Ingresa el nombre del Proyecto"
                                   value="<?php echo isset($_POST['Denominacion']) ? $_POST['Denominacion'] : ''; ?>" required>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title mb-0">Empresa <i class="align-middle me-2" data-feather="command"></i></h5>
                            <select class="form-select mb-3" name="IdEmpresa" required>
                                <option value="">Para quien trabajaremos...</option>
                                <?php for ($i = 0; $i < $CantidadEmpresas; $i++): ?>
                                    <option value="<?php echo $ListadoEmpresas[$i]['ID']; ?>"
                                        <?php echo (isset($_POST['IdEmpresa']) && $_POST['IdEmpresa'] == $ListadoEmpresas[$i]['ID']) ? 'selected' : ''; ?>>
                                        <?php echo $ListadoEmpresas[$i]['DENOMINACION']; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title mb-0">Líder <i class="align-middle me-2" data-feather="command"></i></h5>
                            <select class="form-select mb-3" name="IdLider" required>
                                <option value="">Selecciona una opción</option>
                                <?php for ($i = 0; $i < $CantidadLideres; $i++): ?>
                                    <option value="<?php echo $ListadoLideres[$i]['ID']; ?>"
                                        <?php echo (isset($_POST['IdLider']) && $_POST['IdLider'] == $ListadoLideres[$i]['ID']) ? 'selected' : ''; ?>>
                                        <?php echo $ListadoLideres[$i]['APELLIDO'] . ', ' . $ListadoLideres[$i]['NOMBRE']; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title mb-0">Observaciones</h5>
                            <textarea class="form-control" name="Observaciones" rows="2" 
                                      placeholder="Observaciones del tema..."><?php echo isset($_POST['Observaciones']) ? $_POST['Observaciones'] : ''; ?></textarea>
                        </div>

                        <div class="card-body">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="Prioridad" value="1"
                                    <?php echo isset($_POST['Prioridad']) ? 'checked' : ''; ?>>
                                <span class="form-check-label">
                                    Tildar si es solicitado con prioridad 
                                </span>
                            </label>
                        </div>

                        <div class="card-body pt-0">
                            <input type="submit" class="btn btn-primary" name="BotonRegistrar" value="Registrar Datos" />
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</main>

<?php require_once 'includes/footer.inc.php'; ?>
