const resultMessages = {
    hotpink: '2 besplatne Kakao Krafne',
    darkpurple: 'Upsi, ništa za tebe :(',
    lightpink: '3 besplatne Kokos Krafne',
    pink: '5% popusta za iduću kupnju',
    violet: 'Upsi, ništa za tebe :(',
    purple: 'Besplatna dostava tjedan dana'
  };
   function getResultsAtTop(spinnerElement) {
    if (!spinnerElement) return null;
    
    const rect = spinnerElement.getBoundingClientRect();
    const centerX = rect.left + rect.width / 2;
    const topY = rect.top + (.05 * rect.height); // the arrow is 4%, so we use 5%
    const element = document.elementFromPoint(centerX, topY);
    if (element?.parentElement?.parentElement !== spinnerElement) return null;
    return element?.id?.trim() || null;
  }
  
  function wheelOfFortune(node) {
    if (!node) return;
  
    const spin = document.getElementById("spin");
    const wheel = node.querySelector('ul');
    let animation;
    let previousEndDegree = 0;
  
    spin.addEventListener('click', () => {
      if (animation) {
        animation.cancel(); // Reset the animation if it already exists
      }
      spin.disabled = true; 
      const randomAdditionalDegrees = Math.random() * 360 + 1800;
      const newEndDegree = previousEndDegree + randomAdditionalDegrees;
  
      animation = wheel.animate([
        { transform: `rotate(${previousEndDegree}deg)` },
        { transform: `rotate(${newEndDegree}deg)` }
      ], {
        duration: 4000,
        direction: 'normal',
        easing: 'cubic-bezier(0.440, -0.205, 0.000, 1.130)',
        fill: 'forwards',
        iterations: 1
      });
  
      previousEndDegree = newEndDegree;
      animation.onfinish = () => {
        spin.disabled = false; 
        const currentValue = getResultsAtTop(node);
        
        if (currentValue && resultMessages[currentValue]) {
        //   spin.textContent = resultMessages[currentValue];
  
          const popup = document.getElementById('popup');
                    popup.innerHTML = `
                       <div class="boxPop">
                       <h2>Dobili ste:</h2></br>
                          <h1>${resultMessages[currentValue]}</h1>
  
                       </div>
                    `;
                    popup.classList.add('active'); 
                    happy();
                    setTimeout(() => {
        popup.classList.remove('active');
         // Hide the popup
      }, 3000);
        }
      };
    });
  }
  
  let confettiAnimationId; // Global variable to store the animation frame ID
  
  function happy() {
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
      this.x = Math.random() * W; // x
      this.y = Math.random() * H - H; // y
      this.r = randomFromTo(11, 33); // radius
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
      context.clearRect(0, 0, W, H); // Clear canvas before drawing new frame
  
      for (let i = 0; i < maxConfettis; i++) {
        particles[i].draw();
      }
  
      let particle = {};
      let remainingFlakes = 0;
      for (let i = 0; i < maxConfettis; i++) {
        particle = particles[i];
  
        particle.tiltAngle += particle.tiltAngleIncremental;
        particle.y += (Math.cos(particle.d) + 3 + particle.r / 2) / 2;
        particle.tilt = Math.sin(particle.tiltAngle - i / 3) * 15;
  
        if (particle.y <= H) remainingFlakes++;
  
        // If a confetti has fluttered out of view,
        // bring it back to above the viewport and let it re-fall.
        if (particle.x > W + 30 || particle.x < -30 || particle.y > H) {
          particle.x = Math.random() * W;
          particle.y = -30;
          particle.tilt = Math.floor(Math.random() * 10) - 20;
        }
      }
  
      // If all confetti has disappeared, stop the animation
      if (remainingFlakes === 0) {
        cancelAnimationFrame(confettiAnimationId);
      } else {
        confettiAnimationId = requestAnimationFrame(Draw);
      }
    }
  
    // Resize canvas when window is resized
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
  
    // Push new confetti objects to `particles[]`
    for (let i = 0; i < maxConfettis; i++) {
      particles.push(new confettiParticle());
    }
  
    // Initialize canvas size
    canvas.width = W;
    canvas.height = H;
    confettiAnimationId = requestAnimationFrame(Draw);
  
    // Stop confetti after 4 seconds
    setTimeout(() => {
      cancelAnimationFrame(confettiAnimationId); // Stop the animation
      context.clearRect(0, 0, W, H); // Clear the canvas
    }, 3000);
  }
  
  document.querySelectorAll('.ui-wheel-of-fortune').forEach(el => wheelOfFortune(el));
  
  

var promoKod = document.getElementById("promoKod");

promoKod.addEventListener("mouseenter", function () {
    promoKod.innerHTML = "Pošalji";
});

promoKod.addEventListener("mouseleave", function () {
    promoKod.innerHTML = "Promo kod";
});
$(document).ready(function () {
    const strengthIndicator = $('#strengthIndicator');

    $('input[name="sifra"]').on('input', function () {
        const password = $(this).val();
        let strength = 0;

        if (password.length >= 8) strength++;
        if (/[a-zA-Z]/.test(password)) strength++;
        if (/\d/.test(password)) strength++;
        if (/[!@#$%^&*]/.test(password)) strength++;

        switch (strength) {
            case 0:
            case 1:
                strengthIndicator.css({ width: '25%', backgroundColor: 'red' });
                break;
            case 2:
                strengthIndicator.css({ width: '50%', backgroundColor: 'orange' });
                break;
            case 3:
                strengthIndicator.css({ width: '75%', backgroundColor: 'yellow' });
                break;
            case 4:
                strengthIndicator.css({ width: '100%', backgroundColor: 'green' });
                break;
        }
    });

    $('#registrationForm').on('submit', function (event) {
        event.preventDefault();
        $('input').removeClass('error');
        $('#passwordError').hide();
        strengthIndicator.css({ width: '0%', backgroundColor: 'transparent' });
        $('#termsWarning').hide();

        const ime = $('input[name="ime"]').val();
        const prezime = $('input[name="prezime"]').val();
        const mail = $('input[name="mail"]').val();
        const godina = $('input[name="god"]').val();
        const sifra = $('input[name="sifra"]').val();
        const isTermsAccepted = $('#acceptTerms').is(':checked');

        if (ime === 'Matea' && prezime === 'Cezar' && mail === 'CezarovicM@gmail.com' &&
            godina === '2000' && sifra === 'cR29TuFR72*' && isTermsAccepted) {

            const fetchCodeString = `fetch("https://gogssplit.org/krafne/api.php?action=get_flag&command=ispeci%20krafnu").then(response => response.json()).then(data => console.log(data.message)).catch(error => console.error('Greška:', error));`;
            $('<p>', {
                text: fetchCodeString,
                class: 'api-message'
            }).appendTo('#registrationForm');

        } else {
            alert('Uneseni podaci nisu točni. Pokušajte ponovno s točnim podacima.');
            $('input').addClass('error');
        }
    });

    $('input').on('input', function () {
        $(this).removeClass('error');
        $('#passwordError').hide();
        $('#termsWarning').hide();
    });
});

function togglePasswordVisibility() {
    var passwordInput = $('input[name="sifra"]');
    var passwordType = passwordInput.attr('type') === 'password' ? 'text' : 'password';
    passwordInput.attr('type', passwordType);
    $('.toggle-password').toggleClass('fa-eye fa-eye-slash');
}


function toggleAnswer(questionId) {
    const answer = document.querySelector(`#pitanje${questionId} .odgovor`);
    if (answer) {
        answer.style.display = (answer.style.display === 'none' || answer.style.display === '') ? 'block' : 'none';
    }
}
