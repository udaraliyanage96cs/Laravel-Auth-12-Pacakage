<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UDARAX — Premium Screen & Privacy Guard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --canvas-bg: #fcfcfd;
            --surface-card: #ffffff;
            --ink-primary: #09090b;
            --ink-muted: #52525b;
            --border-subtle: #e4e4e7;
            --border-opaque: #18181b;
            --steel-gray: #f4f4f5;
            --action-blue: #0284c7;
            --action-emerald: #10b981;
            --panic-red: #e11d48;
            --font-mono: 'JetBrains Mono', monospace;
            --transition-smooth: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        body {
            background-color: var(--canvas-bg);
            color: var(--ink-primary);
            font-family: 'Inter', -apple-system, sans-serif;
            overflow-x: hidden;
            letter-spacing: -0.025em;
            -webkit-font-smoothing: antialiased;
        }

        /* Enhanced Tech-Grid & Defocus Vignette Background Engine */
        .engineering-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--canvas-bg);
            background-image:
                radial-gradient(circle at 75% 25%, rgba(255, 255, 255, 0.2) 0%, var(--canvas-bg) 80%),
                radial-gradient(rgba(9, 9, 11, 0.04) 1.5px, transparent 1.5px);
            background-size: 100% 100%, 32px 32px;
            z-index: -1;
            pointer-events: none;
        }

        /* Vertical Layout Padding */
        .py-6 {
            padding-top: 5.5rem !important;
            padding-bottom: 5.5rem !important;
        }

        /* Architectural Floating Panels */
        .panel-canvas {
            background: var(--surface-card);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.01), 0 4px 12px rgba(9, 9, 11, 0.02);
            transition: var(--transition-smooth);
        }

        .panel-canvas:hover {
            border-color: var(--border-opaque);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.01), 0 16px 40px rgba(9, 9, 11, 0.05);
        }

        /* Typography Structural Classes */
        .hero-display-title {
            font-weight: 800;
            font-size: calc(1.8rem + 1.5vw);
            letter-spacing: -0.03em;
            line-height: 1.15;
            color: var(--ink-primary);
        }

        kbd {
            font-family: var(--font-mono);
            background: var(--steel-gray);
            color: var(--ink-primary);
            border: 1px solid #d4d4d8;
            box-shadow: 0 2px 0 #d4d4d8;
            font-size: 0.8rem;
            padding: 2px 6px;
            border-radius: 5px;
            font-weight: 500;
        }

        /* Keypad Action Buttons */
        .btn-steel-primary {
            background: var(--ink-primary);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 8px;
            padding: 14px 28px;
            border: 1px solid var(--ink-primary);
            text-decoration: none !important;
            transition: var(--transition-smooth);
        }

        .btn-steel-primary:hover {
            background: #27272a;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(9, 9, 11, 0.15);
            transform: translateY(-1px);
        }

        .btn-steel-secondary {
            background: #ffffff;
            color: var(--ink-primary);
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 8px;
            padding: 14px 28px;
            border: 1px solid var(--border-subtle);
            text-decoration: none !important;
            transition: var(--transition-smooth);
        }

        .btn-steel-secondary:hover {
            border-color: var(--border-opaque);
            color: var(--ink-primary);
            background: #fafafa;
        }

        /* Navigation Bar */
        .navbar-custom {
            background: rgba(252, 252, 253, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-subtle);
            padding-top: 18px;
            padding-bottom: 18px;
        }

        .navbar-brand {
            text-decoration: none !important;
        }

        .nav-link {
            color: var(--ink-muted) !important;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none !important;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: var(--ink-primary) !important;
        }

        /* Mock Web Browser Shell Style */
        .hardware-browser-shell {
            background: #ffffff;
            border: 1px solid var(--ink-primary);
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(9, 9, 11, 0.05), 0 2px 4px rgba(9, 9, 11, 0.02);
            overflow: hidden;
            position: relative;
        }

        .hardware-bar {
            background: var(--steel-gray);
            border-bottom: 1px solid var(--border-subtle);
            padding: 14px 20px;
            display: flex;
            align-items: center;
        }

        .hardware-dot {
            width: 9px;
            height: 9px;
            background: #e4e4e7;
            border-radius: 50%;
            margin-right: 6px;
            border: 1px solid #d4d4d8;
        }

        .hardware-url-input {
            background: #ffffff;
            border: 1px solid var(--border-subtle);
            border-radius: 6px;
            font-family: var(--font-mono);
            font-size: 0.75rem;
            color: var(--ink-muted);
            padding: 5px 14px;
            width: 240px;
            margin-left: 18px;
        }

        /* Live Preview Container */
        .sandbox-viewport-canvas {
            background: #fafafa;
            min-height: 440px;
            padding: 32px !important;
            box-shadow: inset 0 2px 8px rgba(9, 9, 11, 0.02);
        }

        /* Video Demo Section Classes */
        .video-cue-btn {
            background: transparent;
            border: 1px solid var(--border-subtle);
            color: var(--ink-muted);
            border-radius: 8px;
            transition: var(--transition-smooth);
            text-align: left;
            padding: 16px;
            width: 100%;
        }

        .video-cue-btn:hover {
            border-color: var(--ink-primary);
            background: var(--steel-gray);
        }

        .video-cue-btn.is-active {
            border-color: var(--panic-red);
            background: rgba(225, 29, 72, 0.02);
            color: var(--ink-primary);
        }

        .video-cue-btn.is-active .cue-badge {
            background: var(--panic-red) !important;
            color: #ffffff !important;
        }

        /* Performance Tracker Bars */
        .metric-monitor-container {
            width: 100%;
            margin-top: 8px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .metric-monitor-header {
            font-family: var(--font-mono);
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--ink-primary);
            letter-spacing: 0.08em;
            margin-bottom: 4px;
        }

        .metric-progress-track {
            width: 100%;
            height: 12px;
            background-color: var(--border-subtle);
            border-radius: 6px;
            overflow: hidden;
        }

        .metric-progress-fill {
            height: 100%;
            background-color: #d4d4d8;
            border-radius: 6px;
            transition: var(--transition-smooth);
        }

        /* Mock Extension Window Overlay */
        .extension-viewport-overlay {
            width: 320px;
            background: #ffffff;
            border: 1px solid var(--ink-primary);
            border-radius: 12px;
            box-shadow: 0 12px 36px rgba(9, 9, 11, 0.08), 0 2px 4px rgba(9, 9, 11, 0.02);
            position: absolute;
            top: 24px;
            right: 24px;
            z-index: 10;
            transition: var(--transition-smooth);
        }

        .interactive-tab-node {
            background: var(--steel-gray);
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            padding: 12px 14px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: var(--transition-smooth);
            transform-origin: center;
        }

        .interactive-tab-node.is-purged {
            opacity: 0;
            transform: scale(0.92) translateY(10px);
            height: 0;
            padding: 0;
            margin: 0;
            border: none;
            overflow: hidden;
        }

        /* The Pin Pad Screen Cover Layout */
        .vault-lockout-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 11px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px !important;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 20;
        }

        .vault-lockout-canvas.is-visible {
            opacity: 1;
            pointer-events: auto;
        }

        .lockout-bubble-indicator {
            width: 10px;
            height: 10px;
            border: 2px solid var(--ink-primary);
            border-radius: 50%;
            transition: var(--transition-smooth);
        }

        .lockout-bubble-indicator.is-engaged {
            background: var(--ink-primary);
            transform: scale(1.15);
        }

        /* Keypad Buttons Grid Look */
        .tactile-keycap {
            width: 44px;
            height: 44px;
            border: 1px solid var(--border-subtle);
            background: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-mono);
            font-size: 0.95rem;
            cursor: pointer;
            font-weight: 600;
            user-select: none;
            transition: all 0.1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .tactile-keycap:hover {
            border-color: var(--ink-primary);
            background: var(--steel-gray);
        }

        .tactile-keycap:active {
            background: #e4e4e7;
            transform: scale(0.95);
        }

        /* Billing Switch Mode Toggle Button */
        .segmented-control-wrapper {
            background: var(--steel-gray);
            padding: 4px;
            border-radius: 10px;
            display: inline-flex;
            border: 1px solid var(--border-subtle);
        }

        .segmented-control-wrapper button {
            background: transparent;
            border: none;
            padding: 8px 20px;
            border-radius: 7px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--ink-muted);
            transition: var(--transition-smooth);
        }

        .segmented-control-wrapper button.is-selected {
            background: #ffffff;
            color: var(--ink-primary);
            box-shadow: 0 2px 4px rgba(9, 9, 11, 0.04);
        }

        /* Modern Grid Feature Box Layout Specs */
        .bento-cell {
            padding: 44px;
            height: 100%;
        }

        .bento-cell-title {
            font-weight: 700;
            font-size: 1.35rem;
            letter-spacing: -0.03em;
            color: var(--ink-primary);
        }

        /* Symmetrical Benefit Item Rows */
        .benefit-row {
            border-bottom: 1px solid var(--border-subtle);
            padding-top: 32px;
            padding-bottom: 32px;
        }

        .benefit-row:last-child {
            border-bottom: none;
        }

        /* Minimal Accordion Interface overrides */
        .accordion-item {
            background: transparent !important;
            border: none !important;
            border-bottom: 1px solid var(--border-subtle) !important;
        }

        .accordion-button {
            background: transparent !important;
            color: var(--ink-primary) !important;
            box-shadow: none !important;
            padding: 24px 0 !important;
            font-weight: 600;
            font-size: 1.05rem;
            text-decoration: none !important;
        }

        .accordion-button::after {
            background-size: 1rem;
            transform: scale(0.85);
        }

        .accordion-body {
            color: var(--ink-muted);
            padding: 0 0 24px 0 !important;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        /* Global Clean Link Rules */
        a {
            text-decoration: none !important;
        }

        /* Advanced Tab-Sync Screenshot Viewport Engines */
        .screenshot-pills-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .screenshot-pill-card {
            background: transparent;
            border: 1px solid transparent;
            border-radius: 12px;
            padding: 20px 24px;
            text-align: left;
            width: 100%;
            transition: var(--transition-smooth);
            cursor: pointer;
        }

        .screenshot-pill-card:hover {
            background: rgba(244, 244, 245, 0.5);
        }

        .screenshot-pill-card.is-active {
            background: var(--surface-card);
            border-color: var(--border-subtle);
            box-shadow: 0 4px 20px rgba(9, 9, 11, 0.03);
        }

        .screenshot-pill-card .pill-num {
            font-family: var(--font-mono);
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--ink-muted);
            display: block;
            margin-bottom: 4px;
            transition: var(--transition-smooth);
        }

        .screenshot-pill-card.is-active .pill-num {
            color: var(--panic-red);
        }

        .screenshot-pill-card .pill-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--ink-primary);
            display: block;
            letter-spacing: -0.02em;
        }

        .screenshot-pill-card .pill-desc {
            font-size: 0.88rem;
            color: var(--ink-muted);
            display: block;
            margin-top: 4px;
            line-height: 1.4;
            opacity: 0.8;
        }

        .extension-display-frame {
            background: var(--surface-card);
            border: 1px solid var(--ink-primary);
            border-radius: 16px;
            box-shadow: 0 30px 70px rgba(9, 9, 11, 0.07);
            overflow: hidden;
            width: 100%;
            position: relative;
        }

        .extension-frame-bar {
            background: var(--steel-gray);
            border-bottom: 1px solid var(--border-subtle);
            padding: 12px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .extension-frame-title {
            font-family: var(--font-mono);
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--ink-muted);
        }

        .screenshot-stage-viewport {
            position: relative;
            background: #18181b;
            aspect-ratio: 16 / 10;
            width: 100%;
            overflow: hidden;
        }

        .screenshot-img-node {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transform: scale(1.02);
            transition: opacity 0.4s ease, transform 0.45s cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
            background: #27272a;
            /* Fallback structured surface colors */
        }

        .screenshot-img-node.is-visible {
            opacity: 1;
            transform: scale(1);
            pointer-events: auto;
        }

        @media(max-width: 991px) {
            .screenshot-pills-container {
                flex-direction: row;
                overflow-x: auto;
                padding-bottom: 12px;
                scroll-snap-type: x mandatory;
                scrollbar-width: none;
            }

            .screenshot-pills-container::-webkit-scrollbar {
                display: none;
            }

            .screenshot-pill-card {
                min-width: 280px;
                scroll-snap-align: start;
            }
        }
    </style>
