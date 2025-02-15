<?php
session_start(); // Pokreni sesiju
header("Content-Type: application/json");

// Funkcija za vraćanje JSON odgovora
function jsonResponse($status, $message) {
    echo json_encode(["status" => $status, "message" => $message]);
}

// Definiraj tajnu naredbu i flag
$secret_command = "ispeci krafnu";  // Tajna naredba
$flag = "kraljevina";      // Tvoj pravi flag

// Inicijaliziraj broj pokušaja u sesiji
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0; // Prvi pokušaj
}

// Ograničenje pokušaja
$max_attempts = 5; // Maksimalan broj pokušaja

// Provjeri akciju i naredbu
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_flag') {
    // Dohvati naredbu iz URL-a
    $command = $_GET['command'] ?? '';

    // Provjeri je li naredba točna
    if ($command === $secret_command) {
        jsonResponse(true, $flag); // Vrati flag ako je naredba točna
        $_SESSION['attempts'] = 0;  // Resetiraj pokušaje nakon uspjeha
    } else {
        $_SESSION['attempts']++; // Povećaj broj pokušaja

        // Provjeri broj pokušaja
        if ($_SESSION['attempts'] >= $max_attempts) {
            jsonResponse(false, "Prekoračili ste maksimalan broj pokušaja. Pokušajte kasnije.");
        } else {
            jsonResponse(false, "Pogrešna naredba. Pokušajte ponovno!");
        }
    }
    exit;
}

// Ako ruta nije prepoznata
jsonResponse(false, "Nepoznata akcija.");
?>