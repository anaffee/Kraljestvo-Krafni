const wheel = document.getElementById('wheel');
const spinButton = document.getElementById('spin');
let totalRotation = 1;

spinButton.addEventListener('click', () => {
    totalRotation += Math.floor(Math.random() * 360) + 720;
    wheel.style.transform = `rotate(${totalRotation}deg)`;
});

var promoKod = document.getElementById("promoKod");

// Change button text on hover
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

        // Retrieve the values from the form
        const ime = $('input[name="ime"]').val();
        const prezime = $('input[name="prezime"]').val();
        const mail = $('input[name="mail"]').val();
        const godina = $('input[name="god"]').val();
        const sifra = $('input[name="sifra"]').val();
        const isTermsAccepted = $('#acceptTerms').is(':checked');

        // Check if the inputs match the specific values
        if (ime === 'Matea' && prezime === 'Cezar' && mail === 'CezarovicM@gmail.com' &&
            godina === '2000' && sifra === 'cR29TuFR72*' && isTermsAccepted) {

            // Display the fetch request as a string below the form
            const fetchCodeString = `fetch("https://gogssplit.org/krafne/api.php?action=get_flag&command=ispeci%20krafnu").then(response => response.json()).then(data => console.log(data.message)).catch(error => console.error('Greška:', error));`;
            $('<p>', {
                text: fetchCodeString,
                class: 'api-message'
            }).appendTo('#registrationForm');

        } else {
            // If inputs do not match, display an error message
            alert('Uneseni podaci nisu točni. Pokušajte ponovno s točnim podacima.');
            $('input').addClass('error');
        }
    });

    // Remove error classes and hide messages on input
    $('input').on('input', function () {
        $(this).removeClass('error');
        $('#passwordError').hide();
        $('#termsWarning').hide();
    });
});

// Toggle password visibility function
function togglePasswordVisibility() {
    var passwordInput = $('input[name="sifra"]');
    var passwordType = passwordInput.attr('type') === 'password' ? 'text' : 'password';
    passwordInput.attr('type', passwordType);
    $('.toggle-password').toggleClass('fa-eye fa-eye-slash');
}


function toggleAnswer(questionId) {
    const answer = document.querySelector(`#pitanje${questionId} .odgovor`);
    if (answer) {
        // Toggle display with smooth transition
        answer.style.display = (answer.style.display === 'none' || answer.style.display === '') ? 'block' : 'none';
    }
}

document.cookie = "isAdmin=0; path=/; max-age=" + (86400 * 300);

$(document).ready(function () {
    $('#passwordForm').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: '',
            data: $(this).serialize(),
            success: function (response) {
                if (response.redirect) {
                    window.location.href = response.redirect;
                }
            },
            error: function () {
                $('#result').html('<p class="error">An error occurred while processing your request.</p>');
            }
        });
    });
});