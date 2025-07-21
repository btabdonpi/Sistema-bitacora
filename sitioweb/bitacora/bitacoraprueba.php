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
$renglon=array();
$datos = array();
//se ejecuta el servicio web

$cliente=new SoapClient(null, array('uri'=>'http://localhost/','location'=> 'https://virtualizacione01.000webhostapp.com/bitacora/serviciosweb/servicioweb.php'));

if (isset($_POST["btnLeer"])) {
    $tipoArchivos = ['application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

    if (in_array($_FILES["file"]["type"], $tipoArchivos)) {
        $rutaArchivo = 'bitacora/archivos/' . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $rutaArchivo);

        $leerArchivo = new SpreadsheetReader($rutaArchivo);

        $numHojas = count($leerArchivo->sheets());
        $lectura = 1;
    } else {
        $type = "error";
        $message = "El archivo enviado es invalido. Por favor vuelva a intentarlo";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora</title>
    <style>
        body {
          margin: 0;
          padding: 0;
          font-family: 'Titillium Web', sans-serif;
        }
        /* Barra Lateral */
        .sidebar {
            width: 250px; /* Ajusta el ancho según sea necesario */
            background-color: #2c3e50;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            padding: 20px;
            overflow-y: auto;
        }
        
        /* Contenido Principal */
        .main-content {
            font-family: 'Titillium Web', sans-serif;
            color:black;
            margin-left: 250px; /* Deja espacio para la barra lateral */
            padding: 20px;
        }
        
        /* Estilo para el Formulario de Cargado de Bitácora */
        #frmExcel {
            margin-bottom: 20px;
        }
        
        .switch-holder {
            margin: 20px 0;
            padding: 20px;
            background-color: #ecf0f1;
            border-radius: 5px;
            text-align: center;
        }
        
        .switch-holder h4 {
            margin-bottom: 20px;
        }
        
        .btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        
        .btn:hover {
            background-color: #2980b9;
        }
        
        /* Estilo para las Tablas */
        .table {
            width: 90%;
            border-collapse: collapse;
            margin: auto;
        }
        
        .table, th, td {
            border: 1px solid #ddd;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
        }
        
        thead {
            background-color: #34495e;
            color: white;
        }
        
        tbody tr {
            text-align: center;
        }
        
        /* Estilo para los mensajes */
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .message.error {
            background-color: #e74c3c;
            color: white;
        }
        
        .message.success {
            background-color: #2ecc71;
            color: white;
        }

    </style>
</head>

<body>
    <div class="sidebar">
        <header>
            <h1>Bitácora</h1>
        </header>
        <!-- Aquí puedes agregar enlaces de navegación o más contenido para la barra lateral -->
    </div>
    <div class="main-content">
        <form id="frmExcel" name="frmExcel" method="POST" enctype="multipart/form-data">
            <div class="switch-holder">
                <h4><b>Cargado de Bitácora (lectura de datos de Excel)</b></h4>
                <input type="file" name="file" id="file" accept=".xls,.xlsx" />
                <input type="submit" name="btnLeer" id="btnLeer" value="Leer datos archivo" class="btn" />
            </div>
            <?php if (isset($type) && $type == "error"): ?>
                <div class="message error"><?php echo $message; ?></div>
            <?php endif; ?>
            <?php if ($lectura == 1) : ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Clave usuario</th>
                                <th>Fecha transacción</th>
                                <th>Tarea</th>
                                <th>Proyecto</th>
                                <th>Actividad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < $numHojas; $i++) {
                                $leerArchivo->ChangeSheet($i);
                                foreach ($leerArchivo as $renglon) {
                                    if (!empty($renglon[0]) && !empty($renglon[1]) && !empty($renglon[2]) && !empty($renglon[3]) && !empty($renglon[4])) {
                                        $datos = $cliente->registrarBitacora($renglon[0], $renglon[1], $renglon[2], $renglon[3], ($renglon[4]));
                                        if ((int)$datos[0]["REGISTRADO"] == 0 || (int)$datos[0]["REGISTRADO"] == 1) {
                                            echo '<tr style="background-color:#e74c3c;">';
                                        } else {
                                            echo '<tr style="background-color:#2ecc71;">';
                                        }
                                        echo '<td>' . htmlspecialchars($renglon[0]) . '</td>';
                                        echo '<td>' . htmlspecialchars($renglon[1]) . '</td>';
                                        echo '<td>' . htmlspecialchars($renglon[2]) . '</td>';
                                        echo '<td>' . htmlspecialchars($renglon[3]) . '</td>';
                                        echo '<td>' . htmlspecialchars($renglon[4]) . '</td>';
                                        echo '</tr>';
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>

</html>
