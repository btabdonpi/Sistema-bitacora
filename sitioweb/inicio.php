<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central System's</title>
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
            background-color:#273746;
            font-family: "Titillium Web", sans-serif;
            position: relative;
            --white: #ebebeb;
            --pink: #d6157c;
        }

        header {
            position: absolute;
            width: 1000px;
            left: 50%;
            top: 5%;
            transform: translateX(-50%);
            padding: 10px;
            display: grid;
            grid-template-columns: 1fr auto auto auto;
            align-items: center;
            z-index: 7;
            color: var(--white);
        }

        header h4 {
            font-size: 1.2rem;
            color: var(--pink);
            letter-spacing: 1px;
        }

        header a {
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
            color: var(--white);
            text-decoration: none;
            transition: 0.3s;
            margin-left: 20px;
        }

        header a:hover {
            color: var(--pink);
            cursor: pointer;
        }

        .container {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 1000px;
            height: 80%;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-column-gap: 10px;
            perspective: 1000px;
        }

        .layer {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 1000px;
            height: 80%;
            padding: 1em;
            position: relative;
            z-index: 5;
            clip-path: polygon(3% 0, 40% 0%, 40% 100%, 0% 100%);
        }

        .layer h1 {
            position: absolute;
            top: 50%;
            left: -270px;
            transform: translate(0, -50%);
            font-size: 5rem;
            font-weight: 900;
            color: var(--white);
            text-shadow: 4px 4px 16px rgba(0, 0, 0, 0.3);
            letter-spacing: 5px;
        }

        .layer h1 span {
            color: var(--pink);
        }

        .panel {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transform-origin: 50% 0;
            transform: translateZ(0) translateX(0) rotateY(0deg);
            position: relative;
        }

        .panel::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            background: linear-gradient(0deg, rgba(0, 0, 0, 0.7) 10%, rgba(0, 0, 0, 0));
        }

        .front,
        .back {
            width: 100%;
            height: 100%;
            background-image: url("https://www.sicontis.com/codepen/cpc-reflection/gdtography.jpg");
            background-size: cover;
            background-position: left top;
            position: absolute;
            backface-visibility: hidden;
        }

        .back {
            transform: scaleX(-1) rotateY(180deg);
        }

        .panel:nth-child(1) .front {
            background-position: 0 0;
        }

        .panel:nth-child(2) .front {
            background-position: -250px 0;
        }

        .panel:nth-child(3) .front {
            background-position: -500px 0;
        }

        .panel:nth-child(4) .front {
            background-position: -750px 0;
        }

        .panel:nth-child(1) .back {
            background-position: 250px 0;
        }

        .panel:nth-child(2) .back {
            background-position: 500px 0;
        }

        .panel:nth-child(3) .back {
            background-position: 750px 0;
        }

        .panel:nth-child(4) .back {
            background-position: 1000px 0;
        }

        footer {
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            bottom: 5%;
            padding: 10px;
            display: grid;
            place-items: center;
            z-index: 6;
        }

        footer p {
            font-size: 0.8rem;
            color: #979797;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        footer a {
            color: var(--pink);
            text-decoration: none;
        }

        .replay {
            cursor: pointer;
            width: min-content;
            font-size: 0.8rem;
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 5px;
            transform: translateY(-20px);
        }
    </style>
</head>
<body>
    <header>
        <h4>CENTRAL SYSTEM'S</h4>
        <a href="nosotros.php">Nosotros</a>
        <a href="servicios.php">Servicios</a>
        <a href="acceso.php">Iniciar Sesión</a>
    </header>
    <div class="container">
        <div class="panel">
            <div class="front"></div>
            <div class="back"></div>
        </div>
        <div class="panel">
            <div class="front"></div>
            <div class="back"></div>
        </div>
        <div class="panel">
            <div class="front"></div>
            <div class="back"></div>
        </div>
        <div class="panel">
            <div class="front"></div>
            <div class="back"></div>
        </div>
    </div>
    <div class="layer">
        <h1>CEN<span>TRAL</span>System's</h1>
    </div>
    <footer>
        <div class="replay">REPLAY</div>
        <p>UPMH<a href="https://dribbble.com/shots/3911960-Reflet-Communication" target="_blank"></a> VIRTUALIZACIÓN</p>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script>
        let panels = document.querySelectorAll(".panel");
        let fronts = document.querySelectorAll(".front");
        let backs = document.querySelectorAll(".back");
        let replay_btn = document.querySelector(".replay");

        const mirrorTL = gsap.timeline();
        const titleTL = gsap.timeline();

        gsap.set(replay_btn, { opacity: 0 });
        replay_btn.addEventListener("click", (e) => {
            mirrorTL.restart();
            titleTL.restart();
            gsap.to(e.target, 0.5, { opacity: 0 });
            console.log(e.target);
        });

        mirrorTL
            .to(fronts, 2.5, { backgroundPosition: "30px 0px", ease: "expo.inOut" })
            .to(panels, 2.5, { z: -300, rotationY: 180, ease: "expo.inOut" }, "-=2.3")
            .from(
                backs,
                2.5,
                {
                    backgroundPosition: "-30px 0px",
                    ease: "expo.inOut",
                    onComplete: () => {
                        gsap.to(replay_btn, 1, { opacity: 1 });
                    }
                },
                "-=2.3"
            );

        titleTL
            .to(".layer", 1, { clipPath: "polygon(3% 0, 100% 0%, 100% 100%, 0% 100%" })
            .to(".layer h1", 2, { x: 400, ease: "expo.inOut" }, "-=0.5")
            .to(".cta", 2, { x: 0, ease: "expo.inOut" }, "-=2");
    </script>
</body>
</html>
