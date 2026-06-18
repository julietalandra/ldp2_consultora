<?php
// Determina el nombre del archivo actual para marcar la opción activa en el menú
$currentPage = basename($_SERVER['PHP_SELF']);
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

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>2do Desempeño - AdminKit</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.php">
                    <span class="align-middle">AdminKit</span>
                </a>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Proyectos
                    </li>

                    <!-- Clase 'active' agregada dinámicamente si es la página de listado de proyectos -->
                    <li class="sidebar-item <?php echo ($currentPage == 'listado_proyecto.php') ? 'active' : ''; ?>">
                        <a class="sidebar-link" href="listado_proyecto.php">
                            <i class="align-middle me-2" data-feather="list"></i> <span class="align-middle">Listado</span>
                        </a>
                    </li>

                    <!-- Clase 'active' agregada dinámicamente si es la página de carga de proyectos -->
                    <li class="sidebar-item <?php echo ($currentPage == 'carga_proyecto.php') ? 'active' : ''; ?>">
                        <a class="sidebar-link" href="carga_proyecto.php">
                            <i class="align-middle me-2" data-feather="file"></i><span class="align-middle">Cargar nuevo</span>
                        </a>
                    </li>

					<?php if ($_SESSION['Usuario_Nivel'] == 1){ ?>

                    <li class="sidebar-header">
                        Personal
                    </li>
                    <!-- Clase 'active' agregada dinámicamente si es la página de listado de usuarios -->
                    <li class="sidebar-item <?php echo ($currentPage == 'listado_usuarios.php') ? 'active' : ''; ?>">
                        <a class="sidebar-link" href="listado_usuarios.php">
                            <i class="align-middle me-2" data-feather="user"></i><span class="align-middle">Listado de usuarios</span>
                        </a>
                    </li>

                    <?php } ?>

                    <li class="sidebar-header">
                        Empresas
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="listado_empresas.html">
                            <i class="align-middle me-2" data-feather="award"></i> <span class="align-middle">Listado</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="carga_empresa.html">
                            <i class="align-middle me-2" data-feather="file"></i><span class="align-middle">Cargar nueva</span>
                        </a>
                    </li>
                    
                    <?php if ($_SESSION['Usuario_Nivel'] == 1){ ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="listado_paises.html">
                            <i class="align-middle me-2" data-feather="map-pin"></i><span class="align-middle">Listado de países</span>
                        </a>
                    </li>
                    <?php } ?>
                    
                </ul>
            </div>
        </nav>
        
        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="bell"></i>
                                    <span class="indicator">4</span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                                <div class="dropdown-menu-header">
                                    4 Nuevas Notificaciones
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <i class="text-danger" data-feather="alert-circle"></i>
                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark">Actualización completa</div>
                                                <div class="text-muted small mt-1">Reiniciar servidor 12 para finalizar.</div>
                                                <div class="text-muted small mt-1">Hace 30m</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="message-square"></i>
                                </div>
                            </a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

                            <!-- Avatar y Nombre completo del usuario logueado en la sesión -->
                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                <img src="img/avatars/<?php echo $_SESSION['Usuario_Img']; ?>" class="avatar img-fluid rounded me-1" alt="<?php echo $_SESSION['Usuario_Nombre']; ?>" />
                                <span class="text-dark"><?php echo $_SESSION['Usuario_Nombre'] . ' ' . $_SESSION['Usuario_Apellido']; ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- Nombre del nivel/rol del usuario logueado en la sesión -->
                                <a class="dropdown-item" href="#">
                                    <i class="align-middle me-1" data-feather="user"></i>
                                    Rol: <?php echo $_SESSION['Usuario_NombreNivel']; ?>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="index.php"><i class="align-middle me-1" data-feather="settings"></i> Panel</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="cerrarsesion.php">Salir</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
