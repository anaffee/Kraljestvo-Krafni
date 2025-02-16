window.addEventListener("DOMContentLoaded", (event) => {
    const spin = document.getElementById("spin");

    if (spin) {
        spin.onclick = function (event) {
            event.preventDefault();

            const popup = document.getElementById("popup");
            popup.innerHTML = `
                <div class="boxPop">
                    <h2>Nova sifra: </h2>
                    <h1>Heksametar</h1>
                </div>
            `;
            popup.classList.add("active");

            setTimeout(function () {
                popup.classList.remove("active");
            }, 3000);

        };
    }
});