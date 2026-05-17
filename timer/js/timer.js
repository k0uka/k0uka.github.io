// Variables
let timer;
let timeRemaining;
let isRunning = false;
let isPaused = false;

// Récupérer les éléments DOM
const timerDisplay = document.getElementById('timerDisplay');
const minuteInput = document.getElementById('minuteInput');
const secondInput = document.getElementById('secondInput');
const startBtn = document.getElementById('startBtn');
const pauseBtn = document.getElementById('pauseBtn');
const resumeBtn = document.getElementById('resumeBtn');
const resetBtn = document.getElementById('resetBtn');
const alertSound = document.getElementById('alertSound');

// Fonction pour afficher le temps restant au format minute et seconde
function displayTime(timeInSeconds) {
    const minutes = Math.floor(timeInSeconds / 60);
    const seconds = timeInSeconds % 60;
    timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
}

// Fonction pour sauvegarder l'état dans le localStorage
function saveTimerState() {
    localStorage.setItem('timeRemaining', timeRemaining);
    localStorage.setItem('isRunning', isRunning);
    localStorage.setItem('isPaused', isPaused);
}

// Fonction pour charger l'état à partir du localStorage
function loadTimerState() {
    timeRemaining = parseInt(localStorage.getItem('timeRemaining')) || 0;
    isRunning = JSON.parse(localStorage.getItem('isRunning')) || false;
    isPaused = JSON.parse(localStorage.getItem('isPaused')) || false;
    displayTime(timeRemaining);
    updateButtons();
}

// Fonction pour démarrer le timer
function startTimer() {
    const userMinutes = parseInt(minuteInput.value);
    const userSeconds = parseInt(secondInput.value);

    if ((isNaN(userMinutes) || userMinutes < 0) || 
        (isNaN(userSeconds) || userSeconds < 0 || userSeconds >= 60) || 
        isRunning) {
        return;
    }

    timeRemaining = (userMinutes * 60) + userSeconds;
    isRunning = true;
    isPaused = false;
    saveTimerState();
    updateButtons();

    timer = setInterval(function () {
        if (timeRemaining > 0) {
            timeRemaining--;
            displayTime(timeRemaining);
            saveTimerState();
        } else {
            clearInterval(timer);
            alert("Le temps est écoulé !");
            alertSound.play();
            triggerVisualAlert();
            isRunning = false;
            saveTimerState();
            updateButtons();
        }
    }, 1000);
}

// Fonction pour mettre en pause le timer
function pauseTimer() {
    clearInterval(timer);
    isPaused = true;
    isRunning = false;
    saveTimerState();
    updateButtons();
}

// Fonction pour reprendre le timer
function resumeTimer() {
    if (isPaused) {
        isRunning = true;
        isPaused = false;
        saveTimerState();
        updateButtons();

        timer = setInterval(function () {
            if (timeRemaining > 0) {
                timeRemaining--;
                displayTime(timeRemaining);
                saveTimerState();
            } else {
                clearInterval(timer);
                alert("Le temps est écoulé !");
                alertSound.play();
                triggerVisualAlert();
                isRunning = false;
                saveTimerState();
                updateButtons();
            }
        }, 1000);
    }
}

// Fonction pour réinitialiser le timer
function resetTimer() {
    clearInterval(timer);
    timeRemaining = 0;
    displayTime(timeRemaining);
    isRunning = false;
    isPaused = false;
    saveTimerState();
    updateButtons();
    resetVisualAlert();
}

// Fonction pour mettre à jour les états des boutons
function updateButtons() {
    if (isRunning) {
        startBtn.disabled = true;
        pauseBtn.disabled = false;
        resumeBtn.disabled = true;
        resetBtn.disabled = false;
    } else if (isPaused) {
        startBtn.disabled = true;
        pauseBtn.disabled = true;
        resumeBtn.disabled = false;
        resetBtn.disabled = false;
    } else {
        startBtn.disabled = false;
        pauseBtn.disabled = true;
        resumeBtn.disabled = true;
        resetBtn.disabled = true;
    }
}

// Fonction pour alerte visuelle
function triggerVisualAlert() {
    timerDisplay.style.backgroundColor = '#ff4444';
    timerDisplay.style.color = 'white';
}

// Fonction pour réinitialiser l'alerte visuelle
function resetVisualAlert() {
    timerDisplay.style.backgroundColor = '#fff';
    timerDisplay.style.color = 'black';
}

// Ajouter les événements sur les boutons
startBtn.addEventListener('click', startTimer);
pauseBtn.addEventListener('click', pauseTimer);
resumeBtn.addEventListener('click', resumeTimer);
resetBtn.addEventListener('click', resetTimer);

// Charger l'état du timer depuis le localStorage lorsque la page est chargée
window.addEventListener('load', loadTimerState);
