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
    <title>Sismos | Construcvida</title>
    <meta name="description"
        content="Información sobre cobertura de seguros hipotecarios ante sismos y daños estructurales en viviendas en el Perú.">
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

    <!-- Hero del riesgo -->
    <section class="riesgo-hero" style="background-image: url('assets/images/sis1.jpg');">
        <div class="riesgo-hero-overlay"></div>
        <div class="container riesgo-hero-content">
            <div class="riesgo-hero-badge"><i class="fa-solid fa-house-crack"></i></div>
            <h1>SISMOS</h1>
            <p>Cobertura, daños estructurales y gestión de seguros hipotecarios</p>
        </div>
    </section>

    <!-- Contenido principal -->
    <main class="section riesgo-main">
        <div class="container riesgo-container">

            <!-- Breadcrumb -->
            <nav class="breadcrumb-nav" aria-label="Breadcrumb">
                <a href="index.php"><i class="fa-solid fa-house"></i> Inicio</a>
                <span>/</span>
                <span>Sismos</span>
            </nav>

            <!-- Pregunta apertura -->
            <div class="riesgo-pregunta-banner">
                <i class="fa-solid fa-circle-question"></i>
                <p>¿Estamos realmente preparados y protegidos frente a desastres y fenómenos naturales mediante los
                    seguros de vivienda?</p>
            </div>

            <!-- Introducción -->
            <div class="riesgo-intro">
                <h2>¿Qué son los <span class="text-orange">sismos?</span></h2>
                <p class="riesgo-lead">
                    Los sismos son movimientos bruscos de la corteza terrestre originados por la liberación repentina de
                    energía acumulada en las placas tectónicas. Son las vibraciones de la tierra ocasionadas por la
                    propagación, en el interior o en la superficie de ésta, de varios tipos de ondas. <strong>Terremoto
                        o temblor son sinónimos de la palabra sismo.</strong>
                </p>
                <p class="riesgo-lead" style="margin-top:1rem;">
                    Los sismos ocurren porque la tierra está cubierta por una capa rocosa conocida como
                    <strong>litosfera</strong> (con espesor de hasta 100 km), fragmentada en grandes porciones llamadas
                    <strong>placas tectónicas</strong>. La movilidad de éstas genera esfuerzos de fricción en sus
                    bordes; cuando dichos esfuerzos sobrepasan la resistencia de las rocas, ocurre una ruptura violenta
                    y la liberación repentina de la energía acumulada.
                </p>
            </div>

            <!-- ¿El Perú es sísmico? -->
            <div class="riesgo-callout">
                <div class="riesgo-callout-icon"><i class="fa-solid fa-earth-americas"></i></div>
                <div>
                    <h3>¿El Perú es un país sísmico?</h3>
                    <p>
                        Sí. El Perú se ubica en el <strong>Cinturón de Fuego del Pacífico</strong>, zona donde se
                        concentra aproximadamente el <strong>85 % de la actividad sísmica a nivel mundial</strong>. Los
                        movimientos telúricos que se presentan principalmente en la región costera se deben a la
                        interacción entre las <strong>placas de Nasca y Sudamericana</strong>, proceso que libera
                        grandes cantidades de energía y se manifiesta en fuertes sacudidas del suelo capaces de
                        ocasionar daños materiales, pérdidas humanas y afectaciones a otros seres vivos.
                    </p>
                </div>
            </div>

            <!-- Galería de imágenes -->
            <div class="riesgo-galeria">
                <div class="riesgo-galeria-item">
                    <img src="assets/images/sismo1.png" alt="Daños por sismo en viviendas">
                    <span class="riesgo-galeria-caption">Daños estructurales en viviendas por sismo</span>
                </div>
                <div class="riesgo-galeria-item">
                    <img src="assets/images/sismo2.png" alt="Colapso de edificaciones por sismo">
                    <span class="riesgo-galeria-caption">Colapso de edificaciones por actividad sísmica</span>
                </div>
            </div>

            <!-- Grid de tarjetas -->
            <div class="riesgo-grid">

                <div class="riesgo-info-card">
                    <div class="riesgo-info-icon"><i class="fa-solid fa-triangle-exclamation text-orange"></i></div>
                    <h3>Principales causas</h3>
                    <ul class="riesgo-list">
                        <li><i class="fa-solid fa-check text-orange"></i> Acumulación de esfuerzos tectónicos entre
                            placas</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Fallas geológicas activas en el subsuelo</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Actividad volcánica en zonas específicas</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Interacción de las placas de Nasca y
                            Sudamericana</li>
                    </ul>
                </div>

                <div class="riesgo-info-card">
                    <div class="riesgo-info-icon"><i class="fa-solid fa-house-crack text-orange"></i></div>
                    <h3>Consecuencias y daños</h3>
                    <ul class="riesgo-list">
                        <li><i class="fa-solid fa-check text-orange"></i> Agrietamientos y fisuramientos en muros
                            interiores y exteriores de las viviendas
                        </li>
                        <li><i class="fa-solid fa-check text-orange"></i> Fisuras y agrietamiento en losas aligeradas
                        </li>
                        <li><i class="fa-solid fa-check text-orange"></i> Descuadre o desalineación de puertas, ventanas
                            y mamparas
                        </li>
                        <li><i class="fa-solid fa-check text-orange"></i> Desprendimiento, fisuración o ruptura de
                            cerámicos, porcelanatos y pisos concreto (pulidos, frotachados)</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Afectación en instalaciones eléctricas y
                            sanitarias, como desprendimientos y fallas en su funcionamiento</li>
                    </ul>
                </div>

                <div class="riesgo-info-card">
                    <div class="riesgo-info-icon"><i class="fa-solid fa-shield-halved text-blue"></i></div>
                    <h3>Medidas de prevención</h3>
                    <ul class="riesgo-list">
                        <li><i class="fa-solid fa-check text-orange"></i> Implementar diseños estructurales
                            sismorresistentes</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Realizar estudios de suelos antes de construir
                        </li>
                        <li><i class="fa-solid fa-check text-orange"></i> Cumplir con las normativas técnicas vigentes
                        </li>
                        <li><i class="fa-solid fa-check text-orange"></i> Contar con planes de evacuación y simulacros
                            periódicos</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Implementar sistemas de alerta temprana</li>
                    </ul>
                </div>

                <div class="riesgo-info-card">
                    <div class="riesgo-info-icon"><i class="fa-solid fa-bag-shopping text-blue"></i></div>
                    <h3>Recomendaciones del INDECI</h3>
                    <ul class="riesgo-list">
                        <li><i class="fa-solid fa-check text-orange"></i> Mantener la calma y evitar el pánico ante un
                            sismo</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Elaborar un plan de evacuación familiar</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Verificar vías de salida y zonas de seguridad
                            internas y externas</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Tener siempre lista la <strong>mochila de
                                emergencia</strong></li>
                    </ul>
                </div>

                <div class="riesgo-info-card riesgo-info-card--full">
                    <div class="riesgo-info-icon"><i class="fa-solid fa-file-contract text-blue"></i></div>
                    <h3>¿Cómo te protege tu seguro hipotecario?</h3>
                    <p>
                        Los seguros hipotecarios cuentan con cobertura <strong>contra todo riesgo</strong> que incluye
                        daños materiales comprobables causados por sismos. En Grupo Hogar Constructivo evaluamos,
                        sustentamos y gestionamos todo el proceso de activación de tu póliza desde la inspección
                        técnica inicial hasta la obtención de la indemnización que te corresponde, sin costo previo:
                        <strong>solo cobramos si logramos tu indemnización.</strong>
                    </p>
                </div>

            </div>

            <!-- CTA -->
            <div class="riesgo-cta">
                <h3>¿Tu vivienda fue afectada por un sismo?</h3>
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
                <a href="lluvias.php" class="otro-card">
                    <i class="fa-solid fa-cloud-showers-heavy text-blue"></i>
                    <span>Lluvias e Inundaciones</span>
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