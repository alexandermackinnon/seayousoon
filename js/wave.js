window.addEventListener("DOMContentLoaded", (event) => {
  const canvas = document.createElement("canvas");
  document.body.appendChild(canvas);

  const ctx = canvas.getContext("2d");
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;

  const wave = {
    amplitude: 20,
    frequency: 0.01,
    speed: 2,
    yOffset: canvas.height / 2,
  };

  function drawWave() {
    ctx.fillStyle = "rgba(255,255,255,0.05)";
    ctx.beginPath();

    for (let x = 0; x < canvas.width; x++) {
      const y =
        wave.amplitude * Math.sin(wave.frequency * x + wave.speed) +
        wave.yOffset;
      ctx.lineTo(x, y);
    }

    ctx.lineTo(canvas.width, canvas.height);
    ctx.lineTo(0, canvas.height);
    ctx.closePath();
    ctx.fill();
  }

  function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawWave();
    wave.speed += 0.01;
    requestAnimationFrame(animate);
  }

  animate();

  window.addEventListener("resize", () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    wave.yOffset = canvas.height / 2;
  });
});
