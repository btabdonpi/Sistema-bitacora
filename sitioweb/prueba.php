<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Ejemplo</title>
    <style>
        body {
            background-color: #f5f5f5; /* Fondo gris claro */
            color: #000000; /* Texto en negro */
        }
        header, footer {
            background-color: #2c3e50; /* Azul oscuro para encabezado y pie de página */
            color: #ffffff; /* Texto en blanco */
            padding: 10px;
            text-align: center;
        }
        .content {
            padding: 20px;
            background: linear-gradient(to bottom, #ff7e5f, #feb47b); /* Degradado más suave */
            color: #ffffff; /* Texto en blanco */
            margin: 20px;
            border-radius: 10px;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff; /* Fondo blanco para la tabla */
            color: #000000; /* Texto en negro */
        }
        .content th, .content td {
            padding: 10px;
            border: 1px solid #ddd; /* Borde ligero */
        }
        .content th {
            background-color: #ff6347; /* Fondo tomato para los encabezados de la tabla */
            color: #ffffff; /* Texto en blanco */
        }
        .content td {
            background-color: #f9f9f9; /* Fondo gris claro para celdas */
        }
        .btn {
            background-color: #ff6347; /* Botones en color tomato */
            color: #ffffff; /* Texto en blanco */
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #e55347; /* Color más oscuro en hover */
        }
    </style>
</head>
<body>
    <header>
        <h1>Bitácora de Transacciones</h1>
        <p>Usuario: Brandon Mora Hernandez | Rol: Administrador</p>
    </header>
    <nav>
        <ul style="list-style: none; padding: 0; text-align: center;">
            <li style="display: inline; margin: 0 10px;"><a href="#" style="color: #ffffff;">Administración</a></li>
            <li style="display: inline; margin: 0 10px;"><a href="#" style="color: #ffffff;">Acciones del Personal</a></li>
            <li style="display: inline; margin: 0 10px;"><a href="#" style="color: #ffffff;">Reportes</a></li>
            <li style="display: inline; margin: 0 10px;"><a href="#" style="color: #ffffff;">Bitácora</a></li>
            <li style="display: inline; margin: 0 10px;"><a href="#" style="color: #ffffff;">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <div class="content">
        <h2>Administración de proyectos</h2>
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
                <tr>
                    <td>aaa</td>
                    <td>2024-07-04</td>
                    <td>2024-08-08</td>
                    <td>Terminado</td>
                    <td>✔</td>
                    <td><button class="btn">Borrar</button></td>
                </tr>
                <tr>
                    <td>sexual</td>
                    <td>2024-07-05</td>
                    <td>2024-08-02</td>
                    <td>Terminado</td>
                    <td>✔</td>
                    <td><button class="btn">Borrar</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <footer>
        <p>CENTRAL SYSTEMS</p>
    </footer>
</body>
</html>
