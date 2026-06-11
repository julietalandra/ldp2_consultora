<?php
session_start();
require_once 'funciones/library.php';

$MiConexion = ConexionBD();

$Mensaje = '';


if (!empty($_POST['BotonLogin'])) {
    // Limpieza de datos básica
    $usuario = trim(strip_tags($_POST['email']));
    $clave   = trim(strip_tags($_POST['password']));

    // Validar que los campos no estén vacíos
    if (empty($usuario) || empty($clave)) {
        $Mensaje = 'Por favor, completa todos los campos.';
    } else {
        // Consultar a la base de datos si las credenciales son válidas (verifica hash de clave)
        $UsuarioLogueado = DatosLogin_Hash($usuario, $clave, $MiConexion);

        if (!empty($UsuarioLogueado)) {
            // Definir niveles de acceso permitidos: 1 = Administrador, 2 = Líder
            $NivelesPermitidos = [1, 2];
            $PermiteIngresar = in_array($UsuarioLogueado['NIVEL_ID'], $NivelesPermitidos);

            // Validar permisos y si la cuenta está activa
            if (!$PermiteIngresar) {
                $Mensaje = 'No tienes permisos asignados para ingresar al panel';
            } elseif ($UsuarioLogueado['Activo'] != 1) {
                $Mensaje = 'Tu cuenta se encuentra inactiva.';
            } else {
                // Todo ok — genero las variables de sesión requeridas
                $_SESSION['Usuario_Nombre']      = $UsuarioLogueado['Nombre'];
                $_SESSION['Usuario_Apellido']    = $UsuarioLogueado['Apellido'];
                $_SESSION['Usuario_Nivel']       = $UsuarioLogueado['NIVEL_ID'];
                $_SESSION['Usuario_NombreNivel'] = $UsuarioLogueado['NIVEL_NOMBRE'];
                $_SESSION['Usuario_Img']         = $UsuarioLogueado['Foto'];
                $_SESSION['Usuario_Id']          = $UsuarioLogueado['Id'];
                
                header('Location: index.php');
                exit;
            }
        } else {
            $Mensaje = 'Datos incorrectos, intenta de nuevo.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

    <title>Sign In | AdminKit Demo</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-3">
                                    <div class="text-center mt-4">
                                        <p class="lead">
                                            <img src="img/avatars/login.png" width="150" height="150" alt="Login">
                                        </p>
                                        <h1 class="h2">Ingresa tus datos.</h1>
                                    </div>
                                    
                                    <div class="card-header text-center pb-0">
                                        <!-- Mostrar mensaje de error si existió alguna falla en el login -->
                                        <?php if (!empty($Mensaje)): ?>
                                            <h4 class="text-danger"><?php echo $Mensaje; ?></h4>
                                        <?php endif; ?>
                                    </div>

                                    <form action="" method="POST">
                                        <div class="mb-3">
                                            <label class="form-label">Login</label>
                                            <!-- Mantiene el valor del email/usuario ingresado tras un intento fallido -->
                                            <input class="form-control form-control-lg" type="text" name="email" 
                                                   placeholder="Ingresa tu email o usuario" 
                                                   value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password" 
                                                   placeholder="Ingresa tu password" required />
                                        </div>
                                        <div class="d-grid gap-2 mt-3">
                                            <input class="btn btn-lg btn-primary" type="submit" name="BotonLogin" value="Ingresar">
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/app.js"></script>

</body>

</html>