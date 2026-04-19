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
    <title>Incendios | Construcvida</title>
    <meta name="description"
        content="Información sobre incendios en el hogar, factores de riesgo, prevención y cobertura de seguros hipotecarios en el Perú.">
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
    <section class="riesgo-hero" style="background-image: url('assets/images/ince1.jpg');">
        <div class="riesgo-hero-overlay"></div>
        <div class="container riesgo-hero-content">
            <div class="riesgo-hero-badge riesgo-hero-badge--orange"><i class="fa-solid fa-fire"></i></div>
            <h1>INCENDIOS</h1>
            <p>Causas, prevención y cobertura de seguros hipotecarios</p>
        </div>
    </section>

    <!-- Contenido principal -->
    <main class="section riesgo-main">
        <div class="container riesgo-container">

            <!-- Breadcrumb -->
            <nav class="breadcrumb-nav" aria-label="Breadcrumb">
                <a href="index.php"><i class="fa-solid fa-house"></i> Inicio</a>
                <span>/</span>
                <span>Incendios</span>
            </nav>

            <!-- Banner apertura -->
            <div class="riesgo-pregunta-banner">
                <i class="fa-solid fa-circle-question"></i>
                <p>¿Estamos realmente preparados y protegidos frente a desastres y fenómenos naturales mediante los
                    seguros de vivienda?</p>
            </div>

            <!-- ── SECCIÓN 1: QUÉ SON LOS INCENDIOS ── -->
            <div class="riesgo-intro">
                <h2>¿Qué son los <span class="text-orange">incendios?</span></h2>
                <p class="riesgo-lead">
                    El incendio es la <strong>propagación libre y no programada del fuego de grandes
                        proporciones</strong>
                    que se desarrolla sin control. Puede presentarse de manera instantánea o gradual, provocando daños
                    materiales, interrupción de los procesos de producción, pérdida de vidas humanas y afectación al
                    ambiente.
                </p>
                <p class="riesgo-lead" style="margin-top:1rem;">
                    El <strong>incendio urbano</strong> es causado principalmente por fallas en las instalaciones
                    eléctricas, fugas de gas, manejo inadecuado de materiales inflamables, velas encendidas y
                    mantenimiento deficiente de tanques contenedores de gas, en instalaciones, casas o edificios con
                    alta concentración de asentamientos humanos.
                </p>
            </div>

            <!-- ── SECCIÓN 2: FACTORES ── -->
            <div class="riesgo-tabla-wrapper">
                <h3 class="riesgo-tabla-titulo">
                    <i class="fa-solid fa-fire-flame-curved text-orange"></i>
                    Factores que provocan un incendio
                </h3>
                <div class="incendio-factores-grid">

                    <div class="incendio-factor-card">
                        <div class="incendio-factor-icon">
                            <i class="fa-solid fa-bolt text-orange"></i>
                        </div>
                        <div class="incendio-factor-body">
                            <h4>Cortocircuito</h4>
                            <p>Las instalaciones eléctricas defectuosas o antiguas están entre las causas más comunes
                                de incendios en el hogar. Es fundamental revisar periódicamente la instalación y
                                asegurarse de que no existan riesgos por mal mantenimiento.</p>
                        </div>
                    </div>

                    <div class="incendio-factor-card">
                        <div class="incendio-factor-icon">
                            <i class="fa-solid fa-fire-burner text-orange"></i>
                        </div>
                        <div class="incendio-factor-body">
                            <h4>Fugas de gas</h4>
                            <p>Una instalación de gas defectuosa puede provocar incendios fácilmente. Un técnico
                                especializado debe inspeccionar tu caldera cada dos años. Si detectas olor a gas,
                                corta el flujo, abre ventanas y llama a un especialista inmediatamente.</p>
                        </div>
                    </div>

                    <div class="incendio-factor-card">
                        <div class="incendio-factor-icon">
                            <i class="fa-solid fa-fire-flame-simple text-orange"></i>
                        </div>
                        <div class="incendio-factor-body">
                            <h4>Velas</h4>
                            <p>Aunque son un elemento decorativo habitual, su uso exige medidas de seguridad. Usa
                                velas en recipientes de cristal, nunca las dejes sin vigilancia y mantenlas alejadas
                                de textiles y objetos inflamables.</p>
                        </div>
                    </div>

                    <div class="incendio-factor-card">
                        <div class="incendio-factor-icon">
                            <i class="fa-solid fa-star text-orange"></i>
                        </div>
                        <div class="incendio-factor-body">
                            <h4>Luces navideñas</h4>
                            <p>Los árboles naturales se calientan con facilidad. El riesgo aumenta con luces
                                decorativas de baja calidad que tienden a sobrecalentarse. Mantén un control estricto
                                y usa productos certificados y de buena calidad.</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Galería de imágenes -->
            <div class="riesgo-galeria">
                <div class="riesgo-galeria-item">
                    <img src="assets/images/inc2.png" alt="Incendio en vivienda">
                    <span class="riesgo-galeria-caption">Daños por incendio en viviendas</span>
                </div>
                <div class="riesgo-galeria-item">
                    <img src="assets/images/inc3.jpg" alt="Prevención de incendios en el hogar">
                    <span class="riesgo-galeria-caption">Prevención y seguridad ante incendios</span>
                </div>
            </div>

            <!-- ── SECCIÓN 3: PREVENCIÓN ── -->
            <div class="riesgo-callout">
                <div class="riesgo-callout-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <div>
                    <h3>¿Cómo prevenir incendios en el hogar y en el trabajo?</h3>
                    <p>
                        Implementar medidas de prevención es fundamental para evitar incendios. La combinación de
                        inspecciones periódicas, almacenamiento adecuado de materiales inflamables y la capacitación
                        de las personas que habitan o trabajan en el espacio son la base para reducir el riesgo.
                    </p>
                </div>
            </div>

            <!-- Grid de tarjetas -->
            <div class="riesgo-grid">

                <div class="riesgo-info-card">
                    <div class="riesgo-info-icon"><i class="fa-solid fa-magnifying-glass text-blue"></i></div>
                    <h3>Medidas de prevención</h3>
                    <ul class="riesgo-list">
                        <li><i class="fa-solid fa-check text-orange"></i> Inspeccionar regularmente instalaciones
                            eléctricas y sistemas de calefacción</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Almacenar materiales inflamables en lugares
                            seguros y ventilados</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Capacitar al personal en medidas de seguridad
                            y extinción</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Instalar detectores de humo que funcionen
                            correctamente</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Establecer rutas de evacuación con puntos de
                            encuentro claros</li>
                    </ul>
                </div>

                <div class="riesgo-info-card">
                    <div class="riesgo-info-icon"><i class="fa-solid fa-house-fire text-orange"></i></div>
                    <h3>Consecuencias en la vivienda</h3>
                    <ul class="riesgo-list">
                        <li><i class="fa-solid fa-check text-orange"></i> Pérdida total o parcial de la estructura del
                            inmueble</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Daños irreparables en bienes y enseres del
                            hogar</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Afectación a servicios básicos (instalaciones
                            eléctricas, gas, agua)</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Riesgo para la vida de los ocupantes</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Pérdidas económicas significativas para la
                            familia</li>
                    </ul>
                </div>

                <div class="riesgo-info-card riesgo-info-card--full">
                    <div class="riesgo-info-icon"><i class="fa-solid fa-file-contract text-blue"></i></div>
                    <h3>¿Cómo te protege tu seguro hipotecario?</h3>
                    <p>
                        Los seguros hipotecarios cuentan con cobertura <strong>contra todo riesgo</strong> que incluye
                        daños materiales comprobables causados por incendios. En Grupo Hogar Constructivo evaluamos,
                        sustentamos y gestionamos todo el proceso de activación de tu póliza desde la inspección
                        técnica inicial hasta la obtención de la indemnización que te corresponde, sin costo previo:
                        <strong>solo cobramos si logramos tu indemnización.</strong>
                    </p>
                </div>

            </div>

            <!-- CTA -->
            <div class="riesgo-cta">
                <h3>¿Tu vivienda fue afectada por un incendio?</h3>
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
                <a href="lluvias.php" class="otro-card">
                    <i class="fa-solid fa-cloud-showers-heavy text-blue"></i>
                    <span>Lluvias e Inundaciones</span>
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