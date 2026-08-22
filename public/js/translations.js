/**
 * BestLiveIPTV - Translation System
 * This script provides automatic translation of all page content
 */

// Complete translation data for all languages
const translations = {
    en: {
        // Navigation
        "Home": "Home",
        "Pricing": "Pricing",
        "Channels": "Channels",
        "FAQ": "FAQ",
        "Affiliate": "Affiliate",
        "Reseller": "Reseller",
        "Blog": "Blog",
        "Contact": "Contact",
        "Login": "Login",
        "Register": "Register",
        "My Profile": "My Profile",
        "Admin Panel": "Admin Panel",
        "Logout": "Logout",
        "Get Started": "Get Started",
        "Sign In": "Sign In",
        "Log In": "Log In",
        "Create Account": "Create Account",
        "24/7 Support Available": "24/7 Support Available",

        // Hero Section
        "Experience The": "Experience The",
        "Future": "Future",
        "of": "of",
        "Television": "Television",
        "Stream 20,000+ premium channels in stunning HD & 4K quality. Enjoy movies, sports, news, and entertainment from around the world with 99.9% uptime guarantee.": "Stream 20,000+ premium channels in stunning HD & 4K quality. Enjoy movies, sports, news, and entertainment from around the world with 99.9% uptime guarantee.",
        "20,000+ Channels": "20,000+ Channels",
        "100,000 VOD": "100,000 VOD",
        "150+ Countries": "150+ Countries",
        "Premium Sports & Entertainment": "Premium Sports & Entertainment",
        "Start Free Trial": "Start Free Trial",
        "View Pricing": "View Pricing",
        "SSL Secured": "SSL Secured",
        "100% Private": "100% Private",
        "Money Back": "Money Back",
        "4K Ultra HD": "4K Ultra HD",
        "Live Streaming": "Live Streaming",
        "Multi Device": "Multi Device",
        "Scroll to explore": "Scroll to explore",
        "Back": "Back",
        "Now Playing": "Now Playing",
        "Premium Content in 4K Ultra HD": "Premium Content in 4K Ultra HD",

        // Stats Section
        "Uptime Guarantee": "Uptime Guarantee",
        "Global Servers": "Global Servers",
        "Years in Business": "Years in Business",
        "Customer Support": "Customer Support",

        // Features Section
        "Premium Features for": "Premium Features for",
        "Premium Experience": "Premium Experience",
        "Discover why thousands of customers trust us for their entertainment needs": "Discover why thousands of customers trust us for their entertainment needs",
        "20,000+ Live Channels": "20,000+ Live Channels",
        "Access thousands of live TV channels from around the world including sports, movies, news, and entertainment.": "Access thousands of live TV channels from around the world including sports, movies, news, and entertainment.",
        "Sports": "Sports",
        "Movies": "Movies",
        "News": "News",
        "50,000+ VOD Library": "50,000+ VOD Library",
        "Enjoy our massive collection of movies and TV series on demand. New content added daily.": "Enjoy our massive collection of movies and TV series on demand. New content added daily.",
        "Series": "Series",
        "Documentaries": "Documentaries",
        "HD & 4K Quality": "HD & 4K Quality",
        "Experience crystal clear picture quality with our HD, Full HD, and 4K streaming options.": "Experience crystal clear picture quality with our HD, Full HD, and 4K streaming options.",
        "HD": "HD",
        "Full HD": "Full HD",
        "4K Ultra": "4K Ultra",
        "Multi-Device Support": "Multi-Device Support",
        "Watch on any device - Smart TV, Android, iOS, Fire Stick, MAG Box, and more.": "Watch on any device - Smart TV, Android, iOS, Fire Stick, MAG Box, and more.",
        "Smart TV": "Smart TV",
        "Mobile": "Mobile",
        "Fire Stick": "Fire Stick",
        "TV Guide (EPG)": "TV Guide (EPG)",
        "Never miss your favorite shows with our electronic program guide. Plan your viewing ahead.": "Never miss your favorite shows with our electronic program guide. Plan your viewing ahead.",
        "Schedule": "Schedule",
        "Reminders": "Reminders",
        "Listings": "Listings",
        "Anti-Freeze Technology": "Anti-Freeze Technology",
        "Our advanced anti-freeze technology ensures smooth, buffer-free streaming experience.": "Our advanced anti-freeze technology ensures smooth, buffer-free streaming experience.",
        "No Buffer": "No Buffer",
        "Smooth": "Smooth",
        "Stable": "Stable",

        // Devices Section
        "Works on": "Works on",
        "All Your Devices": "All Your Devices",
        "Stream your favorite content on any device, anywhere, anytime": "Stream your favorite content on any device, anywhere, anytime",
        "Android": "Android",
        "iOS/iPhone": "iOS/iPhone",
        "Windows PC": "Windows PC",
        "Mac": "Mac",
        "MAG Box": "MAG Box",
        "Xbox": "Xbox",

        // Pricing Section
        "Choose Your": "Choose Your",
        "Perfect Plan": "Perfect Plan",
        "Flexible pricing options to suit every need. All plans include all features.": "Flexible pricing options to suit every need. All plans include all features.",
        "1 Month": "1 Month",
        "3 Months": "3 Months",
        "6 Months": "6 Months",
        "12 Months": "12 Months",
        "Best Value": "Best Value",
        "Most Popular": "Most Popular",
        "Devices": "Devices",
        "Device": "Device",
        "20,000+ Channels & VOD": "20,000+ Channels & VOD",
        "HD & 4K Image Quality": "HD & 4K Image Quality",
        "Instant Delivery": "Instant Delivery",
        "24/7 Customer Support": "24/7 Customer Support",
        "View All Plans": "View All Plans",

        // How It Works Section
        "Get Started in": "Get Started in",
        "3 Easy Steps": "3 Easy Steps",
        "Start streaming your favorite content in just minutes": "Start streaming your favorite content in just minutes",
        "Choose Your Plan": "Choose Your Plan",
        "Select the subscription plan that best fits your needs. We offer flexible options for everyone.": "Select the subscription plan that best fits your needs. We offer flexible options for everyone.",
        "Secure Payment": "Secure Payment",
        "Complete your purchase using our secure payment gateway. We accept multiple payment methods.": "Complete your purchase using our secure payment gateway. We accept multiple payment methods.",
        "Start Watching": "Start Watching",
        "Receive your credentials instantly via email and start enjoying unlimited entertainment.": "Receive your credentials instantly via email and start enjoying unlimited entertainment.",

        // Testimonials Section
        "What Our": "What Our",
        "Customers Say": "Customers Say",
        "Join thousands of satisfied customers enjoying premium entertainment": "Join thousands of satisfied customers enjoying premium entertainment",

        // FAQ Section
        "Frequently Asked": "Frequently Asked",
        "Questions": "Questions",
        "Find answers to common questions about our service": "Find answers to common questions about our service",

        // CTA Section
        "Ready to Start Streaming?": "Ready to Start Streaming?",
        "Join thousands of satisfied customers and experience the future of television today": "Join thousands of satisfied customers and experience the future of television today",

        // Footer
        "Quick Links": "Quick Links",
        "Pricing Plans": "Pricing Plans",
        "Channel List": "Channel List",
        "Reseller Program": "Reseller Program",
        "Blog & News": "Blog & News",
        "Support": "Support",
        "How It Works": "How It Works",
        "Help Center": "Help Center",
        "Live Support": "Live Support",
        "Terms of Service": "Terms of Service",
        "Privacy Policy": "Privacy Policy",
        "Contact Us": "Contact Us",
        "Secure Payment Methods": "Secure Payment Methods",
        "All rights reserved": "All rights reserved",
        "Terms": "Terms",
        "Privacy": "Privacy",
        "Refund Policy": "Refund Policy",

        // Layout & Auth
        "Sign In": "Sign In",
        "Log In": "Log In",
        "Create Account": "Create Account",
        "24/7 Support Available": "24/7 Support Available",
        "Open menu": "Open menu",
        "Close menu": "Close menu",
        "Navigation menu": "Navigation menu",
        "Change language": "Change language",
        "Services": "Services",
        "Company": "Company",
        "Get Support": "Get Support",
        "Subscription Plans": "Subscription Plans",
        "Channel Guide": "Channel Guide",
        "Affiliate Program": "Affiliate Program",
        "About Us": "About Us",
        "Our Blog": "Our Blog",
        "Email Us": "Email Us",
        "WhatsApp": "WhatsApp",
        "Support Hours": "Support Hours",
        "24/7 — Always Available": "24/7 — Always Available",
        "We Accept": "We Accept",
        "Chat with us": "Chat with us",
        "Chat on WhatsApp": "Chat on WhatsApp",
        "Chat with us on WhatsApp": "Chat with us on WhatsApp",
        "Premium IPTV streaming with 40,000+ live channels in stunning 4K & HD. Zero buffering, instant activation, and 24/7 expert support.": "Premium IPTV streaming with 40,000+ live channels in stunning 4K & HD. Zero buffering, instant activation, and 24/7 expert support.",
        "Our team is available around the clock to help you.": "Our team is available around the clock to help you.",
        "Back to Home": "Back to Home",
        "Welcome Back": "Welcome Back",
        "Sign in to your account to continue": "Sign in to your account to continue",
        "Email Address": "Email Address",
        "Forgot Password?": "Forgot Password?",
        "Enter your password": "Enter your password",
        "Remember me for 30 days": "Remember me for 30 days",
        "Don't have an account?": "Don't have an account?",
        "Stream the World,": "Stream the World,",
        "Anytime Anywhere": "Anytime Anywhere",
        "Join 100,000+ customers enjoying premium IPTV — 40,000+ channels and 100,000+ VOD titles.": "Join 100,000+ customers enjoying premium IPTV — 40,000+ channels and 100,000+ VOD titles.",
        "Live Channels": "Live Channels",
        "Movies & Series": "Movies & Series",
        "Countries Covered": "Countries Covered",
        "Secure Payments": "Secure Payments",
        "24/7 Support": "24/7 Support",
        "Instant Setup": "Instant Setup",
        "Start Watching": "Start Watching",
        "in 3 Minutes": "in 3 Minutes",
        "Create your free account today and get instant access to 40,000+ live channels and 100,000+ VOD titles.": "Create your free account today and get instant access to 40,000+ live channels and 100,000+ VOD titles.",
        "24-Hour Free Trial": "24-Hour Free Trial",
        "No credit card needed": "No credit card needed",
        "Instant Activation": "Instant Activation",
        "Within 5 minutes": "Within 5 minutes",
        "All Devices": "All Devices",
        "TV, mobile, tablet, PC": "TV, mobile, tablet, PC",
        "Expert team always online": "Expert team always online",
        "4.9/5 Rating": "4.9/5 Rating",
        "100K+ Customers": "100K+ Customers",
        "Join 100,000+ streamers worldwide. Free trial included.": "Join 100,000+ streamers worldwide. Free trial included.",
        "Full Name": "Full Name",
        "Confirm Password": "Confirm Password",
        "Min 8 characters": "Min 8 characters",
        "Re-enter password": "Re-enter password",
        "Free 24h Trial": "Free 24h Trial",
        "No Credit Card": "No Credit Card",
        "Cancel Anytime": "Cancel Anytime",
        "Already have an account?": "Already have an account?",
        "No worries! Enter your email and we'll send a secure reset link within a few minutes.": "No worries! Enter your email and we'll send a secure reset link within a few minutes.",
        "We'll send a reset link to your email. Check your spam folder if you don't see it.": "We'll send a reset link to your email. Check your spam folder if you don't see it.",
        "Send Reset Link": "Send Reset Link",
        "Back to Sign In": "Back to Sign In",
        "Reset Password": "Reset Password",
        "Create a new strong password for your account. Make sure it's at least 8 characters.": "Create a new strong password for your account. Make sure it's at least 8 characters.",
        "New Password": "New Password",
        "Confirm New Password": "Confirm New Password",
        "Set New Password": "Set New Password",
        "Two-Factor Auth": "Two-Factor Auth",
        "Open your authenticator app and enter the 6-digit verification code to continue.": "Open your authenticator app and enter the 6-digit verification code to continue.",
        "6-Digit Code": "6-Digit Code",
        "Codes expire every 30 seconds. Make sure your device clock is synced correctly.": "Codes expire every 30 seconds. Make sure your device clock is synced correctly.",
        "Verify & Sign In": "Verify & Sign In",
        "(optional)": "(optional)",

        // Contact Page
        "Get in Touch": "Get in Touch",
        "Send Message": "Send Message",
        "Your Name": "Your Name",
        "Your Email": "Your Email",
        "Subject": "Subject",
        "Message": "Message",
        "Submit": "Submit",

        // Auth Pages
        "Email": "Email",
        "Password": "Password",
        "Remember me": "Remember me",
        "Forgot your password?": "Forgot your password?",
        "Already have an account?": "Already have an account?",
        "Don't have an account?": "Don't have an account?",
        "Create an account": "Create an account",
        "Sign in": "Sign in",
        "Sign up": "Sign up"
    },

    es: {
        // Navigation
        "Home": "Inicio",
        "Pricing": "Precios",
        "Channels": "Canales",
        "FAQ": "Preguntas",
        "Affiliate": "Afiliados",
        "Reseller": "Revendedor",
        "Blog": "Blog",
        "Contact": "Contacto",
        "Login": "Acceso",
        "Register": "Registro",
        "My Profile": "Mi Perfil",
        "Admin Panel": "Panel Admin",
        "Logout": "Salir",
        "Get Started": "Comenzar",
        "Sign In": "Iniciar sesión",
        "Log In": "Iniciar sesión",
        "Create Account": "Crear cuenta",
        "24/7 Support Available": "Soporte 24/7 disponible",

        // Hero Section
        "Experience The": "Experimenta El",
        "Future": "Futuro",
        "of": "de la",
        "Television": "Televisión",
        "Stream 20,000+ premium channels in stunning HD & 4K quality. Enjoy movies, sports, news, and entertainment from around the world with 99.9% uptime guarantee.": "Transmite más de 20,000 canales premium en impresionante calidad HD y 4K. Disfruta de películas, deportes, noticias y entretenimiento de todo el mundo con 99.9% de disponibilidad.",
        "20,000+ Channels": "20,000+ Canales",
        "100,000 VOD": "100,000 VOD",
        "150+ Countries": "150+ Países",
        "Premium Sports & Entertainment": "Deportes y Entretenimiento Premium",
        "Start Free Trial": "Prueba Gratis",
        "View Pricing": "Ver Precios",
        "SSL Secured": "SSL Seguro",
        "100% Private": "100% Privado",
        "Money Back": "Devolución",
        "4K Ultra HD": "4K Ultra HD",
        "Live Streaming": "En Vivo",
        "Multi Device": "Multi Dispositivo",
        "Scroll to explore": "Desplázate para explorar",
        "Back": "Atrás",
        "Now Playing": "Reproduciendo",
        "Premium Content in 4K Ultra HD": "Contenido Premium en 4K Ultra HD",

        // Stats Section
        "Uptime Guarantee": "Garantía de Disponibilidad",
        "Global Servers": "Servidores Globales",
        "Years in Business": "Años en el Negocio",
        "Customer Support": "Soporte al Cliente",

        // Features Section
        "Premium Features for": "Características Premium para",
        "Premium Experience": "Experiencia Premium",
        "Discover why thousands of customers trust us for their entertainment needs": "Descubre por qué miles de clientes confían en nosotros para su entretenimiento",
        "20,000+ Live Channels": "20,000+ Canales en Vivo",
        "Access thousands of live TV channels from around the world including sports, movies, news, and entertainment.": "Accede a miles de canales de TV en vivo de todo el mundo incluyendo deportes, películas, noticias y entretenimiento.",
        "Sports": "Deportes",
        "Movies": "Películas",
        "News": "Noticias",
        "50,000+ VOD Library": "Biblioteca VOD 50,000+",
        "Enjoy our massive collection of movies and TV series on demand. New content added daily.": "Disfruta de nuestra enorme colección de películas y series bajo demanda. Nuevo contenido agregado diariamente.",
        "Series": "Series",
        "Documentaries": "Documentales",
        "HD & 4K Quality": "Calidad HD y 4K",
        "Experience crystal clear picture quality with our HD, Full HD, and 4K streaming options.": "Experimenta calidad de imagen cristalina con nuestras opciones HD, Full HD y 4K.",
        "HD": "HD",
        "Full HD": "Full HD",
        "4K Ultra": "4K Ultra",
        "Multi-Device Support": "Soporte Multi-Dispositivo",
        "Watch on any device - Smart TV, Android, iOS, Fire Stick, MAG Box, and more.": "Mira en cualquier dispositivo - Smart TV, Android, iOS, Fire Stick, MAG Box y más.",
        "Smart TV": "Smart TV",
        "Mobile": "Móvil",
        "Fire Stick": "Fire Stick",
        "TV Guide (EPG)": "Guía de TV (EPG)",
        "Never miss your favorite shows with our electronic program guide. Plan your viewing ahead.": "Nunca te pierdas tus programas favoritos con nuestra guía electrónica. Planifica tu visualización.",
        "Schedule": "Horario",
        "Reminders": "Recordatorios",
        "Listings": "Listados",
        "Anti-Freeze Technology": "Tecnología Anti-Congelamiento",
        "Our advanced anti-freeze technology ensures smooth, buffer-free streaming experience.": "Nuestra tecnología avanzada garantiza una experiencia de streaming fluida y sin interrupciones.",
        "No Buffer": "Sin Buffer",
        "Smooth": "Fluido",
        "Stable": "Estable",

        // Devices Section
        "Works on": "Funciona en",
        "All Your Devices": "Todos Tus Dispositivos",
        "Stream your favorite content on any device, anywhere, anytime": "Transmite tu contenido favorito en cualquier dispositivo, donde sea, cuando sea",
        "Android": "Android",
        "iOS/iPhone": "iOS/iPhone",
        "Windows PC": "Windows PC",
        "Mac": "Mac",
        "MAG Box": "MAG Box",
        "Xbox": "Xbox",

        // Pricing Section
        "Choose Your": "Elige Tu",
        "Perfect Plan": "Plan Perfecto",
        "Flexible pricing options to suit every need. All plans include all features.": "Opciones de precios flexibles para cada necesidad. Todos los planes incluyen todas las características.",
        "1 Month": "1 Mes",
        "3 Months": "3 Meses",
        "6 Months": "6 Meses",
        "12 Months": "12 Meses",
        "Best Value": "Mejor Valor",
        "Most Popular": "Más Popular",
        "Devices": "Dispositivos",
        "Device": "Dispositivo",
        "20,000+ Channels & VOD": "20,000+ Canales y VOD",
        "HD & 4K Image Quality": "Calidad de Imagen HD y 4K",
        "Instant Delivery": "Entrega Instantánea",
        "24/7 Customer Support": "Soporte 24/7",
        "View All Plans": "Ver Todos los Planes",

        // How It Works Section
        "Get Started in": "Comienza en",
        "3 Easy Steps": "3 Pasos Fáciles",
        "Start streaming your favorite content in just minutes": "Comienza a transmitir tu contenido favorito en minutos",
        "Choose Your Plan": "Elige Tu Plan",
        "Select the subscription plan that best fits your needs. We offer flexible options for everyone.": "Selecciona el plan que mejor se adapte a tus necesidades. Ofrecemos opciones flexibles para todos.",
        "Secure Payment": "Pago Seguro",
        "Complete your purchase using our secure payment gateway. We accept multiple payment methods.": "Completa tu compra usando nuestra pasarela de pago segura. Aceptamos múltiples métodos de pago.",
        "Start Watching": "Comienza a Ver",
        "Receive your credentials instantly via email and start enjoying unlimited entertainment.": "Recibe tus credenciales al instante por email y empieza a disfrutar de entretenimiento ilimitado.",

        // Testimonials Section
        "What Our": "Lo Que Dicen",
        "Customers Say": "Nuestros Clientes",
        "Join thousands of satisfied customers enjoying premium entertainment": "Únete a miles de clientes satisfechos disfrutando entretenimiento premium",

        // FAQ Section
        "Frequently Asked": "Preguntas",
        "Questions": "Frecuentes",
        "Find answers to common questions about our service": "Encuentra respuestas a preguntas comunes sobre nuestro servicio",

        // CTA Section
        "Ready to Start Streaming?": "¿Listo para Empezar?",
        "Join thousands of satisfied customers and experience the future of television today": "Únete a miles de clientes satisfechos y experimenta el futuro de la televisión hoy",

        // Footer
        "Quick Links": "Enlaces Rápidos",
        "Pricing Plans": "Planes de Precios",
        "Channel List": "Lista de Canales",
        "Reseller Program": "Programa Revendedor",
        "Blog & News": "Blog y Noticias",
        "Support": "Soporte",
        "How It Works": "Cómo Funciona",
        "Help Center": "Centro de Ayuda",
        "Live Support": "Soporte en Vivo",
        "Terms of Service": "Términos de Servicio",
        "Privacy Policy": "Política de Privacidad",
        "Contact Us": "Contáctanos",
        "Secure Payment Methods": "Métodos de Pago Seguros",
        "All rights reserved": "Todos los derechos reservados",
        "Terms": "Términos",
        "Privacy": "Privacidad",
        "Refund Policy": "Política de Reembolso",

        // Layout & Auth
        "Open menu": "Abrir menú",
        "Close menu": "Cerrar menú",
        "Navigation menu": "Menú de navegación",
        "Change language": "Cambiar idioma",
        "Services": "Servicios",
        "Company": "Empresa",
        "Get Support": "Obtener Soporte",
        "Subscription Plans": "Planes de Suscripción",
        "Channel Guide": "Guía de Canales",
        "Affiliate Program": "Programa de Afiliados",
        "About Us": "Sobre Nosotros",
        "Our Blog": "Nuestro Blog",
        "Email Us": "Envíanos un Email",
        "WhatsApp": "WhatsApp",
        "Support Hours": "Horario de Soporte",
        "24/7 — Always Available": "24/7 — Siempre Disponible",
        "We Accept": "Aceptamos",
        "Chat with us": "Chatea con nosotros",
        "Chat on WhatsApp": "Chatear en WhatsApp",
        "Chat with us on WhatsApp": "Chatea con nosotros en WhatsApp",
        "Premium IPTV streaming with 40,000+ live channels in stunning 4K & HD. Zero buffering, instant activation, and 24/7 expert support.": "Streaming IPTV premium con más de 40,000 canales en vivo en impresionante 4K y HD. Sin buffering, activación instantánea y soporte experto 24/7.",
        "Our team is available around the clock to help you.": "Nuestro equipo está disponible las 24 horas para ayudarte.",
        "Back to Home": "Volver al Inicio",
        "Welcome Back": "Bienvenido de Nuevo",
        "Sign in to your account to continue": "Inicia sesión en tu cuenta para continuar",
        "Email Address": "Correo Electrónico",
        "Forgot Password?": "¿Olvidaste tu Contraseña?",
        "Enter your password": "Ingresa tu contraseña",
        "Remember me for 30 days": "Recordarme por 30 días",
        "Don't have an account?": "¿No tienes una cuenta?",
        "Stream the World,": "Transmite el Mundo,",
        "Anytime Anywhere": "En Cualquier Momento y Lugar",
        "Join 100,000+ customers enjoying premium IPTV — 40,000+ channels and 100,000+ VOD titles.": "Únete a más de 100,000 clientes que disfrutan IPTV premium — más de 40,000 canales y 100,000+ títulos VOD.",
        "Live Channels": "Canales en Vivo",
        "Movies & Series": "Películas y Series",
        "Countries Covered": "Países Cubiertos",
        "Secure Payments": "Pagos Seguros",
        "24/7 Support": "Soporte 24/7",
        "Instant Setup": "Configuración Instantánea",
        "Start Watching": "Empieza a Ver",
        "in 3 Minutes": "en 3 Minutos",
        "Create your free account today and get instant access to 40,000+ live channels and 100,000+ VOD titles.": "Crea tu cuenta gratis hoy y obtén acceso instantáneo a más de 40,000 canales y 100,000+ títulos VOD.",
        "24-Hour Free Trial": "Prueba Gratis de 24 Horas",
        "No credit card needed": "Sin tarjeta de crédito",
        "Instant Activation": "Activación Instantánea",
        "Within 5 minutes": "En 5 minutos",
        "All Devices": "Todos los Dispositivos",
        "TV, mobile, tablet, PC": "TV, móvil, tablet, PC",
        "Expert team always online": "Equipo experto siempre en línea",
        "4.9/5 Rating": "Calificación 4.9/5",
        "100K+ Customers": "100K+ Clientes",
        "Join 100,000+ streamers worldwide. Free trial included.": "Únete a más de 100,000 streamers en todo el mundo. Prueba gratis incluida.",
        "Full Name": "Nombre Completo",
        "Confirm Password": "Confirmar Contraseña",
        "Min 8 characters": "Mínimo 8 caracteres",
        "Re-enter password": "Vuelve a ingresar la contraseña",
        "Free 24h Trial": "Prueba Gratis 24h",
        "No Credit Card": "Sin Tarjeta",
        "Cancel Anytime": "Cancela Cuando Quieras",
        "Already have an account?": "¿Ya tienes una cuenta?",
        "No worries! Enter your email and we'll send a secure reset link within a few minutes.": "¡No te preocupes! Ingresa tu email y te enviaremos un enlace seguro en unos minutos.",
        "We'll send a reset link to your email. Check your spam folder if you don't see it.": "Enviaremos un enlace a tu email. Revisa tu carpeta de spam si no lo ves.",
        "Send Reset Link": "Enviar Enlace",
        "Back to Sign In": "Volver a Iniciar Sesión",
        "Reset Password": "Restablecer Contraseña",
        "Create a new strong password for your account. Make sure it's at least 8 characters.": "Crea una nueva contraseña segura. Asegúrate de que tenga al menos 8 caracteres.",
        "New Password": "Nueva Contraseña",
        "Confirm New Password": "Confirmar Nueva Contraseña",
        "Set New Password": "Establecer Nueva Contraseña",
        "Two-Factor Auth": "Autenticación de Dos Factores",
        "Open your authenticator app and enter the 6-digit verification code to continue.": "Abre tu app de autenticación e ingresa el código de 6 dígitos para continuar.",
        "6-Digit Code": "Código de 6 Dígitos",
        "Codes expire every 30 seconds. Make sure your device clock is synced correctly.": "Los códigos expiran cada 30 segundos. Asegúrate de que el reloj de tu dispositivo esté sincronizado.",
        "Verify & Sign In": "Verificar e Iniciar Sesión",
        "(optional)": "(opcional)",

        // Contact Page
        "Get in Touch": "Contáctanos",
        "Send Message": "Enviar Mensaje",
        "Your Name": "Tu Nombre",
        "Your Email": "Tu Email",
        "Subject": "Asunto",
        "Message": "Mensaje",
        "Submit": "Enviar",

        // Auth Pages
        "Email": "Correo Electrónico",
        "Password": "Contraseña",
        "Remember me": "Recordarme",
        "Forgot your password?": "¿Olvidaste tu contraseña?",
        "Already have an account?": "¿Ya tienes cuenta?",
        "Don't have an account?": "¿No tienes cuenta?",
        "Create an account": "Crear cuenta",
        "Sign in": "Iniciar sesión",
        "Sign up": "Registrarse"
    },

    fr: {
        // Navigation
        "Home": "Accueil",
        "Pricing": "Tarifs",
        "Channels": "Chaînes",
        "FAQ": "FAQ",
        "Affiliate": "Affiliation",
        "Reseller": "Revendeur",
        "Blog": "Blog",
        "Contact": "Contact",
        "Login": "Connexion",
        "Register": "S'inscrire",
        "My Profile": "Mon Profil",
        "Admin Panel": "Panneau Admin",
        "Logout": "Déconnexion",
        "Get Started": "Commencer",
        "Sign In": "Se connecter",
        "Log In": "Connexion",
        "Create Account": "Créer un compte",
        "24/7 Support Available": "Support 24/7 disponible",

        // Hero Section
        "Experience The": "Découvrez Le",
        "Future": "Futur",
        "of": "de la",
        "Television": "Télévision",
        "Stream 20,000+ premium channels in stunning HD & 4K quality. Enjoy movies, sports, news, and entertainment from around the world with 99.9% uptime guarantee.": "Diffusez plus de 20 000 chaînes premium en qualité HD et 4K époustouflante. Profitez de films, sports, actualités et divertissements du monde entier avec 99,9% de disponibilité.",
        "20,000+ Channels": "20 000+ Chaînes",
        "100,000 VOD": "100 000 VOD",
        "150+ Countries": "150+ Pays",
        "Premium Sports & Entertainment": "Sports et Divertissement Premium",
        "Start Free Trial": "Essai Gratuit",
        "View Pricing": "Voir les Prix",
        "SSL Secured": "SSL Sécurisé",
        "100% Private": "100% Privé",
        "Money Back": "Remboursement",
        "4K Ultra HD": "4K Ultra HD",
        "Live Streaming": "Direct",
        "Multi Device": "Multi Appareils",
        "Scroll to explore": "Défiler pour explorer",
        "Back": "Retour",
        "Now Playing": "En Lecture",
        "Premium Content in 4K Ultra HD": "Contenu Premium en 4K Ultra HD",

        // Stats Section
        "Uptime Guarantee": "Garantie de Disponibilité",
        "Global Servers": "Serveurs Mondiaux",
        "Years in Business": "Années d'Expérience",
        "Customer Support": "Support Client",

        // Features Section
        "Premium Features for": "Fonctionnalités Premium pour une",
        "Premium Experience": "Expérience Premium",
        "Discover why thousands of customers trust us for their entertainment needs": "Découvrez pourquoi des milliers de clients nous font confiance pour leurs besoins en divertissement",
        "20,000+ Live Channels": "20 000+ Chaînes en Direct",
        "Access thousands of live TV channels from around the world including sports, movies, news, and entertainment.": "Accédez à des milliers de chaînes TV en direct du monde entier incluant sport, films, actualités et divertissement.",
        "Sports": "Sport",
        "Movies": "Films",
        "News": "Actualités",
        "50,000+ VOD Library": "Bibliothèque VOD 50 000+",
        "Enjoy our massive collection of movies and TV series on demand. New content added daily.": "Profitez de notre immense collection de films et séries à la demande. Nouveau contenu ajouté quotidiennement.",
        "Series": "Séries",
        "Documentaries": "Documentaires",
        "HD & 4K Quality": "Qualité HD et 4K",
        "Experience crystal clear picture quality with our HD, Full HD, and 4K streaming options.": "Découvrez une qualité d'image cristalline avec nos options HD, Full HD et 4K.",
        "HD": "HD",
        "Full HD": "Full HD",
        "4K Ultra": "4K Ultra",
        "Multi-Device Support": "Support Multi-Appareils",
        "Watch on any device - Smart TV, Android, iOS, Fire Stick, MAG Box, and more.": "Regardez sur tout appareil - Smart TV, Android, iOS, Fire Stick, MAG Box et plus.",
        "Smart TV": "Smart TV",
        "Mobile": "Mobile",
        "Fire Stick": "Fire Stick",
        "TV Guide (EPG)": "Guide TV (EPG)",
        "Never miss your favorite shows with our electronic program guide. Plan your viewing ahead.": "Ne manquez jamais vos émissions préférées avec notre guide électronique. Planifiez vos visionnages.",
        "Schedule": "Programme",
        "Reminders": "Rappels",
        "Listings": "Listes",
        "Anti-Freeze Technology": "Technologie Anti-Gel",
        "Our advanced anti-freeze technology ensures smooth, buffer-free streaming experience.": "Notre technologie avancée garantit une expérience de streaming fluide et sans interruption.",
        "No Buffer": "Sans Buffer",
        "Smooth": "Fluide",
        "Stable": "Stable",

        // Devices Section
        "Works on": "Fonctionne sur",
        "All Your Devices": "Tous Vos Appareils",
        "Stream your favorite content on any device, anywhere, anytime": "Diffusez votre contenu préféré sur tout appareil, partout, à tout moment",
        "Android": "Android",
        "iOS/iPhone": "iOS/iPhone",
        "Windows PC": "Windows PC",
        "Mac": "Mac",
        "MAG Box": "MAG Box",
        "Xbox": "Xbox",

        // Pricing Section
        "Choose Your": "Choisissez Votre",
        "Perfect Plan": "Plan Parfait",
        "Flexible pricing options to suit every need. All plans include all features.": "Options de tarification flexibles pour chaque besoin. Tous les plans incluent toutes les fonctionnalités.",
        "1 Month": "1 Mois",
        "3 Months": "3 Mois",
        "6 Months": "6 Mois",
        "12 Months": "12 Mois",
        "Best Value": "Meilleure Offre",
        "Most Popular": "Plus Populaire",
        "Devices": "Appareils",
        "Device": "Appareil",
        "20,000+ Channels & VOD": "20 000+ Chaînes et VOD",
        "HD & 4K Image Quality": "Qualité d'Image HD et 4K",
        "Instant Delivery": "Livraison Instantanée",
        "24/7 Customer Support": "Support 24/7",
        "View All Plans": "Voir Tous les Plans",

        // How It Works Section
        "Get Started in": "Commencez en",
        "3 Easy Steps": "3 Étapes Simples",
        "Start streaming your favorite content in just minutes": "Commencez à diffuser votre contenu préféré en quelques minutes",
        "Choose Your Plan": "Choisissez Votre Plan",
        "Select the subscription plan that best fits your needs. We offer flexible options for everyone.": "Sélectionnez le plan d'abonnement qui correspond le mieux à vos besoins. Nous offrons des options flexibles.",
        "Secure Payment": "Paiement Sécurisé",
        "Complete your purchase using our secure payment gateway. We accept multiple payment methods.": "Complétez votre achat avec notre passerelle de paiement sécurisée. Nous acceptons plusieurs méthodes.",
        "Start Watching": "Commencez à Regarder",
        "Receive your credentials instantly via email and start enjoying unlimited entertainment.": "Recevez vos identifiants instantanément par email et commencez à profiter d'un divertissement illimité.",

        // Testimonials Section
        "What Our": "Ce Que Disent",
        "Customers Say": "Nos Clients",
        "Join thousands of satisfied customers enjoying premium entertainment": "Rejoignez des milliers de clients satisfaits profitant d'un divertissement premium",

        // FAQ Section
        "Frequently Asked": "Questions",
        "Questions": "Fréquentes",
        "Find answers to common questions about our service": "Trouvez des réponses aux questions courantes sur notre service",

        // CTA Section
        "Ready to Start Streaming?": "Prêt à Commencer?",
        "Join thousands of satisfied customers and experience the future of television today": "Rejoignez des milliers de clients satisfaits et découvrez le futur de la télévision aujourd'hui",

        // Footer
        "Quick Links": "Liens Rapides",
        "Pricing Plans": "Plans Tarifaires",
        "Channel List": "Liste des Chaînes",
        "Reseller Program": "Programme Revendeur",
        "Blog & News": "Blog et Actualités",
        "Support": "Support",
        "How It Works": "Comment ça Marche",
        "Help Center": "Centre d'Aide",
        "Live Support": "Support en Direct",
        "Terms of Service": "Conditions d'Utilisation",
        "Privacy Policy": "Politique de Confidentialité",
        "Contact Us": "Contactez-nous",
        "Secure Payment Methods": "Méthodes de Paiement Sécurisées",
        "All rights reserved": "Tous droits réservés",
        "Terms": "Conditions",
        "Privacy": "Confidentialité",
        "Refund Policy": "Politique de Remboursement",

        // Contact Page
        "Get in Touch": "Contactez-nous",
        "Send Message": "Envoyer un Message",
        "Your Name": "Votre Nom",
        "Your Email": "Votre Email",
        "Subject": "Sujet",
        "Message": "Message",
        "Submit": "Envoyer",

        // Auth Pages
        "Email": "Email",
        "Password": "Mot de Passe",
        "Remember me": "Se souvenir de moi",
        "Forgot your password?": "Mot de passe oublié?",
        "Already have an account?": "Déjà un compte?",
        "Don't have an account?": "Pas de compte?",
        "Create an account": "Créer un compte",
        "Sign in": "Se connecter",
        "Sign up": "S'inscrire"
    },

    de: {
        // Navigation
        "Home": "Startseite",
        "Pricing": "Preise",
        "Channels": "Kanäle",
        "FAQ": "FAQ",
        "Affiliate": "Affiliate",
        "Reseller": "Wiederverkäufer",
        "Blog": "Blog",
        "Contact": "Kontakt",
        "Login": "Anmelden",
        "Register": "Registrieren",
        "My Profile": "Mein Profil",
        "Admin Panel": "Admin-Bereich",
        "Logout": "Abmelden",
        "Get Started": "Loslegen",
        "Sign In": "Anmelden",
        "Log In": "Anmelden",
        "Create Account": "Konto erstellen",
        "24/7 Support Available": "24/7 Support verfügbar",

        // Hero Section
        "Experience The": "Erleben Sie Die",
        "Future": "Zukunft",
        "of": "des",
        "Television": "Fernsehens",
        "Stream 20,000+ premium channels in stunning HD & 4K quality. Enjoy movies, sports, news, and entertainment from around the world with 99.9% uptime guarantee.": "Streamen Sie über 20.000 Premium-Kanäle in atemberaubender HD- und 4K-Qualität. Genießen Sie Filme, Sport, Nachrichten und Unterhaltung aus aller Welt.",
        "20,000+ Channels": "20.000+ Kanäle",
        "100,000 VOD": "100.000 VOD",
        "150+ Countries": "150+ Länder",
        "Premium Sports & Entertainment": "Premium Sport & Unterhaltung",
        "Start Free Trial": "Kostenlos Testen",
        "View Pricing": "Preise Ansehen",
        "SSL Secured": "SSL Gesichert",
        "100% Private": "100% Privat",
        "Money Back": "Geld Zurück",
        "4K Ultra HD": "4K Ultra HD",
        "Live Streaming": "Live",
        "Multi Device": "Multi Geräte",
        "Scroll to explore": "Scrollen zum Erkunden",
        "Back": "Zurück",
        "Now Playing": "Aktuelle Wiedergabe",
        "Premium Content in 4K Ultra HD": "Premium Inhalte in 4K Ultra HD",

        // Stats Section
        "Uptime Guarantee": "Verfügbarkeitsgarantie",
        "Global Servers": "Globale Server",
        "Years in Business": "Jahre Erfahrung",
        "Customer Support": "Kundenbetreuung",

        // Pricing Section
        "Choose Your": "Wählen Sie Ihren",
        "Perfect Plan": "Perfekten Plan",
        "1 Month": "1 Monat",
        "3 Months": "3 Monate",
        "6 Months": "6 Monate",
        "12 Months": "12 Monate",
        "Best Value": "Bester Wert",
        "Most Popular": "Beliebteste",

        // Footer
        "Quick Links": "Schnelllinks",
        "Support": "Support",
        "Contact Us": "Kontaktieren Sie uns",
        "All rights reserved": "Alle Rechte vorbehalten",
        "Terms": "AGB",
        "Privacy": "Datenschutz",
        "Refund Policy": "Rückerstattung"
    },

    ar: {
        // Navigation
        "Home": "الرئيسية",
        "Pricing": "الأسعار",
        "Channels": "القنوات",
        "FAQ": "الأسئلة",
        "Affiliate": "الشركاء",
        "Reseller": "الموزعين",
        "Blog": "المدونة",
        "Contact": "اتصل بنا",
        "Login": "تسجيل الدخول",
        "Register": "التسجيل",
        "My Profile": "ملفي",
        "Admin Panel": "لوحة التحكم",
        "Logout": "خروج",
        "Get Started": "ابدأ الآن",
        "Sign In": "تسجيل الدخول",
        "Log In": "تسجيل الدخول",
        "Create Account": "إنشاء حساب",
        "24/7 Support Available": "دعم متاح على مدار الساعة",

        // Hero Section
        "Experience The": "اختبر",
        "Future": "مستقبل",
        "of": "",
        "Television": "التلفزيون",
        "20,000+ Channels": "أكثر من 20,000 قناة",
        "100,000 VOD": "100,000 فيديو",
        "150+ Countries": "أكثر من 150 دولة",
        "Premium Sports & Entertainment": "رياضة وترفيه مميز",
        "Start Free Trial": "ابدأ التجربة المجانية",
        "View Pricing": "عرض الأسعار",

        // Pricing Section
        "1 Month": "شهر واحد",
        "3 Months": "3 أشهر",
        "6 Months": "6 أشهر",
        "12 Months": "12 شهر",
        "Best Value": "أفضل قيمة",
        "Most Popular": "الأكثر شعبية",

        // Footer
        "Quick Links": "روابط سريعة",
        "Support": "الدعم",
        "Contact Us": "اتصل بنا",
        "All rights reserved": "جميع الحقوق محفوظة"
    },

    pt: {
        // Navigation
        "Home": "Início",
        "Pricing": "Preços",
        "Channels": "Canais",
        "FAQ": "Perguntas",
        "Affiliate": "Afiliados",
        "Reseller": "Revendedor",
        "Blog": "Blog",
        "Contact": "Contato",
        "Login": "Entrar",
        "Register": "Cadastrar",
        "My Profile": "Meu Perfil",
        "Admin Panel": "Painel Admin",
        "Logout": "Sair",
        "Get Started": "Começar",
        "Sign In": "Entrar",
        "Log In": "Entrar",
        "Create Account": "Criar conta",
        "24/7 Support Available": "Suporte 24/7 disponível",

        // Hero Section
        "Experience The": "Experimente O",
        "Future": "Futuro",
        "of": "da",
        "Television": "Televisão",
        "20,000+ Channels": "20.000+ Canais",
        "100,000 VOD": "100.000 VOD",
        "150+ Countries": "150+ Países",
        "Premium Sports & Entertainment": "Esportes e Entretenimento Premium",
        "Start Free Trial": "Teste Grátis",
        "View Pricing": "Ver Preços",

        // Pricing Section
        "1 Month": "1 Mês",
        "3 Months": "3 Meses",
        "6 Months": "6 Meses",
        "12 Months": "12 Meses",
        "Best Value": "Melhor Valor",
        "Most Popular": "Mais Popular",

        // Footer
        "Quick Links": "Links Rápidos",
        "Support": "Suporte",
        "Contact Us": "Fale Conosco",
        "All rights reserved": "Todos os direitos reservados"
    },

    it: {
        // Navigation
        "Home": "Home",
        "Pricing": "Prezzi",
        "Channels": "Canali",
        "FAQ": "FAQ",
        "Affiliate": "Affiliazione",
        "Reseller": "Rivenditore",
        "Blog": "Blog",
        "Contact": "Contatto",
        "Login": "Accedi",
        "Register": "Registrati",
        "My Profile": "Profilo",
        "Admin Panel": "Pannello Admin",
        "Logout": "Esci",
        "Get Started": "Inizia",
        "Sign In": "Accedi",
        "Log In": "Accedi",
        "Create Account": "Crea account",
        "24/7 Support Available": "Supporto 24/7 disponibile",

        // Hero Section  
        "Experience The": "Scopri Il",
        "Future": "Futuro",
        "of": "della",
        "Television": "Televisione",
        "20,000+ Channels": "20.000+ Canali",
        "100,000 VOD": "100.000 VOD",
        "150+ Countries": "150+ Paesi",
        "Premium Sports & Entertainment": "Sport e Intrattenimento Premium",
        "Start Free Trial": "Prova Gratuita",
        "View Pricing": "Vedi Prezzi",

        // Footer
        "Quick Links": "Link Rapidi",
        "Support": "Supporto",
        "Contact Us": "Contattaci",
        "All rights reserved": "Tutti i diritti riservati"
    },

    nl: {
        // Navigation
        "Home": "Home",
        "Pricing": "Prijzen",
        "Channels": "Kanalen",
        "FAQ": "Veelgestelde Vragen",
        "Affiliate": "Affiliate",
        "Reseller": "Wederverkoper",
        "Blog": "Blog",
        "Contact": "Contact",
        "Login": "Inloggen",
        "Register": "Registreren",
        "My Profile": "Mijn Profiel",
        "Admin Panel": "Admin Paneel",
        "Logout": "Uitloggen",
        "Get Started": "Aan de Slag",
        "Sign In": "Inloggen",
        "Log In": "Inloggen",
        "Create Account": "Account aanmaken",
        "24/7 Support Available": "24/7 ondersteuning beschikbaar",

        // Hero Section
        "Experience The": "Ervaar De",
        "Future": "Toekomst",
        "of": "van",
        "Television": "Televisie",
        "20,000+ Channels": "20.000+ Kanalen",
        "100,000 VOD": "100.000 VOD",
        "150+ Countries": "150+ Landen",
        "Start Free Trial": "Gratis Proberen",
        "View Pricing": "Prijzen Bekijken",

        // Footer
        "Quick Links": "Snelle Links",
        "Support": "Ondersteuning",
        "Contact Us": "Neem Contact Op",
        "All rights reserved": "Alle rechten voorbehouden"
    }
};

