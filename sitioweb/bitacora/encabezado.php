<?php
$usuario = "";
$rol = "";
if (!empty($_SESSION['usuNombre']) && !empty($_SESSION['tipRol'])) {
    $usuario = $_SESSION['usuNombre'];
    $rol = $_SESSION['tipRol'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora de Transacciones</title>
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
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
            font-family: 'Staatliches', sans-serif;
            background: var(--background);
        }

        #nav-bar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            background: var(--navbar-dark-primary);
            width: var(--navbar-width);
            display: flex;
            flex-direction: column;
            color: var(--navbar-light-primary);
            overflow: hidden;
            z-index: 10;
        }

        #nav-header {
            width: 100%;
            min-height: 80px;
            background: var(--navbar-dark-primary);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            box-sizing: border-box;
        }

        #nav-title {
            font-size: 1.5rem;
            margin: 0;
        }

        label[for="nav-toggle"] {
            cursor: pointer;
        }

        #nav-content {
            flex: 1;
            padding: 1rem;
            box-sizing: border-box;
            background: var(--navbar-dark-primary);
            color: var(--navbar-light-primary);
        }

        .nav-button {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            color: var(--navbar-light-primary);
            text-decoration: none;
            transition: background 0.3s, color 0.3s;
        }

        .nav-button:hover {
            background: var(--navbar-dark-secondary);
        }

        .nav-button span {
            margin-left: 1rem;
        }

        #nav-footer {
            background: var(--navbar-dark-secondary);
            padding: 1rem;
            text-align: center;
        }

        #nav-footer-avatar img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }

        .content {
            margin-left: var(--navbar-width);
            padding: 2rem;
        }

        @media (max-width: 768px) {
            #nav-bar {
                width: var(--navbar-width-min);
            }

            .content {
                margin-left: var(--navbar-width-min);
            }
        }
    </style>
</head>
<body>
    <div id="nav-bar">
        <header id="nav-header">
            <h1 id="nav-title">Central System's</h1>
            <label for="nav-toggle">
                <div id="nav-toggle-burger"></div>
            </label>
            <hr>
        </header>
        <div id="nav-content">
            <div id="nav-content-highlight"></div>
 
            <a href="/sitioweb/index.php?op=acciones" class="nav-button"><i class="fas fa-cogs"></i><span>Simulador de Acciones </span></a>
            <a href="/sitioweb/index.php?op=reportes" class="nav-button"><i class="fas fa-chart-bar"></i><span>Reportes</span></a>
            <a href="/sitioweb/index.php?op=bitacoraprueba" class="nav-button"><i class="fas fa-book"></i><span>Bitácora</span></a>
            <a href="/sitioweb/index.php?op=proyectosexcel" class="nav-button"><i class="fas fa-project-diagram"></i><span>Proyectos</span></a>
            <a href="/sitioweb/inicio.php" class="nav-button"><i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span></a>
        </div>
    </div>
    <header class="showcase">
    </header>
</body>
</html>
