<?php
session_start();
function hdr(string $h): void
{
    if (!headers_sent())
        header($h);
}
hdr('X-Frame-Options: SAMEORIGIN');
hdr('X-Content-Type-Options: nosniff');
hdr('Referrer-Policy: strict-origin-when-cross-origin');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lluvias e Inundaciones | Construcvida</title>
    <meta name="description"
        content="Información sobre cobertura de seguros hipotecarios ante lluvias intensas e inundaciones en el Perú.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/riesgo-detail.css">
</head>

<body>

    <!-- Navbar -->
    <header class="navbar" id="navbar">
        <div class="container nav-container">
            <a href="index.php" class="logo">
                <img src="assets/images/logo.jpeg" alt="GH Constructivo" class="logo-img">
                <span class="logo-tagline"><strong>GRUPO HOGAR</strong><strong class="text-orange">CONSTRUCTIVO</strong></span>
            </a>
            <div class="mobile-menu-btn" id="mobile-btn"><i class="fa-solid fa-bars"></i></div>
            <nav class="nav-links" id="nav-links">
                <a href="index.php#hero">Inicio</a>
                <a href="index.php#nosotros">Nosotros</a>
                <a href="index.php#seguro">Seguros</a>
                <a href="index.php#elegirnos">¿Por qué elegirnos?</a>
                <a href="index.php#contacto" class="btn btn-primary">Contacto</a>
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <section class="riesgo-hero" style="background-image: url('assets/images/im10.jpg');">
        <div class="riesgo-hero-overlay"></div>
        <div class="container riesgo-hero-content">
            <div class="riesgo-hero-badge"><i class="fa-solid fa-cloud-showers-heavy"></i></div>
            <h1>LLUVIAS <span class="text-orange">E INUNDACIONES</span></h1>
            <p>Fenómenos, impacto en el Perú y cobertura de seguros hipotecarios</p>
        </div>
    </section>

    <!-- Contenido principal -->
    <main class="section riesgo-main">
        <div class="container riesgo-container">

            <!-- Breadcrumb -->
            <nav class="breadcrumb-nav" aria-label="Breadcrumb">
                <a href="index.php"><i class="fa-solid fa-house"></i> Inicio</a>
                <span>/</span>
                <span>Lluvias e Inundaciones</span>
            </nav>

            <!-- Banner apertura -->
            <div class="riesgo-pregunta-banner">
                <i class="fa-solid fa-circle-question"></i>
                <p>¿Estamos realmente preparados y protegidos frente a desastres y fenómenos naturales mediante los
                    seguros de vivienda?</p>
            </div>

            <!-- ── SECCIÓN 1: QUÉ ES LA LLUVIA ── -->
            <div class="riesgo-intro">
                <h2>¿Qué es la <span class="text-orange">lluvia?</span></h2>
                <p class="riesgo-lead">
                    Es un fenómeno atmosférico de tipo acuático que se inicia con la <strong>condensación del vapor de
                        agua</strong>
                    contenido en las nubes. Las lluvias son fenómenos meteorológicos que pueden generar emergencias
                    cuando superan la capacidad de absorción del suelo o de los sistemas de drenaje.
                </p>
            </div>

            <!-- Tabla clasificación -->
            <div class="riesgo-tabla-wrapper">
                <h3 class="riesgo-tabla-titulo">
                    <i class="fa-solid fa-table-list text-blue"></i>
                    Clasificación de la lluvia según su forma
                </h3>
                <div class="riesgo-tabla-scroll">
                    <table class="riesgo-tabla">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="fa-solid fa-droplet text-blue"></i> Llovizna</td>
                                <td>Gotas menudas con diámetro &lt;0,5 mm, se presenta como pulverizada, flotando en el
                                    aire.</td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-droplet text-blue"></i> Lluvia</td>
                                <td>Continua y regular, con diámetro de gotas &gt;0,5 mm.</td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-cloud-showers-heavy text-orange"></i> Chubasco</td>
                                <td>Cae de golpe, con intensidad y en un intervalo de tiempo pequeño.</td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-bolt text-orange"></i> Tormenta eléctrica</td>
                                <td>Alta pluviosidad, gotas grandes, viento intenso y posibilidad de granizo. Puede ser
                                    débil o intensa.</td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-wind text-orange"></i> Aguacero</td>
                                <td>Lluvia torrencial que puede causar estragos, acompañada de vientos entre 25 y más de
                                    100 km/h.</td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-water text-blue"></i> Tromba</td>
                                <td>Cae tan violenta y abundantemente que provoca riadas e inundaciones.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ── SECCIÓN 2: QUÉ SON LAS INUNDACIONES ── -->
            <div class="riesgo-intro" style="margin-top: 3rem;">
                <h2>¿Qué son las <span class="text-orange">inundaciones?</span></h2>
                <p class="riesgo-lead">
                    Una inundación es la <strong>ocupación por parte del agua de zonas o regiones que habitualmente se
                        encuentran secas</strong>.
                    Normalmente es consecuencia de una cantidad de agua superior a la que puede drenar el cauce del río.
                    Se producen por causas naturales como lluvias, oleaje o deshielo, o no naturales como la rotura de
                    presas.
                </p>
            </div>

            <!-- Galería de imágenes -->
            <div class="riesgo-galeria">
                <div class="riesgo-galeria-item">
                    <img src="assets/images/inun1.jpg" alt="Inundación en viviendas del Perú">
                    <span class="riesgo-galeria-caption">Inundaciones y daños en viviendas</span>
                </div>
                <div class="riesgo-galeria-item">
                    <img src="assets/images/inu2.jpg" alt="Lluvias intensas y zonas afectadas">
                    <span class="riesgo-galeria-caption">Zonas afectadas por lluvias intensas</span>
                </div>
            </div>

            <!-- ── SECCIÓN 3: PERÚ ── -->
            <div class="riesgo-callout">
                <div class="riesgo-callout-icon"><i class="fa-solid fa-earth-americas"></i></div>
                <div>
                    <h3>¿Lluvias e inundaciones en el Perú?</h3>
                    <p>
                        Las inundaciones provocadas por el <strong>Fenómeno El Niño</strong> entre enero y marzo de 2017
                        afectaron a <strong>1,9 millones de personas</strong> en Perú, incluyendo niños, niñas y
                        familias que
                        perdieron sus casas y fuentes de ingreso. Entre enero y mayo de 2023, lluvias intensas
                        provocaron
                        huaicos, deslizamientos, derrumbes e inundaciones que ocasionaron daños a viviendas, salud,
                        agricultura,
                        transporte e infraestructura educativa en el departamento de <strong>Piura</strong>.
                    </p>
                </div>
            </div>

            <!-- Grid de tarjetas -->
            <div class="riesgo-grid">

                <div class="riesgo-info-card">
                    <div class="riesgo-info-icon"><i class="fa-solid fa-triangle-exclamation text-orange"></i></div>
                    <h3>Causas de las inundaciones</h3>
                    <ul class="riesgo-list">
                        <li><i class="fa-solid fa-check text-orange"></i> Lluvias intensas que superan la capacidad de
                            drenaje</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Desborde de ríos y quebradas</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Geografía y composición del suelo</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Deficiencias en infraestructura de drenaje
                            urbano</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Nivel freático elevado y efectos del Fenómeno
                            El Niño</li>
                    </ul>
                </div>

                <div class="riesgo-info-card">
                    <div class="riesgo-info-icon"><i class="fa-solid fa-house-flood-water text-blue"></i></div>
                    <h3>Consecuencias en la vivienda</h3>
                    <ul class="riesgo-list">
                        <li><i class="fa-solid fa-check text-orange"></i> Desprendimiento de pintura en muros interiores
                            y exteriores</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Atascamiento o dificultad de apertura en
                            ventanas y mamparas</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Hinchamiento, deformación o deterioro en
                            puertas</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Levantamiento y desprendimiento de papel tapiz
                            en muros</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Levantamiento, separación o deterioro en pisos
                            laminados</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Fallas o cortocircuitos en instalaciones
                            eléctricas</li>
                    </ul>
                </div>

                <div class="riesgo-info-card">
                    <div class="riesgo-info-icon"><i class="fa-solid fa-shield-halved text-blue"></i></div>
                    <h3>Medidas de prevención</h3>
                    <ul class="riesgo-list">
                        <li><i class="fa-solid fa-check text-orange"></i> Mejorar la infraestructura de drenaje pluvial
                        </li>
                        <li><i class="fa-solid fa-check text-orange"></i> Fortalecer la planificación urbana sostenible
                        </li>
                        <li><i class="fa-solid fa-check text-orange"></i> Mantenimiento de canales pluviales</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Reforestación de áreas vulnerables</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Educación en gestión del riesgo</li>
                    </ul>
                </div>

                <div class="riesgo-info-card">
                    <div class="riesgo-info-icon"><i class="fa-solid fa-users text-orange"></i></div>
                    <h3>Impacto en Piura (2023)</h3>
                    <ul class="riesgo-list">
                        <li><i class="fa-solid fa-check text-orange"></i> Huaicos, deslizamientos y derrumbes</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Daños en viviendas y medios de vida</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Afectación a infraestructura de salud y
                            educación</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Pérdidas en agricultura y ganadería</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Daños en infraestructura vial y transporte
                        </li>
                    </ul>
                </div>

                <div class="riesgo-info-card riesgo-info-card--full">
                    <div class="riesgo-info-icon"><i class="fa-solid fa-file-contract text-blue"></i></div>
                    <h3>¿Cómo te protege tu seguro hipotecario?</h3>
                    <p>
                        Los seguros hipotecarios cuentan con cobertura <strong>contra todo riesgo</strong> que incluye
                        daños materiales comprobables causados por lluvias intensas e inundaciones. En Grupo Hogar
                        Constructivo evaluamos, sustentamos y gestionamos todo el proceso de activación de tu póliza
                        desde la inspección técnica inicial hasta la obtención de la indemnización que te corresponde,
                        sin costo previo: <strong>solo cobramos si logramos tu indemnización.</strong>
                    </p>
                </div>

            </div>

            <!-- CTA -->
            <div class="riesgo-cta">
                <h3>¿Tu vivienda fue afectada por lluvias o inundaciones?</h3>
                <p>Contáctanos hoy y te asesoramos sin costo inicial.</p>
                <a href="index.php#contacto" class="btn btn-primary btn-large">
                    <i class="fa-solid fa-phone"></i> Solicitar Asesoría Gratuita
                </a>
            </div>

        </div>
    </main>

    <!-- Otros riesgos -->
    <section class="otros-riesgos section bg-light">
        <div class="container text-center">
            <h3 class="mb-4">Otros siniestros que cubrimos</h3>
            <div class="otros-riesgos-grid">
                <a href="sismos.php" class="otro-card">
                    <i class="fa-solid fa-house-crack text-orange"></i>
                    <span>Sismos</span>
                </a>
                <a href="incendios.php" class="otro-card">
                    <i class="fa-solid fa-fire text-orange"></i>
                    <span>Incendios</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer compacto -->
    <footer class="footer-mini">
        <div class="container footer-mini-inner">
            <p>&copy; 2026 GH Constructivo. Todos los derechos reservados.</p>
            <a href="index.php" class="btn btn-primary">
                <i class="fa-solid fa-arrow-left"></i> Volver al inicio
            </a>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>

</html>