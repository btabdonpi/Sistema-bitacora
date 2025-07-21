<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;900&display=swap">
    <title>Administración</title>
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
            background-color: #f4f4f4;
            color: #2c3e50;
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

        .admin-options {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 50px;
        }

        .admin-option {
            background-color: #273746;
            color: white;
            border: none;
            padding: 20px;
            margin: 10px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
            flex: 1 1 calc(25% - 40px);
            max-width: calc(25% - 40px);
        }

        .admin-option:hover {
            background-color: #34495e;
        }

        .admin-option svg {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div id="nav-bar">
        <div id="nav-header">
            <h1 id="nav-title">Central System's</h1>
        </div>
        <div id="nav-content">
            <a href="index.php" class="nav-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <polyline points="5 12 3 12 12 3 21 12 19 12" />
                    <path d="M5 12v10a1 1 0 0 0 1 1h3a1 1 0 0 0 1 -1v-4a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a1 1 0 0 0 1 -1v-10" />
                </svg>
                <span>Inicio</span>
            </a>
            <!-- Agregar más enlaces aquí -->
        </div>
        <div id="nav-footer">
            <div id="nav-footer-avatar">
                <img src="avatar.jpg" alt="Avatar">
            </div>
            <div>Central System's</div>
        </div>
    </div>
    <div class="content">
        <h1>Administración</h1>
        <div class="admin-options">
            <div class="admin-option" onclick="window.location.href='/sitioweb/bitacora/crearProyectos.php?op=crear_Proyecto'">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-filled" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 2l.117 .007a1 1 0 0 1 .876 .876l.007 .117v4l.005 .15a2 2 0 0 0 1.838 1.844l.157 .006h4l.117 .007a1 1 0 0 1 .876 .876l.007 .117v9a3 3 0 0 1 -2.824 2.995l-.176 .005h-10a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-14a3 3 0 0 1 2.824 -2.995l.176 -.005h5z" stroke-width="0" fill="currentColor" />
                    <path d="M19 7h-4l-.001 -4.001z" stroke-width="0" fill="currentColor" />
                </svg>
                Crear Proyecto
            </div>
            <div class="admin-option" onclick="window.location.href='/sitioweb/bitacora/adminProyectos.php?op=adminProyectos'">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-search" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                    <path d="M18.5 18.5l2.5 2.5" />
                    <path d="M4 6h16" />
                    <path d="M4 12h4" />
                    <path d="M4 18h4" />
                </svg>
                Proyectos
            </div>
            <div class="admin-option" onclick="window.location.href='/sitioweb/bitacora/crearTareas.php?op=crearTarea'">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                </svg>
                Crear Tareas
            </div>
            <div class="admin-option" onclick="window.location.href='/sitioweb/bitacora/adminTareas.php?op=adminTareas'">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M9 6l11 0" />
                    <path d="M9 12l11 0" />
                    <path d="M9 18l11 0" />
                    <path d="M5 6l0 .01" />
                    <path d="M5 12l0 .01" />
                    <path d="M5 18l0 .01" />
                </svg>
                Tareas
            </div>
        </div>
    </div>
</body>
</html>
