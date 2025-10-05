const CACHE_NAME = 'my-laravel-app-v1';
const urlsToCache = [
  '/',
  '/dashboard',
  '/orders',
  '/css/style.css',
  '/panel/assets/css/demo.css',
  '/panel/assets/vendor/css/core.css',
  '/panel/assets/vendor/libs/node-waves/node-waves.css',
  '/panel/assets/vendor/libs/pickr/pickr-themes.css',
  '/panel/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css',
  '/panel/assets/vendor/libs/apex-charts/apex-charts.css',
  '/panel/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css',
  '/panel/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css',
  '/panel/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css',
  '/panel/assets/vendor/libs/spinkit/spinkit.css',
  '/panel/assets/vendor/fonts/iconify-icons.css',
  'https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap',
  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
  'https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css',
  '/panel/assets/vendor/js/helpers.js',
  '/panel/assets/vendor/js/template-customizer.js',
  '/panel/assets/js/config.js',
  '/panel/assets/vendor/libs/jquery/jquery.js',
  '/panel/assets/vendor/libs/popper/popper.js',
  '/panel/assets/vendor/js/bootstrap.js',
  '/panel/assets/vendor/libs/node-waves/node-waves.js',
  '/panel/assets/vendor/libs/%40algolia/autocomplete-js.js',
  '/panel/assets/vendor/libs/pickr/pickr.js',
  '/panel/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js',
  '/panel/assets/vendor/libs/hammer/hammer.js',
  '/panel/assets/vendor/libs/i18n/i18n.js',
  '/panel/assets/vendor/js/menu.js',
  '/panel/assets/vendor/libs/apex-charts/apexcharts.js',
  '/panel/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  '/panel/assets/js/main.js',
  '/panel/assets/js/app-ecommerce-dashboard.js',
  'https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js',
  'https://cdn.jsdelivr.net/npm/sweetalert2@11',
  '/icons/icon-192x192.png',
  '/icons/icon-512x512.png'
];

// Install event - cache resources
self.addEventListener('install', (event) => {
  console.log('Service Worker: Installing...');
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        console.log('Service Worker: Caching files');
        return cache.addAll(urlsToCache);
      })
      .catch((error) => {
        console.log('Service Worker: Cache failed', error);
      })
  );
});

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
  console.log('Service Worker: Activating...');
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheName !== CACHE_NAME) {
            console.log('Service Worker: Deleting old cache', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

// Fetch event - serve from cache, fallback to network
self.addEventListener('fetch', (event) => {
  // Skip non-GET requests
  if (event.request.method !== 'GET') {
    return;
  }

  // Skip requests to external domains (except CDNs we want to cache)
  const url = new URL(event.request.url);
  const isExternalRequest = !url.origin.includes(window.location.hostname) && 
                           !url.hostname.includes('cdnjs.cloudflare.com') &&
                           !url.hostname.includes('fonts.googleapis.com') &&
                           !url.hostname.includes('fonts.gstatic.com') &&
                           !url.hostname.includes('cdn.jsdelivr.net');
  
  if (isExternalRequest) {
    return;
  }

  event.respondWith(
    caches.match(event.request)
      .then((response) => {
        // Return cached version or fetch from network
        if (response) {
          console.log('Service Worker: Serving from cache', event.request.url);
          return response;
        }

        console.log('Service Worker: Fetching from network', event.request.url);
        return fetch(event.request)
          .then((response) => {
            // Don't cache if not a valid response
            if (!response || response.status !== 200 || response.type !== 'basic') {
              return response;
            }

            // Clone the response
            const responseToCache = response.clone();

            // Cache the response
            caches.open(CACHE_NAME)
              .then((cache) => {
                cache.put(event.request, responseToCache);
              });

            return response;
          })
          .catch(() => {
            // Return offline page for navigation requests
            if (event.request.mode === 'navigate') {
              return caches.match('/');
            }
          });
      })
  );
});

// Background sync for offline actions
self.addEventListener('sync', (event) => {
  console.log('Service Worker: Background sync', event.tag);
  
  if (event.tag === 'background-sync') {
    event.waitUntil(
      // Handle background sync tasks
      handleBackgroundSync()
    );
  }
});

// Push notifications
self.addEventListener('push', (event) => {
  console.log('Service Worker: Push received');
  
  const options = {
    body: event.data ? event.data.text() : 'New notification from My Laravel App',
    icon: '/icons/icon-192x192.png',
    badge: '/icons/icon-72x72.png',
    vibrate: [100, 50, 100],
    data: {
      dateOfArrival: Date.now(),
      primaryKey: 1
    },
    actions: [
      {
        action: 'explore',
        title: 'View Details',
        icon: '/icons/icon-192x192.png'
      },
      {
        action: 'close',
        title: 'Close',
        icon: '/icons/icon-192x192.png'
      }
    ]
  };

  event.waitUntil(
    self.registration.showNotification('My Laravel App', options)
  );
});

// Notification click handler
self.addEventListener('notificationclick', (event) => {
  console.log('Service Worker: Notification clicked');
  
  event.notification.close();

  if (event.action === 'explore') {
    event.waitUntil(
      clients.openWindow('/dashboard')
    );
  } else if (event.action === 'close') {
    // Just close the notification
  } else {
    // Default action - open the app
    event.waitUntil(
      clients.openWindow('/')
    );
  }
});

// Handle background sync
async function handleBackgroundSync() {
  try {
    // Implement your background sync logic here
    // For example, sync offline orders, upload pending data, etc.
    console.log('Service Worker: Handling background sync');
  } catch (error) {
    console.error('Service Worker: Background sync failed', error);
  }
}

// Message handler for communication with main thread
self.addEventListener('message', (event) => {
  console.log('Service Worker: Message received', event.data);
  
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
  
  if (event.data && event.data.type === 'GET_VERSION') {
    event.ports[0].postMessage({ version: CACHE_NAME });
  }
});
