// Import the functions you need from the SDKs you need
importScripts("https://www.gstatic.com/firebasejs/9.22.2/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/9.22.2/firebase-messaging-compat.js");
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
firebase.initializeApp({
  apiKey: "AIzaSyA_iJ_Nd7X6pepqLpHVNMRaoukHFEjJChA",
  authDomain: "crm-push-notification-ae1b8.firebaseapp.com",
  projectId: "crm-push-notification-ae1b8",
  storageBucket: "crm-push-notification-ae1b8.appspot.com",
  messagingSenderId: "708608062410",
  appId: "1:708608062410:web:d3515e632b2a4d8b39d533"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function (payload) {
  console.log("[firebase-messaging-sw.js] Received background message ", payload);

  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: '/icon.png', // optional
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});