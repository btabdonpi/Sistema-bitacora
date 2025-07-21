<?php
ob_start(); // Inicia el búfer de salida
session_start(); // Inicia la sesión

// Verifica que exista la variable 'op', posteriormente convierte todo a minúsculas
$pagina = isset($_GET['op']) ? strtolower($_GET['op']) : 'principal';

// Se genera la opción de menú
require_once __DIR__ . '/bitacora/encabezado.php';

// Se muestran las páginas que van a cambiar en esta sección
$archivo = __DIR__ . '/bitacora/' . $pagina . '.php';
if (file_exists($archivo)) {
    require_once $archivo;
} else {
    echo "<div><h1>Página no encontrada</h1></div>";
}

// Se crea la sección de pie de página
require_once __DIR__ . '/bitacora/piepagina.php';

ob_end_flush(); // Envía la salida del búfer al navegador

?>
