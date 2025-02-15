<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="winDiv">
            <svg id="donut" width="240" height="240" ></svg>

        <h1 class="naslov pobijeda">BRAVO! USPIJELI STE!!!</h1>
        <canvas id="canvas"></canvas>
    </div>
    <script src="https://unpkg.com/zdog@1/dist/zdog.dist.min.js"></script>

    <script >
        let W = window.innerWidth;
        let H = window.innerHeight;
        const canvas = document.getElementById("canvas");
        const context = canvas.getContext("2d");
        const maxConfettis = 150;
        const particles = [];

        const possibleColors = [
        "DodgerBlue",
        "PaleGreen",
        "DeepPink",
        "Pink",
        "SlateBlue",
        "LightBlue",
        "Gold",
        "Violet",
        "PaleGreen",
        "SteelBlue",
        "HotPink",
        "LightSkyBlue",
        "MediumVioletRed"
        ];

        function randomFromTo(from, to) {
        return Math.floor(Math.random() * (to - from + 1) + from);
        }

        function confettiParticle() {
        this.x = Math.random() * W;
        this.y = Math.random() * H - H; 
        this.r = randomFromTo(11, 33); 
        this.d = Math.random() * maxConfettis + 11;
        this.color =
            possibleColors[Math.floor(Math.random() * possibleColors.length)];
        this.tilt = Math.floor(Math.random() * 33) - 11;
        this.tiltAngleIncremental = Math.random() * 0.07 + 0.05;
        this.tiltAngle = 0;

        this.draw = function() {
            context.beginPath();
            context.lineWidth = this.r / 2;
            context.strokeStyle = this.color;
            context.moveTo(this.x + this.tilt + this.r / 3, this.y);
            context.lineTo(this.x + this.tilt, this.y + this.tilt + this.r / 5);
            return context.stroke();
        };
        }

        function Draw() {
        const results = [];

        requestAnimationFrame(Draw);

        context.clearRect(0, 0, W, window.innerHeight);

        for (var i = 0; i < maxConfettis; i++) {
            results.push(particles[i].draw());
        }

        let particle = {};
        let remainingFlakes = 0;
        for (var i = 0; i < maxConfettis; i++) {
            particle = particles[i];

            particle.tiltAngle += particle.tiltAngleIncremental;
            particle.y += (Math.cos(particle.d) + 3 + particle.r / 2) / 2;
            particle.tilt = Math.sin(particle.tiltAngle - i / 3) * 15;

            if (particle.y <= H) remainingFlakes++;

        
            if (particle.x > W + 30 || particle.x < -30 || particle.y > H) {
            particle.x = Math.random() * W;
            particle.y = -30;
            particle.tilt = Math.floor(Math.random() * 10) - 20;
            }
        }

        return results;
        }

        window.addEventListener(
        "resize",
        function() {
            W = window.innerWidth;
            H = window.innerHeight;
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        },
        false
        );


        for (var i = 0; i < maxConfettis; i++) {
        particles.push(new confettiParticle());
        }


        canvas.width = W;
        canvas.height = H;
        Draw();

        let isSpinning = true;

let illo = new Zdog.Illustration({
  element: '#donut',
  dragRotate: true,
  rotate: { y: 0.4 },
});

// dough ring
new Zdog.Ellipse({
  addTo: illo,
  diameter: 50,
  stroke: 35,
  color: '#ffe6c4',
});

// frosting
new Zdog.Ellipse({
  addTo: illo,
  diameter: 45,
  stroke: 30,
  translate: { z: 10 },
  color: '#fd7fc0',
});

 // sprinkles
const sprinkleGroup = new Zdog.Group({
  addTo: illo,
  translate: { z: 25 },
});
const sprinkle = new Zdog.Shape({
  addTo: sprinkleGroup,
  path: [
    { x: -2 },
    { x:  2 },
  ],
  translate: { x: -5, y: -18 },
  rotate: { z: 0.5 },
  stroke: 3,
  color: '#FFF',
});
sprinkle.copy({
  translate: { x: 20, y: -10 },
  rotate: { z: 0 }
});
sprinkle.copy({
  translate: { x: -22, y: -8 },
  rotate: { z: 2 }
});
sprinkle.copy({
  translate: { x: 12, y: -25 },
  rotate: { z: 2 }
});
sprinkle.copy({
  translate: { x: -20, y: -23 },
  rotate: { z: 3 }
});
sprinkle.copy({
  translate: { x: 0, y: -30 },
  rotate: { z: 2.5 }
});
sprinkle.copy({
  translate: { x: 17, y: 5 },
  rotate: { z: -0.5 }
});
sprinkle.copy({
  translate: { x: -25, y: 8 },
  rotate: { z: 0 }
});
sprinkle.copy({
  translate: { x: 13, y: 20 },
  rotate: { z: 2 }
});
sprinkle.copy({
  translate: { x: -20, y: 22 },
  rotate: { z: 1.5 }
});
sprinkle.copy({
  translate: { x: -2, y: 30 },
  rotate: { z: 3 }
});
sprinkle.copy({
  translate: { x: 28, y: 10 },
  rotate: { z: 4.5 }
});
sprinkle.copy({
  translate: { x: -5, y: 18 },
  rotate: { z: 4.5 }
});

function animate() {
  illo.rotate.z += isSpinning ? -0.01 : 0;
  illo.updateRenderGraph();
  requestAnimationFrame( animate );
}
animate();
    </script>

</body>
</html>