// Notification sound functionality
const notificationSound = {
    audio: null,
    
    init: function() {
        // Create audio element
        this.audio = new Audio('/v2/crm/public/sounds/notification.mp3');
        this.audio.volume = 0.5; // Set volume to 50%
    },
    
    play: function() {
        if (this.audio) {
            this.audio.currentTime = 0; // Reset audio to start
            this.audio.play().catch(error => {
                console.log('Error playing notification sound:', error);
            });
        }
    }
};

// Initialize notification sound when document is ready
document.addEventListener('DOMContentLoaded', function() {
    notificationSound.init();
});

// Function to play notification sound
function playNotificationSound() {
    notificationSound.play();
} 