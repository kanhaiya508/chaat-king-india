<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .push-toast {
            position: fixed;
            right: 16px;
            bottom: 16px;
            width: min(360px, 92vw);
            background: #111;
            color: #fff;
            border-radius: 14px;
            padding: 14px 14px 12px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .35);
            display: grid;
            grid-template-columns: 48px 1fr auto;
            gap: 12px;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            transform: translateY(10px);
            transition: .25s ease;
        }

        .push-toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .push-toast img {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            object-fit: cover;
        }

        .push-toast .title {
            font-weight: 700;
            margin-bottom: 4px;
        }

        .push-toast .body {
            font-size: 14px;
            color: #d8d8d8;
        }

        .push-toast .actions {
            display: flex;
            gap: 8px;
        }

        .push-btn {
            background: #2575fc;
            color: #fff;
            border: 0;
            border-radius: 9px;
            padding: 8px 12px;
            font-weight: 600;
            cursor: pointer;
        }

        .push-btn--ghost {
            background: transparent;
            border: 1px solid #3a3a3a;
            color: #f1f1f1;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <h3>Web Push (Customers)</h3>
        <button id="enablePush" class="btn btn-primary">Enable Notifications</button>
        <div id="status" class="mt-3 text-muted"></div>
    </div>

    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import {
            getMessaging,
            getToken,
            onMessage,
            isSupported
        } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-messaging.js";

        const app = initializeApp({
            apiKey: "{{ env('FIREBASE_API_KEY') }}",
            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
            projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
            storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
            appId: "{{ env('FIREBASE_APP_ID') }}",
            measurementId: "{{ env('FIREBASE_MEASUREMENT_ID') }}"
        });

        const statusEl = document.getElementById('status');

        document.getElementById('enablePush').addEventListener('click', async () => {
            try {
                if (!(await isSupported())) {
                    statusEl.textContent = "Push not supported in this browser.";
                    return;
                }
                const permission = await Notification.requestPermission();
                if (permission !== 'granted') {
                    statusEl.textContent = "Permission denied.";
                    return;
                }

                const messaging = getMessaging(app);
                const reg = await navigator.serviceWorker.register('/firebase-messaging-sw.js');

                const token = await getToken(messaging, {
                    vapidKey: "{{ env('FIREBASE_VAPID_KEY') }}",
                    serviceWorkerRegistration: reg
                });

                if (!token) {
                    statusEl.textContent = "No token (check VAPID key).";
                    return;
                }

                await fetch("{{ route('customer.fcm.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        token,
                        device: navigator.userAgent
                    })
                });

                statusEl.textContent = "Token saved for this customer.";
            } catch (e) {
                console.error(e);
                statusEl.textContent = "Error: " + e.message;
            }
        });

        isSupported().then((ok) => {
            if (!ok) return;
            const messaging = getMessaging(app);
            onMessage(messaging, (payload) => {
                const n = payload.notification || {};
                const d = payload.data || {};
                showToast({
                    title: n.title || d.title,
                    body: n.body || d.body,
                    icon: n.icon || d.icon,
                    primary: d.action_primary_title ? {
                        title: d.action_primary_title,
                        url: d.action_primary_url
                    } : null,
                    secondary: d.action_secondary_title ? {
                        title: d.action_secondary_title,
                        url: d.action_secondary_url
                    } : null,
                });
            });
        });


        function showToast({
            title,
            body,
            icon,
            primary,
            secondary
        }) {
            const wrap = document.createElement('div');
            wrap.className = 'push-toast';
            wrap.innerHTML = `
      <img src="${icon || '/icon-192.png'}" alt="">
      <div>
        <div class="title">${title || 'Notification'}</div>
        <div class="body">${body || ''}</div>
      </div>
      <div class="actions">
        ${primary?.title ? `<button class="push-btn" data-href="${primary.url}">${primary.title}</button>`:''}
        ${secondary?.title ? `<button class="push-btn push-btn--ghost" data-href="${secondary.url}">${secondary.title}</button>`:''}
      </div>
    `;
            document.body.appendChild(wrap);
            requestAnimationFrame(() => wrap.classList.add('show'));

            wrap.addEventListener('click', (e) => {
                const btn = e.target.closest('button[data-href]');
                if (btn) window.open(btn.dataset.href, '_blank');
                document.body.removeChild(wrap);
            });

            setTimeout(() => {
                wrap.classList.remove('show');
                setTimeout(() => wrap.remove(), 25000);
            }, 6500);
        }
    </script>
</body>

</html>
