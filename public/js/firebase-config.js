// public/js/firebase-config.js

import { initializeApp } from "https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js";
import { getDatabase, ref, set, onValue } from "https://www.gstatic.com/firebasejs/9.0.0/firebase-database.js";

const firebaseConfig = {
    apiKey: "AIzaSyDGeCHzLu7OGQlCgyntd8ag5yQYxBVXdyA",
    authDomain: "bcv1-d6838.firebaseapp.com",
    databaseURL: "https://bcv1-d6838-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "bcv1-d6838",
    storageBucket: "bcv1-d6838.appspot.com",
    messagingSenderId: "91065609832",
    appId: "1:91065609832:web:5c38f8ada7bcd4b43c55dd"
};

const app = initializeApp(firebaseConfig);
const database = getDatabase(app);

window.handleClick = function(elementId, firebasePath, imageId, onImage, offImage) {
    const img = document.getElementById(imageId);
    if (!img) {
        console.warn(`Element with ID ${imageId} not found.`);
        return;
    }
    const currentSrc = img.src;
    const newValue = currentSrc.includes('off') ? 1 : 0;
    const newImage = newValue === 1 ? onImage : offImage;

    img.src = newImage;
    updateFirebase(firebasePath, newValue);
};

function updateFirebase(path, value) {
    const dbRef = ref(database, path);
    console.log(`Updating Firebase at ${path} with value ${value}`); 
    set(dbRef, value)
        .then(() => {
            console.log("Data updated successfully!");
        })
        .catch((error) => {
            console.error("Error updating data: ", error);
        });
}

function listenFirebase(path, callback) {
    const dbRef = ref(database, path);
    onValue(dbRef, (snapshot) => {
        const data = snapshot.val();
        callback(data);
    });
}

function updateUIForAutomation(value) {
    const elements = ['bor-besar', 'kondisi-air', 'pompa-dorong'];
    elements.forEach(id => {
        const element = document.getElementById(id);
        if (!element) {
            return; // Skip if element is not found
        }
        if (value === 1) {
            element.style.pointerEvents = 'none';
            element.style.opacity = '0.5';
        } else {
            element.style.pointerEvents = 'auto';
            element.style.opacity = '1';
        }
    });
}

function updateImageBasedOnFirebaseValue(elementId, imageId, value) {
    const img = document.getElementById(imageId);
    if (!img) {
        return; // Skip if element is not found
    }
    const onImage = 'img/lightbulb-on.png'; 
    const offImage = 'img/lightbulb-off.png'; 
    img.src = value === 1 ? onImage : offImage;
}

listenFirebase('ControlSystem/Automation', updateUIForAutomation);
listenFirebase('ControlSystem/Reservoir1/Radar', (data) => {
    const img = document.getElementById('gambar-reservoir-atas');
    if (img) {
        const newImage = data === 1 ?  'img/cylinder-off.png' : 'img/cylinder.png';
        img.src = newImage;
    }
});
listenFirebase('ControlSystem/Reservoir2/RadarPompa3', (data) => {
    const img = document.getElementById('gambar-reservoir-bawah');
    if (img) {
        const newImage = data === 1 ?  'img/cylinder-off.png' : 'img/cylinder.png';
        img.src = newImage;
    }
});

// Listen to Firebase changes for each control element
listenFirebase('ControlSystem/Automation', (data) => {
    updateImageBasedOnFirebaseValue('mode-kontrol', 'gambar1', data);
});
listenFirebase('ControlSystem/Reservoir2/Relay1', (data) => {
    updateImageBasedOnFirebaseValue('bor-besar', 'gambar2', data);
});
listenFirebase('ControlSystem/Reservoir2/Relay2', (data) => {
    updateImageBasedOnFirebaseValue('kondisi-air', 'gambar3', data);
});
listenFirebase('ControlSystem/Reservoir2/Relay3', (data) => {
    updateImageBasedOnFirebaseValue('pompa-dorong', 'gambar4', data);
});
