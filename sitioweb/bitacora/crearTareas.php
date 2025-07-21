<?php
    session_start();
    $datos=array();
    if(!empty($_SESSION['usuNombre']) && !empty($_SESSION['tipRol']))
    {
        $usuario=$_SESSION['usuNombre'];
        $rol=$_SESSION['tipRol'];
        $id=$_SESSION['usuCve'];
    }
    
    $cliente=new SoapClient(null, array('uri'=>'http://localhost/','location'=>'https://virtualizacione01.000webhostapp.com/bitacora/serviciosweb/servicioweb.php'));
    //$cliente->CrearProyecto($nombre,$descripcion,$tipo,$Fechain,$Fechaf,1,$id);
require_once 'encabezado.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Crear Tarea</title>
</head>
<style>
   body {
    font-family: 'Titillium Web', sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
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

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

label {
    flex: 1;
    color: #333;
}

input[type="text"], select {
    flex: 2;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

button {
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 25px;
    color: #fff; /* Color del texto */
    font-size: 16px;
    cursor: pointer;
}

.create-btn {
    background-color: #ff6347; /* Color de fondo del botón */
}

.create-btn:hover {
    background-color: #e65032;
}

</style>
<body>
    <div class="container">
        <h1>Crear Tarea</h1>
        <form method="POST" action="procesarTarea.php">
            <div class="form-group">
                <label for="taskName">Nombre de la Tarea</label>
                <input type="text" id="taskName" name="taskName" placeholder="Nombre de la tarea" required>
            </div>
            <div class="form-group">
                <label for="personnel">Asignar Personal</label>
                <select id="personnel" name="personnel" required>
                    <option value="" disabled selected>Selecciona personal</option>
                    <option value="personal1">Yair Ortega García</option>
                    <option value="personal2">Brandon Rubin Mora Hernandez</option>
                    <option value="personal3">Karla Marian Perez Baños</option>
                    <!-- personal -->
                </select>
            </div>
            <div class="form-group">
                <label for="resources">Asignar Recursos</label>
                <select id="resources" name="resources" required>
                    <option value="" disabled selected>Selecciona los recursos</option>
                    <option value="recurso1">Recurso 1</option>
                    <option value="recurso2">Recurso 2</option>
                    <!-- recursos-->
                </select>
            </div>
            <div class="form-group">
                <label for="phase">Asignar Fase</label>
                <select id="phase" name="phase" required>
                    <option value="" disabled selected>Selecciona fase</option>
                    <option value="fase1">Fase 1</option>
                    <option value="fase2">Fase 2</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="create-btn">Crear Tarea</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php require_once 'piepagina.php'; ?>
