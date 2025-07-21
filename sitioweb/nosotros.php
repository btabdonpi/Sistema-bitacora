<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;900&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            width: 100vw;
            height: 100vh;
            background-color: #273746;
            font-family: "Titillium Web", sans-serif;
            position: relative;
            color: #ffffff;
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
            display: grid;
            place-items: center;
            text-align: center;
            padding: 40px 20px;
            margin-top: 50px;
        }

        .container h1 {
            font-size: 2.5rem;
            font-weight: 900;
            color: #ffffff;
        }

        .container p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .container img {
            width: 100%;
            max-width: 300px;
            border-radius: 50%;
            margin: 20px 0;
        }

        footer {
            position: relative;
            padding: 10px;
            text-align: center;
            background-color: #1a1a1a;
            color: #979797;
        }

        footer p {
            font-size: 0.8rem;
            text-transform: uppercase;
        }

        .contact {
            padding: 20px;
            background-color: #1a1a1a;
            text-align: center;
        }

        .contact h2 {
            font-size: 2rem;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .contact p {
            font-size: 1rem;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .example-2 {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .example-2 .icon-content {
            position: relative;
        }

        .example-2 .icon-content .tooltip {
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            color: #ffffff;
            padding: 6px 10px;
            border-radius: 5px;
            opacity: 0;
            visibility: hidden;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .example-2 .icon-content:hover .tooltip {
            opacity: 1;
            visibility: visible;
            top: -50px;
        }

        .example-2 .icon-content a {
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            color: #4d4d4d;
            background-color: #ffffff;
            transition: all 0.3s ease-in-out;
        }

        .example-2 .icon-content a:hover {
            box-shadow: 3px 2px 45px 0px rgb(0 0 0 / 12%);
        }

        .example-2 .icon-content a svg {
            width: 24px;
            height: 24px;
        }

        .example-2 .icon-content a:hover {
            color: white;
        }

        .example-2 .icon-content a .filled {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 0;
            background-color: #000;
            transition: all 0.3s ease-in-out;
        }

        .example-2 .icon-content a:hover .filled {
            height: 100%;
        }

        .example-2 .icon-content a[data-social="linkedin"] .filled,
        .example-2 .icon-content a[data-social="linkedin"] ~ .tooltip {
            background-color: #0274b3;
        }

        .example-2 .icon-content a[data-social="github"] .filled,
        .example-2 .icon-content a[data-social="github"] ~ .tooltip {
            background-color: #24262a;
        }

        .example-2 .icon-content a[data-social="instagram"] .filled,
        .example-2 .icon-content a[data-social="instagram"] ~ .tooltip {
            background: linear-gradient(45deg, #405de6, #5b51db, #b33ab4, #c135b4, #e1306c, #fd1f1f);
        }

        .example-2 .icon-content a[data-social="youtube"] .filled,
        .example-2 .icon-content a[data-social="youtube"] ~ .tooltip {
            background-color: #ff0000;
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
        <h1>Sobre Nosotros</h1>
        <img src="img/dd.png" alt="Equipo Central System's">
        <p>
            En Central System's nos dedicamos a proporcionar soluciones tecnológicas avanzadas para empresas y particulares. Nuestro equipo está compuesto por expertos en diversas áreas de la tecnología, comprometidos en ofrecer servicios de alta calidad y personalizados.
        </p>
        <p>
            Desde el desarrollo web hasta la virtualización y el monitoreo de sistemas, nuestra misión es impulsar la eficiencia y la innovación en cada proyecto que emprendemos. Creemos en la importancia de una relación cercana y de confianza con nuestros clientes, para así entender mejor sus necesidades y superar sus expectativas.
        </p>
    </div>
    <div class="contact">
        <h2>Contacto</h2>
        <p>Para consultas y más información, no dudes en contactarnos a través de nuestras redes sociales:</p>
        <ul class="example-2">
            <li class="icon-content">
                <a href="https://linkedin.com/" aria-label="LinkedIn" data-social="linkedin">
                    <div class="filled"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                    </svg>
                    <span class="tooltip">LinkedIn</span>
                </a>
            </li>
            <li class="icon-content">
                <a href="https://github.com/" aria-label="GitHub" data-social="github">
                    <div class="filled"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 0 0-2.546 15.579c.4.074.548-.174.548-.387v-1.329c-2.235.487-2.707-1.077-2.707-1.077-.364-.926-.888-1.174-.888-1.174-.725-.494.055-.484.055-.484.803.056 1.225.825 1.225.825.713 1.219 1.868.866 2.319.662.072-.518.28-.866.508-1.065-1.779-.203-3.649-.889-3.649-3.959 0-.875.312-1.588.826-2.148-.082-.202-.359-1.014.079-2.115 0 0 .663-.213 2.172.823A7.61 7.61 0 0 1 8 4.106a7.61 7.61 0 0 1 2.017-.275c1.51-1.036 2.172-.823 2.172-.823.438 1.101.161 1.913.079 2.115.515.56.826 1.273.826 2.148 0 3.075-1.876 3.759-3.659 3.955.29.248.546.736.546 1.481v2.198c0 .214.148.462.555.387A8 8 0 0 0 8 0z"/>
                    </svg>
                    <span class="tooltip">GitHub</span>
                </a>
            </li>
            <li class="icon-content">
                <a href="https://instagram.com/" aria-label="Instagram" data-social="instagram">
                    <div class="filled"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 1.5a6.5 6.5 0 1 0 6.5 6.5A6.507 6.507 0 0 0 8 1.5zm0 12a5.5 5.5 0 1 1 5.5-5.5A5.506 5.506 0 0 1 8 13.5zM11.5 4a.5.5 0 1 1 0 1 .5.5 0 0 1 0-1zM8 4a4 4 0 1 0 4 4 4.004 4.004 0 0 0-4-4z"/>
                    </svg>
                    <span class="tooltip">Instagram</span>
                </a>
            </li>
            <li class="icon-content">
                <a href="https://youtube.com/" aria-label="YouTube" data-social="youtube">
                    <div class="filled"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
                        <path d="M8.051 1.991a.5.5 0 0 1 .898 0c.62 1.161 1.08 2.794 1.285 4.676a.5.5 0 0 1-.398.562L8.508 7.62c-.443.164-.919-.075-1.019-.582a11.5 11.5 0 0 1-.457-2.82c-.015-1.95-.358-3.978-1.039-5.565a.5.5 0 0 1 .676-.675z"/>
                        <path d="M8 8a3.992 3.992 0 0 1-3.533-2.061A3.992 3.992 0 0 1 8 3.876a3.993 3.993 0 0 1 3.533 2.061A3.993 3.993 0 0 1 8 8z"/>
                    </svg>
                    <span class="tooltip">YouTube</span>
                </a>
            </li>
        </ul>
    </div>
    <footer>
        <p>&copy; 2024 Central System's. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
