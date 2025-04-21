// Import the functions you need from the SDKs you need
importScripts("https://www.gstatic.com/firebasejs/9.22.2/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/9.22.2/firebase-messaging-compat.js");
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
firebase.initializeApp({
  apiKey: "AIzaSyAt-UM6sfQa2NXMNrBUWrw2YRbJGExDvpw",
  authDomain: "mydemo-8a477.firebaseapp.com",
  projectId: "mydemo-8a477",
  storageBucket: "mydemo-8a477.appspot.com",
  messagingSenderId: "386016084099",
  appId: "1:386016084099:web:3da6dabc3db173e78adbb6",
  measurementId: "G-97ZT9B2612"
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