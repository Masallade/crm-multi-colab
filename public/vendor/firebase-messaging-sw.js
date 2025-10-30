// Import Firebase scripts (compat version for service worker)
importScripts("https://www.gstatic.com/firebasejs/9.22.2/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/9.22.2/firebase-messaging-compat.js");

// Initialize Firebase
const firebaseConfig = {
  apiKey: "AIzaSyA_iJ_Nd7X6pepqLpHVNMRaoukHFEjJChA",
  authDomain: "crm-push-notification-ae1b8.firebaseapp.com",
  projectId: "crm-push-notification-ae1b8",
  storageBucket: "crm-push-notification-ae1b8.firebasestorage.app",
  messagingSenderId: "708608062410",
  appId: "1:708608062410:web:d3515e632b2a4d8b39d533"
};
firebase.initializeApp(firebaseConfig);

// Retrieve Firebase Messaging instance
const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage(function (payload) {
  console.log("[firebase-messaging-sw.js] Received background message:", payload);

  const notificationTitle = payload.notification?.title || "New Notification";
  const notificationOptions = {
    body: payload.notification?.body || "",
    icon: 'https://teamspace.baselinepracticesupport.co.uk/v2/crm/images/logo/logo.png', // Replace with your own icon path
    data: payload.data || {},
    vibrate: [100, 50, 100],
    requireInteraction: true
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});

// Optional: Handle notification click
self.addEventListener('notificationclick', function(event) {
  event.notification.close();

  const clickActionUrl = event.notification.data?.click_action || '/';

  event.waitUntil(
    clients.matchAll({ type: "window" }).then(function(clientList) {
      for (const client of clientList) {
        if (client.url === clickActionUrl && 'focus' in client) {
          return client.focus();
        }
      }
      if (clients.openWindow) {
        return clients.openWindow(clickActionUrl);
      }
    })
  );
});
