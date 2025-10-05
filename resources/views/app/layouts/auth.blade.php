<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Tabletray - Login' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="Login to Tabletray - Complete restaurant management system">
    <meta name="keywords" content="login, authentication, restaurant, management">
    <meta name="author" content="Tabletray">
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#800020">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Tabletray">
    <meta name="msapplication-TileColor" content="#800020">
    <meta name="msapplication-tap-highlight" content="no">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    
    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" sizes="72x72" href="/icons/icon-72x72.png">
    <link rel="apple-touch-icon" sizes="96x96" href="/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="128x128" href="/icons/icon-128x128.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/icons/icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/icons/icon-192x192.png">
    <link rel="apple-touch-icon" sizes="384x384" href="/icons/icon-384x384.png">
    <link rel="apple-touch-icon" sizes="512x512" href="/icons/icon-512x512.png">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('panel/assets/img/favicon/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="/icons/icon-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/icons/icon-512x512.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Google Font (Optional) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Remix Icons for subtle visuals -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Custom Auth CSS -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

</head>

<body class="d-flex align-items-center justify-content-center vh-100 px-3">

    {{ $slot }}

    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('✅ Service Worker registered successfully:', registration.scope);
                    })
                    .catch((error) => {
                        console.log('❌ Service Worker registration failed:', error);
                    });
            });
        }
    </script>

    <!-- PWA Install Prompt -->
    <script>
        let deferredPrompt;
        let installButton = null;

        // Create install button
        function createInstallButton() {
            if (installButton) return;

            installButton = document.createElement('button');
            installButton.id = 'pwa-install-btn';
            installButton.innerHTML = '<i class="ri-download-line me-2"></i><span>Install App</span>';
            installButton.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: linear-gradient(135deg, #800020 0%, #600018 100%);
                color: white;
                border: none;
                padding: 15px 25px;
                border-radius: 50px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                box-shadow: 0 4px 20px rgba(128, 0, 32, 0.4);
                z-index: 9999;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 8px;
                animation: pulse 2s infinite;
            `;

            installButton.addEventListener('mouseenter', () => {
                installButton.style.transform = 'scale(1.05)';
                installButton.style.boxShadow = '0 6px 25px rgba(128, 0, 32, 0.6)';
            });

            installButton.addEventListener('mouseleave', () => {
                installButton.style.transform = 'scale(1)';
                installButton.style.boxShadow = '0 4px 20px rgba(128, 0, 32, 0.4)';
            });

            installButton.addEventListener('click', async () => {
                if (!deferredPrompt) return;
                
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                
                console.log(outcome === 'accepted' ? '✅ PWA installed' : '❌ PWA dismissed');
                
                deferredPrompt = null;
                installButton.style.display = 'none';
            });

            document.body.appendChild(installButton);
        }

        // Capture install prompt
        window.addEventListener('beforeinstallprompt', (e) => {
            console.log('📱 PWA install available');
            e.preventDefault();
            deferredPrompt = e;
            createInstallButton();
        });

        // App installed
        window.addEventListener('appinstalled', () => {
            console.log('✅ PWA installed successfully');
            if (installButton) installButton.style.display = 'none';
            deferredPrompt = null;
        });

        // Check standalone mode
        if (window.matchMedia('(display-mode: standalone)').matches) {
            console.log('✅ Running in standalone mode');
        }

        // Add animation
        const style = document.createElement('style');
        style.textContent = '@keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }';
        document.head.appendChild(style);
    </script>

</body>

</html>
