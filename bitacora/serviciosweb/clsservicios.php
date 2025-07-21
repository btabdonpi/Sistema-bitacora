<?php
    class clsservicios
    {
        public function acceso($usuario, $contra)
        {
            $datos = array();
            require('conexion.php');
            $renglon = query("CALL spValidarAcceso('$usuario','$contra')");
            while ($resultado = mysqli_fetch_assoc($renglon)) {
                $datos[0]["ID"] = $resultado["CLAVE"];
                if ((int)$datos[0] != 0) {
                    $datos[1]["NOMBRE"] = $resultado["USUARIO"];
                    $datos[2]["ROL"] = $resultado["ROL"];
                }
            }
            return $datos;
        }

        public function ListarPersonal()
        {
            $datos = array();
            $reg = 0;
            require('conexion.php');
            $renglon = query("SELECT A.PersonalID, A.Nombre, B.Nombre as Rol from personal A , roles B WHERE A.RolID=B.RolID;");
            while ($resultado = mysqli_fetch_assoc($renglon)) {
                $datos[$reg]["PersonalID"] = $resultado["PersonalID"];
                $datos[$reg]["Nombre"] = $resultado["Nombre"];
                $datos[$reg]["Rol"] = $resultado["Rol"];
                $reg++;
            }
            return $datos;
        }

        public function mostrarBitacora($filtro,$valor)
        {
            $datos = array();
            $reg = 0;
            require('conexion.php');
            $renglon = query("CALL FiltrarBitacora('$filtro','$valor')");
            while ($resultado = mysqli_fetch_assoc($renglon)) {
                $datos[$reg]["bID"] = $resultado["bID"];
                $datos[$reg]["personal"] = $resultado["personal"];
                $datos[$reg]["rol"] = $resultado["rol"];
                $datos[$reg]["fecha"] = $resultado["fecha"];
                $datos[$reg]["tarea"] = $resultado["tarea"];
                $datos[$reg]["proyecto"] = $resultado["proyecto"];
                $datos[$reg]["actividad"] = $resultado["actividad"];
                $reg++;
            }
            return $datos;
        }

        public function AccionesPersonal($accion, $PersonalID)
        {
            require('conexion.php');
            $renglon = query("CALL RegistrarActividad($accion, $PersonalID)");
        }

        public function CrearProyecto($nombre, $descripcion, $tipo, $Fechain, $Fechaf, $id)
        {
            
            
            $datos=array();
            $reg=0;
            require('conexion.php');
            $renglon=query("CALL CrearNuevoProyecto('$nombre','$descripcion','$tipo','$Fechain','$Fechaf','Activo','$id');");
            while($resultado=mysqli_fetch_assoc($renglon))
            {
                //$resultado['Clave'];
                $datos[0]["REGISTRADO"]=$resultado["INSERTADO"];
    
            }
            return $datos;
        }

        public function listaProyectos()
        {
            $datos = array();
            $reg = 0;
            require('conexion.php');
            $renglon = query("SELECT a.ProyectoID as id, a.Nombre, a.FechaInicio as I, a.FechaFin as F, a.EstatusP as Estatus from proyectos a;");
            while ($resultado = mysqli_fetch_assoc($renglon)) {
                $datos[$reg]["id"] = $resultado["id"];
                $datos[$reg]["Nombre"] = $resultado["Nombre"];
                $datos[$reg]["I"] = $resultado["I"];
                $datos[$reg]["F"] = $resultado["F"];
                $datos[$reg]["Estatus"] = $resultado["Estatus"];
                $reg++;
            }
            return $datos;
        }

        public function BorrarProyecto($idp, $idu)
        {
            require('conexion.php');
            query("call BorrarProyecto($idp, $idu);");
        }

        public function EstatusProyecto($idp, $idu)
        {
            require('conexion.php');
            query("call EstatusProyecto($idp, $idu);");
        }

        public function listaTareas() {
            // Supongamos que tienes una base de datos configurada y conectada
            require('conexion.php');
    
            if ($conexion->connect_error) {
                die("Conexión fallida: " . $conexion->connect_error);
            }
    
            $consulta = "SELECT nombre, personal, recursos, fase FROM tareas";
            $resultado = $conexion->query($consulta);
    
            $tareas = array();
            if ($resultado->num_rows > 0) {
                while($fila = $resultado->fetch_assoc()) {
                    $tareas[] = $fila;
                }
            }
    
            $conexion->close();
            return $tareas;
        }
        //para filtros
        public function getUsu(){
        $datos=array();
        $reg=0;
        require('conexion.php');
        $renglon=query("SELECT p.PersonalID as ID, p.Nombre as Nombre FROM personal p;");
        while($resultado=mysqli_fetch_assoc($renglon))
        {
            //$resultado['Clave'];
            $datos[$reg]["ID"]=$resultado["ID"];
            $datos[$reg]["Nombre"]=$resultado["Nombre"];
            $reg++;
        }
        return $datos;
    }
    
    
        public function getRol(){
        $datos=array();
        $reg=0;
        require('conexion.php');
        $renglon=query("SELECT roles.RolID as ID, roles.Nombre from roles");
        while($resultado=mysqli_fetch_assoc($renglon))
        {
            //$resultado['Clave'];
            $datos[$reg]["ID"]=$resultado["ID"];
            $datos[$reg]["Nombre"]=$resultado["Nombre"];
            $reg++;
        }
        return $datos;
    }
    
    public function getPro(){
        $datos=array();
        $reg=0;
        require('conexion.php');
        $renglon=query("SELECT act.ActID as ID, act.NomAct as De from Actividades act");
        while($resultado=mysqli_fetch_assoc($renglon))
        {
            //$resultado['Clave'];
            $datos[$reg]["ID"]=$resultado["ID"];
            $datos[$reg]["De"]=$resultado["De"];
            $reg++;
        }
        return $datos;
    }
    
    public function getTa(){
        $datos=array();
        $reg=0;
        require('conexion.php');
        $renglon=query("SELECT Tareas.TareaID as ID, Tareas.Descripcion as De from Tareas");
        while($resultado=mysqli_fetch_assoc($renglon))
        {
            //$resultado['Clave'];
            $datos[$reg]["ID"]=$resultado["ID"];
            $datos[$reg]["De"]=$resultado["De"];
            $reg++;
        }
        return $datos;
    }
    
    public function getProy(){
        $datos=array();
        $reg=0;
        require('conexion.php');
        $renglon=query("SELECT proyectos.ProyectoID as ID, proyectos.Nombre as De FROM proyectos");
        while($resultado=mysqli_fetch_assoc($renglon))
        {
            //$resultado['Clave'];
            $datos[$reg]["ID"]=$resultado["ID"];
            $datos[$reg]["De"]=$resultado["De"];
            $reg++;
        }
        return $datos;
    }
    
    public function registrarBitacora($usuario,$fecha,$tarea,$proyecto,$actividad)
    {
        $datos=array();
        $reg=0;
        require('conexion.php');
        $renglon=query("call spInBitacora('$usuario','$fecha','$tarea','$proyecto','$actividad')");
        while($resultado=mysqli_fetch_assoc($renglon))
        {
            //$resultado['Clave'];
            $datos[0]["REGISTRADO"]=$resultado["INSERTADO"];

        }
        return $datos;
        
    }
    
    
    }
?>