// Get current locale from Laravel-rendered config
function getCurrentLocale() {
    if (window.SITE_LOCALE) {
        return window.SITE_LOCALE;
    }

    const htmlLang = document.documentElement.lang;
    if (htmlLang) {
        return htmlLang;
    }

    return 'en';
}

function getSupportedLocales() {
    return ['en', 'es', 'fr', 'de', 'pt', 'it', 'ar', 'nl'];
}

function getTranslationMap() {
    const locale = getCurrentLocale();

    if (locale === 'en') {
        return {};
    }

    const map = {};

    if (window.SITE_TRANSLATIONS && typeof window.SITE_TRANSLATIONS === 'object') {
        Object.assign(map, window.SITE_TRANSLATIONS);
    }

    if (translations[locale]) {
        Object.assign(map, translations[locale]);
    }

    return map;
}

function getSortedTranslationKeys(map) {
    return Object.keys(map)
        .filter((key) => key && map[key] && key !== map[key])
        .sort((a, b) => b.length - a.length);
}

function applyTranslationMap(text, map, sortedKeys) {
    if (!text || !sortedKeys.length) {
        return text;
    }

    let result = text;

    sortedKeys.forEach((key) => {
        if (result.includes(key)) {
            result = result.split(key).join(map[key]);
        }
    });

    return result;
}

