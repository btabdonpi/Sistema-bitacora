<?php
    define("hostname", "localhost");
    define("user", "id22230899_equipo1");
    define("password", "Equipo1.");
    define("database", "id22230899_bd_centrals");
    //función para verificar los datos de acceso
    function query($query){
        //conexión con BD
        $cnn = mysqli_connect(hostname, user, password, database);
        if(mysqli_connect_errno()){
            printf("Conexión al servidor de base de datos ha fallado: ", mysqli_connect_error());
                exit();
        }
        
        $res = mysqli_query($cnn, $query);
        $cnn->close();
        return $res;
    }
?>