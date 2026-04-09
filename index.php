<?php
// ─────────────────────────────────────────────────────────────────────────────
// index.php — Construcvida | Versión PHP para XAMPP (todas las 3 fases)
// ─────────────────────────────────────────────────────────────────────────────
session_start();

// ── Security Headers HTTP ─────────────────────────────────────────────
hdr('X-Frame-Options: SAMEORIGIN');              // Anti-clickjacking
hdr('X-Content-Type-Options: nosniff');          // Anti-MIME sniffing
hdr('Referrer-Policy: strict-origin-when-cross-origin');
hdr('Permissions-Policy: geolocation=(), camera=(), microphone=()');
hdr("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src 'self' data: https://images.unsplash.com; connect-src 'self' https://formsubmit.co; frame-src 'none'; object-src 'none';");

function hdr(string $h): void
{
    if (!headers_sent())
        header($h);
}

// ── 3.2 Generar token CSRF ────────────────────────────────────────────────────
if (empty($_SESSION['csrf_token'])) {
    session_regenerate_id(true);
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ── Anti-bot: token de tiempo firmado ────────────────────────────────────────
require_once __DIR__ . '/db_config.php';
$form_time = time();
$form_secret = hash_hmac('sha256', (string) $form_time, FORM_SECRET_KEY);

// ── Cargar testimonios de BD (fallback a estáticos) ───────────────────────────
$testimonios_static = [
    [
        'nombre' => 'Carlos Morales',
        'ciudad' => 'Piura, Perú',
        'comentario' => 'Mi casa sufrió graves daños por las lluvias y no sabía cómo proceder con mi seguro. El equipo de Construcvida me asesoró en todo momento y lograron que mi siniestro sea indemnizado rápidamente.'
    ],
    [
        'nombre' => 'Ana López',
        'ciudad' => 'Lima, Perú',
        'comentario' => 'Excelente servicio. Fueron muy transparentes desde el inicio, me explicaron paso a paso y solo cobraron al final cuando logré recuperar la indemnización de mi seguro hipotecario por el sismo.'
    ],
];
$testimonios = $testimonios_static;
$db_activa = false;
try {
    $pdo = getDB();
    $stmt = $pdo->query("SELECT nombre, ciudad, comentario FROM testimonios ORDER BY id DESC LIMIT 2");
    $rows = $stmt->fetchAll();
    if (!empty($rows)) {
        $testimonios = $rows;
        $db_activa = true;
    }
} catch (Exception $e) {
    // BD no disponible — se usan los testimonios estáticos
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Construcvida | Asesoría en Seguros Hipotecarios</title>
    <meta name="description"
        content="Brindamos asesoría técnica y legal especializada para gestionar la indemnización de seguros hipotecarios ante siniestros climáticos y fortuitos en el Perú.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <!-- Header / Navbar -->
    <header class="navbar" id="navbar">
        <div class="container nav-container">
            <a href="#" class="logo">
                <i class="fa-solid fa-city logo-icon"></i>
                <span>GRUPO HOGAR<span class="text-orange"> Constructivo</span></span>
            </a>
            <div class="mobile-menu-btn" id="mobile-btn">
                <i class="fa-solid fa-bars"></i>
            </div>
            <nav class="nav-links" id="nav-links">
                <a href="#hero" data-i18n="nav1">Inicio</a>
                <a href="#nosotros" data-i18n="nav2">Nosotros</a>
                <a href="#seguro" data-i18n="nav3">Seguros</a>
                <a href="#elegirnos" data-i18n="nav4">¿Por qué elegirnos?</a>
                <div class="tool-btn lang-btn nav-tool-btn" id="langBtn" title="Cambiar Idioma">ES</div>
                <div class="tool-btn theme-btn nav-tool-btn" id="themeBtn" title="Modo Oscuro/Claro"><i
                        class="fa-regular fa-moon"></i></div>
                <a href="#contacto" class="btn btn-primary" data-i18n="nav5">Contacto</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="hero" class="hero fade-in-section">
        <div class="hero-bg-carousel">
            <div class="carousel-slide active" style="background-image: url('assets/images/im22.jpeg');"></div>
            <div class="carousel-slide" style="background-image: url('assets/images/im5.jpg');"></div>
            <div class="carousel-slide" style="background-image: url('assets/images/im6.jpg');"></div>
            <div class="carousel-slide" style="background-image: url('assets/images/im9.jpg');"></div>
        </div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <div class="hero-text-box">
                <h1 class="hero-title" data-i18n="hero_title">Especialistas en <br><span class="text-orange">Seguros
                        Hipotecarios</span></h1>
                <p class="hero-subtitle" data-i18n="hero_subtitle">Brindamos asesoría técnica y legal especializada para
                    gestionar la indemnización de seguros hipotecarios ante siniestros climáticos y fortuitos en el
                    Perú.</p>
                <a href="#contacto" class="btn btn-primary btn-large" data-i18n="hero_btn">Proteger mi Patrimonio
                    Ahora</a>
            </div>
        </div>
    </section>

    <!-- Valor Proposition Section -->
    <section id="valor" class="section valor-section fade-in-section">
        <div class="container">
            <div class="section-header text-center">
                <div class="icon-badge"><i class="fa-solid fa-shield-halved"></i></div>
                <h2 data-i18n="val_h2">TU HOGAR EN BUENAS MANOS: <br><span class="text-blue">CONFIANZA, PROTECCIÓN Y
                        RESPALDO PROFESIONAL</span></h2>
            </div>
            <div class="valor-content">
                <div class="valor-text">
                    <p>En contextos adversos provocados por fenómenos naturales que impactan al Perú, como lluvias
                        intensas, inundaciones, deslizamientos, así como eventos sísmicos e incendios que pueden afectar
                        gravemente las viviendas, es fundamental contar con el respaldo adecuado para enfrentar estas
                        situaciones.</p>
                    <p>Nuestra empresa surge con el propósito de brindar asesoría especializada en la gestión de seguros
                        hipotecarios, acompañando a los propietarios durante todo el proceso de activación de su
                        cobertura, garantizando que puedan acceder a la indemnización que les corresponde.</p>

                    <div class="mini-carrusel-contenedor">
                        <div class="mini-carrusel-track">
                            <!-- Set original: 5 imágenes (cubren 530px ≥ ancho columna) -->
                            <img src="assets/images/1.1.png" alt="Proyecto 1" class="img-circulo">
                            <img src="assets/images/l1.png"  alt="Proyecto 2" class="img-circulo">
                            <img src="assets/images/3.1.png" alt="Proyecto 3" class="img-circulo">
                            <img src="assets/images/4.1.png" alt="Proyecto 4" class="img-circulo">
                            <img src="assets/images/1.1.png" alt="Proyecto 1" class="img-circulo">
                            <!-- Duplicado para loop infinito -->
                            <img src="assets/images/l1.png"  alt="Proyecto 2" class="img-circulo">
                            <img src="assets/images/3.1.png" alt="Proyecto 3" class="img-circulo">
                            <img src="assets/images/4.1.png" alt="Proyecto 4" class="img-circulo">
                            <img src="assets/images/1.1.png" alt="Proyecto 1" class="img-circulo">
                            <img src="assets/images/l1.png"  alt="Proyecto 2" class="img-circulo">
                        </div>
                    </div>
                </div>
                <div class="valor-image">
                    <img src="assets/images/im8.png" alt="Hombre de negocios inspeccionando casa"
                        class="oval-image shadow-large">
                </div>
            </div>
        </div>
    </section>

    <!-- Riesgos Section -->
    <section id="riesgos" class="section bg-light text-center fade-in-section">
        <div class="container">
            <div class="section-header">
                <h2 data-i18n="riesgos_h2">Protegemos tu hogar contra <br><span class="text-orange">siniestros
                        climáticos y fortuitos</span></h2>
            </div>
            <!-- Carrusel automático sin flechas -->
            <div class="riesgos-slider">
                <div class="riesgos-track-auto">
                    <!-- Originales con enlace semántico (Fase 1.1) -->
                    <a href="https://www.senamhi.gob.pe/" target="_blank" rel="noopener noreferrer"
                        class="riesgo-card-link" title="Alertas meteorológicas - SENAMHI Perú">
                        <div class="riesgo-card">
                            <div class="circle-img-container">
                                <img src="assets/images/im10.jpg" alt="Lluvias">
                            </div>
                            <h3 data-i18n="r1"><i class="fa-solid fa-droplet text-blue"></i> LLUVIAS</h3>
                        </div>
                    </a>
                    <a href="https://www.igp.gob.pe/" target="_blank" rel="noopener noreferrer" class="riesgo-card-link"
                        title="Información sísmica - IGP Perú">
                        <div class="riesgo-card">
                            <div class="circle-img-container">
                                <img src="assets/images/sis1.jpg" alt="Sismos">
                            </div>
                            <h3 data-i18n="r2"><i class="fa-solid fa-house-crack text-orange"></i> SISMOS</h3>
                        </div>
                    </a>
                    <a href="https://www.cenepred.gob.pe/" target="_blank" rel="noopener noreferrer"
                        class="riesgo-card-link" title="Gestión de riesgo de desastres - CENEPRED">
                        <div class="riesgo-card">
                            <div class="circle-img-container">
                                <img src="assets/images/im11.jpg" alt="Inundaciones">
                            </div>
                            <h3 data-i18n="r3"><i class="fa-solid fa-water text-blue"></i> INUNDACIONES</h3>
                        </div>
                    </a>
                    <a href="http://www.bomberosperu.gob.pe/" target="_blank" rel="noopener noreferrer"
                        class="riesgo-card-link" title="Prevención de incendios - Bomberos Voluntarios del Perú">
                        <div class="riesgo-card">
                            <div class="circle-img-container">
                                <img src="assets/images/ince1.jpg" alt="Incendios">
                            </div>
                            <h3 data-i18n="r4"><i class="fa-solid fa-fire text-orange"></i> INCENDIOS</h3>
                        </div>
                    </a>


                    <a href="https://www.senamhi.gob.pe/" target="_blank" rel="noopener noreferrer"
                        class="riesgo-card-link" title="Alertas meteorológicas - SENAMHI Perú">
                        <div class="riesgo-card">
                            <div class="circle-img-container"><img src="assets/images/im10.jpg" alt="Lluvias"></div>
                            <h3><i class="fa-solid fa-droplet text-blue"></i> LLUVIAS</h3>
                        </div>
                    </a>
                    <a href="https://www.igp.gob.pe/" target="_blank" rel="noopener noreferrer" class="riesgo-card-link"
                        title="Información sísmica - IGP Perú">
                        <div class="riesgo-card">
                            <div class="circle-img-container"><img src="assets/images/sis1.jpg" alt="Sismos"></div>
                            <h3><i class="fa-solid fa-house-crack text-orange"></i> SISMOS</h3>
                        </div>
                    </a>
                    <a href="https://www.cenepred.gob.pe/" target="_blank" rel="noopener noreferrer"
                        class="riesgo-card-link" title="Gestión de riesgo de desastres - CENEPRED">
                        <div class="riesgo-card">
                            <div class="circle-img-container"><img src="assets/images/im11.jpg" alt="Inundaciones">
                            </div>
                            <h3><i class="fa-solid fa-water text-blue"></i> INUNDACIONES</h3>
                        </div>
                    </a>
                    <a href="http://www.bomberosperu.gob.pe/" target="_blank" rel="noopener noreferrer"
                        class="riesgo-card-link" title="Prevención de incendios - Bomberos Voluntarios del Perú">
                        <div class="riesgo-card">
                            <div class="circle-img-container"><img src="assets/images/ince1.jpg" alt="Incendios"></div>
                            <h3><i class="fa-solid fa-fire text-orange"></i> INCENDIOS</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Seguro Hipotecario Section -->
    <section id="seguro" class="section seguro-section fade-in-section">
        <div class="container container-flex">
            <div class="seguro-image-col">
                <!-- Carrusel de imágenes — agrega tus fotos en assets/images/ y actualiza los src -->
                <div class="seguro-carousel shadow-large" id="seguroCarousel">
                    <img src="assets/images/im22.jpeg" alt="Asesoría en seguros hipotecarios" class="seguro-slide active">
                    <img src="assets/images/im23.jpeg" alt="Gestión de siniestros" class="seguro-slide">
                    <img src="assets/images/im24.jpeg" alt="Protección de vivienda" class="seguro-slide">
                    <img src="assets/images/im25.jpeg" alt="Inspección de daños" class="seguro-slide">
                    <img src="assets/images/im26.jpeg" alt="Equipo de asesores" class="seguro-slide">
                    <img src="assets/images/im27.jpeg" alt="Tramitación de seguros" class="seguro-slide">
                </div>
            </div>
            <div class="seguro-text-col">
                <h2 class="section-title" data-i18n="seguro_h2">¿CUENTAS CON UN <br><span class="text-orange">SEGURO
                        HIPOTECARIO?</span></h2>
                <div class="card-text">
                    <p class="highlight-text">Los seguros hipotecarios cuentan con un seguro contra todo riesgo que
                        brindan cobertura frente a siniestros climáticos y eventos fortuitos como sismos, lluvias
                        intensas, inundaciones e incendios, siempre que estos generen daños materiales comprobables en
                        la vivienda.</p>
                    <hr>
                    <p><strong>En este contexto, nuestra empresa se encarga de evaluar, sustentar y gestionar todo el
                            proceso asegurando</strong>
                </div>
            </div>
        </div>
    </section>

    <!-- Nosotros (Visión, Misión, Valores) -->
    <section id="nosotros" class="section bg-light fade-in-section">
        <div class="container">
            <div class="nosotros-top">
                <div class="nosotros-box">
                    <div class="icon-header">
                        <i class="fa-solid fa-heart text-orange"></i>
                        <h3>Nuestra visión</h3>
                    </div>
                    <p>Ser una empresa líder en la gestión de indemnizaciones de seguros hipotecarios, reconocida por su
                        eficiencia, transparencia y compromiso, brindando seguridad y confianza a nuestros clientes en
                        la protección de su vivienda y patrimonio.</p>
                </div>
                <div class="nosotros-box">
                    <div class="icon-header">
                        <i class="fa-solid fa-house-flag text-blue"></i>
                        <h3>Nuestra misión</h3>
                    </div>
                    <p>Brindar asesoría especializada y acompañamiento integral, con seguridad y confianza, a
                        propietarios de viviendas con seguro hipotecario, a través de un equipo de profesionales,
                        gestionando de manera eficiente la activación del seguro y la obtención de la indemnización ante
                        siniestros cubiertos, protegiendo así su patrimonio y bienestar.</p>
                </div>
            </div>
            <div class="valores-container mt-5">
                <div class="icon-header center">
                    <i class="fa-solid fa-star text-orange"></i>
                    <h2 data-i18n="nosotros_h2">Empresa y Valores</h2>
                </div>
                <div class="valores-grid">
                    <div class="valor-item"><i class="fa-regular fa-handshake"></i>
                        <h4>Confianza</h4>
                        <p>Actuamos con honestidad y transparencia, generando seguridad en cada etapa.</p>
                    </div>
                    <div class="valor-item"><i class="fa-regular fa-circle-dot"></i>
                        <h4>Compromiso</h4>
                        <p>Nos involucramos plenamente buscando el mejor resultado para el cliente.</p>
                    </div>
                    <div class="valor-item"><i class="fa-regular fa-id-badge"></i>
                        <h4>Profesionalismo</h4>
                        <p>Trabajamos con criterio técnico y responsabilidad en cada gestión.</p>
                    </div>
                    <div class="valor-item"><i class="fa-regular fa-eye"></i>
                        <h4>Transparencia</h4>
                        <p>Brindamos información clara, veraz y oportuna en todo momento.</p>
                    </div>
                    <div class="valor-item"><i class="fa-regular fa-clock"></i>
                        <h4>Eficiencia</h4>
                        <p>Gestionamos de manera ágil y ordenada optimizando los tiempos.</p>
                    </div>
                    <div class="valor-item"><i class="fa-regular fa-scale-balanced"></i>
                        <h4>Responsabilidad</h4>
                        <p>Asumimos cada proceso garantizando un servicio de máxima calidad.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Por Qué Elegirnos (Parallax + Ticker) -->
    <section id="elegirnos" class="section dark-section parallax-section fade-in-section">
        <div class="container">
            <div class="elegirnos-grid">
                <div class="elegirnos-content">
                    <h2 class="text-white" data-i18n="elegir_h2">¿POR QUÉ CONFIAR <br><span class="text-orange">EN
                            NOSOTROS?</span></h2>
                    <p class="lead-white">Porque brindamos un servicio integral basado en la confianza, el
                        profesionalismo y la eficiencia, acompañando a nuestros clientes en todo el proceso de
                        activación de su seguro hipotecario hasta la obtención de su indemnización.</p>
                    <ul class="diferenciadores-list">
                        <li><i class="fa-solid fa-check text-orange"></i> Equipo especializado de ingenieros,
                            arquitectos y abogados que garantizan un sustento técnico y legal sólido.</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Acompañamiento completo, desde la evaluación
                            del daño hasta la gestión final del trámite.</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Transparencia y seguridad en cada etapa del
                            proceso.</li>
                        <li><i class="fa-solid fa-check text-orange"></i> Modelo de pago justo, donde solo cobramos si
                            el cliente obtiene su indemnización.</li>
                    </ul>
                    <p class="compromiso-text"><strong>Nuestro compromiso es proteger tu vivienda, tu patrimonio y tu
                            tranquilidad.</strong></p>
                </div>
                <!-- Ticker grande en el lado derecho -->
                <div class="elegirnos-ticker-panel" aria-label="Tu hogar merece: Seguridad, Confianza, Bienestar">
                    <span class="ticker-label-top">TU HOGAR MERECE:</span>
                    <div class="big-ticker-wrapper">
                        <div class="big-ticker-track">
                            <span class="big-ticker-word">SEGURIDAD</span>
                            <span class="big-ticker-word">CONFIANZA</span>
                            <span class="big-ticker-word">BIENESTAR</span>
                            <span class="big-ticker-word" aria-hidden="true">SEGURIDAD</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof: Logos -->
    <section class="section bg-light text-center fade-in-section pb-4 pt-0"
        style="border-top: 1px solid var(--bg-lines); padding-top: 40px !important;">
        <div class="container overflow-hidden">
            <h4 class="text-muted mb-4" data-i18n="logos_h4"
                style="font-family: var(--font-body); font-weight: 500; font-size: 1.1rem;">Gestionamos pólizas de:</h4>
            <div class="logos-slider">
                <div class="logos-track">
                    <div class="logo-item"><i class="fa-solid fa-car-burst text-muted"></i> MAPFRE</div>
                    <div class="logo-item"><i class="fa-solid fa-umbrella text-muted"></i> PACÍFICO</div>
                    <div class="logo-item"><i class="fa-solid fa-shield-virus text-muted"></i> RÍMAC</div>
                    <div class="logo-item"><i class="fa-solid fa-plus text-muted"></i> LA POSITIVA</div>
                    <div class="logo-item"><i class="fa-solid fa-building-shield text-muted"></i> INTERSEGURO</div>
                    <div class="logo-item"><i class="fa-solid fa-car-burst text-muted"></i> MAPFRE</div>
                    <div class="logo-item"><i class="fa-solid fa-umbrella text-muted"></i> PACÍFICO</div>
                    <div class="logo-item"><i class="fa-solid fa-shield-virus text-muted"></i> RÍMAC</div>
                    <div class="logo-item"><i class="fa-solid fa-plus text-muted"></i> LA POSITIVA</div>
                    <div class="logo-item"><i class="fa-solid fa-building-shield text-muted"></i> INTERSEGURO</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof: Testimonios (dinámicos desde BD) -->
    <section class="section testimonios-section fade-in-section">
        <div class="container">
            <div class="section-header" style="text-align: center; border: none; padding: 0;">
                <h2 data-i18n="testimonio_h2">Lo que dicen <br><span class="text-orange">nuestros clientes</span></h2>
            </div>

            <!-- Grid de testimonios – cargados desde BD o fallback estático -->
            <div class="testimonios-grid" id="testimonios-grid">
                <?php foreach ($testimonios as $t): ?>
                    <div class="testimonio-card">
                        <div class="stars">
                            <i class="fa-solid fa-star text-orange"></i><i class="fa-solid fa-star text-orange"></i>
                            <i class="fa-solid fa-star text-orange"></i><i class="fa-solid fa-star text-orange"></i>
                            <i class="fa-solid fa-star text-orange"></i>
                        </div>
                        <p class="testimonio-text">"<?= htmlspecialchars($t['comentario'], ENT_QUOTES, 'UTF-8') ?>"</p>
                        <div class="testimonio-author">
                            <strong><?= htmlspecialchars($t['nombre'], ENT_QUOTES, 'UTF-8') ?></strong>
                            <span><?= htmlspecialchars($t['ciudad'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- ── Formulario de nuevo testimonio (Fase 3) ── -->
            <div class="testimonio-form-wrapper mt-5">
                <div class="testimonio-form-header">
                    <i class="fa-regular fa-comment-dots text-orange"></i>
                    <h3>¿Eres cliente? Comparte tu experiencia</h3>
                </div>
                <form id="testimonioForm" class="contact-form testimonio-form" novalidate>
                    <!-- 3.2 CSRF Token -->
                    <input type="hidden" name="csrf_token"
                        value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                    <!-- Anti-bot: token de tiempo firmado -->
                    <input type="hidden" name="form_timestamp" value="<?= $form_time ?>">
                    <input type="hidden" name="form_secret" value="<?= $form_secret ?>">
                    <!-- Anti-bot: honeypot (invisible para humanos, visible para bots) -->
                    <div class="hp-field" aria-hidden="true">
                        <label for="website">Dejar en blanco</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="testimonio-form-grid">
                        <div class="form-group">
                            <label for="t_nombre">Nombre Completo <span class="req">*</span></label>
                            <input type="text" id="t_nombre" name="t_nombre" placeholder="Tu nombre" maxlength="100"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="t_ciudad">Ciudad / Región</label>
                            <input type="text" id="t_ciudad" name="t_ciudad" placeholder="Lima, Perú" maxlength="100">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="t_comentario">Tu testimonio <span class="req">*</span></label>
                        <textarea id="t_comentario" name="t_comentario" rows="4"
                            placeholder="Cuéntanos cómo te ayudamos con tu seguro hipotecario... (10-500 caracteres)"
                            maxlength="500" required></textarea>
                        <small class="char-count"><span id="charCount">0</span>/500 caracteres</small>
                    </div>
                    <button type="submit" class="btn btn-primary" id="testimonioSubmitBtn">
                        <i class="fa-regular fa-paper-plane"></i> Enviar Testimonio
                    </button>
                    <div id="testimonioMsg" class="form-feedback" role="alert" aria-live="polite"></div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer / Contacto -->
    <footer id="contacto" class="footer fade-in-section">
        <div class="container footer-content">
            <div class="footer-info">
                <h2 data-i18n="footer_h2">ENFOQUE DE <span class="text-orange">EMPRESA</span></h2>
                <p>En este contexto, nuestra empresa se convierte en tu aliado estratégico, brindando asesoría técnica y
                    legal especializada, y acompañándote en cada etapa del proceso para garantizar la correcta
                    activación de tu seguro y la obtención de la indemnización que te corresponde.</p>
                <p><strong>Nos encargamos de todo el proceso con eficiencia, transparencia y compromiso, protegiendo tu
                        patrimonio y brindándote la tranquilidad que necesitas.</strong></p>
                <div class="contact-methods mt-4">
                    <p><i class="fa-solid fa-phone text-orange"></i> +51 999 999 999</p>
                    <p><i class="fa-solid fa-envelope text-orange"></i> contacto@ghconstructivo.pe</p>
                    <p><i class="fa-solid fa-location-dot text-orange"></i> Lima, Perú</p>
                </div>
            </div>
            <div class="footer-form-container shadow-large">
                <h3 class="text-center mb-4" data-i18n="form_h3">Solicita Asesoría <span
                        class="text-orange">Gratuita</span></h3>

                <form id="contactForm" class="contact-form">

                    <!-- Campo trampa (Honeypot). Si un bot lo llena, el servidor lo rechaza silenciosamente -->
                    <div style="display:none;" aria-hidden="true">
                        <label for="seguridad_bot">Deja esto en blanco</label>
                        <input type="text" name="seguridad_bot" id="seguridad_bot" tabindex="-1">
                    </div>

                    <!-- Tokens CSRF y Anti-Bot de Tiempo -->
                    <input type="hidden" name="csrf_token"
                        value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="form_timestamp" value="<?= $form_time ?>">
                    <input type="hidden" name="form_secret" value="<?= $form_secret ?>">

                    <div class="form-group">
                        <label for="nombre">Nombre Completo</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono de Contacto</label>
                        <input type="tel" id="telefono" name="telefono"
                            placeholder="Ingresa tu número celular (9 dígitos)" pattern="[0-9]{9}" minlength="9"
                            maxlength="9" title="Debe contener exactamente 9 números" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" id="correo" name="correo" placeholder="correo@ejemplo.com" required>
                    </div>
                    <div class="form-group">
                        <label for="siniestro">Tipo de Siniestro</label>
                        <select id="siniestro" name="siniestro" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="Lluvia">Lluvia Intensa</option>
                            <option value="Sismo">Sismo</option>
                            <option value="Inundacion">Inundación</option>
                            <option value="Incendio">Incendio</option>
                            <option value="Huaico">Huaico / Deslizamiento</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mensaje">Mensaje / Descripción del Daño</label>
                        <textarea id="mensaje" name="mensaje" rows="4"
                            placeholder="Describe brevemente el daño ocurrido en la vivienda..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" data-i18n="form_btn"
                        id="contactSubmitBtn">Solicitar Mi Asesoría</button>
                    <!-- Alerta para mostrar éxito o error silencioso -->
                    <div id="contactMsg"
                        style="display:none; margin-top: 15px; padding: 12px; border-radius: 4px; font-weight: bold; text-align: center;">
                    </div>
                </form>
            </div>
        </div>
        </div>
        <div class="footer-legal">
            <div class="container legal-flex">
                <div class="legal-info">
                    <p><strong>GH Constructivo S.A.C.</strong> | RUC: 20123456789</p>
                    <p>Av. Principal 123, Oficina 405, Lima, Perú</p>
                </div>
                <div class="legal-links">
                    <a href="#">Políticas de Privacidad</a>
                    <a href="#">Términos y Condiciones</a>
                    <a href="#" class="libro-reclamaciones">
                        <i class="fa-solid fa-book-open"></i> Libro de Reclamaciones
                    </a>
                </div>
            </div>
            <div class="copyright-line">
                <p>&copy; 2026 GH Constructivo. Todos los derechos reservados. Confianza que perdura, calidad que se
                    construye.</p>
            </div>
        </div>
    </footer>

    <!-- Floating tools (hidden, kept for backwards compat) -->
    <div class="floating-tools" style="display:none;">
        <div class="tool-btn lang-btn" id="langBtnOld">ES</div>
        <div class="tool-btn theme-btn" id="themeBtnOld"><i class="fa-regular fa-moon"></i></div>
    </div>

    <!-- Scroll Top Button -->
    <div class="scroll-top shadow-large" id="scrollTop" title="Volver Arriba">
        <i class="fa-solid fa-arrow-up"></i>
    </div>

    <!-- Botón Whatsapp -->
    <a href="https://wa.me/51999999999" target="_blank" class="whatsapp-btn shadow-large">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <!-- Custom JS -->
    <script src="js/translations.js"></script>
    <script src="js/main.js"></script>
    <script>
        // ── Fase 3: Lógica del formulario de testimonios (AJAX) ──────────────────
        (function () {
            const form = document.getElementById('testimonioForm');
            const btn = document.getElementById('testimonioSubmitBtn');
            const msgBox = document.getElementById('testimonioMsg');
            const textarea = document.getElementById('t_comentario');
            const counter = document.getElementById('charCount');

            if (!form) return;

            // Contador de caracteres en tiempo real
            textarea.addEventListener('input', () => {
                counter.textContent = textarea.value.length;
            });

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Enviando...';
                msgBox.className = 'form-feedback';
                msgBox.textContent = '';

                try {
                    const res = await fetch('procesar_testimonio.php', {
                        method: 'POST',
                        body: new FormData(form),
                    });
                    const data = await res.json();

                    msgBox.textContent = data.msg;
                    if (data.ok) {
                        msgBox.classList.add('feedback-ok');
                        form.reset();
                        counter.textContent = '0';
                        // Refrescar la grilla de testimonios vía AJAX
                        setTimeout(refreshTestimonios, 800);
                    } else {
                        msgBox.classList.add('feedback-err');
                    }
                } catch (_) {
                    msgBox.textContent = 'Error de red. Verifica tu conexión e inténtalo de nuevo.';
                    msgBox.classList.add('feedback-err');
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-regular fa-paper-plane"></i> Enviar Testimonio';
                }
            });

            async function refreshTestimonios() {
                try {
                    const res = await fetch('get_testimonios.php');
                    const data = await res.json();
                    if (!data.ok || data.data.length === 0) return;

                    const grid = document.getElementById('testimonios-grid');
                    grid.innerHTML = data.data.map(t => `
                    <div class="testimonio-card">
                        <div class="stars">
                            ${'<i class="fa-solid fa-star text-orange"></i>'.repeat(5)}
                        </div>
                        <p class="testimonio-text">"${escHtml(t.comentario)}"</p>
                        <div class="testimonio-author">
                            <strong>${escHtml(t.nombre)}</strong>
                            <span>${escHtml(t.ciudad || '')}</span>
                        </div>
                    </div>`).join('');
                } catch (_) { /* silencioso */ }
            }

            function escHtml(str) {
                const d = document.createElement('div');
                d.appendChild(document.createTextNode(str));
                return d.innerHTML;
            }
        })();
    </script>
</body>

</html>