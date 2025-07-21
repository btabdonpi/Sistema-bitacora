<?php
session_start();
$nombre = "";
$descripcion = "";
$tipo = "";
$Fechain = "";
$Fechaf = "";
$datos = array();
$registrar;

if (!empty($_SESSION['usuNombre']) && !empty($_SESSION['tipRol'])) {
    $usuario = $_SESSION['usuNombre'];
    $rol = $_SESSION['tipRol'];
    $id = $_SESSION['usuCve'];
}

$cliente = new SoapClient(null, array('uri' => 'http://localhost/', 'location' => 'https://virtualizacione01.000webhostapp.com/bitacora/serviciosweb/servicioweb.php'));

if (isset($_POST['btnRegistrar'])) {
    if (!empty($_REQUEST['nombre_proyecto']) && !empty($_REQUEST['descripcion']) && !empty($_REQUEST['fecha_inicio']) && !empty($_REQUEST['fecha_final']) && !empty($_REQUEST['tipo_proyecto'])) {
        // Obtiene los valores
        $nombre = htmlspecialchars($_REQUEST['nombre_proyecto']);
        $descripcion = htmlspecialchars($_REQUEST['descripcion']);
        $Fechain = htmlspecialchars($_REQUEST['fecha_inicio']);
        $Fechaf = htmlspecialchars($_REQUEST['fecha_final']);
        $tipo = htmlspecialchars($_REQUEST['tipo_proyecto']);

        // Validar que todos los controles tengan datos
        $cliente->CrearProyecto($nombre, $descripcion, $tipo, $Fechain, $Fechaf, $id);

        // Limpia los campos después del registro
        $tipo = "";
        $nombre = "";
        $ap = "";
        $am = "";
        $usu = "";
        $contra = "";

        echo "<script>alert('Proyecto Registrado Correctamente');</script>";
    } else {
        echo "<script>alert('Los datos marcados con * son OBLIGATORIOS, no puedes dejar espacios vacíos');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Proyecto</title>    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;900&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Titillium Web', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
        }
        .header {
            text-align: center;
            background-color: #ff6347;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .form-group {
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
        }
        .form-group label {
            flex: 1;
            padding: 10px;
            text-transform: uppercase;
            font-size: 12px;
            color: #777;
        }
        .form-group input {
            flex: 3;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            background-color: #f7f7f7;
            font-size: 14px;
        }
        .form-group input[type="date"] {
            flex: 2;
        }
        .form-group input[type="submit"] {
            background-color: #ff6347;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #e65032;
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/encabezado.php'; ?>
    <div class="container">
        <div class="header">
            <h1>Crear Proyecto</h1>
        </div>
        <form action="#" method="post">
            <div class="form-group">
                <label for="nombre_proyecto">Nombre del Proyecto</label>
                <input type="text" id="nombre_proyecto" name="nombre_proyecto">
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion">
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio">
            </div>
            <div class="form-group">
                <label for="fecha_final">Fecha Final</label>
                <input type="date" id="fecha_final" name="fecha_final">
            </div>
            <div class="form-group">
                <label for="tipo_proyecto">Tipo de Proyecto</label>
                <input type="text" id="tipo_proyecto" name="tipo_proyecto">
            </div>
            <div class="form-group">
                <input type="submit" value="Ingresar" id="btnRegistrar" name="btnRegistrar">
            </div>
        </form>
    </div>
    <?php require_once __DIR__ . '/piepagina.php'; ?>
</body>
</html>
