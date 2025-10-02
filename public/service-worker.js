const CACHE_NAME = 'chaat-king-v1.0.0';
const STATIC_CACHE = 'chaat-king-static-v1';
const DYNAMIC_CACHE = 'chaat-king-dynamic-v1';

// Static assets to cache immediately
const STATIC_ASSETS = [
  '/',
  '/favicon.ico',
  '/manifest.json',
  '/panel/assets/vendor/css/core.css',
  '/panel/assets/css/demo.css',
  '/css/auth.css',
  '/css/style.css'
];

// PWA Icons (will be added dynamically when available)
const PWA_ICONS = [
  '/icons/icon-72x72.png',
  '/icons/icon-96x96.png',
  '/icons/icon-128x128.png',
  '/icons/icon-144x144.png',
  '/icons/icon-152x152.png',
  '/icons/icon-192x192.png',
  '/icons/icon-384x384.png',
  '/icons/icon-512x512.png'
];

// Install event - cache static assets
self.addEventListener('install', event => {
  console.log('[Service Worker] Installing Service Worker...');
  event.waitUntil(
    caches.open(STATIC_CACHE)
      .then(cache => {
        console.log('[Service Worker] Caching static assets');
        // Cache static assets first
        return cache.addAll(STATIC_ASSETS).then(() => {
          // Try to cache PWA icons, but don't fail if they don't exist
          return Promise.allSettled(
            PWA_ICONS.map(iconUrl => 
              fetch(iconUrl).then(response => {
                if (response.ok) {
                  return cache.put(iconUrl, response);
                }
                throw new Error(`Icon not found: ${iconUrl}`);
              }).catch(err => {
                console.warn(`[Service Worker] Could not cache icon: ${iconUrl}`, err.message);
                return null; // Don't fail the entire cache operation
              })
            )
          );
        });
      })
      .catch(err => {
        console.error('[Service Worker] Cache installation failed:', err);
      })
  );
  self.skipWaiting();
});

// Activate event - clean up old caches
self.addEventListener('activate', event => {
  console.log('[Service Worker] Activating Service Worker...');
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cache => {
          if (cache !== STATIC_CACHE && cache !== DYNAMIC_CACHE) {
            console.log('[Service Worker] Deleting old cache:', cache);
            return caches.delete(cache);
          }
        })
      );
    })
  );
  return self.clients.claim();
});

// Fetch event - network first, fallback to cache
self.addEventListener('fetch', event => {
  const { request } = event;
  const url = new URL(request.url);

  // Skip cross-origin requests
  if (url.origin !== location.origin) {
    return;
  }

  // Skip API requests and POST requests from caching
  if (request.method !== 'GET' || url.pathname.startsWith('/api/')) {
    return;
  }

  event.respondWith(
    caches.match(request)
      .then(cachedResponse => {
        // Return cached response if found
        if (cachedResponse) {
          // Update cache in background
          fetch(request).then(response => {
            if (response && response.status === 200) {
              caches.open(DYNAMIC_CACHE).then(cache => {
                cache.put(request, response);
              });
            }
          }).catch(() => {});
          return cachedResponse;
        }

        // Otherwise fetch from network
        return fetch(request)
          .then(response => {
            // Check if valid response
            if (!response || response.status !== 200 || response.type === 'error') {
              return response;
            }

            // Clone response for caching
            const responseToCache = response.clone();

            caches.open(DYNAMIC_CACHE)
              .then(cache => {
                cache.put(request, responseToCache);
              });

            return response;
          })
          .catch(err => {
            console.log('[Service Worker] Fetch failed, trying cache:', err);
            // Try to return a cached offline page
            return caches.match('/').then(response => {
              return response || new Response('Offline - Please check your connection', {
                status: 503,
                statusText: 'Service Unavailable',
                headers: new Headers({
                  'Content-Type': 'text/plain'
                })
              });
            });
          });
      })
  );
});

// Background sync for offline orders (optional feature)
self.addEventListener('sync', event => {
  if (event.tag === 'sync-orders') {
    event.waitUntil(syncOrders());
  }
});

async function syncOrders() {
  console.log('[Service Worker] Syncing offline orders...');
  // Implement your order sync logic here
}

// Push notifications (optional feature)
self.addEventListener('push', event => {
  if (event.data) {
    const data = event.data.json();
    const options = {
      body: data.body || 'New notification from Chaat King India',
      icon: '/icons/icon-192x192.png',
      badge: '/icons/icon-72x72.png',
      vibrate: [200, 100, 200],
      data: {
        url: data.url || '/'
      }
    };
    event.waitUntil(
      self.registration.showNotification(data.title || 'Chaat King India', options)
    );
  }
});

self.addEventListener('notificationclick', event => {
  event.notification.close();
  event.waitUntil(
    clients.openWindow(event.notification.data.url || '/')
  );
});