function shouldSkipNode(node) {
    const parent = node.parentElement;

    if (!parent) {
        return true;
    }

    const tag = parent.tagName;
    const skipTags = ['SCRIPT', 'STYLE', 'NOSCRIPT', 'CODE', 'PRE', 'TEXTAREA'];

    if (skipTags.includes(tag)) {
        return true;
    }

    if (parent.closest('[data-no-translate]')) {
        return true;
    }

    return false;
}

// Translate a single string
function translate(text, locale = null) {
    const currentLocale = locale || getCurrentLocale();

    if (currentLocale === 'en') {
        return text;
    }

    const map = getTranslationMap();

    return map[text] || text;
}

// Translate all text nodes in the page
function translatePage() {
    const locale = getCurrentLocale();
    const map = getTranslationMap();
    const sortedKeys = getSortedTranslationKeys(map);

    document.documentElement.lang = locale;
    document.documentElement.dir = window.SITE_RTL || locale === 'ar' ? 'rtl' : 'ltr';
    localStorage.setItem('siteLocale', locale);

    if (!sortedKeys.length) {
        return;
    }

    const walker = document.createTreeWalker(
        document.body,
        NodeFilter.SHOW_TEXT,
        null,
        false
    );

    while (walker.nextNode()) {
        const node = walker.currentNode;

        if (shouldSkipNode(node)) {
            continue;
        }

        const original = node.textContent;

        if (!original || !original.trim()) {
            continue;
        }

        const translated = applyTranslationMap(original, map, sortedKeys);

        if (translated !== original) {
            node.textContent = translated;
        }
    }

    document.querySelectorAll('[placeholder]').forEach((el) => {
        const placeholder = el.getAttribute('placeholder');
        const translated = map[placeholder] || applyTranslationMap(placeholder || '', map, sortedKeys);

        if (translated && translated !== placeholder) {
            el.setAttribute('placeholder', translated);
        }
    });

    document.querySelectorAll('[title]').forEach((el) => {
        const title = el.getAttribute('title');
        const translated = map[title] || applyTranslationMap(title || '', map, sortedKeys);

        if (translated && translated !== title) {
            el.setAttribute('title', translated);
        }
    });

    document.querySelectorAll('[aria-label]').forEach((el) => {
        const label = el.getAttribute('aria-label');
        const translated = map[label] || applyTranslationMap(label || '', map, sortedKeys);

        if (translated && translated !== label) {
            el.setAttribute('aria-label', translated);
        }
    });

    document.querySelectorAll('button, input[type="submit"], a.btn, .pk-btn, .hb').forEach((el) => {
        if (el.children.length > 1) {
            el.childNodes.forEach((child) => {
                if (child.nodeType === Node.TEXT_NODE) {
                    const translated = applyTranslationMap(child.textContent, map, sortedKeys);
                    if (translated !== child.textContent) {
                        child.textContent = translated;
                    }
                }
            });
            return;
        }

        const text = (el.textContent || el.value || '').trim();
        const translated = map[text] || applyTranslationMap(text, map, sortedKeys);

        if (!translated || translated === text) {
            return;
        }

        if (el.tagName === 'INPUT') {
            el.value = translated;
        } else {
            el.textContent = translated;
        }
    });

    if (document.title) {
        document.title = applyTranslationMap(document.title, map, sortedKeys);
    }
}

// Save locale preference
function setLocale(locale) {
    if (getSupportedLocales().includes(locale)) {
        localStorage.setItem('siteLocale', locale);
        window.location.href = `/lang/${locale}`;
    }
}

function initSiteTranslations() {
    translatePage();
}

// Initialize translation on page load
document.addEventListener('DOMContentLoaded', function () {
    initSiteTranslations();
});

// Export for global use
window.BestLiveIPTV = window.BestLiveIPTV || {};
window.BestLiveIPTV.translate = translate;
window.BestLiveIPTV.translatePage = translatePage;
window.BestLiveIPTV.setLocale = setLocale;
window.BestLiveIPTV.getCurrentLocale = getCurrentLocale;
window.BestLiveIPTV.initSiteTranslations = initSiteTranslations;
