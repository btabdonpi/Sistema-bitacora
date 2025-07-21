<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #fff;
        color: #333;
        margin: 0;
    }

    .container {
        background: linear-gradient(to bottom, #ff4081, #ff8e53);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 300px;
        margin: auto; /* Centra el contenedor */
        margin-top: 50px; /* Ajusta el margen superior según necesites */
    }

    h1 {
        color: #fff;
    }

    nav {
        background-color: #333;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    label {
        color: #fff;
        text-align: left;
    }

    input, select {
        padding: 10px;
        border: none;
        border-radius: 5px;
    }

    button {
        background-color: #ff4081;
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #ff1a65;
    }

</style>
<body>
    <?php require_once 'encabezado.php'; ?>
    
    <div class="container">
        <h1>Insertar Usuario</h1>
        <form>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre">
            
            <label for="ape_paterno">Ape. Paterno</label>
            <input type="text" id="ape_paterno" name="ape_paterno">
            
            <label for="ape_materno">Ape. Materno</label>
            <input type="text" id="ape_materno" name="ape_materno">
            
            <label for="rol">Rol</label>
            
            <button type="submit">Aceptar</button>
        </form>
    </div>

    <?php require_once 'piepagina.php'; ?>
</body>
</html>
