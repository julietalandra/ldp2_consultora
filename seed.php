<?php
require_once 'funciones/library.php';

echo "<h2>Iniciando migración y sembrado de la base de datos...</h2>";

try {
    $conn = ConexionBD();
} catch (Exception $e) {
    die("<p style='color:red;'>Error de conexión: " . $e->getMessage() . "</p>");
}

// 1. Crear tablas si no existen
$queries = [];

// Tabla usuarios
$queries['tabla_usuarios'] = "
CREATE TABLE IF NOT EXISTS usuarios (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(50) NOT NULL,
  Apellido VARCHAR(50) NOT NULL,
  Email VARCHAR(100) NOT NULL UNIQUE,
  Usuario VARCHAR(50) NOT NULL UNIQUE,
  Clave VARCHAR(255) NOT NULL,
  IdRol INT NOT NULL,
  Foto VARCHAR(100),
  Activo TINYINT DEFAULT 1,
  FOREIGN KEY (IdRol) REFERENCES roles(Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
";

// Tabla empresas
$queries['tabla_empresas'] = "
CREATE TABLE IF NOT EXISTS empresas (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  Denominacion VARCHAR(100) NOT NULL,
  IdPais INT NOT NULL,
  Observaciones TEXT,
  FechaCarga DATE,
  IdUsuarioCarga INT,
  FOREIGN KEY (IdPais) REFERENCES paises(Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
";

// Tabla proyectos
$queries['tabla_proyectos'] = "
CREATE TABLE IF NOT EXISTS proyectos (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  Denominacion VARCHAR(150) NOT NULL,
  IdEmpresa INT NOT NULL,
  IdLider INT NOT NULL,
  Observaciones TEXT,
  Prioridad TINYINT DEFAULT 0,
  IdEstado INT DEFAULT 1,
  FechaCarga DATE,
  IdUsuarioCarga INT,
  FOREIGN KEY (IdEmpresa) REFERENCES empresas(Id),
  FOREIGN KEY (IdLider) REFERENCES usuarios(Id),
  FOREIGN KEY (IdEstado) REFERENCES estados(Id),
  FOREIGN KEY (IdUsuarioCarga) REFERENCES usuarios(Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
";

foreach ($queries as $tabla => $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green;'>✓ Tabla <strong>$tabla</strong> creada o ya existente.</p>";
    } else {
        echo "<p style='color:red;'>✗ Error al crear tabla <strong>$tabla</strong>: " . mysqli_error($conn) . "</p>";
    }
}

// 2. Insertar Brasil en paises si no existe
$checkPais = mysqli_query($conn, "SELECT Id FROM paises WHERE Denominacion = 'Brasil'");
if (mysqli_num_rows($checkPais) == 0) {
    if (mysqli_query($conn, "INSERT INTO paises (Id, Denominacion) VALUES (4, 'Brasil')")) {
        echo "<p style='color:green;'>✓ País 'Brasil' insertado correctamente en tabla paises (ID: 4).</p>";
    } else {
        echo "<p style='color:red;'>✗ Error al insertar país Brasil: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color:green;'>✓ El país 'Brasil' ya existe en la base de datos.</p>";
}

// 3. Sembrar Usuarios con claves encriptadas (bcrypt)
// Contraseña genérica para todos: clave123
$claveComun = password_hash('clave123', PASSWORD_DEFAULT);

$usuariosSeed = [
    [
        'Nombre' => 'Sue',
        'Apellido' => 'Palacios',
        'Email' => 'spalacios@consultora.com',
        'Usuario' => 'spalacios',
        'Clave' => $claveComun,
        'IdRol' => 1, // Administrador
        'Foto' => 'spalacios.png',
        'Activo' => 1
    ],
    [
        'Nombre' => 'Julieta',
        'Apellido' => 'Landra',
        'Email' => 'jlandra@consultora.com',
        'Usuario' => 'jlandra',
        'Clave' => $claveComun,
        'IdRol' => 1, // Administrador
        'Foto' => 'user.png',
        'Activo' => 1
    ],
    [
        'Nombre' => 'Marcos',
        'Apellido' => 'Gutierrez',
        'Email' => 'mgutierrez@consultora.com',
        'Usuario' => 'mgutierrez',
        'Clave' => $claveComun,
        'IdRol' => 2, // Lider
        'Foto' => 'mgutierrez.jpg',
        'Activo' => 1
    ],
    [
        'Nombre' => 'William',
        'Apellido' => 'Jhonson',
        'Email' => 'wjhonson@consultora.com',
        'Usuario' => 'wjhonson',
        'Clave' => $claveComun,
        'IdRol' => 2, // Lider
        'Foto' => 'wjhonson.jpg',
        'Activo' => 1
    ],
    [
        'Nombre' => 'Anna',
        'Apellido' => 'Rodriguez',
        'Email' => 'arodriguez@consultora.com',
        'Usuario' => 'arodriguez',
        'Clave' => $claveComun,
        'IdRol' => 2, // Lider
        'Foto' => 'arodriguez.jpg',
        'Activo' => 1
    ],
    [
        'Nombre' => 'Carlos',
        'Apellido' => 'Sanabria',
        'Email' => 'csanabria@consultora.com',
        'Usuario' => 'csanabria',
        'Clave' => $claveComun,
        'IdRol' => 3, // Analista Funcional
        'Foto' => 'csanabria.jpg',
        'Activo' => 1
    ],
    [
        'Nombre' => 'Marcos',
        'Apellido' => 'Ferrero',
        'Email' => 'mferrero@consultora.com',
        'Usuario' => 'mferrero',
        'Clave' => $claveComun,
        'IdRol' => 4, // Programador/a
        'Foto' => 'mferrero.jpg',
        'Activo' => 1
    ]
];

foreach ($usuariosSeed as $u) {
    $usuarioEscaped = mysqli_real_escape_string($conn, $u['Usuario']);
    $emailEscaped = mysqli_real_escape_string($conn, $u['Email']);
    $checkUser = mysqli_query($conn, "SELECT Id FROM usuarios WHERE Usuario = '$usuarioEscaped' OR Email = '$emailEscaped'");
    
    if (mysqli_num_rows($checkUser) == 0) {
        $sql = "INSERT INTO usuarios (Nombre, Apellido, Email, Usuario, Clave, IdRol, Foto, Activo)
                VALUES ('{$u['Nombre']}', '{$u['Apellido']}', '{$u['Email']}', '{$u['Usuario']}', '{$u['Clave']}', {$u['IdRol']}, '{$u['Foto']}', {$u['Activo']})";
        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green;'>✓ Usuario <strong>{$u['Usuario']}</strong> insertado correctamente. Clave: <code>clave123</code></p>";
        } else {
            echo "<p style='color:red;'>✗ Error al insertar usuario {$u['Usuario']}: " . mysqli_error($conn) . "</p>";
        }
    } else {
        // Si el usuario ya existe, actualizamos su contraseña y datos semilla para poder loguearnos
        $sql = "UPDATE usuarios 
                SET Nombre = '{$u['Nombre']}', 
                    Apellido = '{$u['Apellido']}', 
                    Clave = '{$u['Clave']}', 
                    IdRol = {$u['IdRol']}, 
                    Foto = '{$u['Foto']}', 
                    Activo = {$u['Activo']}
                WHERE Usuario = '$usuarioEscaped' OR Email = '$emailEscaped'";
        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green;'>✓ Usuario <strong>{$u['Usuario']}</strong> actualizado (Clave configurada a <code>clave123</code>).</p>";
        } else {
            echo "<p style='color:red;'>✗ Error al actualizar usuario {$u['Usuario']}: " . mysqli_error($conn) . "</p>";
        }
    }
}

// 4. Sembrar Empresas
// AVEC (Uruguay=2), Mercado Libre Brasil (Brasil=4), Tersuave (Argentina=1), La Serena (Chile=3)
$empresasSeed = [
    ['Id' => 1, 'Denominacion' => 'Pinturerias Tersuave', 'IdPais' => 1, 'Observaciones' => 'Cliente histórico de pintura', 'FechaCarga' => '2026-05-15', 'IdUsuarioCarga' => 1],
    ['Id' => 2, 'Denominacion' => 'AVEC Automotores', 'IdPais' => 2, 'Observaciones' => 'Concesionario de vehículos en Uruguay', 'FechaCarga' => '2026-05-01', 'IdUsuarioCarga' => 1],
    ['Id' => 3, 'Denominacion' => 'La Serena Automotores', 'IdPais' => 3, 'Observaciones' => 'Distribuidor automotriz chileno', 'FechaCarga' => '2026-05-25', 'IdUsuarioCarga' => 1],
    ['Id' => 4, 'Denominacion' => 'Mercado Libre Brasil', 'IdPais' => 4, 'Observaciones' => 'Plataforma líder de ecommerce en Brasil', 'FechaCarga' => '2026-05-10', 'IdUsuarioCarga' => 1]
];

foreach ($empresasSeed as $emp) {
    $checkEmp = mysqli_query($conn, "SELECT Id FROM empresas WHERE Id = {$emp['Id']}");
    if (mysqli_num_rows($checkEmp) == 0) {
        // Obtenemos un usuario administrador existente
        $adminQuery = mysqli_query($conn, "SELECT Id FROM usuarios WHERE IdRol = 1 LIMIT 1");
        $admin = mysqli_fetch_array($adminQuery);
        $userId = $admin ? $admin['Id'] : 1;

        $sql = "INSERT INTO empresas (Id, Denominacion, IdPais, Observaciones, FechaCarga, IdUsuarioCarga)
                VALUES ({$emp['Id']}, '{$emp['Denominacion']}', {$emp['IdPais']}, '{$emp['Observaciones']}', '{$emp['FechaCarga']}', $userId)";
        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green;'>✓ Empresa <strong>{$emp['Denominacion']}</strong> sembrada correctamente.</p>";
        } else {
            echo "<p style='color:red;'>✗ Error al sembrar empresa {$emp['Denominacion']}: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color:green;'>✓ La empresa <strong>{$emp['Denominacion']}</strong> ya existe.</p>";
    }
}

// 5. Sembrar Proyectos Iniciales (para probar el listado de proyectos)
// 1 = Analisis Iniciado, 2 = En Desarrollo, 3 = Terminado, 4 = Cancelado
$proyectosSeed = [
    [
        'Denominacion' => 'ECommerce Renovación',
        'IdEmpresa' => 2, // AVEC
        'IdLider' => 4, // Rodriguez Anna (will be fetched dynamically below)
        'Observaciones' => 'Reestructuración del portal de ventas',
        'Prioridad' => 1,
        'IdEstado' => 3, // Terminado
        'FechaCarga' => '2026-05-01'
    ],
    [
        'Denominacion' => 'Generación APIs + Documentación',
        'IdEmpresa' => 4, // Mercado Libre Brasil
        'IdLider' => 2, // Gutierrez Marcos
        'Observaciones' => 'Desarrollo de APIs e integración',
        'Prioridad' => 0,
        'IdEstado' => 2, // En Desarrollo
        'FechaCarga' => '2026-05-10'
    ],
    [
        'Denominacion' => 'Adecuaciones en estructuras de Productos',
        'IdEmpresa' => 1, // Tersuave
        'IdLider' => 3, // Jhonson William
        'Observaciones' => 'Cambios en bases de datos de productos',
        'Prioridad' => 1,
        'IdEstado' => 1, // Análisis Iniciado
        'FechaCarga' => '2026-05-15'
    ],
    [
        'Denominacion' => 'Cambios en seguridad al ingreso',
        'IdEmpresa' => 4, // Mercado Libre Brasil
        'IdLider' => 2, // Gutierrez Marcos
        'Observaciones' => 'Ajuste en sistema de login y tokens',
        'Prioridad' => 0,
        'IdEstado' => 1, // Análisis Iniciado
        'FechaCarga' => '2026-05-18'
    ],
    [
        'Denominacion' => 'Gestión de Facturación Web',
        'IdEmpresa' => 3, // La Serena
        'IdLider' => 3, // Jhonson William
        'Observaciones' => 'Integración con pasarela fiscal de Chile',
        'Prioridad' => 1,
        'IdEstado' => 4, // Cancelado
        'FechaCarga' => '2026-05-25'
    ]
];

// Obtener IDs correctos de los líderes
$lideresMap = [];
$res = mysqli_query($conn, "SELECT Id, Usuario FROM usuarios WHERE IdRol = 2");
while ($row = mysqli_fetch_array($res)) {
    $lideresMap[$row['Usuario']] = $row['Id'];
}

// Obtener ID del admin para el campo de carga
$adminQuery = mysqli_query($conn, "SELECT Id FROM usuarios WHERE IdRol = 1 LIMIT 1");
$admin = mysqli_fetch_array($adminQuery);
$adminId = $admin ? $admin['Id'] : 1;

$checkProj = mysqli_query($conn, "SELECT COUNT(*) as total FROM proyectos");
$projCount = mysqli_fetch_array($checkProj)['total'];

if ($projCount == 0) {
    foreach ($proyectosSeed as $p) {
        // Mapear líderes por usuario
        $liderId = 1;
        if ($p['IdLider'] == 2) {
            $liderId = $lideresMap['mgutierrez'] ?? 2;
        } elseif ($p['IdLider'] == 3) {
            $liderId = $lideresMap['wjhonson'] ?? 3;
        } elseif ($p['IdLider'] == 4) {
            $liderId = $lideresMap['arodriguez'] ?? 4;
        }

        $sql = "INSERT INTO proyectos (Denominacion, IdEmpresa, IdLider, Observaciones, Prioridad, IdEstado, FechaCarga, IdUsuarioCarga)
                VALUES ('{$p['Denominacion']}', {$p['IdEmpresa']}, $liderId, '{$p['Observaciones']}', {$p['Prioridad']}, {$p['IdEstado']}, '{$p['FechaCarga']}', $adminId)";
        
        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green;'>✓ Proyecto <strong>{$p['Denominacion']}</strong> creado.</p>";
        } else {
            echo "<p style='color:red;'>✗ Error al insertar proyecto {$p['Denominacion']}: " . mysqli_error($conn) . "</p>";
        }
    }
} else {
    echo "<p style='color:green;'>✓ La tabla proyectos ya tiene registros cargados.</p>";
}

echo "<h3>¡Proceso de sembrado finalizado correctamente!</h3>";
echo "<p>Puedes entrar al <a href='login.php'>Login del Panel</a> con cualquiera de estas credenciales:</p>";
echo "<ul>
    <li><strong>Administrador (¡Tú!):</strong> <code>jlandra</code> / Contraseña: <code>clave123</code></li>
    <li><strong>Administrador:</strong> <code>spalacios</code> / Contraseña: <code>clave123</code></li>
    <li><strong>Líder (Tiene acceso):</strong> <code>mgutierrez</code> / Contraseña: <code>clave123</code></li>
    <li><strong>Líder (Tiene acceso):</strong> <code>wjhonson</code> / Contraseña: <code>clave123</code></li>
    <li><strong>Líder (Tiene acceso):</strong> <code>arodriguez</code> / Contraseña: <code>clave123</code></li>
    <li><strong>Programador (Sin acceso):</strong> <code>mferrero</code> / Contraseña: <code>clave123</code></li>
    <li><strong>Analista Funcional (Sin acceso):</strong> <code>csanabria</code> / Contraseña: <code>clave123</code></li>
</ul>";
?>
