<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Servicios</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;900&display=swap">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Titillium Web', sans-serif;
      color: #ffffff;
      background-color: #273746;
    }

    header {
      width: 100%;
      padding: 20px;
      background-color: #1a1a1a;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1000;
    }

    header h4 {
      font-size: 1.5rem;
      color: #f39c12;
    }

    header a {
      color: #ffffff;
      text-decoration: none;
      margin: 0 15px;
      font-size: 1rem;
      transition: color 0.3s;
    }

    header a:hover {
      color: #f39c12;
    }

    .container {
      display: flex;
      height: 100vh;
      margin-top: 60px; /* Adjust to account for header height */
    }

    .section {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
      overflow: hidden;
      background-size: cover;
      background-position: center;
      color: #fff;
      transition: flex 0.4s ease;
      position: relative;
    }

    .section .overlay {
      background-color: rgba(0, 0, 0, 0.7);
      width: 100%;
      height: 100%;
      position: absolute;
      transition: background-color 0.8s ease;
    }

    .section .content {
      z-index: 2;
      text-align: center;
    }

    .section:hover {
      flex: 2;
    }

    .section:hover .overlay {
      background-color: rgba(0, 0, 0, 0.95);
    }

    #Virtualizacion {
      background-image: url('img/virtualizacion.jpg');
    }

    #Desarrollo_web {
      background-image: url('img/web.jpg');
    }

    #Gaming {
      background-image: url('img/juegos.jpg');
    }

    .circular-img {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      object-fit: cover;
      margin: 20px 0;
    }
  </style>
</head>
<body>
  <header>
    <h4>CENTRAL SYSTEM'S</h4>
    <nav>
      <a href="nosotros.php">Nosotros</a>
      <a href="servicios.php">Servicios</a>
      <a href="acceso.php">Iniciar Sesión</a>
    </nav>
  </header>
  <div class="container">
    <div id="marketing" class="section">
      <div class="content">
        <h1>Servicio de Monitoreo</h1>
        <h3>Base de datos</h3>
        <h3>Transacciones</h3>
        <h3>Witio Web</h3>
        <img src="https://us.123rf.com/450wm/arhimicrostok/arhimicrostok1707/arhimicrostok170703909/81665225-icono-de-ojo-sistema-de-monitoreo-y-vigilancia-estilo-de-dise%C3%B1o-plano.jpg" alt="monitoreo" class="circular-img">
      </div>
      <div class="overlay"></div>
    </div>
    <div id="technology" class="section">
      <div class="content">
        <h1>Virtualización</h1>
        <h3>Godot</h3>
        <h3>Python</h3>
        <h3>Sublime Text 3</h3>
        <h3>Visual Studio Code</h3>
        <h3>Adobe</h3>
        <h3>Base de datos relacionales</h3>
        <img src="https://f.hubspotusercontent20.net/hubfs/5115875/Blog/Blog_Art%C3%ADculos/Blog_Art%C3%ADculos_2021/Blog_Art%C3%ADculos_2021_Marzo/Blog_Art%C3%ADculos_2021_Marzo_Art42_VR/Blog_Art%C3%ADculos_2021_Marzo_Art42_VR_nuevo/Virtualizaci%C3%B3n-el%20siguiente-paso-para-tu-empresa.jpg" alt="virtualización" class="circular-img">
      </div>
      <div class="overlay"></div>
    </div>
    <div id="advertising" class="section">
      <div class="content">
        <h1>Proyectos</h1>
        <h3>Entretenimiento</h3>
        <h3>Transaccionales</h3>
        <h3>Gestión de Proyectos</h3>
        <img src="https://kreaweb.cl/wp-content/uploads/2021/04/Diseno-Web.png" alt="proyectos" class="circular-img">
      </div>
      <div class="overlay"></div>
    </div>
  </div>
</body>
</html>
