<?php
session_start();
$usuario = "";
$rol = "";
$PersonalID = "";

if (!empty($_SESSION['usuNombre']) && !empty($_SESSION['tipRol'])) {
    $usuario = $_SESSION['usuNombre'];
    $rol = $_SESSION['tipRol'];
    $PersonalID = $_SESSION['usuCve'];
}

// Datos simulados
$datos = array(
    array("nombre" => "Tarea 1", "personal" => "Yair Ortega García", "recursos" => "Recurso 1", "fase" => "Fase 1"),
    array("nombre" => "Tarea 2", "personal" => "Brandon Rubin Mora Hernandez", "recursos" => "Recurso 2", "fase" => "Fase 2"),
    array("nombre" => "Tarea 3", "personal" => "Karla Marian Perez Baños", "recursos" => "Recurso 1", "fase" => "Fase 1"),
    array("nombre" => "Tarea 4", "personal" => "Yair Ortega García", "recursos" => "Recurso 2", "fase" => "Fase 2"),
);

require_once 'encabezado.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Titillium Web', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: #fff;
        }

        .edit-btn {
            background-color: #4CAF50;
        }

        .delete-btn {
            background-color: #f44336;
        }

        .complete-btn {
            background-color: #ff6347;
        }

        .action-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Tareas</h1>
        <table>
            <thead>
                <tr>
                    <th>Nombre de la Tarea</th>
                    <th>Personal Asignado</th>
                    <th>Recursos</th>
                    <th>Fase</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($datos as $tarea) {
                    echo '<tr>';
                    echo '<td>' . $tarea["nombre"] . '</td>';
                    echo '<td>' . $tarea["personal"] . '</td>';
                    echo '<td>' . $tarea["recursos"] . '</td>';
                    echo '<td>' . $tarea["fase"] . '</td>';
                    echo '<td>';
                    echo '<button class="action-btn complete-btn">Completar</button> ';
                    echo '<button class="action-btn edit-btn">Editar</button> ';
                    echo '<button class="action-btn delete-btn">Borrar</button>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php require_once 'piepagina.php'; ?>
</body>
</html>
