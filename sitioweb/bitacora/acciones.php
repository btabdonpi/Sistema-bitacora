<?php

$usuario = "";
$rol = "";

if (!empty($_SESSION['usuNombre']) && !empty($_SESSION['tipRol'])) {
    $usuario = $_SESSION['usuNombre'];
    $rol = $_SESSION['tipRol'];
}

$datos = array();
try {
    $cliente = new SoapClient(null, array('uri' => 'http://localhost/', 'location' => 'https://virtualizacione01.000webhostapp.com/bitacora/serviciosweb/servicioweb.php'));
    $datos = $cliente->ListarPersonal();
} catch (Exception $e) {
    echo 'Error al conectar con el servicio web: ',  $e->getMessage(), "\n";
}

$actions = [
    'godot' => 1,
    'pygame' => 2,
    'vs' => 3,
    'sub' => 4,
    'net' => 5,
    'sql' => 6,
    'adobe' => 7,
    'adob' => 8,
    'cproy' => 9,
    'mproy' => 10,
    'bproy' => 11,
    'ctarea' => 12,
    'mtarea' => 13,
    'btarea' => 14,
    'recurso' => 15,
    'person' => 16,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($actions as $key => $value) {
        if (isset($_POST[$key])) {
            $PersonalID = $_POST['PersonalID'];
            $cliente->AccionesPersonal($value, $PersonalID);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;900&display=swap">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acciones de Personal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos Globales */
        body {
            font-family: 'Titillium Web', sans-serif;
            background-color: #ecf0f1;
            color: #333;
            margin: 0;
            padding: 0;
            margin-left: 250px;
        }
        
        header {
            background-color: #2c3e50;
            color: white;
            padding: auto;
            text-align: center;
        }
        
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        table th {
            background-color: #34495e;
            color: white;
            font-weight:500;
             text-align: center;
        }
        
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        table tr:hover {
            background-color: #f1c40f;
            color: white;
        }
        
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        button:disabled {
            background-color: #95a5a6;
            cursor: not-allowed;
        }
        
        .actions-cell {
            text-align: center;
        }
        
        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Central System´s</h1>
        <h1>Simulador de Acciones de Personal</h1>
        <p>Usuario: <?php echo htmlspecialchars($usuario); ?> | Rol: <?php echo htmlspecialchars($rol); ?></p>
    </header>
    <table>
        <thead>
            <tr>
                <th>Clave</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Selección de Procesos Simulados</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($datos) {
                foreach ($datos as $persona) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($persona["PersonalID"]) . '</td>';
                    echo '<td>' . htmlspecialchars($persona["Nombre"]) . '</td>';
                    echo '<td>' . htmlspecialchars($persona["Rol"]) . '</td>';
                    echo '<td class="actions-cell">';
                    echo '<form method="post">';
                    echo '<input type="hidden" name="PersonalID" value="' . htmlspecialchars($persona["PersonalID"]) . '">';
                    echo '<div class="button-container">';
                    echo '<button type="submit" name="godot">Godot</button>';
                    echo '<button type="submit" name="pygame">Python Pygame</button>';
                    echo '<button type="submit" name="vs">VS Code</button>';
                    echo '<button type="submit" name="sub">Sublime Text</button>';
                    echo '<button type="submit" name="net">VS .Net</button>';
                    echo '<button type="submit" name="sql">Mysql Server</button>';
                    echo '<button type="submit" name="adobe">Adobe Premiere</button>';
                    echo '<button type="submit" name="adob">Adobe Animate</button>';
                    if ($persona["PersonalID"] == 1 || $persona["PersonalID"] == 9) {
                        echo '<button type="submit" name="cproy">Creación de Proyecto</button>';
                        echo '<button type="submit" name="mproy">Modificación De Proyecto</button>';
                        echo '<button type="submit" name="bproy">Borrado de Proyecto</button>';
                        echo '<button type="submit" name="ctarea">Creación de Tarea</button>';
                        echo '<button type="submit" name="mtarea">Modificación de Tarea</button>';
                        echo '<button type="submit" name="btarea">Borrado de Tarea</button>';
                        echo '<button type="submit" name="recurso">Asignación de Recursos</button>';
                    }
                    echo '</div>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
    <footer>
        <p>&copy; 2024 Central System's S.A. de C.V. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
