<?php

// CONEXIÓN 
function ConexionBD($Host='localhost', $User='root', $Password='root', $BaseDatos='consultora') {
    $link = mysqli_connect($Host, $User, $Password, $BaseDatos);
    if (!$link) {
        die('No se pudo establecer la conexión con la base de datos.');
    }
    return $link;
}

// USUARIOS
function DatosLogin_Hash($usuario, $clave, $vConexion) {
    
    // Busca el usuario por email O por nombre de usuario
    $SQL = "SELECT u.Id, u.Nombre, u.Apellido, u.Clave, u.Foto, u.Activo,
                   r.Id as NIVEL_ID, r.Denominacion as NIVEL_NOMBRE
            FROM usuarios u
            INNER JOIN roles r ON u.IdRol = r.Id
            WHERE u.Email = '$usuario' OR u.Usuario = '$usuario'";
            
    $rs = mysqli_query($vConexion, $SQL);
    if ($rs && mysqli_num_rows($rs) > 0) {
        $dato = mysqli_fetch_array($rs);
        // Verifica la contraseña
        if (password_verify($clave, $dato['Clave'])) {
            return $dato;
        }
    }
    return false;
}

function Listar_Usuarios($vConexion) {
    $Listado = array();
    $SQL = "SELECT u.Id, u.Nombre, u.Apellido, u.Usuario, u.Foto, u.Activo,
                   r.Denominacion as ROL
            FROM usuarios u
            INNER JOIN roles r ON u.IdRol = r.Id
            ORDER BY u.Apellido, u.Nombre";
    $rs = mysqli_query($vConexion, $SQL);
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['ID']       = $data['Id'];
        $Listado[$i]['NOMBRE']   = $data['Nombre'];
        $Listado[$i]['APELLIDO'] = $data['Apellido'];
        $Listado[$i]['USUARIO']  = $data['Usuario'];
        $Listado[$i]['FOTO']     = $data['Foto'];
        $Listado[$i]['ROL']      = $data['ROL'];
        $Listado[$i]['ACTIVO']   = $data['Activo'];
        $i++;
    }
    return $Listado;
}

// EMPRESAS
function Listar_Empresas($vConexion) {
    $Listado = array();
    $SQL = "SELECT Id, Denominacion FROM empresas ORDER BY Denominacion";
    $rs = mysqli_query($vConexion, $SQL);
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['ID']           = $data['Id'];
        $Listado[$i]['DENOMINACION'] = $data['Denominacion'];
        $i++;
    }
    return $Listado;
}

// LÍDERES
function Listar_Lideres($vConexion) {
    // Solo trae usuarios con rol Lider (IdRol = 2)
    $Listado = array();
    $SQL = "SELECT Id, Nombre, Apellido FROM usuarios
            WHERE IdRol = 2 AND Activo = 1
            ORDER BY Apellido, Nombre";
    $rs = mysqli_query($vConexion, $SQL);
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['ID']       = $data['Id'];
        $Listado[$i]['NOMBRE']   = $data['Nombre'];
        $Listado[$i]['APELLIDO'] = $data['Apellido'];
        $i++;
    }
    return $Listado;
}

// PROYECTOS
function Insertar_Proyecto($vConexion) {
    $denominacion = trim($_POST['Denominacion']);
    $idEmpresa    = (int)$_POST['IdEmpresa'];
    $idLider      = (int)$_POST['IdLider'];
    $obs          = trim($_POST['Observaciones']);
    $prioridad    = isset($_POST['Prioridad']) ? 1 : 0;
    $idEstado     = 1;  // Siempre "Análisis Iniciado"
    $idUsuario    = $_SESSION['Usuario_Id'];

    $SQL = "INSERT INTO proyectos
            (Denominacion, IdEmpresa, IdLider, Observaciones, Prioridad, IdEstado, FechaCarga, IdUsuarioCarga)
            VALUES
            ('$denominacion', $idEmpresa, $idLider, '$obs', $prioridad, $idEstado, NOW(), $idUsuario)";

    if (!mysqli_query($vConexion, $SQL)) {
        die('<h4>Consulta: ' . $SQL . '</h4><p style="color:#ff0000">' . mysqli_error($vConexion) . '</p>');
    }
    return true;
}

function Listar_Proyectos($vConexion) {
    $Listado = array();
    $SQL = "SELECT p.Id, p.Denominacion, p.FechaCarga, p.Prioridad,
                   e.Denominacion as EMPRESA,
                   es.Id as ESTADO_ID, es.Denominacion as ESTADO,
                   u.Nombre as LIDER_NOMBRE, u.Apellido as LIDER_APELLIDO, u.Foto as LIDER_FOTO,
                   pa.Denominacion as PAIS
            FROM proyectos p
            INNER JOIN empresas e ON p.IdEmpresa = e.Id
            INNER JOIN estados es ON p.IdEstado = es.Id
            INNER JOIN usuarios u ON p.IdLider = u.Id
            INNER JOIN paises pa ON e.IdPais = pa.Id
            ORDER BY p.FechaCarga ASC";
    $rs = mysqli_query($vConexion, $SQL);
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['ID']            = $data['Id'];
        $Listado[$i]['DENOMINACION']  = $data['Denominacion'];
        $Listado[$i]['FECHA_CARGA']   = date('d/m/Y', strtotime($data['FechaCarga']));
        $Listado[$i]['EMPRESA']       = $data['EMPRESA'];
        $Listado[$i]['ESTADO_ID']     = $data['ESTADO_ID'];
        $Listado[$i]['ESTADO']        = $data['ESTADO'];
        $Listado[$i]['LIDER_NOMBRE']  = $data['LIDER_NOMBRE'];
        $Listado[$i]['LIDER_APELLIDO']= $data['LIDER_APELLIDO'];
        $Listado[$i]['LIDER_FOTO']    = $data['LIDER_FOTO'];
        $Listado[$i]['PAIS']          = $data['PAIS'];
        $i++;
    }
    return $Listado;
}

// VALIDACIONES
function Validar_Proyecto() {
    $_SESSION['Mensaje'] = '';

    if (strlen($_POST['Denominacion']) < 3) {
        $_SESSION['Mensaje'] .= 'Ingresá un nombre de proyecto con al menos 3 caracteres.<br/>';
    }
    if (empty($_POST['IdEmpresa'])) {
        $_SESSION['Mensaje'] .= 'Seleccioná una empresa.<br/>';
    }
    if (empty($_POST['IdLider'])) {
        $_SESSION['Mensaje'] .= 'Seleccioná un líder.<br/>';
    }
}

?>
