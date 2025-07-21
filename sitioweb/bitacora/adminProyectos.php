<?php
session_start();
$usuario = "";
$rol = "";
$PersonalID="";

if (!empty($_SESSION['usuNombre']) && !empty($_SESSION['tipRol'])) {
    $usuario = $_SESSION['usuNombre'];
    $rol = $_SESSION['tipRol'];
    $PersonalID = $_SESSION['usuCve'];
}

$datos = array();
$cliente = new SoapClient(null, array('uri' => 'http://localhost/', 'location' => 'https://virtualizacione01.000webhostapp.com/bitacora/serviciosweb/servicioweb.php'));
$datos = $cliente->listaProyectos();

if (isset($_POST['Borrar'])){
    $idProy = $_POST['id'];
    $cliente = new SoapClient(null, array('uri' => 'http://localhost/', 'location' => 'https://virtualizacione01.000webhostapp.com/bitacora/serviciosweb/servicioweb.php'));
    $cliente->BorrarProyecto($idProy, $PersonalID); 
    echo "<script>alert('Proyecto Borrado Correctamente'); window.location.href=window.location.href;</script>";
} 
if (isset($_POST['Completar'])){
    $idProy = $_POST['id'];
    $cliente = new SoapClient(null, array('uri' => 'http://localhost/', 'location' => 'https://virtualizacione01.000webhostapp.com/bitacora/serviciosweb/servicioweb.php'));
    $cliente->EstatusProyecto($idProy, $PersonalID); 
    echo "<script>alert('Proyecto Actualizado Correctamente'); window.location.href=window.location.href;</script>";
} 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Proyectos</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Titillium Web', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff; /* Cambio de color de fondo */
        }
        
        nav {
            background-color: #444;
            padding: 10px 0;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: #555;
        }

        .main-content {
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px; /* Espacio entre el header y el contenido */
        }

        .container {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            background-color: #ffa07a;
        }

        h1 {
            color: #fff; /* Color de texto oscuro */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #333; /* Borde oscuro */
            color: #333; /* Color de texto oscuro */
            background-color: #fff;
        }

        th {
            background-color: #fff ; /* Fondo oscuro para encabezados */
            color: black; /* Texto blanco para encabezados */
        }

        button {
            background-color: #ff6347;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s; /* Transición suave para el cambio de color al pasar el cursor */
        }

        button:hover {
            background-color: #e65032; /* Cambio de color al pasar el cursor */
        }
    </style>
</head>
<body>
    <?php require_once 'encabezado.php'; ?>
    <div class="main-content">
        <div class="container">
            <h1>Administración de proyectos</h1>
            <table>
                <thead>
                    <tr>
                        <th>Lista de proyectos</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de Fin</th>
                        <th>Estatus</th>
                        <th>Completado</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                for ($rr = 0; $rr < count($datos); $rr++) {
                    echo '<tr align="center">';
                    echo '<td>' . $datos[$rr]["Nombre"] . '</td>';
                    echo '<td>' . $datos[$rr]["I"] . '</td>';
                    echo '<td>' . $datos[$rr]["F"] . '</td>';
                    echo '<td>' . $datos[$rr]["Estatus"] . '</td>';
                    
                    echo '<td>';
                    if($datos[$rr]["Estatus"]=='Activo'){
                        echo '<form method="post" action="adminProyectos.php">';
                        echo '<input type="hidden" id="id" name="id" value="' . $datos[$rr]["id"] . '">';
                        echo '<button type="submit" id="Completar" name="Completar">Completar</button>';
                        echo '</form>';
                    } else {
                        echo "";
                    }
                    echo '</td>';

                    echo '<td>';
                    echo '<form method="post" action="adminProyectos.php">';
                    echo '<input type="hidden" id="id" name="id" value="' . $datos[$rr]["id"] . '">';
                    echo '<button type="submit" id="Borrar" name="Borrar">Borrar</button>';
                    echo '</form>';
                    echo '</td>';

                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php require_once 'piepagina.php'; ?>
</body>
</html>
