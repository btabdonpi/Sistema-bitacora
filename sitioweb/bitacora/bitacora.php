<?php
$usuario;
$proceso;
$datos;
$fecha;
$ban=0;
$lectura=0;
//se requiere
require_once('excel/php-excel-reader/excel_reader2.php');
require_once('excel/SpreadsheetReader.php');

$datos=array();
//se ejecuta el servicio web
$cliente=new SoapClient(null, array('uri'=>'http://localhost/','location'=> 'https://virtualizacione01.000webhostapp.com/bitacora/serviciosweb/servicioweb.php'));

if (isset($_POST["btnLeer"])){
    $tipoArchivos = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    
    if(in_array($_FILES["file"]["type"],$tipoArchivos)){
        $rutaArchivo = 'bitacora/archivos/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $rutaArchivo);
        
        $leerArchivo = new SpreadsheetReader($rutaArchivo);
        
        $numHojas = count($leerArchivo->sheets());
        $lectura = 1;
        
    } else {
        $type = "error";
        $message = "El archivo enviado es inválido. Por favor vuelva a intentarlo";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora de Transacciones</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">
    <style>
        :root {
            --background: #9c88ff;
            --navbar-width: 256px;
            --navbar-width-min: 80px;
            --navbar-dark-primary: #18283b;
            --navbar-dark-secondary: #2c3e50;
            --navbar-light-primary: #f5f6fa;
            --navbar-light-secondary: #8392a5;
        }

        body {
            margin: 0;
            font-family: 'Titillium Web', sans-serif;
            background: var(--background);
        }

        .container {
            margin-left: var(--navbar-width);
            padding: 2rem;
            background: var(--navbar-light-primary);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-dark {
            background-color: var(--navbar-dark-primary);
            color: var(--navbar-light-primary);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-dark:hover {
            background-color: var(--navbar-dark-secondary);
        }

        .form-check-label {
            color: var(--navbar-dark-primary);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        table, th, td {
            border: 1px solid var(--navbar-dark-secondary);
        }

        th, td {
            padding: 0.5rem;
            text-align: left;
        }

        .bg-dark {
            background-color: var(--navbar-dark-primary);
            color: var(--navbar-light-primary);
        }

        .text-dark {
            color: var(--navbar-dark-primary);
        }
    </style>
</head>
<body>
    <form id="frmExcel" name="frmExcel" method="POST" enctype="multipart/form-data">
        <main class="container col-10 mb-5 border rounded shadow p-3">
            <div class="justify-content-center rounded mb-3 p-2 align-text-center">
                <h4 class="form-check-label mb-3"><b>Cargado de Bitácora (lectura de datos de Excel)</b></h4>
            </div>
            <div class="switch-holder col-8 justify-content-center btn">
                <input type="file" name="file" id="file" accept=".xls,.xlsx" />
                <input type="submit" name="btnLeer" id="btnLeer" value="Leer datos archivo" class="btn-dark" />
            </div>  
            <?php
            if ($lectura == 1) {
                echo '<table class="table">';
                echo '<tr><td colspan="4" class="text-center text-dark"><h4 class="form-check-label mb-3"><b>Registros leídos y registrados en la Base de Datos</b></h4></td></tr>';
                echo '<tr class="bg-dark text-center">';
                echo '<td class="header-clave"><b>Clave usuario</b></td>';
                echo '<td class="header-proceso"><b>Proceso</b></td>';
                echo '<td class="header-datos"><b>Datos</b></td>';
                echo '<td class="header-fecha"><b>Fecha transacción</b></td>';
                echo '</tr>';
                for ($i = 0; $i < $numHojas; $i++) {
                    $leerArchivo->ChangeSheet($i);
                    foreach ($leerArchivo as $renglon) {
                        if (!empty($renglon[0]) && !empty($renglon[1]) && !empty($renglon[2]) && !empty($renglon[3])) {
                            echo '<tr>';
                            echo '<td>'.$renglon[0].'</td>';
                            echo '<td>'.$renglon[1].'</td>';
                            echo '<td>'.$renglon[2].'</td>';
                            echo '<td>'.$renglon[3].'</td>';
                            echo '</tr>';
                        }
                    }
                }
                echo '</table>';
            } 
            ?>
        </main>
    </form>
</body>
</html>
