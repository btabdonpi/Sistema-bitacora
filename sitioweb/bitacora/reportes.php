<?php
// Verificar sesión de usuario y rol
$usuario = "";
$rol = "";

$filtro = isset($_POST['filtro']) ? $_POST['filtro'] : 'todos';
$valorFiltro = isset($_POST['valorFiltro']) ? $_POST['valorFiltro'] : '';

if (!empty($_SESSION['usuNombre']) && !empty($_SESSION['tipRol'])) {
    $usuario = $_SESSION['usuNombre'];
    $rol = $_SESSION['tipRol'];
}

// Llamada al servicio web para obtener datos
$datos = array();
$cliente = new SoapClient(null, array('uri' => 'http://localhost/', 'location' => 'https://virtualizacione01.000webhostapp.com/bitacora/serviciosweb/servicioweb.php'));
$datosUsu = $cliente->getUsu();
$datosDe = $cliente->getPro();
$datosRol = $cliente->getRol();
$datosProy = $cliente->getProy();
$datosTa = $cliente->getTa();

$datos = $cliente->mostrarbitacora('todos', '');
if (isset($_POST["ver"])) {
    $_SESSION['filtro'] = $filtro;
    $_SESSION['valorFiltro'] = $valorFiltro;

    if (isset($_POST["todos"])) {
        $filtro = 'todos';
        $valorFiltro = '';
    }
    $datos = $cliente->mostrarbitacora($filtro, $valorFiltro);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;900&display=swap">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora de Actividades</title>
    <style>
    
    /* Color de diseño */
        :root {
            --design-color: #2c3e50;
        }
        
        .styled-select {
            position: relative;
            display: inline-block;
            width: 100%;
            margin-bottom: 20px; /* Espaciado entre los elementos */
        }
        
        .styled-select select {
            display: block;
            width: 100%;
            padding: 12px 20px;
            font-size: 16px;
            border: 2px solid var(--design-color);
            border-radius: 8px;
            background-color: #f0f0f0;
            color: #333;
            outline: none;
            transition: border-color 0.3s ease-in-out, background-color 0.3s ease-in-out;
        }
        
        .styled-select select:focus {
            border-color: var(--design-color);
            background-color: #e8e8e8;
        }
        
        .styled-label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            font-weight: 600;
            color: var(--design-color);
            font-family: 'Titillium Web', sans-serif;
        }
        
        .styled-date {
            display: block;
            width: 100%;
            padding: 12px 20px;
            font-size: 16px;
            border: 2px solid var(--design-color);
            border-radius: 8px;
            background-color: #f0f0f0;
            color: #333;
            outline: none;
            transition: border-color 0.3s ease-in-out, background-color 0.3s ease-in-out;
        }
        
        .styled-date:focus {
            border-color: var(--design-color);
            background-color: #e8e8e8;
        }
        
            .radio-button-container {
          display: flex;
          align-items: center;
          gap: 24px;
        }
        
        .radio-button {
          display: inline-block;
          position: relative;
          cursor: pointer;
        }
        
        .radio-button__input {
          position: relative;
          opacity: 0;
          width: 0;
          height: 0;
        }
        
        .radio-button__label {
          display: inline-block;
          padding-left: 30px;
          margin-bottom: 15px;
          position: relative;
          font-size: 15px;
          color: #000000;
          font-weight: 600;
          cursor: pointer;
          text-transform: uppercase;
          transition: all 0.3s ease;
        }
        
        .radio-button__custom {
          position: absolute;
          top: 0;
          left: 0;
          width: 20px;
          height: 20px;
          border-radius: 50%;
          border: 2px solid #555;
          transition: all 0.3s ease;
        }
        
        .radio-button__input:checked + .radio-button__label .radio-button__custom {
          background-color: #4c8bf5;
          border-color: transparent;
          transform: scale(0.8);
          box-shadow: 0 0 20px #4c8bf580;
        }
        
        .radio-button__input:checked + .radio-button__label {
          color: #4c8bf5;
        }
        
        .radio-button__label:hover .radio-button__custom {
          transform: scale(1.2);
          border-color: #4c8bf5;
          box-shadow: 0 0 20px #4c8bf580;
        }
        
        body {
            font-family: 'Titillium Web', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
    font-family: 'Titillium Web', sans-serif;
    max-width: 1200px;
    margin: 0;
    background-color: #fff;
    padding: 0px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    position: absolute;
    right: 0;
}

       
        .header {
            background-color: var(--design-color);
            color: white;
            font-family: 'Titillium Web', sans-serif;
            text-align: center;
            padding: auto;
            border-radius: 5px;
            width: 100%;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: auto;
            color: white;
        }
        .content {
            margin-bottom: 20px;
            width: 100%;
        }
        .form-container {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .form {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        .form label {
            margin-bottom: 10px;
        }
        table {
            width: 90%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            font-weight:500;
             text-align: center;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #34495e;
            color: white;
        }
        .export-buttons {
            margin-bottom: 20px;
            text-align: center;
        }
        .export-buttons button {
            margin-right: 10px;
            padding: 10px 20px;
            background-color: #34495e;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .export-buttons button:hover {
            background-color: #2c3e50;
        }
        .footer {
            text-align: center;
            padding: 10px 0;
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="header">
            <h1>Central System´s</h1>
            <h1>Bitácora de Actividades</h1>
            <p>Bienvenido <?php echo $usuario; ?> - <?php echo $rol; ?></p>
        </div>
        <div class="radio-button-container">
    <form id="filtroForm" method="post" class="form">
        <div class="filter-container">
            <div class="radio-button">
                <input type="radio" class="radio-button__input" id="personal" name="filtro" value="personal" <?php echo $filtro == 'personal' ? 'checked' : ''; ?>>
                <label class="radio-button__label" for="personal">
                    <span class="radio-button__custom"></span>
                    Usuario
                </label>
            </div>
            <div class="radio-button">
                <input type="radio" class="radio-button__input" id="rol" name="filtro" value="rol" <?php echo $filtro == 'rol' ? 'checked' : ''; ?>>
                <label class="radio-button__label" for="rol">
                    <span class="radio-button__custom"></span>
                    Rol
                </label>
            </div>
            <div class="radio-button">
                <input type="radio" class="radio-button__input" id="actividad" name="filtro" value="actividad" <?php echo $filtro == 'actividad' ? 'checked' : ''; ?>>
                <label class="radio-button__label" for="actividad">
                    <span class="radio-button__custom"></span>
                    Proceso
                </label>
            </div>
            <div class="radio-button">
                <input type="radio" class="radio-button__input" id="fecha" name="filtro" value="fecha" <?php echo $filtro == 'fecha' ? 'checked' : ''; ?>>
                <label class="radio-button__label" for="fecha">
                    <span class="radio-button__custom"></span>
                    Fecha
                </label>
            </div>
            <div class="radio-button">
                <input type="radio" class="radio-button__input" id="tarea" name="filtro" value="tarea" <?php echo $filtro == 'tarea' ? 'checked' : ''; ?>>
                <label class="radio-button__label" for="tarea">
                    <span class="radio-button__custom"></span>
                    Tarea
                </label>
            </div>
            <div class="radio-button">
                <input type="radio" class="radio-button__input" id="proyecto" name="filtro" value="proyecto" <?php echo $filtro == 'proyecto' ? 'checked' : ''; ?>>
                <label class="radio-button__label" for="proyecto">
                    <span class="radio-button__custom"></span>
                    Proyecto
                </label>
            </div>
            <div class="radio-button">
                <input type="radio" class="radio-button__input" id="todos" name="filtro" value="todos" <?php echo $filtro == 'todos' ? 'checked' : ''; ?>>
                <label class="radio-button__label" for="todos">
                    <span class="radio-button__custom"></span>
                    Todas
                </label>
            </div>
            
        </div>
        <div class="export-buttons">
        <button type="submit" name="usar" class="simple-button">Usar</button>
        </div>
        
            <?php
// Establece el color de diseño
$designColor = '#2c3e50';
?>

<?php 
if (isset($_POST['usar'])) {
    if ($filtro == 'personal') { ?>
        <div id="valorFiltroDiv" class="styled-select">
            <label for="valorFiltro" class="styled-label">Seleccione Usuario:</label>
            <select name="valorFiltro" id="valorFiltro" class="styled-select">
                <?php
                for ($rr = 0; $rr < count($datosUsu); $rr++) {
                    echo '<option value="'.$datosUsu[$rr]["ID"].'">'.$datosUsu[$rr]["Nombre"].'</option>';
                }
                ?>
            </select>
        </div>
    <?php } elseif ($filtro == 'rol') { ?>
        <div id="valorFiltroDiv" class="styled-select">
            <label for="valorFiltro" class="styled-label">Seleccione el Rol:</label>
            <select name="valorFiltro" id="valorFiltro" class="styled-select">
                <?php
                for ($rr = 0; $rr < count($datosRol); $rr++) {
                    echo '<option value="'.$datosRol[$rr]["ID"].'">'.$datosRol[$rr]["Nombre"].'</option>';
                }
                ?>
            </select>
        </div>
    <?php } elseif ($filtro == 'proyecto') { ?>
        <div id="valorFiltroDiv" class="styled-select">
            <label for="valorFiltro" class="styled-label">Seleccione el Proyecto:</label>
            <select name="valorFiltro" id="valorFiltro" class="styled-select">
                <?php
                for ($rr = 0; $rr < count($datosProy); $rr++) {
                    echo '<option value="'.$datosProy[$rr]["ID"].'">'.$datosProy[$rr]["De"].'</option>';
                }
                ?>
            </select>
        </div>
    <?php } elseif ($filtro == 'tarea') { ?>
        <div id="valorFiltroDiv" class="styled-select">
            <label for="valorFiltro" class="styled-label">Seleccione la Tarea:</label>
            <select name="valorFiltro" id="valorFiltro" class="styled-select">
                <?php
                for ($rr = 0; $rr < count($datosTa); $rr++) {
                    echo '<option value="'.$datosTa[$rr]["ID"].'">'.$datosTa[$rr]["De"].'</option>';
                }
                ?>
            </select>
        </div>
    <?php } elseif ($filtro == 'actividad') { ?>
        <div id="valorFiltroDiv" class="styled-select">
            <label for="valorFiltro" class="styled-label">Seleccione Proceso:</label>
            <select name="valorFiltro" id="valorFiltro2" class="styled-select">
                <?php
                for ($rr = 0; $rr < count($datosDe); $rr++) {
                    echo '<option value="'.$datosDe[$rr]["ID"].'">'.$datosDe[$rr]["De"].'</option>';
                }
                ?>
            </select>
        </div>
    <?php } elseif ($filtro == 'fecha') { ?>
        <div id="fechaFiltroDiv">
            <label for="fechaFiltro" class="styled-label">Fecha:</label>
            <input type="date" name="valorFiltro" id="valorFiltro" class="styled-date" value="<?php echo $valorFiltro; ?>">
        </div>
    <?php }
}
?>
        <div class="export-buttons">
            <button type="submit" class="simple-button" name="ver">Ver</button>
        </div>
    </form>
</div>

        <div class="content">
            
            <?php if (empty($datos[0]["bID"]) || $datos[0]["bID"] == 0): ?>
                <h2>No hay datos disponibles o seleccionados.</h2>
            <?php else: ?>
            <div class="export-buttons">
                <button onclick="window.location.href='/sitioweb/bitacora/exportarPDF.php'">Exportar PDF</button>
            </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Personal</th>
                            <th>Nombre del Rol</th>
                            <th>Fecha</th>
                            <th>Tarea Asignada</th>
                            <th>Proyecto Asignado</th>
                            <th>Actividad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datos as $dato): ?>
                            <tr>
                                <td><?php echo $dato["bID"]; ?></td>
                                <td><?php echo $dato["personal"]; ?></td>
                                <td><?php echo $dato["rol"]; ?></td>
                                <td><?php echo $dato["fecha"]; ?></td>
                                <td><?php echo $dato["tarea"]; ?></td>
                                <td><?php echo $dato["proyecto"]; ?></td>
                                <td><?php echo $dato["actividad"]; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer">
        CENTRAL SYSTEMS
    </div>
</body>
</html>