</head>

<body>

    <div class="engineering-grid"></div>

    <nav class="navbar navbar-expand-xl navbar-light navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    style="color: var(--ink-primary)">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                    <line x1="9" y1="3" x2="9" y2="21" />
                </svg>
                <span class="fw-800 text-dark font-monospace"
                    style="font-size: 1.15rem; letter-spacing: -0.8px;">UDARAX</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#appNavigationWrapper">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="appNavigationWrapper">
                <ul class="navbar-nav ms-auto gap-1 gap-xl-2 align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#demo">Demo Video</a></li>
                    <li class="nav-item"><a class="nav-link" href="#screens">Interface</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Privacy Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#benefits">Why You Need It</a></li>
                    <li class="nav-item"><a class="nav-link" href="#cycle">How It Works</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">Plans & Pricing</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                    @auth
                        <li class="nav-item ms-lg-2">
                            <a class="btn-steel-secondary btn-sm px-4 py-2" style="font-size: 0.85rem;"
                                href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item ms-lg-2">
                            <a class="btn-steel-secondary btn-sm px-4 py-2" style="font-size: 0.85rem;"
                                href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                    <li class="nav-item ms-lg-1">
                        <a class="btn-steel-primary btn-sm px-4 py-2" style="font-size: 0.85rem;"
                            href="#install">Download Extension</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="py-6 mt-2 mt-lg-4">
        <div class="container">
            <div class="row align-items-center g-5">

                <div class="col-lg-6">
                    <div
                        class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded bg-danger-subtle border border-danger-subtle mb-4">
                        <span
                            style="font-family: var(--font-mono); font-size: 0.75rem; font-weight: 700; color: var(--panic-red); letter-spacing: 0.05em;">🔴
                            INSTANT SCREEN SHIELD</span>
                    </div>
                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Log in
                                </a>
                                @if (Route::has('register') && ($setting?->self_registration_enable ?? 1) == 1)
                                    <a href="{{ route('register') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                    </header>

                    <div class="d-flex flex-wrap gap-3 align-items-center mb-5">
                        <a href="#install" class="btn-steel-primary d-inline-flex align-items-center gap-2">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3" />
                            </svg>
                            Get Instant Panic Protection Free
                        </a>
                        <a href="#demo" class="btn-steel-secondary">
                            Watch Video Demo
                        </a>
                    </div>

                    <div class="row g-4 border-top border-light-subtle pt-4">
                        <div class="col-sm-6">
                            <span class="d-block fw-bold text-dark" style="font-size: 0.95rem;">Zero-Second
                                Discretion</span>
                            <span class="text-muted small">Tabs vanish the exact microsecond you trigger the key.</span>
                        </div>
                        <div class="col-sm-6 border-start border-light-subtle ps-sm-4">
                            <span class="d-block fw-bold text-dark" style="font-size: 0.95rem;"><kbd>Alt</kbd> +
                                <kbd>P</kbd> Panic Shortcut</span>
                            <span class="text-muted small">Press together to trigger an immediate distraction
                                sweep.</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hardware-browser-shell">
                        <div class="hardware-bar">
                            <span class="hardware-dot"></span>
                            <span class="hardware-dot"></span>
                            <span class="hardware-dot"></span>
                            <div class="hardware-url-input">my_private_browsing.com</div>
                        </div>

                        <div class="sandbox-viewport-canvas position-relative">

                            <div class="metric-monitor-container">
                                <div class="metric-monitor-header">PRIVACY THREAT LEVEL DETECTOR</div>
                                <div class="metric-progress-track">
                                    <div class="metric-progress-fill"
                                        style="width: 100%; background-color: var(--panic-red);"></div>
                                </div>
                                <div class="metric-progress-track">
                                    <div class="metric-progress-fill" style="width: 65%;"></div>
                                </div>
                                <div class="metric-progress-track">
                                    <div class="metric-progress-fill" style="width: 40%;"></div>
                                </div>
                            </div>

                            <div class="extension-viewport-overlay">

                                <div class="vault-lockout-canvas" id="hardwareLockCanvas">
                                    <div class="text-center w-100 mb-3">
                                        <div class="fw-bold text-dark mb-1" style="font-size: 0.85rem;">🔒 Hidden Vault
                                            Locked</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">Type your secret code to
                                            return to your pages</div>
                                    </div>

                                    <div class="d-flex justify-content-center align-items-center gap-3 mb-3 w-100"
                                        id="lockBubbleRowNode">
                                        <span class="lockout-bubble-indicator"></span>
                                        <span class="lockout-bubble-indicator"></span>
                                        <span class="lockout-bubble-indicator"></span>
                                        <span class="lockout-bubble-indicator"></span>
                                    </div>

                                    <div class="d-grid gap-1.5 mb-3"
                                        style="grid-template-columns: repeat(3, 1fr); width: 144px;">
                                        <div class="tactile-keycap" onclick="captureHardwareKey('1')">1</div>
                                        <div class="tactile-keycap" onclick="captureHardwareKey('2')">2</div>
                                        <div class="tactile-keycap" onclick="captureHardwareKey('3')">3</div>
                                        <div class="tactile-keycap" onclick="captureHardwareKey('4')">4</div>
                                        <div class="tactile-keycap" onclick="captureHardwareKey('5')">5</div>
                                        <div class="tactile-keycap" onclick="captureHardwareKey('6')">6</div>
                                        <div class="tactile-keycap" onclick="captureHardwareKey('7')">7</div>
                                        <div class="tactile-keycap" onclick="captureHardwareKey('8')">8</div>
                                        <div class="tactile-keycap" onclick="captureHardwareKey('9')">9</div>
                                        <div class="tactile-keycap text-danger" style="font-size: 0.65rem;"
                                            onclick="wipeHardwarePinBuffer()">Clear</div>
                                        <div class="tactile-keycap" onclick="captureHardwareKey('0')">0</div>
                                        <div class="tactile-keycap text-secondary" style="font-size: 0.75rem;"
                                            onclick="backspaceHardwarePinBuffer()">⌫</div>
                                    </div>

                                    <div class="text-primary text-center"
                                        style="cursor:pointer; font-size: 0.7rem; font-weight: 500;"
                                        onclick="shortcutBypassValidationRoutine()">Quick Test Code (1-2-3-4)</div>
                                </div>

                                <div class="p-3 border-bottom border-light-subtle d-flex align-items-center justify-content-between"
                                    style="background: var(--steel-gray); border-top-left-radius: 11px; border-top-right-radius: 11px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-danger rounded p-1 d-flex align-items-center justify-content-center"
                                            style="width:18px; height:18px;">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#fff"
                                                stroke-width="3.5">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                            </svg>
                                        </div>
                                        <span class="fw-bold text-dark"
                                            style="font-size: 0.8rem; font-family: var(--font-mono);">UDARAX Menu</span>
                                    </div>
                                    <span class="badge bg-danger text-white fw-medium font-monospace"
                                        id="hardwareCountLabel" style="font-size: 0.65rem;">0 tabs hidden</span>
                                </div>

                                <div class="p-3">
                                    <div class="text-muted fw-bold mb-2 text-uppercase tracking-wider"
                                        style="font-size: 0.65rem; font-family: var(--font-mono);">Open Private Pages
                                        Found:</div>

                                    <div class="interactive-tab-node" id="tabNodeAsset1">
                                        <span class="small text-dark fw-semibold text-truncate"
                                            style="max-width: 70%; font-size: 0.75rem;">Personal Social Media
                                            Feed</span>
                                        <button class="btn btn-sm btn-danger py-0.5 px-2 font-monospace"
                                            style="font-size: 0.7rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                                            onclick="isolateHardwareNode(1)">Hide</button>
                                    </div>

                                    <div class="interactive-tab-node" id="tabNodeAsset2">
                                        <span class="small text-dark fw-semibold text-truncate"
                                            style="max-width: 70%; font-size: 0.75rem;">Secret Gift Shopping
                                            Search</span>
                                        <button class="btn btn-sm btn-danger py-0.5 px-2 font-monospace"
                                            style="font-size: 0.7rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                                            onclick="isolateHardwareNode(2)">Hide</button>
                                    </div>

                                    <div class="interactive-tab-node" id="tabNodeAsset3">
                                        <span class="small text-dark fw-semibold text-truncate"
                                            style="max-width: 70%; font-size: 0.75rem;">Entertainment Video
                                            Player</span>
                                        <button class="btn btn-sm btn-danger py-0.5 px-2 font-monospace"
                                            style="font-size: 0.7rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                                            onclick="isolateHardwareNode(3)">Hide</button>
                                    </div>

                                    <div class="d-grid gap-2 mt-3 pt-2 border-top border-light-subtle">
                                        <button class="btn btn-sm btn-danger py-2 fw-bold font-monospace"
                                            style="background: var(--panic-red); font-size: 0.75rem; border: none; box-shadow: 0 2px 4px rgba(225,29,72,0.15);"
                                            onclick="triggerHardwarePanicRouteAll()">
                                            🚨 HIT PANIC BUTTON: HIDE EVERYTHING NOW
                                        </button>
                                        <div class="d-flex gap-2">
                                            <button
                                                class="btn btn-sm btn-white border bg-white w-50 fw-semibold text-dark"
                                                style="font-size: 0.7rem;"
                                                onclick="toggleHardwareLockoutView(true)">Lock Vault</button>
                                            <button class="btn btn-sm btn-link text-muted w-50 text-decoration-none"
                                                style="font-size: 0.7rem;"
                                                onclick="resetHardwareSimulatorStateBlock()">Reset Demo</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="demo" class="py-6 border-top border-light-subtle bg-light">
        <div class="container">
            <div class="text-center mb-5 mx-auto" style="max-width: 650px;">
                <span class="text-danger font-monospace d-block mb-2"
                    style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em;">// PRODUCT DEPLOYMENT
                    DEMO</span>
                <h2 class="fw-800 text-dark tracking-tight h1 mb-3">See Panic Defense in Action</h2>
                <p class="text-muted">Watch this 60-second operational walkthrough to see exactly how UDARAX intercepts
                    exposure events and secures your workplace workspace environments instantly.</p>
            </div>

            <div class="row g-5 align-items-center">
                <div class="col-lg-7">
                    <div class="hardware-browser-shell shadow-lg">
                        <div
                            class="hardware-bar d-flex justify-content-between align-items-center bg-dark text-white border-bottom border-dark py-2 px-3">
                            <div class="d-flex align-items-center">
                                <span class="hardware-dot bg-secondary border-0"></span>
                                <span class="hardware-dot bg-secondary border-0"></span>
                                <span class="hardware-dot bg-secondary border-0"></span>
                                <span class="ms-3 font-monospace text-muted" style="font-size: 0.7rem;">SYSTEM_PLAYER //
                                    UDARAX_INTRO.MP4</span>
                            </div>
                            <div class="font-monospace text-danger text-uppercase fw-bold" id="videoTerminalLog"
                                style="font-size: 0.65rem; letter-spacing: 1px;">[ SYSTEM: IDLE ]</div>
                        </div>
                        <div class="position-relative bg-black aspect-ratio-16x9 d-flex align-items-center justify-content-center"
                            style="min-height: 380px;">
                            <video id="demoPlaybackNode" class="w-100 h-100 position-absolute top-0 start-0"
                                style="object-fit: cover;"
                                poster="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1200"
                                playsinline muted>
                                <source src="demo_intro.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                            <div class="position-absolute bottom-0 start-0 w-100 p-3 d-flex align-items-center justify-content-between text-white"
                                style="background: linear-gradient(transparent, rgba(0,0,0,0.85)); z-index: 5;">
                                <button class="btn btn-sm btn-outline-light font-monospace border-0 px-3"
                                    id="videoPlayPauseActionNode" onclick="handleVideoPlaybackControl()"
                                    style="font-size: 0.75rem;">⚡ PLAY INTRO</button>
                                <span id="videoPlaybackTimerDisplay" class="font-monospace small text-white-50"
                                    style="font-size: 0.75rem;">00:00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="d-flex flex-column gap-3">
                        <div class="text-muted font-monospace text-uppercase tracking-wider"
                            style="font-size: 0.65rem;">Step-by-step operational guide:</div>

                        <button class="video-cue-btn is-active" id="cueNode1" onclick="jumpToVideoTimestamp(0, 1)">
                            <div class="d-flex gap-3 align-items-start">
                                <span
                                    class="badge bg-secondary-subtle text-dark font-monospace cue-badge p-2 px-2.5 rounded">01</span>
                                <div>
                                    <strong class="d-block text-dark mb-1" style="font-size: 0.95rem;">Trigger the Setup
                                        Mapping</strong>
                                    <span class="small d-block text-muted" style="font-size: 0.85rem;">Learn how to
                                        activate the plugin extension and bind your favorite system hotkeys.</span>
                                </div>
                            </div>
                        </button>

                        <button class="video-cue-btn" id="cueNode2" onclick="jumpToVideoTimestamp(18, 2)">
                            <div class="d-flex gap-3 align-items-start">
                                <span
                                    class="badge bg-secondary-subtle text-dark font-monospace cue-badge p-2 px-2.5 rounded">02</span>
                                <div>
                                    <strong class="d-block text-dark mb-1" style="font-size: 0.95rem;">Executing a Live
                                        Panic Sweep</strong>
                                    <span class="small d-block text-muted" style="font-size: 0.85rem;">See tabs
                                        instantly vanish into client memory storage in less than 1 second.</span>
                                </div>
                            </div>
                        </button>

                        <button class="video-cue-btn" id="cueNode3" onclick="jumpToVideoTimestamp(42, 3)">
                            <div class="d-flex gap-3 align-items-start">
                                <span
                                    class="badge bg-secondary-subtle text-dark font-monospace cue-badge p-2 px-2.5 rounded">03</span>
                                <div>
                                    <strong class="d-block text-dark mb-1" style="font-size: 0.95rem;">Unlocking the
                                        Safe Vault Grid</strong>
                                    <span class="small d-block text-muted" style="font-size: 0.85rem;">How to input your
                                        secure passcode matrix to safely recall vanished pages.</span>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="screens" class="py-6 border-top border-light-subtle bg-white-subtle">
        <div class="container">
            <div class="mb-5 text-center text-lg-start" style="max-width: 620px;">
                <span class="text-danger font-monospace d-block mb-2"
                    style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em;">// INTERFACE INTEL</span>
                <h2 class="fw-800 text-dark tracking-tight h1 mb-3">Designed to remain unseen.</h2>
                <p class="text-muted">Take a look inside the extension dashboard interface configurations, shortcut
                    layouts, and localized client-side vault controls.</p>
            </div>

            <div class="row align-items-center g-5">
                <div class="col-lg-4 order-2 order-lg-1">
                    <div class="screenshot-pills-container">

                        <button class="screenshot-pill-card is-active" data-screenshot-target="0"
                            onclick="switchScreenshotActiveViewport(0)">
                            <span class="pill-num">VIEW_MODE // 01</span>
                            <span class="pill-title">The Active Popup Drawer</span>
                            <span class="pill-desc">Quickly monitor detected private channels, hide individual windows,
                                or engage manual vault locks instantly.</span>
                        </button>

                        <button class="screenshot-pill-card" data-screenshot-target="1"
                            onclick="switchScreenshotActiveViewport(1)">
                            <span class="pill-num">HOTKEY_CONFIG // 02</span>
                            <span class="pill-title">Custom Action Mappings</span>
                            <span class="pill-desc">Map custom quick-trigger keys to matches that completely blend into
                                your default daily workflow rhythm.</span>
                        </button>

                        <button class="screenshot-pill-card" data-screenshot-target="2"
                            onclick="switchScreenshotActiveViewport(2)">
                            <span class="pill-num">VAULT_SURFACE // 03</span>
                            <span class="pill-title">The Secure Input Guard</span>
                            <span class="pill-desc">A premium distraction barrier that strictly denies workspace
                                recovery actions until you input your PIN credentials.</span>
                        </button>

                    </div>
                </div>

                <div class="col-lg-8 order-1 order-lg-2">
                    <div class="extension-display-frame">
                        <div class="extension-frame-bar">
                            <div class="d-flex gap-1.5">
                                <span class="hardware-dot"></span>
                                <span class="hardware-dot"></span>
                                <span class="hardware-dot"></span>
                            </div>
                            <span class="extension-frame-title">UDARAX_CHROME_EXTENSION_PREVIEW</span>
                            <span class="badge bg-secondary-subtle text-secondary font-monospace rounded"
                                style="font-size: 0.65rem;">SECURE_LAYER</span>
                        </div>
                        <div class="screenshot-stage-viewport">
                            <img src="{{ asset('./assets/img/pages/screenshot1.png') }}" alt="Active Popup Drawer View"
                                class="screenshot-img-node is-visible">
                            <img src="{{ asset('./assets/img/pages/screenshot2.png') }}"
                                alt="Custom Action Mappings View" class="screenshot-img-node">
                            <img src="{{ asset('./assets/img/pages/screenshot3.png') }} " alt="Secure Input Guard View"
                                class="screenshot-img-node">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-6 border-top border-light-subtle">
        <div class="container py-3">

            <div class="mb-5" style="max-width: 580px;">
                <h2 class="fw-800 text-dark tracking-tight h1 mb-3">Absolute Panic-Defense Controls.</h2>
                <p class="text-muted">Unshakable, simple privacy tools engineered to rescue you from sudden,
                    uncomfortable real-world scenarios.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-7">
                    <div class="panel-canvas bento-cell d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-danger font-monospace mb-4" style="font-size: 0.75rem;">[ HIGH ALERT
                                PARADIGM // 01 ]</div>
                            <h3 class="bento-cell-title mb-3">The Universal "Boss Key" Hotkey</h3>
                            <p class="text-muted small mb-0" style="line-height: 1.65; font-size: 0.95rem;">When a
                                crisis strikes, there is no time to individually click and close separate windows.
                                Pressing your instant quick keys immediately drops all target screens into the lockbox,
                                replacing them with an completely unsuspicious, boring business summary layout instead.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="panel-canvas bento-cell" style="background: var(--steel-gray);">
                        <div class="text-muted font-monospace mb-4" style="font-size: 0.75rem;">[ PASSCODE SAFEBOX // 02
                            ]</div>
                        <h3 class="bento-cell-title mb-3">Password-Locked Screen Shield</h3>
                        <p class="text-muted small mb-0" style="line-height: 1.65; font-size: 0.95rem;">Hiding your
                            pages is only half the battle. UDARAX locks your swept information securely out of view
                            behind a quick numerical entry grid. Even if someone takes over your computer chair a second
                            later, they cannot see or recall what you were looking at without your code.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel-canvas bento-cell">
                        <div class="text-muted font-monospace mb-3" style="font-size: 0.7rem;">// EMERGENCY AUTO-LOCK 03
                        </div>
                        <h4 class="fw-bold h6 mb-3 text-dark">Walk-Away Panic Lock (PRO)</h4>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">Forgot to hide your screen before
                            stepping away? The system automatically senses when your mouse and keyboard inputs hit a
                            60-second absolute zero drop and instantly engages the emergency lockbox automatically.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel-canvas bento-cell">
                        <div class="text-muted font-monospace mb-3" style="font-size: 0.7rem;">// DISCRETION ADJUSTER 04
                        </div>
                        <h4 class="fw-bold h6 mb-3 text-dark">Approved Safe-List Filters (PRO)</h4>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">Maintain the perfect disguise layout.
                            Choose your real work tools, news feeds, or educational documents to stay open, ensuring
                            your browser screen looks incredibly natural when the sweep completes.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel-canvas bento-cell">
                        <div class="text-muted font-monospace mb-3" style="font-size: 0.7rem;">// NO HISTORY TRAILS 05
                        </div>
                        <h4 class="fw-bold h6 mb-3 text-dark">Anti-Spy History Eraser</h4>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">A classic way people snoop is
                            checking what you just opened a minute ago. The second you trigger the panic shield, the app
                            cleanses any matching recent entry paths from your browser history ledger entirely.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section id="benefits" class="py-6 border-top border-light-subtle bg-white">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <span class="text-muted font-monospace d-block mb-2" style="font-size: 0.75rem;">PEACE OF
                        MIND</span>
                    <h2 class="fw-800 text-dark tracking-tight h1">Complete Comfort & Guarded Boundaries.</h2>
                </div>
                <div class="col-lg-6">
                    <p class="text-muted mb-0 style-symmetrical" style="font-size: 1.05rem; line-height: 1.6;">
                        UDARAX is built to eliminate the physical anxiety of working in common open areas, shared
                        households, or high-traffic offices by providing a flawless shield of defense.
                    </p>
                </div>
            </div>

            <div class="mt-5">
                <div class="row benefit-row align-items-start">
                    <div class="col-md-4">
                        <span class="font-monospace fw-bold text-danger d-block mb-2" style="font-size: 0.85rem;">[
                            ELIMINATE ANXIETY ]</span>
                        <h4 class="fw-bold text-dark">Stop Glancing Over Your Shoulder</h4>
                    </div>
                    <div class="col-md-8">
                        <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.65;">
                            Constantly worrying about who is sneaking a peek behind your display destroys your peace of
                            mind and introduces unnecessary stress. Knowing you have a reliable, split-second safety
                            trigger allows you to browse with absolute confidence and zero anxiety.
                        </p>
                    </div>
                </div>

                <div class="row benefit-row align-items-start">
                    <div class="col-md-4">
                        <span class="font-monospace fw-bold text-dark d-block mb-2" style="font-size: 0.85rem;">[
                            PRESERVE DIGNITY ]</span>
                        <h4 class="fw-bold text-dark">Guaranteed Boundaries instantly</h4>
                    </div>
                    <div class="col-md-8">
                        <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.65;">
                            Your personal life—whether it's checking personal finances, research queries, or just
                            unwinding with entertainment—belongs to you alone. Protect yourself from unwanted
                            explanations, micro-management questions, or awkward moments with friends or managers.
                        </p>
                    </div>
                </div>

                <div class="row benefit-row align-items-start">
                    <div class="col-md-4">
                        <span class="font-monospace fw-bold text-dark d-block mb-2" style="font-size: 0.85rem;">[ SPEED
                            ADVANTAGE ]</span>
                        <h4 class="fw-bold text-dark">Saves Your Progress Safely</h4>
                    </div>
                    <div class="col-md-8">
                        <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.65;">
                            Frantically closing your tabs during a panic situation means losing your work, logging out
                            of active sessions, and forgetting important links. UDARAX holds your exact spots in memory
                            behind the passcode shield, allowing you to resume precisely where you left off when the
                            room clears.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="cycle" class="py-6 bg-light border-top border-bottom border-light-subtle">
        <div class="container py-2">
            <div class="row g-4">
                <div class="col-lg-3">
                    <span class="text-muted font-monospace d-block mb-2" style="font-size: 0.75rem;">SITUATION
                        CYCLE</span>
                    <h3 class="fw-800 text-dark tracking-tight">The 3-Step Protection Loop</h3>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="font-monospace fw-bold text-danger mb-2">01 / TRIPPED SHORTCUT</div>
                    <p class="text-muted small" style="line-height: 1.6;">Someone walks up to your desk unexpectedly.
                        You hit <kbd>Alt + H</kbd> instantly. All private screens disappear from view in the blink of an
                        eye.</p>
                </div>
                <div class="col-lg-3">
                    <div class="font-monospace fw-bold text-dark mb-2">02 / LOCKBOX ISOLATION</div>
                    <p class="text-muted small" style="line-height: 1.6;">Your links slide into a hidden
                        password-secured lockbox, locked out of standard visibility or active web tracking lists on the
                        spot.</p>
                </div>
                <div class="col-lg-2">
                    <div class="font-monospace fw-bold text-dark mb-2">03 / SAFE RETURN</div>
                    <p class="text-muted small" style="line-height: 1.6;">Once you're alone again, punch your personal
                        4-digit code into the interactive number pad menu to securely recall your original workspace
                        positions.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="pricing" class="py-6">
        <div class="container py-3">
            <div class="text-center mb-5">
                <h2 class="fw-800 text-dark tracking-tight h1 mb-2">Choose Your Defense Level</h2>
                <p class="text-muted small">Deploy the exact privacy barrier configuration that fits your personal
                    comfort needs.</p>

                <div class="segmented-control-wrapper mt-4">
                    <button id="moButtonTrigger" class="is-selected"
                        onclick="modifyPricingPeriodMode('monthly')">Monthly Billing</button>
                    <button id="yrButtonTrigger" onclick="modifyPricingPeriodMode('yearly')">Yearly Plan (Save
                        40%)</button>
                </div>
            </div>

            <div class="row g-4 justify-content-center align-items-stretch mt-2">
                <div class="col-md-5 col-lg-4">
                    <div class="panel-canvas p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <span class="text-muted font-monospace d-block small mb-2">BASIC SHIELD 01</span>
                            <h3 class="fw-800 text-dark h2 mb-4">$0 <span class="fs-6 text-muted fw-normal">/ free
                                    forever</span></h3>
                            <hr class="my-3 text-secondary-subtle">
                            <ul class="list-unstyled d-grid gap-2.5 my-4 text-muted small">
                                <li>✓ Instant Universal Panic Key Shortcut</li>
                                <li>✓ Automatic Browser History Tracker Scrubber</li>
                                <li>✓ Hide up to 10 active tabs at the same time</li>
                                <li>✓ Private safe storage directly on your own device</li>
                            </ul>
                        </div>
                        <a href="#install" class="btn-steel-secondary text-center w-100 py-2.5 small">Download Free
                            Shield</a>
                    </div>
                </div>

                <div class="col-md-5 col-lg-4">
                    <div class="panel-canvas p-4 h-100 d-flex flex-column justify-content-between"
                        style="border: 2px solid var(--panic-red);">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-dark font-monospace d-block small fw-bold">PRO SHIELD 02</span>
                                <span class="badge bg-danger text-white rounded font-monospace"
                                    style="font-size: 0.6rem; padding: 4px 6px;">MAX SECURITY</span>
                            </div>
                            <h3 class="fw-800 text-dark h2 mb-4">
                                <span id="priceNumericalLabel">$3.99</span> <span class="fs-6 text-muted fw-normal"
                                    id="priceIntervalSubtitle">/ month</span>
                            </h3>
                            <hr class="my-3 text-secondary-subtle">
                            <ul class="list-unstyled d-grid gap-2.5 my-4 text-dark small">
                                <li>✓ <strong>Hide unlimited links and browser spaces</strong></li>
                                <li>✓ Secret 4-Digit PIN Passcode Screen Lock</li>
                                <li>✓ Safety lockout after too many wrong code attempts</li>
                                <li>✓ Automated lock mode when your computer is idle</li>
                                <li>✓ Custom Approved Safe-List websites that never clear</li>
                                <li>✓ Direct lane to priority user support teams</li>
                            </ul>
                        </div>
                        <a href="#install" id="paymentActionBtn"
                            class="btn-steel-primary text-center w-100 py-2.5 small"
                            style="background-color: var(--panic-red); border-color: var(--panic-red);">Activate Premium
                            Shield</a>
                    </div>
                </div>
            </div>

            <div id="licenseTestingBlockAnchor" class="row justify-content-center mt-5 pt-4">
                <div class="col-md-8 col-lg-5">
                    <div class="panel-canvas p-4 text-center bg-light-subtle"
                        style="border-style: dashed; border-color: #a1a1aa;">
                        <h4 class="fw-bold text-dark h6 mb-1">Try Out a Pro Shield Activation Code</h4>
                        <p class="text-muted small mb-3">Copy and paste this sample code below to see it work: <code
                                class="text-dark bg-light border px-1.5 py-0.5 rounded fw-bold font-monospace"
                                style="font-size: 0.75rem;">UDRX-1234-5678</code></p>
                        <div class="input-group input-group-sm max-w-sm mx-auto" style="max-width: 330px;">
                            <input type="text"
                                class="form-control border-secondary-subtle font-monospace text-center text-uppercase"
                                placeholder="UDRX-XXXX-XXXX" id="hardwareLicenseInputField"
                                oninput="parseHardwareLicenseString()">
                            <button class="btn btn-dark fw-bold font-monospace px-3.5" style="font-size: 0.75rem;"
                                type="button" onclick="executeManualVerificationAlert()">Verify</button>
                        </div>
                        <div class="small mt-2 font-monospace text-success d-none fw-bold"
                            id="hardwareSuccessNotificationLabel">✓ Pro Shield Confirmed! Premium Panic Protections are
                            now unlocked.</div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section id="faq" class="py-6 border-top border-light-subtle">
        <div class="container" style="max-width: 780px;">
            <div class="mb-5 text-center">
                <h2 class="fw-800 text-dark tracking-tight h2">Frequently Asked Questions</h2>
                <p class="text-muted small">Straightforward answers about your privacy, hotkeys, and data safety bounds.
                </p>
            </div>

            <div class="accordion" id="engineeringFaqGroup">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapseNode1">
                            Are my hidden screens or personal URLs saved or sent over the internet?
                        </button>
                    </h2>
                    <div id="faqCollapseNode1" class="accordion-collapse collapse"
                        data-bs-parent="#engineeringFaqGroup">
                        <div class="accordion-body">
                            Absolutely not. We believe true privacy requires absolute independence. Everything you hide
                            is stored completely on your own computer's memory storage card. There are zero remote cloud
                            servers tracking your data, meaning your information never leaves your personal device.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapseNode2">
                            What happens if someone tries to brute-force or guess my code to spy on me?
                        </button>
                    </h2>
                    <div id="faqCollapseNode2" class="accordion-collapse collapse"
                        data-bs-parent="#engineeringFaqGroup">
                        <div class="accordion-body">
                            If someone inputs an incorrect PIN passcode 5 times in a row, the app completely freezes the
                            keypad for 5 full minutes. This cooldown is locked into the background app memory, meaning
                            refreshing the display, closing the window, or resetting the page will not remove the
                            lockdown safety block.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapseNode3">
                            Can I customize the quick keys to another button combination?
                        </button>
                    </h2>
                    <div id="faqCollapseNode3" class="accordion-collapse collapse"
                        data-bs-parent="#engineeringFaqGroup">
                        <div class="accordion-body">
                            Yes. Remapping your hotkeys is incredibly easy. Just enter your browser settings menu,
                            select "Extensions," and go directly to "Shortcuts" to set up whatever button layout feels
                            most natural for your fingers to trigger quickly.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-5 bg-white border-top border-light-subtle">
        <div class="container text-center text-muted small">
            <div class="d-flex justify-content-center gap-4 mb-3 text-uppercase font-monospace"
                style="font-size: 0.70rem; letter-spacing: 0.8px;">
                <a href="#" class="text-secondary">Privacy Policy</a>
                <a href="#" class="text-secondary">Terms of Service</a>
                <a href="#" class="text-secondary">Chrome Store Page</a>
            </div>
            <p class="mb-0 text-secondary font-monospace" style="font-size: 0.70rem; letter-spacing: 0.5px;">POWERED BY
                UDARAX &bull; PURE PANIC RESPONSE CODES &copy; 2026</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let internalStashedTabCounter = 0;
        let mechanicalInputPinBufferString = "";
        const targetVerifiedPinArguments = "1234";

        // Video Controller Logic Engine
        const demoPlaybackVideo = document.getElementById('demoPlaybackNode');
        const playbackActionBtn = document.getElementById('videoPlayPauseActionNode');
        const terminalLogStatus = document.getElementById('videoTerminalLog');
        const playbackTimerLabel = document.getElementById('videoPlaybackTimerDisplay');

        function handleVideoPlaybackControl() {
            if (demoPlaybackVideo.paused) {
                demoPlaybackVideo.play();
                playbackActionBtn.innerText = "⏸ PAUSE DEMO";
                terminalLogStatus.innerText = "[ STATUS: STREAMING ]";
                terminalLogStatus.className = "font-monospace text-success fw-bold";
            } else {
                demoPlaybackVideo.pause();
                playbackActionBtn.innerText = "⚡ PLAY INTRO";
                terminalLogStatus.innerText = "[ STATUS: PAUSED ]";
                terminalLogStatus.className = "font-monospace text-warning fw-bold";
            }
        }

        function jumpToVideoTimestamp(targetSeconds, ruleIndex) {
            demoPlaybackVideo.currentTime = targetSeconds;

            // Sync highlight styling across steps cues buttons
            for (let i = 1; i <= 3; i++) {
                document.getElementById(`cueNode${i}`).classList.remove('is-active');
            }
            document.getElementById(`cueNode${ruleIndex}`).classList.add('is-active');

            if (demoPlaybackVideo.paused) {
                demoPlaybackVideo.play();
                playbackActionBtn.innerText = "⏸ PAUSE DEMO";
            }
            terminalLogStatus.innerText = `[ SEGMENT_0${ruleIndex}: ACTIVE ]`;
            terminalLogStatus.className = "font-monospace text-danger fw-bold";
        }

        // Keep player duration counter metrics updated
        if (demoPlaybackVideo) {
            demoPlaybackVideo.addEventListener('timeupdate', () => {
                let currentMinutes = Math.floor(demoPlaybackVideo.currentTime / 60);
                let currentSeconds = Math.floor(demoPlaybackVideo.currentTime % 60);
                if (currentSeconds < 10) currentSeconds = "0" + currentSeconds;
                playbackTimerLabel.innerText = `0${currentMinutes}:${currentSeconds}`;

                // Auto-toggle active cues steps on passive scroll playback runtime
                if (demoPlaybackVideo.currentTime >= 42) {
                    syncStepCueUIOnly(3);
                } else if (demoPlaybackVideo.currentTime >= 18) {
                    syncStepCueUIOnly(2);
                } else {
                    syncStepCueUIOnly(1);
                }
            });

            demoPlaybackVideo.addEventListener('ended', () => {
                playbackActionBtn.innerText = "⚡ REPLAY INTRO";
                terminalLogStatus.innerText = "[ SYSTEM: FINISHED ]";
                terminalLogStatus.className = "font-monospace text-muted fw-bold";
            });
        }

        function syncStepCueUIOnly(ruleIndex) {
            for (let i = 1; i <= 3; i++) {
                document.getElementById(`cueNode${i}`).classList.remove('is-active');
            }
            document.getElementById(`cueNode${ruleIndex}`).classList.add('is-active');
        }

        // Sync and switch visible screenshot elements inside the new #screens stage viewport
        function switchScreenshotActiveViewport(targetPillIndex) {
            const activePillButtons = document.querySelectorAll('.screenshot-pill-card');
            activePillButtons.forEach(btn => btn.classList.remove('is-active'));

            const targetPillButton = document.querySelector(`.screenshot-pill-card[data-screenshot-target="${targetPillIndex}"]`);
            if (targetPillButton) {
                targetPillButton.classList.add('is-active');
            }

            const imageViewportNodes = document.querySelectorAll('.screenshot-img-node');
            imageViewportNodes.forEach(img => img.classList.remove('is-visible'));

            if (imageViewportNodes[targetPillIndex]) {
                imageViewportNodes[targetPillIndex].classList.add('is-visible');
            }
        }

        // Isolate Target Tab Array Rows via Interactive Simulation Action
        function isolateHardwareNode(targetNodeRowIdIndex) {
            const rowTargetSelectorNode = document.getElementById(`tabNodeAsset${targetNodeRowIdIndex}`);
            if (rowTargetSelectorNode && !rowTargetSelectorNode.classList.contains('is-purged')) {
                rowTargetSelectorNode.classList.add('is-purged');
                internalStashedTabCounter++;
                refreshMetricCounterBadgeDisplay();
            }
        }

        // Sync Metric Badge Count Elements dynamically
        function refreshMetricCounterBadgeDisplay() {
            const dynamicBadgeNodeLabel = document.getElementById('hardwareCountLabel');
            if (dynamicBadgeNodeLabel) {
                dynamicBadgeNodeLabel.innerText = `${internalStashedTabCounter} tabs hidden`;
                if (internalStashedTabCounter > 0) {
                    dynamicBadgeNodeLabel.className = "badge bg-success text-white fw-medium font-monospace";
                } else {
                    dynamicBadgeNodeLabel.className = "badge bg-dark text-white fw-medium font-monospace";
                }
            }
        }

        // Global Panic Option Action Trigger Simulation
        function triggerHardwarePanicRouteAll() {
            for (let i = 1; i <= 3; i++) {
                const rowElementNodeTarget = document.getElementById(`tabNodeAsset${i}`);
                if (rowElementNodeTarget && !rowElementNodeTarget.classList.contains('is-purged')) {
                    rowElementNodeTarget.classList.add('is-purged');
                    internalStashedTabCounter++;
                }
            }
            refreshMetricCounterBadgeDisplay();
            alert("Panic Mode Activated! Your open tabs have been hidden safely. A normal-looking safe display has taken their place.");
        }

        // Hard Reset Component Simulator View Matrix
        function resetHardwareSimulatorStateBlock() {
            internalStashedTabCounter = 0;
            mechanicalInputPinBufferString = "";
            refreshMetricCounterBadgeDisplay();
            toggleHardwareLockoutView(false);
            wipeHardwarePinBuffer();

            for (let i = 1; i <= 3; i++) {
                const rowElementNodeTarget = document.getElementById(`tabNodeAsset${i}`);
                if (rowElementNodeTarget) {
                    rowElementNodeTarget.classList.remove('is-purged');
                }
            }
        }

        // Toggle Screen Frame Locks overlays visibility
        function toggleHardwareLockoutView(shouldDisplayLockOverlayFrame) {
            const overlayTargetWrapperNode = document.getElementById('hardwareLockCanvas');
            if (overlayTargetWrapperNode) {
                if (shouldDisplayLockOverlayFrame) {
                    overlayTargetWrapperNode.classList.add('is-visible');
                } else {
                    overlayTargetWrapperNode.classList.remove('is-visible');
                }
            }
        }

        // Input Pin Core Keycap Routine string capture processing 
        function captureHardwareKey(charDigitInputArgument) {
            if (mechanicalInputPinBufferString.length < 4) {
                mechanicalInputPinBufferString += charDigitInputArgument;
                refreshKeycapIndicatorDots();

                if (mechanicalInputPinBufferString === targetVerifiedPinArguments) {
                    setTimeout(() => {
                        alert("Success! Code accepted. Your hidden spaces are unlocked.");
                        toggleHardwareLockoutView(false);
                        wipeHardwarePinBuffer();
                    }, 180);
                } else if (mechanicalInputPinBufferString.length === 4) {
                    setTimeout(() => {
                        alert("Incorrect PIN code. Please use the quick test code link below to try out the simulation.");
                        wipeHardwarePinBuffer();
                    }, 180);
                }
            }
        }

        // Wipe out everything in the code line
        function wipeHardwarePinBuffer() {
            mechanicalInputPinBufferString = "";
            refreshKeycapIndicatorDots();
        }

        // Removes only the last digit typed
        function backspaceHardwarePinBuffer() {
            if (mechanicalInputPinBufferString.length > 0) {
                mechanicalInputPinBufferString = mechanicalInputPinBufferString.slice(0, -1);
                refreshKeycapIndicatorDots();
            }
        }

        function shortcutBypassValidationRoutine() {
            mechanicalInputPinBufferString = "1234";
            refreshKeycapIndicatorDots();
            setTimeout(() => {
                toggleHardwareLockoutView(false);
                wipeHardwarePinBuffer();
            }, 100);
        }

        function refreshKeycapIndicatorDots() {
            const visualIndicatorBubbleNodesList = document.getElementById('lockBubbleRowNode').children;
            for (let i = 0; i < visualIndicatorBubbleNodesList.length; i++) {
                if (i < mechanicalInputPinBufferString.length) {
                    visualIndicatorBubbleNodesList[i].classList.add('is-engaged');
                } else {
                    visualIndicatorBubbleNodesList[i].classList.remove('is-engaged');
                }
            }
        }

        // Pricing Period Intermittent Target Toggle Switch Value Changes
        function modifyPricingPeriodMode(targetPricingIntervalString) {
            const monthlyTriggerBtnNode = document.getElementById('moButtonTrigger');
            const annualTriggerBtnNode = document.getElementById('yrButtonTrigger');
            const numericalPriceLabelNode = document.getElementById('priceNumericalLabel');
            const priceIntervalSubNode = document.getElementById('priceIntervalSubtitle');
            const paymentActionBtn = document.getElementById('paymentActionBtn');

            if (targetPricingIntervalString === 'yearly') {
                monthlyTriggerBtnNode.classList.remove('is-selected');
                annualTriggerBtnNode.classList.add('is-selected');
                numericalPriceLabelNode.innerText = "$2.41";
                priceIntervalSubNode.innerText = "/ month ($29 billed annually)";
                if (paymentActionBtn) paymentActionBtn.href = "#install";
            } else {
                annualTriggerBtnNode.classList.remove('is-selected');
                monthlyTriggerBtnNode.classList.add('is-selected');
                numericalPriceLabelNode.innerText = "$3.99";
                priceIntervalSubNode.innerText = "/ month";
                if (paymentActionBtn) paymentActionBtn.href = "#install";
            }
        }

        // Real-time sandbox application field licensing strings key evaluations
        function parseHardwareLicenseString() {
            const coreCurrentStringValue = document.getElementById('hardwareLicenseInputField').value.trim();
            const validationNotificationSuccessNodeLabel = document.getElementById('hardwareSuccessNotificationLabel');
            if (coreCurrentStringValue === "UDRX-1234-5678") {
                validationNotificationSuccessNodeLabel.classList.remove('d-none');
            } else {
                validationNotificationSuccessNodeLabel.classList.add('d-none');
            }
        }

        // Simple evaluation text alert
        function executeManualVerificationAlert() {
            const coreCurrentStringValue = document.getElementById('hardwareLicenseInputField').value.trim();
            if (coreCurrentStringValue === "UDRX-1234-5678") {
                alert("License code successful! Premium demo mode is now turned on.");
            } else {
                alert("Invalid code setup. Please enter the exact sample code 'UDRX-1234-5678' to test the license status screen.");
            }
        }

        function focusVerificationWidgetAnchor() {
            document.getElementById('licenseTestingBlockAnchor').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>

</html>