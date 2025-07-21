<?php
    include 'clsservicios.php';
    //USO DEL PROTOCOLO SOAP SERVER PARA ESTABLECER LA CONEXIÓN CON EL HOSTING
    $soap = new SoapServer(null,array('uri' => 'http://localhost/'));
    //SE EJECUTA LA CLASE QUE CONTIENE LOS MÉTODOS
    $soap->setClass('clsservicios');
    //HACE QUE SE EJECUTE LA CLASE
    $soap->handle();
?>