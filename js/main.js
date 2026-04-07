document.addEventListener("DOMContentLoaded", () => {
    // 1. Mobile Menu Toggle
    const mobileBtn = document.getElementById("mobile-btn");
    const navLinks = document.getElementById("nav-links");

    if (mobileBtn && navLinks) {
        mobileBtn.addEventListener("click", () => {
            navLinks.classList.toggle("active");
        });
    }

    // Cerrar menú al hacer clic en un enlace
    const links = document.querySelectorAll(".nav-links a");
    links.forEach(link => {
        link.addEventListener("click", () => {
            if (navLinks.classList.contains("active")) {
                navLinks.classList.remove("active");
            }
        });
    });

    // 2. Sticky Navbar Effect (add shadow on scroll)
    const navbar = document.getElementById("navbar");
    window.addEventListener("scroll", () => {
        if (window.scrollY > 50) {
            navbar.style.padding = "10px 0";
            navbar.style.boxShadow = "var(--shadow-large)";
        } else {
            navbar.style.padding = "15px 0";
            navbar.style.boxShadow = "var(--shadow-soft)";
        }
    });

    // 3. Fade-In on Scroll Intersections
    const fadeSections = document.querySelectorAll('.fade-in-section');

    const appearOptions = {
        threshold: 0.15,
        rootMargin: "0px 0px -50px 0px"
    };

    const appearOnScroll = new IntersectionObserver(function (entries, observer) {
        entries.forEach(entry => {
            if (!entry.isIntersecting) {
                return;
            } else {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, appearOptions);

    fadeSections.forEach(section => {
        appearOnScroll.observe(section);
    });

    // 4. Formulario de Contacto — DOBLE ENVÍO (DB Local + FormSubmit)
    const contactForm = document.getElementById("contactForm");
    if (contactForm) {
        const submitBtn = document.getElementById('contactSubmitBtn');
        const msgBox = document.getElementById('contactMsg');

        contactForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            // 1. Validaciones básicas en cliente
            const nombre = contactForm.nombre.value.trim();
            const telefono = contactForm.telefono.value.trim();
            const correo = contactForm.correo.value.trim();
            const siniestro = contactForm.siniestro.value;
            const mensaje = contactForm.mensaje.value.trim();
            const honeypot = contactForm.seguridad_bot.value;

            // Validación estricta de 9 dígitos para Perú
            if (!/^[0-9]{9}$/.test(telefono)) {
                msgBox.style.display = "block";
                msgBox.style.backgroundColor = "#fff3cd"; // Amarillo/Alerta
                msgBox.style.color = "#856404";
                msgBox.style.border = "1px solid #ffeeba";
                msgBox.innerText = "⚠️ Por favor, ingresa un número de celular válido de exactamente 9 dígitos.";
                setTimeout(() => { msgBox.style.display = "none"; }, 4000);
                return; // Bloquea el envío
            }

            // Bloquear botón mientras procesa
            submitBtn.innerText = "Procesando...";
            submitBtn.disabled = true;
            msgBox.style.display = "none";

            try {
                // PASO 1: Guardar en Base de Datos Local (Seguridad anti-pérdida)
                // InfinityFree bloquea la subida de mail(), pero sí acepta Guardar a DB.
                const formData = new FormData(contactForm);
                await fetch('enviar.php', { method: 'POST', body: formData });

                // PASO 2: Enviar correo vía FormSubmit (Puente Externo Seguro)
                // Usamos fetch AJAX directo para que la página no se recargue jamás.
                if (!honeypot) {
                    await fetch('https://formsubmit.co/ajax/9fcc32f427c0e84f6758eb3ffa47b3ea', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            Atención: "NUEVA SOLICITUD DE ASESORÍA",
                            Nombre: nombre,
                            Teléfono: telefono,
                            Correo: correo || "No proporcionó",
                            Siniestro: siniestro,
                            Mensaje_Del_Cliente: mensaje
                        })
                    });
                }

                // MOSTRAR ÉXITO FINAL
                msgBox.style.display = "block";
                msgBox.style.backgroundColor = "#d4edda";
                msgBox.style.color = "#155724";
                msgBox.style.border = "1px solid #c3e6cb";
                msgBox.innerText = "¡Mensaje enviado con éxito! Nos comunicaremos contigo en breve.";

                // Limpiar todo después de un envío perfecto
                contactForm.reset();

            } catch (error) {
                // MOSTRAR ERROR SI ALGO EXPLOTA
                msgBox.style.display = "block";
                msgBox.style.backgroundColor = "#f8d7da";
                msgBox.style.color = "#721c24";
                msgBox.style.border = "1px solid #f5c6cb";
                msgBox.innerText = "Ocurrió un error de conexión, intenta de nuevo o comunícate vía WhatsApp.";
            } finally {
                submitBtn.innerText = "Solicitar Mi Asesoría";
                submitBtn.disabled = false;

                // Ocultar mensaje verde después de 7 segundos
                setTimeout(() => { msgBox.style.display = "none"; }, 7000);
            }
        });
    }
    const slides = document.querySelectorAll('.carousel-slide');
    if (slides.length > 0) {
        let currentSlide = 0;
        setInterval(() => {
            // Eliminar active de la diapositiva actual
            slides[currentSlide].classList.remove('active');

            // Avanzar a la siguiente (volviendo a 0 si llegamos al final)
            currentSlide = (currentSlide + 1) % slides.length;

            // Hacer visible la siguiente
            slides[currentSlide].classList.add('active');
        }, 2000); // 2000 = 2 segundos solicitados
    }

    // 6. Floating Controls: Scroll to Top
    const scrollTopBtn = document.getElementById('scrollTop');
    if (scrollTopBtn) {
        window.addEventListener('scroll', () => {
            // Aparece solo tras 600px de scroll — limpia la pantalla en visitas cortas
            if (window.scrollY > 600) {
                scrollTopBtn.classList.add('visible');
            } else {
                scrollTopBtn.classList.remove('visible');
            }
        });

        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // 7. Theme Toggle (Dark Mode)
    const themeBtn = document.getElementById('themeBtn');
    if (themeBtn) {
        // Load preference
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-theme');
            themeBtn.innerHTML = '<i class="fa-regular fa-sun"></i>';
        }

        themeBtn.addEventListener('click', () => {
            document.body.classList.toggle('dark-theme');
            const isDark = document.body.classList.contains('dark-theme');

            if (isDark) {
                localStorage.setItem('theme', 'dark');
                themeBtn.innerHTML = '<i class="fa-regular fa-sun"></i>';
            } else {
                localStorage.setItem('theme', 'light');
                themeBtn.innerHTML = '<i class="fa-regular fa-moon"></i>';
            }
        });
    }

    // 8. Language Toggle Translator
    const langBtn = document.getElementById('langBtn');
    if (langBtn) {
        const langs = ['ES', 'EN', 'PT'];
        let currentLangIdx = 0;
        langBtn.addEventListener('click', () => {
            currentLangIdx = (currentLangIdx + 1) % langs.length;
            const newLangCode = langs[currentLangIdx].toLowerCase();
            langBtn.innerText = langs[currentLangIdx];

            // Actualizar todos los nodos que tengan data-i18n
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (window.translations && window.translations[newLangCode] && window.translations[newLangCode][key]) {
                    el.innerHTML = window.translations[newLangCode][key];
                }
            });
        });
    }

});
