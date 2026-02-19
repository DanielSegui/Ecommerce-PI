<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D&N Motors</title>
    <link href="bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="./imgs/logoPest.png">
    <link rel="stylesheet" href="./css/pps5.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="logo">
            <a href="index.html">
                <img src="./imgs/logo3.png" alt="D&N Motors Logo">
            </a>
        </div>
        <div class="user-menu">
            <input type="checkbox" id="toggleMenu">
            <label for="toggleMenu">
                <img src="./imgs/menu1.png" class="user-avatar" alt="Usuario">
            </label>
            <ul class="dropdown">
                <li><a href="./auth/profile.php">Perfil</a></li>
                <li><a href="./auth/login.php">Iniciar sesión</a></li>
                <li><a href="./auth/register.php">Registrarse</a></li>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="coches.html">Coches de lujo</a></li>
                <li><a href="motos.html">Motos Superdeportivas</a></li>
                <li><a href="clasicos.html">Coches clásicos</a></li>
                <li><a href="formulario.php">Contacto</a></li>
            </ul>
        </div>
    </header>

    <section class="hero2">
        <video autoplay loop muted class="hero2-video">
            <source src="vids/mclaren.mp4" type="video/mp4">
        </video>
        <div class="hero2-content">
            <h1>D&N Motors</h1>
            <p>Donde la pasión por los coches se convierte en confianza</p>
        </div>
    </section>

    <section class="categorias container py-5">
        <h2 class="categorias-titulo text-center">Elige Tu Camino</h2>
        <div class="categorias-texto text-center mb-5">
            <p>En D&N Motors puedes elegir si prefieres coches de lujo, motos superdeportivas o apostar por los coches clásicos e históricos.</p>
        </div>

        <div class="row g-4 d-flex align-items-stretch">
            <div class="col-12 col-md-4">
                <div class="cat-card h-100 position-relative">
                    <img src="./imgs/ferrari.png" alt="Coches superdeportivos" class="img-fluid">
                    <h3>Coches De Lujo</h3>
                    <button class="cat-btn" onclick="window.location.href='coches.html'">Descúbrelo</button>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="cat-card h-100 position-relative">
                    <span class="badge rounded-pill bg-danger position-absolute m-3" style="top:0; right:0;">¡TOP VENTAS!</span>
                    <img src="./imgs/motoDeportiva.png" alt="Motos super deportivas" class="img-fluid">
                    <h3>Motos Superdeportivas</h3>
                    <button class="cat-btn" onclick="window.location.href='motos.html'">Descúbrelo</button>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="cat-card h-100 position-relative">
                    <span class="badge rounded-pill bg-warning text-dark position-absolute m-3" style="top:0; right:0;">Nueva Colección</span>
                    <img src="./imgs/clasicos2.png" alt="Coches clásicos" class="img-fluid">
                    <h3>Coches Clásicos</h3>
                    <button class="cat-btn" onclick="window.location.href='clasicos.html'">Descúbrelo</button>
                </div>
            </div>
        </div>
    </section>

    <section class="split">
        <div class="split-img">
            <img src="./imgs/moto1.jpg" alt="Motocicleta deportiva">
        </div>
        <div class="split-text">
            <h2>Pasión por el Motor</h2>
            <p>En D&N Motors somos apasionados del mundo del motor. Nuestro objetivo es ofrecerte los mejores coches nuevos y de ocasión, con la máxima garantía y transparencia.</p>
        </div>
    </section>

    <section class="split reverse">
        <div class="split-img">
            <img src="./imgs/aston.jpg" alt="Coche deportivo azul">
        </div>
        <div class="split-text">
            <h2>Tu Coche Ideal Te Espera</h2>
            <p>Ya sea que busques tu primer coche, un modelo familiar o un vehículo deportivo, en D&N Motors encontrarás la opción perfecta para ti.</p>
        </div>
    </section>

    <section class="about">
        <h2>Sobre nosotros</h2>
        <div class="carousel-container">
            <div class="carousel-track">
                <div class="carousel-item">
                    <img src="./imgs/mecanico.jpg" alt="Mecánicos trabajando">
                    <p>Ofrecemos el mejor cuidado para tu vehículo con los mejores mecánicos.</p>
                </div>
                <div class="carousel-item">
                    <img src="./imgs/taller.jpg" alt="Taller profesional">
                    <p>Contamos con un taller profesional equipado con tecnología de última generación.</p>
                </div>
                <div class="carousel-item">
                    <img src="./imgs/tallerLujo.jpg" alt="Atención personalizada">
                    <p>Brindamos atención personalizada para garantizar tu total satisfacción.</p>
                </div>
            </div>
            <button class="carousel-btn prev">←</button>
            <button class="carousel-btn next">→</button>
        </div>
        <button class="btn" onclick="window.location.href='formulario.php'">Comencemos</button>
    </section>

    <footer class="footer">
        <div class="footer-left">
            <p><strong>D&N Motors</strong></p>
            <div class="social">
                <img src="./imgs/Icon.png" alt="LinkedIn" width="45" data-bs-toggle="tooltip" data-bs-placement="top" title="LinkedIn">
                <img src="./imgs/Icon1.png" alt="Youtube" width="45" data-bs-toggle="tooltip" data-bs-placement="top" title="Youtube">
                <img src="./imgs/Icon2.png" alt="Instagram" width="45" data-bs-toggle="tooltip" data-bs-placement="top" title="Instagram">
                <img src="./imgs/Icon3.png" alt="Facebook" width="45" data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook">
            </div>
        </div>
        <div class="footer-right">
            <p><strong>Términos y configuración</strong></p>
            <ul>
                <li>Condiciones de uso</li>
                <li>Aviso de privacidad</li>
                <li>Política de cookies</li>
                <li>Declaración de accesibilidad</li>
                <li>Gestiona las recomendaciones personalizadas</li>
            </ul>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Inicializar Tooltips de Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // Lógica de tu Carrusel
        const track = document.querySelector('.carousel-track');
        const items = Array.from(track.children);
        const nextBtn = document.querySelector('.next');
        const prevBtn = document.querySelector('.prev');
        let index = 0;

        function updateCarousel() {
            track.style.transform = `translateX(-${index * 100}%)`;
        }

        nextBtn.addEventListener('click', () => {
            index = (index + 1) % items.length;
            updateCarousel();
        });

        prevBtn.addEventListener('click', () => {
            index = (index - 1 + items.length) % items.length;
            updateCarousel();
        });
    </script>
</body>
</html>