CREATE DATABASE krafne_baza
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE krafne_baza;

CREATE TABLE krafne (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ime VARCHAR(50) NOT NULL,
  cijena DECIMAL(4,2) NOT NULL,
  nadjev VARCHAR(50),
  slika VARCHAR(100)
);

INSERT INTO krafne (ime, cijena, nadjev, slika) VALUES
('Kakao Krafna', 2.50, 'Kakao', 'img/krafna1.png'),
('Vanilija Krafna', 2.00, 'Vanilija', 'img/krafna2.png'),
('Jagodica Krafna', 2.50, 'Jagoda', 'img/krafna3.png'),
('Cimet Krafna', 3.00, 'Cimet', 'img/krafna4.png'),
('Kokos Krafna', 3.00, 'Kokos', 'img/krafna5.png'),
('Karamela Krafna', 2.50, 'Karamela', 'img/krafna6.png'),
('Pistacija Krafna', 3.50, 'Pistacija', 'img/krafna7.png'),
('Pronašao si bazu', 85.00, '@UXRsDJ*A', 'img/flag.png');


CREATE TABLE IF NOT EXISTS recepti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ime VARCHAR(100) NOT NULL,
    slika VARCHAR(255) NOT NULL,
    tijesto TEXT NOT NULL,
    nadjev TEXT NOT NULL,
    priprema TEXT NOT NULL,
    vrijeme_pripreme VARCHAR(50) NOT NULL
);

INSERT INTO recepti (ime, slika, tijesto, nadjev, priprema, vrijeme_pripreme) VALUES
('Kakao krafna', 'img/krafna1.png', '250 g brašna, 125 g maslaca, 100 g šećera, prstohvat soli, 1 jaje, 1 vanilin šećer, 1 prašak za pecivo.', 'Kakao krema s mrvicama čokolade', 'Razvaljaj tijesto i ostavi da se dižu 30 minuta. Prži u zagrijanom ulju dok ne postanu zlatne.', '45 minuta'),
('Vanilija krafna', 'img/krafna2.png', '250 g brašna, 125 g maslaca, 100 g šećera, prstohvat soli, 1 jaje, 1 vanilin šećer, 1 prašak za pecivo.', 'Krema od vanilije sa šarenim mrvicama', 'Razvaljaj tijesto i ostavi da se dižu 30 minuta. Prži u zagrijanom ulju dok ne postanu zlatne.', '40 minuta'),
('Jagodica krafna', 'img/krafna3.png', '250 g brašna, 125 g maslaca, 100 g šećera, prstohvat soli, 1 jaje, 1 vanilin šećer, 1 prašak za pecivo.', 'Krema od jagode sa šarenim mrvicama', 'Razvaljaj tijesto i ostavi da se dižu 30 minuta. Prži u zagrijanom ulju dok ne postanu zlatne.', '50 minuta'),
('Cimet krafna', 'img/krafna4.png', '250 g brašna, 125 g maslaca, 100 g šećera, prstohvat soli, 1 jaje, 1 vanilin šećer, 1 prašak za pecivo.', 'Krema od cimeta i lješnjaka sa cvijetovima badema', 'Razvaljaj tijesto i ostavi da se dižu 30 minuta. Prži u zagrijanom ulju dok ne postanu zlatne.', '55 minuta'),
('Kokos krafna', 'img/krafna5.png', '250 g brašna, 125 g maslaca, 100 g šećera, prstohvat soli, 1 jaje, 1 vanilin šećer, 1 prašak za pecivo.', 'Krema od kokosa s ', 'Razvaljaj tijesto i ostavi da se dižu 30 minuta. Prži u zagrijanom ulju dok ne postanu zlatne.', '60 minuta'),
('Elektro krafna', 'img/flag.png', 'Koliko iznosi napon krafne', 'Ako otpor iznosi 8 ohma', 'A struja iznosi 4 ampera', 'Upitnik');
