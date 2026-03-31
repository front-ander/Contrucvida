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

    // 4. Form Submission (Prevent default config)
    const contactForm = document.getElementById("contactForm");
    if (contactForm) {
        contactForm.addEventListener("submit", (e) => {
            e.preventDefault();
            // Lógica de simulación
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerText;

            submitBtn.innerText = "¡Enviando...";
            submitBtn.disabled = true;

            setTimeout(() => {
                submitBtn.innerText = "¡Mensaje Enviado con Éxito!";
                submitBtn.style.backgroundColor = "#25D366"; // WhatsApp Green
                contactForm.reset();

                setTimeout(() => {
                    submitBtn.innerText = originalText;
                    submitBtn.style.backgroundColor = "";
                    submitBtn.disabled = false;
                }, 3000);
            }, 1000);
        });
    }

    // 5. Hero Background Carousel Auto-Play (Cada 2/2.5 segundos)
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
