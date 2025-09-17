/* global importScripts, firebase */
importScripts("https://www.gstatic.com/firebasejs/10.12.2/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/10.12.2/firebase-messaging-compat.js");

firebase.initializeApp({
    apiKey: "AIzaSyAnogSI2oL0xWOc58Gke1h0N5EGHEVWn5o",
    authDomain: "restaurant-management-d66ae.firebaseapp.com",
    projectId: "restaurant-management-d66ae",
    storageBucket: "restaurant-management-d66ae.firebasestorage.app",
    messagingSenderId: "553441463570",
    appId: "1:553441463570:web:e6186bdf26711cf00af7cb",
    measurementId: "G-DBQ80RPCEP"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    const n = payload.notification || {};
    self.registration.showNotification(n.title || "Notification", {
        body: n.body,
        icon: n.icon,
        image: n.image,
        data: { click_action: n.click_action }
    });
});

self.addEventListener("notificationclick", (e) => {
    e.notification.close();
    const url = e.notification.data?.click_action || "/";
    e.waitUntil(clients.openWindow(url));
});
