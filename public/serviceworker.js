var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    '/offline',
    '/css/app.css',
    '/js/app.js',
    '/js/bootstrap.js',
    'https://ik.imagekit.io/taskordimg/seo/icon-72x72_9XXQQ8rO49.png',
    'https://ik.imagekit.io/taskordimg/seo/icon-96x96_iGOfQtMPUa.png',
    'https://ik.imagekit.io/taskordimg/seo/icon-128x128_jWfaVdJko.png',
    'https://ik.imagekit.io/taskordimg/seo/icon-144x144_QOCTg3a3oS.png',
    'https://ik.imagekit.io/taskordimg/seo/icon-152x152_3jjO5R_cz.png',
    'https://ik.imagekit.io/taskordimg/seo/icon-192x192_jTC0KcZevQ.png',
    'https://ik.imagekit.io/taskordimg/seo/icon-384x384_GPM-rSoww.png',
    'https://ik.imagekit.io/taskordimg/seo/icon-512x512_wXNDRqY6nz.png',
    'https://ik.imagekit.io/taskordimg/logo_8lLu9EPFa.svg',
    'https://ik.imagekit.io/taskordimg/beta_J6zazpyIw.svg',
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});