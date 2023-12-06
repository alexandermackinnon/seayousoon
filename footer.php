<footer>
    <span class="link sound-toggle" onclick="toggleBackgroundMusic()"><img id="soundIcon"
            src="assets/icons/soundon.svg">TOGGLE
        AUDIO</span>
    <span>A REFLECTIVE SPACE OF FORESIGHT</span>
</footer>

<script>
var backgroundMusic = document.getElementById("backgroundMusic");
window.addEventListener('load', function() {
    backgroundMusic.play();
});

function toggleBackgroundMusic() {
    if (backgroundMusic.paused) {
        backgroundMusic.play();
    } else {
        backgroundMusic.pause();
    }

    var soundIcon = document.getElementById('soundIcon');

    // Check the current source of the icon
    if (soundIcon.src.includes('soundon.svg')) {
        // If it's soundon.svg, change it to soundoff.svg
        soundIcon.src = 'assets/icons/soundoff.svg';
    } else {
        // If it's not soundon.svg, change it to soundon.svg
        soundIcon.src = 'assets/icons/soundon.svg';
    }
}
</script>