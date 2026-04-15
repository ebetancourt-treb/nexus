<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BlumOps — Tu almacén, tus reglas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --jade: #059669;
            --jade-dark: #047857;
            --jade-50: #ecfdf5;
            --jade-100: #d1fae5;
            --jade-900: #022c22;
            --text: #1f2937;
            --text-secondary: #6b7280;
            --text-light: #9ca3af;
            --bg: #ffffff;
            --bg-alt: #f8fafb;
            --border: #e5e7eb;
        }

        html { scroll-behavior: smooth; }
        body { font-family: 'Montserrat', sans-serif; color: var(--text); background: var(--bg); -webkit-font-smoothing: antialiased; }

        /* ─── Header ─── */
        .header {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(255,255,255,0.92); backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(229,231,235,0.5);
            transition: box-shadow 0.3s;
        }
        .header.scrolled { box-shadow: 0 1px 12px rgba(0,0,0,0.06); }
        .header-inner { max-width: 1200px; margin: 0 auto; padding: 0 24px; height: 64px; display: flex; align-items: center; justify-content: space-between; }
        .logo { font-family: 'Special Gothic Expanded One', sans-serif; font-size: 1.25rem; color: var(--jade-900); text-decoration: none; letter-spacing: -0.5px; }
        .header-nav { display: flex; align-items: center; gap: 32px; }
        .header-nav a { font-size: 0.82rem; font-weight: 500; color: var(--text-secondary); text-decoration: none; transition: color 0.2s; }
        .header-nav a:hover { color: var(--jade); }
        .header-actions { display: flex; align-items: center; gap: 12px; }
        .btn-login { padding: 8px 20px; font-size: 0.82rem; font-weight: 600; color: var(--text-secondary); background: transparent; border: 1px solid var(--border); border-radius: 8px; text-decoration: none; transition: all 0.2s; font-family: inherit; }
        .btn-login:hover { border-color: var(--jade); color: var(--jade); }
        .btn-cta { padding: 8px 20px; font-size: 0.82rem; font-weight: 600; color: #fff; background: var(--jade); border: none; border-radius: 8px; text-decoration: none; transition: background 0.2s; font-family: inherit; cursor: pointer; }
        .btn-cta:hover { background: var(--jade-dark); }

        /* ─── Hero ─── */
        .hero {
            padding: 140px 24px 80px; text-align: center;
            background: linear-gradient(180deg, var(--jade-50) 0%, var(--bg) 100%);
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: ''; position: absolute; top: -200px; right: -200px;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(5,150,105,0.06) 0%, transparent 70%);
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 6px; padding: 6px 16px;
            background: rgba(5,150,105,0.08); border: 1px solid rgba(5,150,105,0.15);
            border-radius: 50px; font-size: 0.72rem; font-weight: 600; color: var(--jade);
            margin-bottom: 24px;
        }
        .hero h1 {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: clamp(2.2rem, 5vw, 3.5rem); line-height: 1.1;
            color: var(--jade-900); max-width: 700px; margin: 0 auto 20px;
        }
        .hero p {
            font-size: clamp(0.95rem, 2vw, 1.1rem); color: var(--text-secondary);
            max-width: 560px; margin: 0 auto 36px; line-height: 1.7;
        }
        .hero-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .btn-hero-primary {
            padding: 14px 32px; font-size: 0.92rem; font-weight: 700; color: #fff;
            background: var(--jade); border: none; border-radius: 10px;
            text-decoration: none; font-family: inherit; cursor: pointer;
            transition: all 0.2s; box-shadow: 0 4px 16px rgba(5,150,105,0.25);
        }
        .btn-hero-primary:hover { background: var(--jade-dark); transform: translateY(-1px); box-shadow: 0 6px 24px rgba(5,150,105,0.3); }
        .btn-hero-secondary {
            padding: 14px 32px; font-size: 0.92rem; font-weight: 600; color: var(--text-secondary);
            background: #fff; border: 1px solid var(--border); border-radius: 10px;
            text-decoration: none; font-family: inherit; transition: all 0.2s;
        }
        .btn-hero-secondary:hover { border-color: var(--jade); color: var(--jade); }
        .hero-note { font-size: 0.72rem; color: var(--text-light); margin-top: 16px; }

        /* ─── Features ─── */
        .features { padding: 80px 24px; background: var(--bg); }
        .section-inner { max-width: 1100px; margin: 0 auto; }
        .section-label {
            font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.08em; color: var(--jade); margin-bottom: 12px; text-align: center;
        }
        .section-title {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: clamp(1.5rem, 3vw, 2rem); color: var(--jade-900);
            text-align: center; margin-bottom: 12px;
        }
        .section-subtitle { font-size: 0.92rem; color: var(--text-secondary); text-align: center; max-width: 560px; margin: 0 auto 48px; line-height: 1.6; }
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .feature-card {
            padding: 28px; border: 1px solid var(--border); border-radius: 12px;
            background: var(--bg); transition: all 0.3s;
        }
        .feature-card:hover { border-color: var(--jade); box-shadow: 0 8px 32px rgba(5,150,105,0.06); transform: translateY(-2px); }
        .feature-icon {
            width: 44px; height: 44px; border-radius: 10px; background: var(--jade-50);
            display: flex; align-items: center; justify-content: center; margin-bottom: 16px;
        }
        .feature-icon svg { width: 22px; height: 22px; color: var(--jade); }
        .feature-card h3 { font-size: 0.92rem; font-weight: 700; color: var(--text); margin-bottom: 8px; }
        .feature-card p { font-size: 0.82rem; color: var(--text-secondary); line-height: 1.6; }

        /* ─── Differentiator ─── */
        .diff { padding: 64px 24px; background: var(--jade-900); color: #fff; }
        .diff-inner { max-width: 800px; margin: 0 auto; text-align: center; }
        .diff h2 { font-family: 'Special Gothic Expanded One', sans-serif; font-size: clamp(1.3rem, 3vw, 1.8rem); margin-bottom: 16px; }
        .diff p { font-size: 0.92rem; color: rgba(255,255,255,0.7); line-height: 1.7; max-width: 600px; margin: 0 auto; }
        .diff-highlight { color: #a7f3d0; font-weight: 700; }

        /* ─── Pricing ─── */
        .pricing { padding: 80px 24px; background: var(--bg-alt); }
        .pricing-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; max-width: 1000px; margin: 0 auto; }
        .price-card {
            background: var(--bg); border: 1px solid var(--border); border-radius: 14px;
            padding: 32px 28px; position: relative; transition: all 0.3s;
        }
        .price-card:hover { box-shadow: 0 12px 40px rgba(0,0,0,0.06); }
        .price-card.popular { border-color: var(--jade); box-shadow: 0 8px 32px rgba(5,150,105,0.1); }
        .price-badge {
            position: absolute; top: -12px; left: 50%; transform: translateX(-50%);
            padding: 4px 16px; background: var(--jade); color: #fff; border-radius: 50px;
            font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .price-name { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-secondary); margin-bottom: 8px; }
        .price-amount { font-size: 2.2rem; font-weight: 800; color: var(--text); }
        .price-amount span { font-size: 0.85rem; font-weight: 500; color: var(--text-light); }
        .price-desc { font-size: 0.78rem; color: var(--text-secondary); margin: 8px 0 20px; line-height: 1.5; }
        .price-features { list-style: none; margin-bottom: 24px; }
        .price-features li { font-size: 0.78rem; color: var(--text-secondary); padding: 6px 0; display: flex; align-items: flex-start; gap: 8px; }
        .price-features li::before { content: '✓'; color: var(--jade); font-weight: 700; flex-shrink: 0; }
        .price-btn {
            display: block; width: 100%; padding: 12px; text-align: center;
            border-radius: 10px; font-size: 0.82rem; font-weight: 700;
            font-family: inherit; cursor: pointer; text-decoration: none; transition: all 0.2s;
        }
        .price-btn-primary { background: var(--jade); color: #fff; border: none; }
        .price-btn-primary:hover { background: var(--jade-dark); }
        .price-btn-outline { background: transparent; color: var(--jade); border: 1.5px solid var(--jade); }
        .price-btn-outline:hover { background: var(--jade-50); }

        /* ─── FAQ ─── */
        .faq { padding: 80px 24px; background: var(--bg); }
        .faq-list { max-width: 700px; margin: 0 auto; }
        .faq-item { border-bottom: 1px solid var(--border); }
        .faq-q {
            padding: 18px 0; font-size: 0.88rem; font-weight: 600; color: var(--text);
            cursor: pointer; display: flex; justify-content: space-between; align-items: center;
            background: none; border: none; width: 100%; text-align: left; font-family: inherit;
        }
        .faq-q:hover { color: var(--jade); }
        .faq-q::after { content: '+'; font-size: 1.2rem; color: var(--text-light); transition: transform 0.2s; }
        .faq-item.open .faq-q::after { content: '−'; color: var(--jade); }
        .faq-a { max-height: 0; overflow: hidden; transition: max-height 0.3s ease, padding 0.3s; }
        .faq-item.open .faq-a { max-height: 200px; padding-bottom: 18px; }
        .faq-a p { font-size: 0.82rem; color: var(--text-secondary); line-height: 1.7; }

        /* ─── CTA ─── */
        .cta-section { padding: 64px 24px; background: var(--jade); text-align: center; }
        .cta-section h2 { font-family: 'Special Gothic Expanded One', sans-serif; font-size: clamp(1.3rem, 3vw, 1.8rem); color: #fff; margin-bottom: 12px; }
        .cta-section p { font-size: 0.92rem; color: rgba(255,255,255,0.8); margin-bottom: 28px; }
        .btn-cta-white {
            padding: 14px 36px; font-size: 0.92rem; font-weight: 700; color: var(--jade);
            background: #fff; border: none; border-radius: 10px; text-decoration: none;
            font-family: inherit; cursor: pointer; transition: all 0.2s;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        .btn-cta-white:hover { transform: translateY(-1px); box-shadow: 0 6px 24px rgba(0,0,0,0.15); }

        /* ─── Footer ─── */
        .footer { padding: 48px 24px 32px; background: var(--jade-900); color: rgba(255,255,255,0.6); }
        .footer-inner { max-width: 1100px; margin: 0 auto; display: flex; justify-content: space-between; align-items: flex-start; gap: 32px; flex-wrap: wrap; }
        .footer-brand .logo { color: #fff; }
        .footer-brand p { font-size: 0.75rem; color: rgba(255,255,255,0.4); margin-top: 8px; max-width: 280px; line-height: 1.5; }
        .footer-links { display: flex; gap: 48px; }
        .footer-col h4 { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: rgba(255,255,255,0.5); margin-bottom: 12px; }
        .footer-col a { display: block; font-size: 0.78rem; color: rgba(255,255,255,0.6); text-decoration: none; padding: 3px 0; transition: color 0.2s; }
        .footer-col a:hover { color: #a7f3d0; }
        .footer-bottom { max-width: 1100px; margin: 32px auto 0; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.08); font-size: 0.7rem; color: rgba(255,255,255,0.3); display: flex; justify-content: space-between; }

        /* ─── Mobile menu ─── */
        .mobile-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
        .mobile-toggle svg { width: 24px; height: 24px; color: var(--text); }

        /* ─── Responsive ─── */
        @media (max-width: 768px) {
            .header-nav { display: none; }
            .mobile-toggle { display: block; }
            .features-grid { grid-template-columns: 1fr; }
            .pricing-grid { grid-template-columns: 1fr; max-width: 400px; }
            .footer-links { flex-direction: column; gap: 24px; }
            .footer-bottom { flex-direction: column; gap: 8px; }
        }
        @media (min-width: 769px) and (max-width: 1024px) {
            .features-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

<!-- Header -->
<header class="header" id="header">
    <div class="header-inner">
        <a href="/" class="logo">BlumOps</a>
        <nav class="header-nav">
            <a href="#features">Funciones</a>
            <a href="#pricing">Precios</a>
            <a href="#faq">FAQ</a>
        </nav>
        <div class="header-actions">
            <a href="{{ route('login') }}" class="btn-login">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="btn-cta">Prueba gratis</a>
        </div>
        <button class="mobile-toggle" onclick="document.querySelector('.header-nav').style.display = document.querySelector('.header-nav').style.display === 'flex' ? 'none' : 'flex';">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
        </button>
    </div>
</header>

<!-- Hero -->
<section class="hero">
    <div class="hero-badge">WMS para PYMES mexicanas</div>
    <h1>Tu almacén, tus reglas</h1>
    <p>BlumOps es el sistema de gestión de almacenes que se adapta a tu proceso — no al revés. Control de inventario en tiempo real, recepción multi-lote, y operación por scanner desde $349 MXN/mes.</p>
    <div class="hero-actions">
        <a href="{{ route('register') }}" class="btn-hero-primary">Empezar prueba gratis — 7 días</a>
        <a href="#pricing" class="btn-hero-secondary">Ver precios</a>
    </div>
    <p class="hero-note">Sin tarjeta de crédito. Configurado en 2 minutos.</p>
</section>

<!-- Features -->
<section class="features" id="features">
    <div class="section-inner">
        <div class="section-label">Funciones</div>
        <h2 class="section-title">Todo lo que tu almacén necesita</h2>
        <p class="section-subtitle">Diseñado para operadores reales en almacenes reales. No necesitas ser experto en tecnología para usarlo.</p>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/></svg></div>
                <h3>Inventario en tiempo real</h3>
                <p>Conoce el stock exacto de cada producto, en cada almacén, en todo momento. Sin hojas de cálculo, sin sorpresas.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/></svg></div>
                <h3>Recepción multi-lote</h3>
                <p>Recibe mercancía con múltiples lotes y fechas de caducidad en un solo movimiento. Ideal para farmacéuticas y distribuidoras.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125h4.5"/></svg></div>
                <h3>Scanner / código de barras</h3>
                <p>Escanea con cualquier lector USB y el producto se agrega automáticamente. Sin clics, sin errores de captura.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/></svg></div>
                <h3>FIFO / FEFO automático</h3>
                <p>Configura la estrategia de rotación por almacén: primero en entrar, primero en salir; o primero en expirar.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35"/></svg></div>
                <h3>Multi-almacén</h3>
                <p>Gestiona varios almacenes o sucursales desde una sola cuenta. Cada almacén con su propia configuración.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625z"/></svg></div>
                <h3>Dashboard y alertas</h3>
                <p>Valor del inventario, movimientos del día, productos con stock bajo — todo en una pantalla al iniciar sesión.</p>
            </div>
        </div>
    </div>
</section>

<!-- Differentiator -->
<section class="diff">
    <div class="diff-inner">
        <h2>El WMS que faltaba en México</h2>
        <p>Los WMS accesibles no se adaptan a tu proceso. Los que se adaptan cuestan $500+ USD al mes. BlumOps ocupa ese espacio: <span class="diff-highlight">alta flexibilidad a precio de PYME</span>. Tu proveedor farmacéutico necesita recepción multi-lote con diferentes caducidades en 1 movimiento — con BlumOps se puede.</p>
    </div>
</section>

<!-- Pricing -->
<section class="pricing" id="pricing">
    <div class="section-inner">
        <div class="section-label">Precios</div>
        <h2 class="section-title">Un plan para cada etapa</h2>
        <p class="section-subtitle">Todos los planes incluyen 7 días de prueba gratis. Sin tarjeta de crédito.</p>

        <div class="pricing-grid">
            <div class="price-card">
                <div class="price-name">Starter</div>
                <div class="price-amount">$349 <span>MXN/mes</span></div>
                <p class="price-desc">Para negocios que inician su gestión de almacén digital.</p>
                <ul class="price-features">
                    <li>1 almacén</li>
                    <li>Hasta 1,000 productos</li>
                    <li>3 usuarios</li>
                    <li>Recepción y despacho estándar</li>
                    <li>Scanner / código de barras</li>
                    <li>Dashboard con alertas</li>
                    <li>Soporte por correo</li>
                </ul>
                <a href="{{ route('register', ['plan' => 'starter']) }}" class="price-btn price-btn-outline">Probar gratis</a>
            </div>

            <div class="price-card popular">
                <div class="price-badge">Más popular</div>
                <div class="price-name">Profesional</div>
                <div class="price-amount">$899 <span>MXN/mes</span></div>
                <p class="price-desc">Para operaciones que necesitan flexibilidad en sus procesos.</p>
                <ul class="price-features">
                    <li>Hasta 3 almacenes</li>
                    <li>Productos ilimitados</li>
                    <li>10 usuarios</li>
                    <li>Control por lotes y series</li>
                    <li>Recepción multi-lote</li>
                    <li>FIFO / FEFO por almacén</li>
                    <li>Proveedores y órdenes de compra</li>
                    <li>Soporte prioritario</li>
                </ul>
                <a href="{{ route('register', ['plan' => 'profesional']) }}" class="price-btn price-btn-primary">Empezar gratis — 7 días</a>
            </div>

            <div class="price-card">
                <div class="price-name">Enterprise</div>
                <div class="price-amount">$2,499 <span>MXN/mes</span></div>
                <p class="price-desc">Para empresas con operaciones complejas y múltiples ubicaciones.</p>
                <ul class="price-features">
                    <li>Almacenes ilimitados</li>
                    <li>Productos ilimitados</li>
                    <li>Usuarios ilimitados</li>
                    <li>Todo lo del Profesional</li>
                    <li>Conteos cíclicos y pick lists</li>
                    <li>API para integraciones</li>
                    <li>Consultoría de implementación</li>
                    <li>Soporte dedicado + SLA</li>
                </ul>
                <a href="https://wa.me/528711234567?text=Hola%2C%20me%20interesa%20el%20plan%20Enterprise%20de%20BlumOps" target="_blank" class="price-btn price-btn-outline">Contactar ventas</a>

            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="faq" id="faq">
    <div class="section-inner">
        <div class="section-label">Preguntas frecuentes</div>
        <h2 class="section-title">Lo que necesitas saber</h2>
        <div style="height: 32px;"></div>

        <div class="faq-list">
            <div class="faq-item">
                <button class="faq-q" onclick="this.parentElement.classList.toggle('open')">¿Qué es BlumOps?</button>
                <div class="faq-a"><p>BlumOps es un sistema de gestión de almacenes (WMS) en la nube, diseñado para PYMES mexicanas. Te permite controlar inventario, recibir y despachar mercancía, y gestionar múltiples almacenes desde cualquier dispositivo.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="this.parentElement.classList.toggle('open')">¿Puedo usarlo con mi lector de código de barras?</button>
                <div class="faq-a"><p>Sí. BlumOps funciona con cualquier lector de código de barras USB estándar. Solo conecta el lector a tu computadora y escanea directamente en el formulario de recepción o despacho.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="this.parentElement.classList.toggle('open')">¿Incluye facturación o CFDI?</button>
                <div class="faq-a"><p>No. BlumOps se especializa 100% en la gestión del almacén. Se integra con tu sistema de facturación existente (Bind, Alegra, CONTPAQi, etc.) para que cada herramienta haga lo que mejor sabe hacer.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="this.parentElement.classList.toggle('open')">¿Qué diferencia a BlumOps de otros sistemas de inventario?</button>
                <div class="faq-a"><p>La mayoría de los sistemas de inventario accesibles usan procesos rígidos. BlumOps permite adaptar los flujos de recepción, despacho y control a cómo realmente opera tu almacén — por ejemplo, recepción multi-lote con diferentes fechas de caducidad en un solo movimiento.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="this.parentElement.classList.toggle('open')">¿Cuánto tiempo toma configurar mi cuenta?</button>
                <div class="faq-a"><p>Menos de 5 minutos. Te registras, se crea tu almacén automáticamente, y puedes empezar a dar de alta productos y recibir mercancía de inmediato.</p></div>
            </div>
            <div class="faq-item">
                <button class="faq-q" onclick="this.parentElement.classList.toggle('open')">¿Puedo cambiar de plan después?</button>
                <div class="faq-a"><p>Sí. Puedes subir o bajar de plan en cualquier momento. El cambio se refleja en tu próximo ciclo de facturación.</p></div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <h2>Empieza a controlar tu almacén hoy</h2>
    <p>7 días gratis. Sin tarjeta de crédito. Configurado en minutos.</p>
    <a href="{{ route('register') }}" class="btn-cta-white">Crear cuenta gratis</a>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <a href="/" class="logo">BlumOps</a>
            <p>Sistema de gestión de almacenes para PYMES mexicanas. Un producto de Treblum™.</p>
        </div>
        <div class="footer-links">
            <div class="footer-col">
                <h4>Producto</h4>
                <a href="#features">Funciones</a>
                <a href="#pricing">Precios</a>
                <a href="#faq">FAQ</a>
            </div>
            <div class="footer-col">
                <h4>Cuenta</h4>
                <a href="{{ route('login') }}">Iniciar sesión</a>
                <a href="{{ route('register') }}">Crear cuenta</a>
            </div>
            <div class="footer-col">
                <h4>Legal</h4>
                <a href="#">Términos de servicio</a>
                <a href="#">Política de privacidad</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <span>&copy; {{ date('Y') }} Treblum™. Todos los derechos reservados.</span>
        <span>Hecho en Torreón, México</span>
    </div>
</footer>

<script>
    // Header scroll effect
    window.addEventListener('scroll', () => {
        document.getElementById('header').classList.toggle('scrolled', window.scrollY > 20);
    });
</script>
</body>
</html>
