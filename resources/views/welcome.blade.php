<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlumOps - Sistema de Inventarios | Producto de Treblum™</title>
    <meta name="description" content="BlumOps es el sistema de inventarios de Treblum™. Controla tu stock, almacenes, ventas y compras en tiempo real. Prueba gratis 7 días.">
    <link rel="canonical" href="https://nexusinventory.mx/precios">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Software de Inventarios | Control Total para tu Negocio">
    <meta property="og:description" content="Gestiona tu inventario en tiempo real con el sistema más completo de México">
    <meta property="og:url" content="https://nexusinventory.mx/precios">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet">
    <link rel="icon" href="/favicon.ico">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --jade: #059669;
            --jade-dark: #047857;
            --text: #1c1c1c;
            --text-light: #6b7280;
            --text-secondary: #666;
            --border: #e5e7eb;
            --bg-light: #f9fafb;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text);
            line-height: 1.6;
            background: #fff;
            overflow-x: hidden;
        }

        /* Header */
        header {
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav {
            max-width: 1400px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: 'Special Gothic Expanded One', sans-serif;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0;
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.15;
            color: #585858;
        }

        .logo-blum {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: inherit;
            font-weight: inherit;
            color: inherit;
        }

        .logo-ops {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: inherit;
            font-weight: inherit;
            color: inherit;
        }

        .btn-header {
            padding: 5px 24px;
            background: linear-gradient(135deg, #047857 0%, #059669 50%, #10b981 100%);
            color: white;
            border: none;
            border-radius: 50px;
            text-decoration: none;
            font-size: .80rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
           
        }

        .btn-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.4) 50%,
                transparent
            );
            transition: left 0.5s ease;
        }

        .btn-header:hover::before {
            left: 100%;
        }


      

        /* Hero Section */
        .hero {
            min-height: 50vh;
            display: flex;
            align-items: center;
            padding: 80px 24px 60px;
            background: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 1;
            text-align: left;
            width: 100%;
        }

        .background-text {
            position: absolute;
            bottom: -90px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 200px;
            font-weight: 700;
            color: #fafafa;
            letter-spacing: -6px;
            user-select: none;
            pointer-events: none;
            z-index: 0;
            opacity: 0.3;
            font-family: 'Montserrat', sans-serif;
            white-space: nowrap;
        }

        .hero-label {
            font-size: .8rem;
            font-weight: 300;
            letter-spacing: 1px;
            color: var(--text-secondary);
            margin-bottom: 14px;
        }

        .hero h1 {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 20px;
            max-width: 700px;
            color: #585858;
            max-width: 45%;
            letter-spacing: -.5px;

        }

        .hero-subtitle {
            font-size: 1rem;
            font-weight: 300;
            line-height: 1.6;
            color: var(--text-secondary);
            max-width: 600px;
            margin-bottom: 48px;
                        max-width: 40%;

        }

        /* Billing Toggle */
        .pricing-controls {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 60px;
        }

        .billing-toggle {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .billing-toggle span {
            font-size: 0.9rem;
            font-weight: 500;
            color: #6b7280;
            transition: color 0.3s ease;
        }

        .billing-toggle span.active {
            color: #000000;
        }

        .billing-toggle .save-badge {
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg, #047857 0%, #059669 50%, #10b981 100%);
            padding: 4px 10px;
            border-radius: 50px;
            margin-left: 4px;
            box-shadow: 
                0 2px 6px rgba(5, 150, 105, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        /* Toggle Switch */
        .toggle-switch {
            position: relative;
            width: 48px;
            height: 24px;
            background: #e5e7eb;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-switch.active {
            background: linear-gradient(135deg, #047857 0%, #059669 50%, #10b981 100%);
            box-shadow: 
                0 2px 8px rgba(5, 150, 105, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2),
                inset 0 -1px 0 rgba(0, 0, 0, 0.2);
        }

        .toggle-switch::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .toggle-switch.active::after {
            transform: translateX(24px);
        }

        /* Pricing Section */
        .pricing-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 60px 24px;
        }

        .pricing-title {
            text-align: left;
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 100px;
            color: #585858;
            max-width: 30%;
            line-height: 1.15;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
        }

        .pricing-card {
            background: #fff;
            border-radius: 12px;
            padding: 40px 30px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            position: relative;
        }

        .pricing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }

        .pricing-card.popular {
            border: 2px solid var(--jade);
        }

        .popular-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #047857 0%, #059669 50%, #10b981 100%);
            color: white;
            padding: 6px 20px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 
                0 2px 8px rgba(5, 150, 105, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.3),
                inset 0 -1px 0 rgba(0, 0, 0, 0.2);
        }

        .plan-name {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #585858;
        }

        .plan-description {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-bottom: 25px;
            line-height: 1.6;
            min-height: 48px;
        }

        .price-container {
            margin-bottom: 30px;
        }

        .price-amount {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text);
            line-height: 1;
        }

        .price-period {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-top: 5px;
        }

        .price-savings {
            display: inline-block;
            background: linear-gradient(135deg, #047857 0%, #059669 50%, #10b981 100%);
            color: white;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-top: 10px;
            box-shadow: 
                0 2px 6px rgba(5, 150, 105, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .features-list {
            list-style: none;
            margin-bottom: 32px;
        }

        .features-list li {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .features-list li:last-child {
            border-bottom: none;
        }

        .feature-icon {
            color: var(--jade);
            margin-right: 10px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .cta-button {
            display: block;
            width: 100%;
            padding: 6px 25px;
            text-align: center;
            background: linear-gradient(135deg, #047857 0%, #059669 50%, #10b981 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
           
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.4) 50%,
                transparent
            );
            transition: left 0.5s ease;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .cta-button:hover {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
            box-shadow: 
                0 4px 16px rgba(5, 150, 105, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.4),
                inset 0 -1px 0 rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }

        .cta-button:active {
            transform: translateY(0);
            box-shadow: 
                0 2px 8px rgba(5, 150, 105, 0.3),
                inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .cta-button.secondary {
            background: transparent;
            color: var(--jade);
            border: 2px solid var(--jade);
            box-shadow: none;
            
        }

        .cta-button.secondary::before {
            display: none;
        }

        .cta-button.secondary:hover {
            background: rgba(5, 150, 105, 0.05);
            box-shadow: none;
            transform: translateY(0);
        }

        /* Comparison Section */
        .comparison-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 60px 24px;
        }

        .comparison-title {
            text-align: left;
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 100px;
            color: #585858;
            max-width: 30%;
            line-height: 1.15;
        }

        .table-wrap {
            overflow-x: auto;
        }

        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .comparison-table th {
            padding: 20px;
            text-align: left;
            background: var(--bg-light);
            font-weight: 600;
            color: var(--text);
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .comparison-table td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
        }

        .comparison-table tr:last-child td {
            border-bottom: none;
        }

        .check-icon {
            color: var(--jade);
            font-weight: 600;
        }

        /* FAQ Section */
        .faq-section {
            max-width: 100%;
            margin: 0 auto;
            padding: 80px 0 80px 64px;
            position: relative;
            overflow: hidden;
        }

        .faq-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 60px;
            margin-left: 150px;
            position: relative;
            max-width: 1250px;
            padding-right: 64px;
        }

        .faq-nav {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .carousel-arrows {
            display: flex;
            gap: 12px;
        }

        .carousel-arrow {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid rgba(0,0,0,0.1);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            color: #666;
        }

        .carousel-arrow:hover {
            background: #f5f5f5;
            border-color: rgba(0,0,0,0.2);
        }

        .carousel-arrow:active {
            transform: scale(0.95);
        }

        .faq-title {
             text-align: right;
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 100px;
            color: #585858;
            max-width: 45%;
            line-height: 1.15;
            margin-right: -230px;
        }

        .faq-title::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -20px;
            width: 500px;
            height: 200px;
            background-image: 
                linear-gradient(to right, #e8e8e8 1px, transparent 1px),
                linear-gradient(to bottom, #e8e8e8 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.3;
            mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, 
                        black 0%, 
                        black 40%, 
                        transparent 100%);
            -webkit-mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, 
                                black 0%, 
                                black 40%, 
                                transparent 100%);
            z-index: -1;
            pointer-events: none;
        }

        .faq-carousel-wrapper {
            position: relative;
            overflow-x: auto;
            overflow-y: hidden;
            padding: 20px 0 40px 0;
            margin-left: 150px;
            margin-right: -64px;
            padding-right: 64px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .faq-carousel-wrapper::-webkit-scrollbar {
            display: none;
        }

        .faq-carousel {
            display: flex;
            gap: 16px;
            width: max-content;
            padding: 0 20px;
        }

        .faq-card {
            background: #ffffff;
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: 10px;
            padding: 36px 32px 40px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            min-height: 280px;
            width: 320px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .faq-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 32px rgba(0,0,0,0.08);
        }

        .faq-question-text {
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            line-height: 1.2;
            margin-bottom: 16px;
            text-align: left;
            padding-top: 8px;
        }

        .faq-answer-text {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.85rem;
            line-height: 1.5;
            color: #666;
            font-weight: 400;
            text-align: left;
            margin-top: 0;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: all 0.6s cubic-bezier(0.22, 0.61, 0.36, 1);
        }

        .faq-card.active .faq-answer-text {
            max-height: 500px;
            opacity: 1;
        }

        .custom-cursor-tooltip {
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.2s ease;
            transform: translate(-50%, -50%);
        }

        .custom-cursor-tooltip.visible {
            opacity: 1;
        }

        .custom-cursor-tooltip-inner {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 50px;
            padding: 8px 20px;
            font-family: 'Montserrat', sans-serif;
            font-size: 12px;
            font-weight: 600;
            color: #333;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Trust Section */
        .trust-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 60px 24px;
            text-align: left;
            background: var(--bg-light);
        }

        .trust-title {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 30px;
            color: #585858;
        }

        .trust-badges {
            display: flex;
            justify-content: flex-start;
            gap: 40px;
            flex-wrap: wrap;
        }

        .trust-badge {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .trust-badge img {
            width: 60px;
            height: 60px;
            border-radius: 12px;
        }

        .trust-badge span {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* CTA Banner */
        .cta-banner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 24px;
            text-align: left;
        }

        .cta-banner h3 {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #585858;
        }

        .cta-banner p {
            font-size: 1rem;
            color: var(--text-secondary);
            margin-bottom: 30px;
            max-width: 700px;
            line-height: 1.7;
        }

        /* Legal Disclaimer */
        .legal-disclaimer {
            max-width: 1400px;
            margin: 0 auto;
            padding: 60px 24px 40px;
            background: #ffffff;
        }

        .disclaimer-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .disclaimer-text {
            font-size: 0.7rem;
            line-height: 1.6;
            color: #6b7280;
            margin-bottom: 16px;
            text-align: left;
            font-weight: 400;
        }

        .disclaimer-text sup {
            font-size: 0.65rem;
            font-weight: 600;
            color: #4b5563;
            margin-right: 4px;
        }

        .disclaimer-text:last-child {
            margin-bottom: 0;
        }

        .disclaimer-text a {
            color: var(--jade);
            text-decoration: none;
            transition: opacity 0.2s ease;
        }

        .disclaimer-text a:hover {
            opacity: 0.7;
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .background-text {
                font-size: 140px;
                bottom: -70px;
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 60px 24px 40px;
            }

            .hero h1 {
                font-size: 1.5rem;
                max-width: 100%;
            }

            .hero-subtitle {
                font-size: 0.95rem;
            }

            .background-text {
                font-size: 90px;
                bottom: -45px;
            }

            .pricing-controls {
                justify-content: flex-start;
            }

            .billing-toggle {
                width: auto;
            }

            .logo {
                font-size: 1.5rem;
            }

            .pricing-grid {
                grid-template-columns: 1fr;
            }

            .comparison-table {
                font-size: 14px;
            }

            .comparison-table th,
            .comparison-table td {
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            .hero {
                padding: 48px 20px 32px;
            }

            .hero h1 {
                font-size: 1.2rem;
            }

            .hero-subtitle {
                font-size: 0.9rem;
            }

            .background-text {
                font-size: 70px;
                bottom: -35px;
            }

            .logo {
                font-size: 1.2rem;
            }

            .pricing-card {
                padding: 30px 20px;
            }

            .price-amount {
                font-size: 2rem;
            }

            .billing-toggle {
                font-size: 0.85rem;
            }

            .billing-toggle .save-badge,
            .save-badge {
                font-size: 0.7rem;
                padding: 3px 8px;
            }

            /* FAQ mobile styles */
            .faq-section {
                padding: 48px 0;
                overflow: visible;
            }
            
            .faq-header {
                margin-bottom: 40px;
                margin-left: 0;
                flex-direction: column-reverse;
                gap: 24px;
                padding-right: 24px;
                padding-left: 24px;
            }
            
            .faq-nav {
                display: none;
            }
            
            .faq-title {
                font-size: 1.5rem;
                text-align: left;
                line-height: 1.1;
                max-width: 90%;
            }
            
            .faq-title::before {
                top: -35px;
                left: -15px;
                right: auto;
                width: 340px;
                height: 180px;
                background-size: 18px 18px;
            }
            
            .faq-question-text {
                font-size: 1rem;
                margin-bottom: 14px;
                line-height: 1.25;
                font-weight: 600;
            }
            
            .faq-answer-text {
                font-size: 0.85rem;
                line-height: 1.6;
                color: #555;
            }
            
            .faq-carousel-wrapper {
                padding: 0 0 30px 0;
                overflow-x: auto;
                overflow-y: hidden;
                margin-left: 0;
                margin-right: 0;
                -webkit-overflow-scrolling: touch;
                scroll-snap-type: x mandatory;
            }
            
            .faq-carousel {
                display: flex;
                gap: 16px;
                padding: 0 24px;
                width: max-content;
            }
            
            .faq-card {
                width: 85vw;
                max-width: 340px;
                padding: 32px 28px 36px;
                min-height: auto;
                scroll-snap-align: center;
                flex-shrink: 0;
            }
            
            /* Mostrar todas las respuestas en mobile */
            .faq-card .faq-answer-text {
                max-height: none;
                opacity: 1;
            }
            
            /* Deshabilitar hover en mobile */
            .faq-card:hover {
                transform: none;
                box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            }

            .legal-disclaimer {
                padding: 40px 20px 32px;
            }

            .disclaimer-text {
                font-size: 0.65rem;
                line-height: 1.5;
            }
        }

        /* ============================================================================
           FOOTER COMPLETO - BLUMOPS
           ============================================================================ */

        footer {
            all: initial;
            display: block !important;
            width: 100%;
            box-sizing: border-box;
        }

        footer,
        footer *,
        footer *::before,
        footer *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', sans-serif;
        }

        footer {
            --primary: #059669;
            --text-main: #1d1d1f;
            --text-secondary: #575757;
            --text-light: #6c6c6c;
            --border-footer: rgba(0, 0, 0, 0.08);
            background: #fafafa;
            position: relative;
            z-index: 1000;
            padding: 80px 0 32px;
            overflow: visible !important;
            border-radius: 40px 40px 0 0;
            margin-top: 0;
            border-top: 1px solid var(--border-footer);
        }

        footer .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }

        /* FOOTER GRID */
        footer .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 64px;
            margin-bottom: 48px;
            padding-bottom: 40px;
            border-bottom: 1px solid var(--border-footer);
        }

        /* BRAND SECTION */
        footer .footer-brand {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        footer .footer-logo {
            display: flex;
            align-items: center;
            gap: 0;
            transition: transform .2s ease;
            width: fit-content;
            cursor: pointer;
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.15;
            color: #585858;
        }

        footer .footer-logo:hover {
            transform: scale(1.02);
        }

        footer .footer-logo-blum {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: inherit;
            font-weight: inherit;
            color: inherit;
        }

        footer .footer-logo-ops {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: inherit;
            font-weight: inherit;
            color: inherit;
        }

        footer .footer-tagline {
            font-size: 0.75rem;
            color: rgba(29, 29, 31, 0.6);
            line-height: 1.5;
            max-width: 280px;
        }

        /* FOOTER COLUMNS */
        footer .footer-column h3 {
            font-family: 'Special Gothic Expanded One', sans-serif;
            font-size: 0.65rem;
            font-weight: 300;
            color: rgba(29, 29, 31, 0.5);
            letter-spacing: 0.05em;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        footer .footer-links {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        footer .footer-links a {
            font-size: 0.75rem;
            font-weight: 400;
            color: rgba(29, 29, 31, 0.7);
            text-decoration: none;
            padding-left: 20px;
            position: relative;
            line-height: 1.2;
            transition: all .2s ease;
            cursor: pointer;
        }

        footer .footer-links a::before {
            content: '·';
            position: absolute;
            left: 0;
            color: rgba(29, 29, 31, 0.4);
            font-size: 20px;
            line-height: 1;
            transition: color .2s ease;
        }

        footer .footer-links a:hover {
            color: var(--primary);
            padding-left: 24px;
        }

        footer .footer-links a:hover::before {
            color: var(--primary);
        }

        /* FOOTER BOTTOM */
        footer .footer-bottom {
            display: flex !important;
            justify-content: space-between;
            align-items: center;
            gap: 32px;
        }

        footer .footer-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        footer .footer-copyright {
            font-size: 0.70rem;
            font-weight: 300;
            color: rgba(29, 29, 31, 0.45);
            line-height: 1.4;
        }

        footer .footer-copyright a {
            color: var(--primary);
            text-decoration: none;
            transition: opacity .2s ease;
        }

        footer .footer-copyright a:hover {
            opacity: 0.7;
        }

        /* SOCIAL LINKS */
        footer .social-links {
            display: flex !important;
            gap: 10px;
            align-items: center;
        }

        footer .social-icon {
            width: 32px !important;
            height: 32px !important;
            border-radius: 50% !important;
            background: rgba(0, 0, 0, 0.04) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: var(--text-light) !important;
            text-decoration: none !important;
            transition: all .3s cubic-bezier(.4, 0, .2, 1) !important;
            cursor: pointer !important;
        }

        footer .social-icon svg {
            width: 15px !important;
            height: 15px !important;
            fill: currentColor !important;
            transition: all .2s ease !important;
        }

        footer .social-icon:hover {
            background: rgba(5, 150, 105, 0.1) !important;
            color: var(--primary) !important;
            transform: translateY(-2px) !important;
        }

        footer .social-icon[data-network="linkedin"]:hover {
            background: rgba(10, 102, 194, 0.1) !important;
            color: #0A66C2 !important;
        }

        footer .social-icon[data-network="instagram"]:hover {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%) !important;
            color: white !important;
        }

        footer .social-icon[data-network="facebook"]:hover {
            background: rgba(24, 119, 242, 0.1) !important;
            color: #1877F2 !important;
        }

        footer .social-icon[data-network="x"]:hover {
            background: rgba(0, 0, 0, 0.1) !important;
            color: #000000 !important;
        }

        footer .social-icon[data-network="youtube"]:hover {
            background: rgba(255, 0, 0, 0.1) !important;
            color: #FF0000 !important;
        }

        /* FOOTER RESPONSIVE */
        @media (max-width: 1024px) {
            footer {
                padding: 64px 0 28px;
                border-radius: 32px 32px 0 0;
            }

            footer .footer-container {
                padding: 0 32px;
            }

            footer .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 48px 32px;
            }

            footer .footer-brand {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 768px) {
            footer {
                padding: 48px 0 24px;
                border-radius: 24px 24px 0 0;
                margin-top: 60px;
            }

            footer .footer-container {
                padding: 0 24px;
            }

            footer .footer-grid {
                grid-template-columns: 1fr;
                gap: 0;
                margin-bottom: 32px;
                padding-bottom: 32px;
            }

            footer .footer-brand {
                margin-bottom: 24px;
                padding-bottom: 24px;
                border-bottom: 1px solid var(--border-footer);
                text-align: left;
                align-items: flex-start;
            }

            footer .footer-logo {
                justify-content: flex-start;
            }

            footer .footer-column {
                border-bottom: 1px solid var(--border-footer);
            }

            footer .footer-column:last-child {
                border-bottom: none;
            }

            footer .footer-column h3 {
                padding: 16px 0;
                margin-bottom: 0;
                cursor: pointer;
                display: flex;
                justify-content: space-between;
                align-items: center;
                user-select: none;
                -webkit-tap-highlight-color: transparent;
                font-size: 0.65rem;
            }

            footer .footer-column h3::after {
                content: '+';
                font-size: 24px;
                font-weight: 300;
                line-height: 1;
                transition: transform .3s ease;
                color: var(--text-secondary);
            }

            footer .footer-column.active h3::after {
                transform: rotate(45deg);
            }

            footer .footer-links {
                max-height: 0;
                overflow: hidden;
                transition: max-height .4s cubic-bezier(.4, 0, .2, 1);
            }

            footer .footer-column.active .footer-links {
                max-height: 500px;
                padding-bottom: 20px;
                gap: 8px;
            }

            footer .footer-bottom {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
                gap: 24px;
            }

            footer .footer-info {
                order: 2;
                align-items: flex-start;
            }

            footer .social-links {
                order: 1;
            }
        }

        @media (max-width: 480px) {
            footer {
                padding: 40px 0 20px;
                border-radius: 20px 20px 0 0;
            }

            footer .footer-container {
                padding: 0 20px;
            }

            footer .social-links {
                gap: 8px;
                flex-wrap: wrap;
                justify-content: flex-start;
            }

            footer .social-icon {
                width: 30px !important;
                height: 30px !important;
            }

            footer .social-icon svg {
                width: 14px !important;
                height: 14px !important;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="/" class="logo">
                <span class="logo-blum">Blum</span><span class="logo-ops">Ops</span>
            </a>
            <a href="#contacto" class="btn-header">Prueba gratis 7 días</a>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <div class="hero-label">Sistema de inventarios</div>
                <h1>Controla todo tu inventario desde un solo lugar</h1>
                <p class="hero-subtitle">
                    Software completo para gestionar tu stock, almacenes, ventas y compras en tiempo real. Diseñado para negocios mexicanos que quieren crecer sin complicaciones.
                </p>
                
                <div class="pricing-controls">
                    <div class="billing-toggle">
                        <span class="monthly-label active">Mensual</span>
                        <div class="toggle-switch" id="billingToggle"></div>
                        <span class="yearly-label">Anual <span class="save-badge">Ahorra 33%</span></span>
                    </div>
                </div>
            </div>
            <div class="background-text">Inventario</div>
        </section>

        <section class="pricing-section">
            <h2 class="pricing-title">Planes para cada etapa de tu negocio</h2>
            
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="plan-name">BÁSICO</div>
                    <p class="plan-description">Perfecto para negocios que están empezando y necesitan orden en su inventario</p>
                    
                    <div class="price-container">
                        <div class="price-amount">$499<span style="font-size: 1rem; color: var(--text-secondary);">/mes</span></div>
                        <div class="price-period">O $4,990 al año (ahorra 2 meses)</div>
                    </div>
                    
                    <ul class="features-list">
                        <li><span class="feature-icon">✓</span> 1 almacén/sucursal</li>
                        <li><span class="feature-icon">✓</span> Hasta 500 productos</li>
                        <li><span class="feature-icon">✓</span> Control de entradas y salidas</li>
                        <li><span class="feature-icon">✓</span> Códigos de barras y SKU</li>
                        <li><span class="feature-icon">✓</span> Alertas de stock bajo</li>
                        <li><span class="feature-icon">✓</span> 2 usuarios</li>
                        <li><span class="feature-icon">✓</span> Reportes básicos</li>
                        <li><span class="feature-icon">✓</span> App móvil incluida</li>
                    </ul>
                    
                    <a href="#contacto" class="cta-button secondary">Empezar prueba gratis</a>
                </div>

                <div class="pricing-card popular">
                    <div class="popular-badge">Más Popular</div>
                    <div class="plan-name">PROFESIONAL</div>
                    <p class="plan-description">Para negocios en crecimiento que necesitan control completo y automatización</p>
                    
                    <div class="price-container">
                        <div class="price-amount">$999<span style="font-size: 1rem; color: var(--text-secondary);">/mes</span></div>
                        <div class="price-period">O $9,990 al año (ahorra 2 meses)</div>
                        <div class="price-savings">El favorito de las PYMES</div>
                    </div>
                    
                    <ul class="features-list">
                        <li><span class="feature-icon">✓</span> Todo en Básico</li>
                        <li><span class="feature-icon">✓</span> Hasta 3 almacenes/sucursales</li>
                        <li><span class="feature-icon">✓</span> Productos ilimitados</li>
                        <li><span class="feature-icon">✓</span> Órdenes de compra automáticas</li>
                        <li><span class="feature-icon">✓</span> Gestión de proveedores</li>
                        <li><span class="feature-icon">✓</span> Control por lotes y series</li>
                        <li><span class="feature-icon">✓</span> Transferencias entre almacenes</li>
                        <li><span class="feature-icon">✓</span> Integración con tu tienda online</li>
                        <li><span class="feature-icon">✓</span> 10 usuarios</li>
                        <li><span class="feature-icon">✓</span> Reportes avanzados y gráficas</li>
                        <li><span class="feature-icon">✓</span> Historial completo de movimientos</li>
                        <li><span class="feature-icon">✓</span> Soporte prioritario</li>
                    </ul>
                    
                    <a href="#contacto" class="cta-button">Empezar prueba gratis</a>
                </div>

                <div class="pricing-card">
                    <div class="plan-name">ENTERPRISE</div>
                    <p class="plan-description">Para empresas con operaciones complejas que necesitan personalización total</p>
                    
                    <div class="price-container">
                        <div class="price-amount">Personalizado</div>
                        <div class="price-period">Cotización según tus necesidades</div>
                    </div>
                    
                    <ul class="features-list">
                        <li><span class="feature-icon">✓</span> Todo en Profesional</li>
                        <li><span class="feature-icon">✓</span> Almacenes ilimitados</li>
                        <li><span class="feature-icon">✓</span> Usuarios ilimitados</li>
                        <li><span class="feature-icon">✓</span> API para integraciones personalizadas</li>
                        <li><span class="feature-icon">✓</span> Conexión con tu sistema contable</li>
                        <li><span class="feature-icon">✓</span> Picking y packing avanzado</li>
                        <li><span class="feature-icon">✓</span> Predicción de demanda con IA</li>
                        <li><span class="feature-icon">✓</span> Inventario cíclico automatizado</li>
                        <li><span class="feature-icon">✓</span> Multi-moneda y multi-idioma</li>
                        <li><span class="feature-icon">✓</span> Gestión de costos y márgenes</li>
                        <li><span class="feature-icon">✓</span> Trazabilidad completa de productos</li>
                        <li><span class="feature-icon">✓</span> Gerente de cuenta dedicado</li>
                        <li><span class="feature-icon">✓</span> Capacitación personalizada</li>
                        <li><span class="feature-icon">✓</span> Soporte 24/7</li>
                    </ul>
                    
                    <a href="#contacto" class="cta-button secondary">Solicitar demostración</a>
                </div>
            </div>
        </section>

        <section class="comparison-section">
            <h2 class="comparison-title">Compara todas las características</h2>
            
            <div class="table-wrap">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>Característica</th>
                            <th>Básico</th>
                            <th>Profesional</th>
                            <th>Enterprise</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Almacenes/Sucursales</td>
                            <td>1</td>
                            <td>3</td>
                            <td>Ilimitados</td>
                        </tr>
                        <tr>
                            <td>Productos</td>
                            <td>500</td>
                            <td>Ilimitados</td>
                            <td>Ilimitados</td>
                        </tr>
                        <tr>
                            <td>Usuarios</td>
                            <td>2</td>
                            <td>10</td>
                            <td>Ilimitados</td>
                        </tr>
                        <tr>
                            <td>Control de entradas y salidas</td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td>Códigos de barras</td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td>Alertas de stock bajo</td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td>App móvil</td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td>Órdenes de compra automáticas</td>
                            <td>-</td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td>Gestión de proveedores</td>
                            <td>-</td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td>Control por lotes y series</td>
                            <td>-</td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td>Transferencias entre almacenes</td>
                            <td>-</td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td>Integración tienda online</td>
                            <td>-</td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td>API personalizada</td>
                            <td>-</td>
                            <td>-</td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td>Predicción de demanda con IA</td>
                            <td>-</td>
                            <td>-</td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td>Conexión con contabilidad</td>
                            <td>-</td>
                            <td>-</td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td>Soporte</td>
                            <td>Email</td>
                            <td>Email + Chat</td>
                            <td>24/7 + Gerente dedicado</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="faq-section">
            <div class="faq-header">
                <div class="faq-nav">
                    <div class="carousel-arrows">
                        <button class="carousel-arrow carousel-prev" aria-label="Anterior">←</button>
                        <button class="carousel-arrow carousel-next" aria-label="Siguiente">→</button>
                    </div>
                </div>
                
                <h2 class="faq-title">Las preguntas que todo dueño de negocio se hace</h2>
            </div>

            <div class="faq-carousel-wrapper">
                <div class="faq-carousel">
                    
                    <div class="faq-card">
                        <div class="faq-question-text">¿Puedo probar el sistema antes de pagar?</div>
                        <div class="faq-answer-text">¡Claro que sí! Ofrecemos 7 días de prueba gratis en todos nuestros planes. No necesitas tarjeta de crédito para empezar, solo te registras y comienzas a usar el sistema completo. Si te gusta, continúas con el plan que mejor se adapte a tu negocio.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Qué tipo de negocios pueden usar este sistema?</div>
                        <div class="faq-answer-text">Nuestro sistema funciona para cualquier negocio que maneje productos no perecederos: ferreterías, tiendas de ropa, refaccionarias, distribuidoras, papelerías, tiendas de electrónica, farmacias, mueblerías, y cualquier comercio que necesite controlar su inventario.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Es difícil de usar? ¿Necesito conocimientos técnicos?</div>
                        <div class="faq-answer-text">Para nada. Diseñamos el sistema pensando en dueños de negocio y empleados que no son expertos en tecnología. La interfaz es muy intuitiva, similar a usar WhatsApp o Facebook. Además, incluimos videos tutoriales y nuestro equipo de soporte te ayuda en todo.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Cómo funciona el control de stock en tiempo real?</div>
                        <div class="faq-answer-text">Cada movimiento (venta, compra, devolución, transferencia) se actualiza al instante en el sistema. Puedes ver desde tu celular o computadora cuántos productos tienes en cada almacén en cualquier momento, sin esperas ni retrasos.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Qué pasa si se va el internet en mi negocio?</div>
                        <div class="faq-answer-text">La app móvil permite trabajar sin internet. Puedes registrar ventas y movimientos offline, y cuando se recupere la conexión, todo se sincroniza automáticamente con el sistema. No pierdes ninguna operación.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Puedo cambiar de plan después?</div>
                        <div class="faq-answer-text">Sí, cuando quieras. Si tu negocio crece y necesitas más funciones, puedes subir de plan en cualquier momento. Solo pagas la diferencia proporcional del mes. Y si necesitas bajar de plan, también puedes hacerlo sin penalizaciones.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿El sistema genera alertas cuando se está acabando un producto?</div>
                        <div class="faq-answer-text">Sí. Tú defines el stock mínimo de cada producto y el sistema te avisa automáticamente por email, notificación push y dentro del panel cuando un producto llega a ese nivel. Nunca más te quedarás sin mercancía importante.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Puedo usar mi propio lector de códigos de barras?</div>
                        <div class="faq-answer-text">Totalmente. El sistema funciona con cualquier lector USB o Bluetooth. También puedes escanear códigos con la cámara de tu celular. Si no tienes lector, te recomendamos modelos económicos compatibles.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Qué formas de pago aceptan?</div>
                        <div class="faq-answer-text">Aceptamos pagos con tarjeta de crédito, débito, transferencia bancaria y depósito en OXXO. El sistema te genera automáticamente tu factura fiscal cada mes para que puedas deducirlo de impuestos. Para planes anuales, también ofrecemos pagos en meses sin intereses.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Puedo controlar varios almacenes o sucursales?</div>
                        <div class="faq-answer-text">Sí, dependiendo de tu plan. El plan Profesional permite hasta 3 almacenes y el Enterprise permite almacenes ilimitados. Puedes ver el stock de todos tus almacenes desde un solo panel y hacer transferencias entre ellos.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Mis datos están seguros?</div>
                        <div class="faq-answer-text">Absolutamente. Toda tu información está encriptada y respaldada automáticamente cada día. Usamos los mismos estándares de seguridad que los bancos. Tus datos solo los puedes ver tú y las personas que tú autorices. Cumplimos con todas las regulaciones mexicanas de protección de datos.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Puedo generar órdenes de compra automáticas?</div>
                        <div class="faq-answer-text">Sí, en los planes Profesional y Enterprise. El sistema analiza tus ventas y te sugiere qué productos reponer y en qué cantidad. Puedes generar órdenes de compra con un click y enviarlas directo a tus proveedores por email.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Puedo rastrear productos por lotes o números de serie?</div>
                        <div class="faq-answer-text">Sí, en el plan Profesional y Enterprise. Ideal para productos con fecha de caducidad, garantías o que necesitas rastrear individualmente. Sabes exactamente de qué lote vendiste cada unidad y a quién.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿El sistema se conecta con mi tienda online?</div>
                        <div class="faq-answer-text">Sí. Nos integramos con las principales plataformas de e-commerce en México. Cuando vendes online, el inventario se descuenta automáticamente. No más ventas de productos que ya no tienes en stock.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Qué reportes puedo generar?</div>
                        <div class="faq-answer-text">Reportes de ventas por período, productos más vendidos, rotación de inventario, valorización de stock, movimientos por almacén, análisis de proveedores, productos con bajo stock, y muchos más. Todo exportable a Excel.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Cuántos usuarios pueden usar el sistema al mismo tiempo?</div>
                        <div class="faq-answer-text">Depende del plan: Básico permite 2 usuarios, Profesional hasta 10, y Enterprise usuarios ilimitados. Cada usuario tiene su propio acceso y puedes configurar permisos específicos para cada uno.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Ofrecen capacitación para mi equipo?</div>
                        <div class="faq-answer-text">Sí. Incluimos videos tutoriales, guías paso a paso y sesiones de capacitación en vivo para todos los planes. En el plan Enterprise, además tienes capacitación personalizada para tu equipo completo.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Qué pasa si necesito ayuda o tengo un problema?</div>
                        <div class="faq-answer-text">Nuestro equipo de soporte en español está disponible por email y chat. Plan Básico y Profesional: de 9am a 6pm de lunes a viernes. Plan Enterprise: soporte 24/7 con gerente de cuenta dedicado.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿Puedo importar mi inventario actual al sistema?</div>
                        <div class="faq-answer-text">Por supuesto. Puedes importar tu catálogo completo desde Excel con un formato simple. Nuestro equipo te ayuda en el proceso de migración para que no pierdas tiempo capturando producto por producto.</div>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question-text">¿El sistema maneja diferentes monedas?</div>
                        <div class="faq-answer-text">Sí, en el plan Enterprise. Puedes trabajar con pesos mexicanos, dólares y otras monedas, ideal si importas productos o tienes operaciones internacionales. El sistema calcula automáticamente los tipos de cambio.</div>
                    </div>

                </div>
            </div>
        </section>

        <section class="legal-disclaimer">
            <div class="disclaimer-container">
                <p class="disclaimer-text">
                    <sup>1</sup>BlumOps es un producto SaaS de <a href="https://treblum.com/" target="_blank" rel="noopener">Treblum™</a>, una empresa mexicana especializada en soluciones digitales B2B para manufactura, logística, almacenamiento y servicios profesionales. Treblum™ ofrece ecosistemas digitales completos que impulsan el crecimiento de empresas a través de tecnología, diseño estratégico y optimización de procesos operativos. BlumOps representa la evolución de nuestra experiencia en gestión de operaciones aplicada específicamente a la administración de inventarios en la nube.
                </p>
                
                <p class="disclaimer-text">
                    <sup>2</sup>La sincronización en tiempo real del inventario está sujeta a la conectividad a internet del dispositivo. BlumOps utiliza tecnología de replicación de datos que garantiza que las actualizaciones se procesen en menos de 2 segundos bajo condiciones normales de red. La disponibilidad del servicio está respaldada por nuestra infraestructura de servidores redundantes con un SLA del 99.9% de tiempo de actividad. En caso de pérdida de conexión, la aplicación móvil permite operaciones offline con sincronización automática al restaurarse la conectividad.
                </p>
                
                <p class="disclaimer-text">
                    <sup>3</sup>Los reportes y análisis predictivos generados por BlumOps utilizan algoritmos de inteligencia artificial entrenados con datos históricos de inventario. La precisión de las predicciones de demanda puede variar según la calidad y cantidad de datos históricos disponibles. BlumOps no garantiza resultados específicos de optimización de inventario, ya que estos dependen de múltiples factores externos incluyendo condiciones de mercado, estacionalidad y comportamiento del consumidor. Los usuarios deben validar las recomendaciones del sistema con su propio criterio empresarial.
                </p>
                
                <p class="disclaimer-text">
                    <sup>4</sup>Las integraciones con plataformas de terceros (e-commerce, contabilidad, ERP) están sujetas a las APIs y políticas de cada proveedor. BlumOps mantiene compatibilidad con las versiones actuales de las integraciones listadas, pero no puede garantizar soporte continuo si los proveedores externos modifican o descontinúan sus APIs. Algunas funciones avanzadas de integración pueden requerir suscripciones adicionales con los proveedores de servicios correspondientes. La configuración de integraciones complejas puede requerir asistencia técnica especializada.
                </p>
                
                <p class="disclaimer-text">
                    <sup>5</sup>El período de prueba gratuita de 7 días incluye acceso completo a todas las funciones del plan seleccionado sin requerir información de tarjeta de crédito. Al finalizar el período de prueba, se requiere una suscripción de pago para continuar usando el servicio. Los datos ingresados durante el período de prueba se conservan por 30 días después de la expiración, permitiendo la reactivación sin pérdida de información. Los planes anuales ofrecen un descuento del 33% comparado con la facturación mensual. Todos los precios están expresados en pesos mexicanos (MXN) y no incluyen IVA.
                </p>
                
                <p class="disclaimer-text">
                    <sup>6</sup>BlumOps, Treblum y sus respectivos logotipos son marcas registradas de Treblum™. Todos los derechos reservados. El uso de este software está sujeto a nuestros <a href="https://treblum.com/servicio/" target="_blank" rel="noopener">Términos de Servicio</a> y <a href="https://treblum.com/aviso-de-privacidad/" target="_blank" rel="noopener">Política de Privacidad</a>. Los datos de inventario del cliente permanecen como propiedad exclusiva del cliente y BlumOps actúa únicamente como procesador de datos según lo establecido en nuestro Acuerdo de Procesamiento de Datos (DPA). Para más información sobre Treblum™ y nuestros servicios empresariales, visite <a href="https://treblum.com/" target="_blank" rel="noopener">treblum.com</a>.
                </p>
            </div>
        </section>
    </main>

    <footer id="contacto">
        <div class="footer-container">
            <div class="footer-grid">
                <!-- BRAND SECTION -->
                <div class="footer-brand">
                    <div class="footer-logo" onclick="window.location.href='/'">
                        <span class="footer-logo-blum">Blum</span><span class="footer-logo-ops">Ops</span>
                    </div>
                    <p class="footer-tagline">Sistema de inventarios inteligente desarrollado por Treblum™. Diseñado para empresas mexicanas que buscan optimizar sus operaciones de almacén y logística.</p>
                </div>

                <!-- PRODUCTO -->
                <div class="footer-column">
                    <h3>Producto</h3>
                    <div class="footer-links">
                        <a href="#features">Características</a>
                        <a href="#pricing">Planes y precios</a>
                        <a href="#integrations">Integraciones</a>
                        <a href="#app">App móvil</a>
                        <a href="#updates">Actualizaciones</a>
                        <a href="#roadmap">Roadmap</a>
                    </div>
                </div>

                <!-- RECURSOS -->
                <div class="footer-column">
                    <h3>Recursos</h3>
                    <div class="footer-links">
                        <a href="#docs">Documentación</a>
                        <a href="#api">API</a>
                        <a href="#tutorials">Tutoriales</a>
                        <a href="#blog">Blog</a>
                        <a href="#webinars">Webinars</a>
                        <a href="#support">Centro de ayuda</a>
                    </div>
                </div>

                <!-- EMPRESA -->
                <div class="footer-column">
                    <h3>Empresa</h3>
                    <div class="footer-links">
                        <a href="#about">Nosotros</a>
                        <a href="#careers">Carreras</a>
                        <a href="#contact">Contacto</a>
                        <a href="#privacy">Privacidad</a>
                        <a href="#terms">Términos</a>
                        <a href="#security">Seguridad</a>
                    </div>
                </div>
            </div>

            <!-- FOOTER BOTTOM -->
            <div class="footer-bottom">
                <div class="footer-info">
                    <p class="footer-copyright">Español | México</p>
                    <p class="footer-copyright">
                        © <span id="current-year">2026</span> Treblum™. Todos los derechos reservados. BlumOps es un producto de Treblum™ | 
                        <a href="mailto:info@treblum.com">info@treblum.com</a>
                    </p>
                </div>

                <div class="social-links">
                    <a href="https://www.linkedin.com/company/treblum" target="_blank" rel="noopener" class="social-icon" data-network="linkedin" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>

                    <a href="https://www.instagram.com/trebluum" target="_blank" rel="noopener" class="social-icon" data-network="instagram" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>

                    <a href="https://www.facebook.com/treblum" target="_blank" rel="noopener" class="social-icon" data-network="facebook" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>

                    <a href="https://x.com/treblum" target="_blank" rel="noopener" class="social-icon" data-network="x" aria-label="X">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>

                    <a href="https://youtube.com/@treblum" target="_blank" rel="noopener" class="social-icon" data-network="youtube" aria-label="YouTube">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Billing toggle functionality
        const billingToggle = document.getElementById('billingToggle');
        const monthlyLabel = document.querySelector('.monthly-label');
        const yearlyLabel = document.querySelector('.yearly-label');
        let isYearly = false;

        billingToggle?.addEventListener('click', () => {
            isYearly = !isYearly;
            billingToggle.classList.toggle('active');
            
            if (isYearly) {
                monthlyLabel.classList.remove('active');
                yearlyLabel.classList.add('active');
                updatePrices('yearly');
            } else {
                monthlyLabel.classList.add('active');
                yearlyLabel.classList.remove('active');
                updatePrices('monthly');
            }
        });

        function updatePrices(period) {
            const priceData = {
                monthly: {
                    basic: '$499',
                    professional: '$999',
                    basicYear: '$4,990 al año (ahorra 2 meses)',
                    professionalYear: '$9,990 al año (ahorra 2 meses)'
                },
                yearly: {
                    basic: '$333',
                    professional: '$666',
                    basicYear: '$3,996 al año',
                    professionalYear: '$7,992 al año'
                }
            };

            const prices = document.querySelectorAll('.price-amount');
            const periods = document.querySelectorAll('.price-period');
            
            if (period === 'yearly') {
                prices[0].innerHTML = priceData.yearly.basic + '<span style="font-size: 1rem; color: var(--text-secondary);">/mes</span>';
                prices[1].innerHTML = priceData.yearly.professional + '<span style="font-size: 1rem; color: var(--text-secondary);">/mes</span>';
                periods[0].textContent = priceData.yearly.basicYear;
                periods[1].textContent = priceData.yearly.professionalYear;
            } else {
                prices[0].innerHTML = priceData.monthly.basic + '<span style="font-size: 1rem; color: var(--text-secondary);">/mes</span>';
                prices[1].innerHTML = priceData.monthly.professional + '<span style="font-size: 1rem; color: var(--text-secondary);">/mes</span>';
                periods[0].textContent = priceData.monthly.basicYear;
                periods[1].textContent = priceData.monthly.professionalYear;
            }
        }

        // Horizontal scroll navigation for desktop
        const scrollAmount = 600;

        document.querySelector('.carousel-prev')?.addEventListener('click', () => {
            const wrapper = document.querySelector('.faq-carousel-wrapper');
            wrapper.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        });

        document.querySelector('.carousel-next')?.addEventListener('click', () => {
            const wrapper = document.querySelector('.faq-carousel-wrapper');
            wrapper.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });

        // Desktop: Card click functionality
        if(window.innerWidth > 520){
            document.addEventListener('click', e => {
                const card = e.target.closest('.faq-card');
                if(!card) return;
                card.classList.toggle('active');
            });
            
            // Custom cursor tooltip for desktop
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-cursor-tooltip';
            tooltip.innerHTML = '<div class="custom-cursor-tooltip-inner">Ver respuesta</div>';
            document.body.appendChild(tooltip);
            
            let currentCard = null;
            
            document.addEventListener('mousemove', e => {
                tooltip.style.left = e.clientX + 'px';
                tooltip.style.top = e.clientY + 'px';
            });
            
            document.addEventListener('mouseover', e => {
                const card = e.target.closest('.faq-card');
                if(card && window.innerWidth > 520){
                    currentCard = card;
                    const text = card.classList.contains('active') ? 'Ocultar respuesta' : 'Ver respuesta';
                    tooltip.querySelector('.custom-cursor-tooltip-inner').textContent = text;
                    tooltip.classList.add('visible');
                }
            });
            
            document.addEventListener('mouseout', e => {
                const card = e.target.closest('.faq-card');
                if(card){
                    tooltip.classList.remove('visible');
                    currentCard = null;
                }
            });
            
            // Update text when card state changes
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if(mutation.type === 'attributes' && mutation.attributeName === 'class'){
                        const card = mutation.target;
                        if(card === currentCard && card.classList.contains('faq-card')){
                            const text = card.classList.contains('active') ? 'Ocultar respuesta' : 'Ver respuesta';
                            tooltip.querySelector('.custom-cursor-tooltip-inner').textContent = text;
                        }
                    }
                });
            });
            
            document.querySelectorAll('.faq-card').forEach(card => {
                observer.observe(card, { attributes: true });
            });
        }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Footer functionality
        (function() {
            'use strict';
            
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initFooter);
            } else {
                initFooter();
            }
            
            function initFooter() {
                const footer = document.querySelector('footer');
                if (!footer) return;
                
                // Actualizar año
                const yearSpan = footer.querySelector('#current-year');
                if (yearSpan) {
                    yearSpan.textContent = new Date().getFullYear();
                }
                
                // Acordeón móvil
                const columns = footer.querySelectorAll('.footer-column');
                
                columns.forEach(function(column) {
                    const header = column.querySelector('h3');
                    if (!header) return;
                    
                    header.addEventListener('click', function() {
                        if (window.innerWidth > 768) return;
                        
                        // Cerrar otras columnas
                        columns.forEach(function(col) {
                            if (col !== column) {
                                col.classList.remove('active');
                            }
                        });
                        
                        // Toggle actual
                        column.classList.toggle('active');
                    });
                });
                
                // Manejar resize
                let resizeTimer;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(function() {
                        if (window.innerWidth > 768) {
                            columns.forEach(function(column) {
                                column.classList.remove('active');
                            });
                        }
                    }, 100);
                });
            }
        })();
    </script>
</body>