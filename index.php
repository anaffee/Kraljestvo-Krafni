<?php
ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passwords = [
        'pocetna' => 'hakuna matata',
        'meni' => 'bazinga',
        'recepti' => '32volta',
        'prijavaKod' => 'kraljevina',
        'kolo' => 'heksametar',
        'radnici' => 'pekara',
        'footerKod' => 'hallstatt'
    ];

    $errors = [];
    foreach ($passwords as $key => $correctPassword) {
        if (isset($_POST[$key]) && strtolower($_POST[$key]) !== strtolower($correctPassword)) {
            $errors[] = ucfirst($key) . " is incorrect.";
        }
    }

    if (empty($errors)) {
        $redirectPath = dirname($_SERVER['PHP_SELF']) . "/win.php";

        header('Content-Type: application/json');
        echo json_encode(['redirect' => $redirectPath]);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => implode("<br>", $errors)]);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <title>Kraljevstvo Krafni</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.14.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.14.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
/>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>



    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <div class="navigation">
        <a href="#kraljevstvo_krafni">
        <div id="logo">
            <img src="img/logo.png" alt="krafna">
            <h1 class="naslov">Kraljevstvo Krafni</h1>
        </div>
        </a>
        <nav>
            <ul>
                <li><a href="#menu">Meni</a></li>
                <li><a href="#recepti">Recepti</a></li>
                <li><a href="#prijava">Prijava</a></li>
                <li><a href="#game">Kolo sreće</a></li>
                <li><a href="#pitanja">Pitanja</a></li>
                <li><a href="#Radnici">Radnici</a></li>
                <li><a href="#KodMain">Promo kod</a></li>
            </ul>
        </nav>
    </div>
    <div class="header" id="kraljevstvo_krafni">
        <div class="text">
            <h1>Kraljevstvo <br> Krafni</h1>
            <div class="image-row">
                <img src="img/krafna1.png" alt="krafna" class="image-row-item">
                <img src="img/krafna6.png" alt="krafna" class="image-row-item">
                <img src="img/logo.png" alt="krafna" class="image-row-item">
                <img src="img/krafna1.png" alt="krafna" class="image-row-item">
                <img src="img/krafna6.png" alt="krafna" class="image-row-item">
                <div class="image-row-item" id="droppable"></div>
            </div>
            <p>
            Iza svakog dijela stranice skriva se novi promo kod, a svaki klik otkriva 
            novi trag. Pronađi svih sedam skrivenih promo kodova i dokaži svoje 
            vještine – samo uporni stižu do kraja i osvajaju nagradu! Jesi li
             spreman za izazov?
            </p>
        </div>
        <div class="image">
            <img src="img/pozadina.png" alt="planina krafna">
        </div>
    </div>
    <div class="traka">
    </div>
    <div class="menu" id="menu">
        <div class="top">
            <div class="naslov-container">
                <h1 class="naslov">Meni</h1>
                <img src="img/logo.png" alt="roza krafna" id="draggable">
            </div>
            <form method="GET" class="inputi">
                <input type="hidden" name="form_action" value="search">
                <input type="checkbox" id="seeAll" name="seeAll" value="1" style="display:none;">
                <input type="text" id="search" name="search" placeholder="Pretraži krafne...">
                <input type="submit" id="searchButton" value="Pretraži">
            </form>
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "krafne_baza";

                $conn = new mysqli($servername, $username, $password, $dbname);
                $conn->set_charset("utf8mb4"); 

              
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }


                $row_count_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM krafne");
                $row_count = mysqli_fetch_assoc($row_count_result)['total'];

                $limit = $row_count -1;

               
                $upit = "SELECT * FROM krafne ORDER BY id ASC LIMIT $limit";
                $rezultat = mysqli_query($conn, $upit);

               
                if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['form_action']) && $_GET['form_action'] === 'search' && isset($_GET['seeAll'])) {
                    if (isset($_GET['search']) && !empty(trim($_GET["search"]))) {
                        
                        $pretrazi =$_GET["search"];
                        
                        $upit2 = "SELECT * FROM krafne WHERE ime LIKE '%$pretrazi%'"; 
                        $rezultat = mysqli_query($conn, $upit2);
                        
                        if (!$rezultat) {
                            echo "Greška u upitu: " . mysqli_error($conn);
                        }
                    }
                }
                $recepti = mysqli_query($conn, "SELECT * FROM recepti");

                if (!isset($_GET['recipe_id'])) {
                    $recipe_result = mysqli_query($conn, "SELECT * FROM recepti ORDER BY id ASC LIMIT 1");
                    $selected_recipe = mysqli_fetch_assoc($recipe_result);
                } else {
                    $recipe_id = intval($_GET['recipe_id']);
                    $recipe_result = mysqli_query($conn, "SELECT * FROM recepti WHERE id = $recipe_id");
                    $selected_recipe = mysqli_fetch_assoc($recipe_result);
                }
                ?>
        </div>
        <div class="items">
            <?php
            if ($rezultat && mysqli_num_rows($rezultat) > 0) {
                while ($row = mysqli_fetch_assoc($rezultat)) {
                    echo "<div class='item'>";
                    echo "<img src='" . htmlspecialchars($row['slika']) . "' alt='" . htmlspecialchars($row['ime']) . "'>";
                    echo "<div class='red'><h4>" . htmlspecialchars($row['ime']) . "</h4>";
                    echo "<p>" . htmlspecialchars($row['cijena']) . "€</p></div>";
                    echo "<div class='red'><p>" . htmlspecialchars($row['nadjev']) . "</p>";
                    echo "<button>+</button></div></div>";
                }
            } else {
                echo "<p>Nema rezultata za pretragu.</p>";
            }
            ?>
        </div>
    </div>
    <div class="recipe" id="recepti">
        <h1 class="naslov">Recepti</h1>
        <div class="list">
        <a href="?krafna=1">Kakao Krafna</a>
        <a href="?krafna=2">Vanilija Krafna</a>
        <a href="?krafna=3">Jagodica Krafna</a>
        <a href="?krafna=4">Cimet Krafna</a>
        <a href="?krafna=5">Kokos Krafna</a>
        </div>
        <div class="card">
        <?php
        if (isset($_GET['krafna'])) {
            $krafna_id = intval($_GET['krafna']); 
            
            $query = "SELECT * FROM recepti WHERE id = $krafna_id";
            $result = mysqli_query($conn, $query);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo "<img src='" . htmlspecialchars($row['slika']) . "' alt='" . htmlspecialchars($row['ime']) . "'>";
                echo "<div class='ispis'>";
                echo "<h1 class='naslov'>" . htmlspecialchars($row['ime']) . "</h1>";
                echo "<p><span>Tijesto:</span> " . htmlspecialchars($row['tijesto']) . "</p>";
                echo "<p><span>Nadjev:</span> " . htmlspecialchars($row['nadjev']) . "</p>";
                echo "<p><span>Priprema:</span> " . htmlspecialchars($row['priprema']) . "</p>";
                echo "<p><span>Vrijeme pripreme:</span> " . htmlspecialchars($row['vrijeme_pripreme']) . "</p>";
                echo "</div>";
            } else {
                echo "<p>Nema podataka za odabranu krafnu.</p>";
            }
        } else {
           
            $query = "SELECT * FROM recepti WHERE id = 1";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            echo "<img src='" . htmlspecialchars($row['slika']) . "' alt='" . htmlspecialchars($row['ime']) . "'>";
            echo "<div class='ispis'>";
            echo "<h1 class='naslov'>" . htmlspecialchars($row['ime']) . "</h1>";
            echo "<p><span>Tijesto:</span> " . htmlspecialchars($row['tijesto']) . "</p>";
            echo "<p><span>Nadjev:</span> " . htmlspecialchars($row['nadjev']) . "</p>";
            echo "<p><span>Priprema:</span> " . htmlspecialchars($row['priprema']) . "</p>";
            echo "<p><span>Vrijeme pripreme:</span> " . htmlspecialchars($row['vrijeme_pripreme']) . "</p>";
            echo "</div>";
        }
        ?>
        </div>
    </div>
    <div class="formaDiv" id="prijava">
        <h1 class="naslov">Prijava</h1>
        <form id="registrationForm">
            <input class="samoInput" type="text" name="ime" placeholder="Unesi ime" required>
            <input class="samoInput" type="text" name="prezime" placeholder="Unesi prezime" required>
            <input class="samoInput" type="email" name="mail" placeholder="Unesi email" required>
            <input class="samoInput" type="text" name="god" placeholder="Unesi godinu rođenja" required>
            
            <div class="password-container">
                <input class="samoInput" type="password" name="sifra" placeholder="Šifra" required>
                <i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility()"></i>
            </div>
            <span class="error-message" id="passwordError" style="display:none;"></span>
            <div class="strength-indicator" id="strengthIndicator"></div>

            <div class="checkbox-container">
                <input type="checkbox" id="acceptTerms">
                <label for="acceptTerms">Ne znam što je robots.txt</label>
            </div>
            <span class="warning-message" id="termsWarning">Morate potvrditi.</span>

          <button type="submit">Pošalji</button>
        </form>
    </div>

    <div class="game" id="game">
      <div class="wheel-container">
         <?php
         if (isset($_GET['skrivamSe']) == 'izaKola') {
            echo '<script src="wheel.js"></script>';
         }
         ?>
         <fieldset class="ui-wheel-of-fortune" style="--_items: 12;">
            <ul data-itemCount="12" id="wheel">
               <li id="hotpink"></li>
               <li id="darkpurple"></li>
               <li id="lightpink"></li>
               <li id="pink"></li>
               <li id="violet"></li>
               <li id="purple"></li>
               <li id="hotpink"></li>
               <li id="darkpurple"></li>
               <li id="lightpink"></li>
               <li id="pink"></li>
               <li id="violet"></li>
               <li id="purple"></li>
            </ul>
            <button type="button"></button>
         </fieldset>

         <button id="spin">Zavrti kolo </button>

      </div>
      <div class="tableText">
         <h1 class="naslov">Zavrti kolo i otkrij pravi promo kod</h1>
         <table>
            <tr>
               <td id="hotpink" class="boje"></td>
               <td class="txt">2 besplatne Kakao Krafne</td>
            </tr>
            <tr>
               <td id="darkpurple" class="boje"></td>
               <td>Upsi, ništa za tebe :(</td>
            </tr>
            <tr>
               <td id="lightpink" class="boje"></td>
               <td>3 besplatne Kokos Krafne</td>
            </tr>
            <tr>
               <td id="pink" class="boje"></td>
               <td>5% popusta za iduću kupnju</td>
            </tr>
            <tr>
               <td id="violet" class="boje"></td>
               <td>Upsi, ništa za tebe :(</td>
            </tr>
            <tr>
               <td id="purple" class="boje"></td>
               <td>Besplatna dostava tjedan dana</td>
            </tr>
         </table>
      </div>
   <div class="popup" id="popup"></div>

   </div>   

   <canvas id="canvas"></canvas>

    
    <div class="pitanja-section" id="pitanja">
    <h2 class="naslov">Pitanja</h2>
    
    <div class="pitanje" id="pitanje1">
        <div class="pitanje-header">
            <span>Koji su sastojci u klasičnoj krafni?</span>
            <button class="toggle-answer-btn" onclick="toggleAnswer(1)">&#9660;</button>
        </div>
        <div class="odgovor">
        Klasična krafna se pravi od sastojaka kao što su brašno, šećer, jaja, maslac 
        i kvasac. Tijesto se diže kako bi postalo mekano i prozračno, a potom se prži 
        u ulju dok ne dobije zlatnu boju. Nakon prženja, krafne se obično uvaljaju u 
        šećer ili se pune džemom, kremom ili čokoladom.
        </div>
    </div>
    
    <div class="pitanje" id="pitanje2">
        <div class="pitanje-header">
            <span>Kako dobiti krafne sa šarenim glazurama?</span>
            <button class="toggle-answer-btn" onclick="toggleAnswer(2)">&#9660;</button>
        </div>
        <div class="odgovor">
        Za šarene glazure koriste se šećerna glazura, čokolada ili bijela čokolada, 
        kojima se dodaju jestive boje. Kad se krafne ohlade, umaču se u obojene 
        glazure, a zatim se mogu posipati šećernim mrvicama, kokosom ili jestivim 
        šljokicama. Tako krafne postaju vizualno privlačnije i prilagođene svakom 
        ukusu i prigodi. 
        </div>
    </div>
    
    <div class="pitanje" id="pitanje3">
        <div class="pitanje-header">
            <span>Koliko dugo traje svježina krafni?</span>
            <button class="toggle-answer-btn" onclick="toggleAnswer(3)">&#9660;</button>
        </div>
        <div class="odgovor">
        Krafne su najsvježije prvi dan nakon pripreme, a u zatvorenoj posudi mogu 
        trajati 1-2 dana. Kako bi ostale mekane i ukusne, preporučuje se čuvanje u 
        hermetički zatvorenoj posudi ili zamotane u aluminijsku foliju. Nakon dva 
        dana, svježina se značajno smanjuje, ali mogu se kratko podgrijati kako bi 
        povratile dio mekane teksture. 
        </div>
    </div>
    
    <div class="pitanje" id="pitanje4">
        <div class="pitanje-header">
            <span>Kako osvojiti nagradu na kolu sreće?</span>
            <button class="toggle-answer-btn " disabled onclick="toggleAnswer(4)">&#9660;</button>
        </div>
        <div class="odgovor">?skrivamSe=izaKola</div>
    </div>
</div>

    <div class="mainRadnici">
    <h1 class="radniciNaslov">Naši radnici</h1>
 
    <div class="radnici" id="Radnici">
        <div class="radnik">
            <img class="profile-pic" src="./img/radnik.jpg">
            <h1 class="profile-name">Ivana Kovač</h1>
            <h3 class="profile-posao">Dekoratorka krafni</h3>
            <p class="profile-bio">Stručnjakinja za dekoriranje krafni, poznata po kreativnim i unikatnim dizajnima.</p>
        </div>
        <div class="radnik">
            <img class="profile-pic" src="./img/radnik2.jpeg">
            <h1 class="profile-name">Marko Horvat</h1>
            <h3 class="profile-posao">Dostavljač</h3>
            <p class="profile-bio">Dostavlja svježe krafne, poznat po točnosti i prijateljskom pristupu.</p>
        </div>
        <div class="radnik">
            <img class="profile-pic" src="./img/radnik3.jpeg">
            <h1 class="profile-name">Ana Petrović</h1>
            <h3 class="profile-posao">Glavna pekarica</h3>
            <p class="profile-bio">Iskusna majstorica krafni, zadužena za kreiranje recepata i vođenje tima.</p>
        </div>
        <div class="radnik">
            <img class="profile-pic" src="./img/radnik4.jpg">
            <h1 class="profile-name">Lana Marušić</h1>
            <h3 class="profile-posao">Prodavačica</h3>
            <p class="profile-bio">Ljubazna i uvijek spremna pomoći kupcima s izborom savršene krafne.</p>
        </div>
        <div class="radnik">
            <img class="profile-pic" src="./img/radnik5.jpg">
            <h1 class="profile-name">Petra Jurković</h1>
            <h3 class="profile-posao">Pekarica specijalizirana za punjenja</h3>
            <p class="profile-bio">Specijalistica za bogata punjenja krafni s raznolikim okusima.</p>
        </div>
 
        <?php
        if (isset($_COOKIE["isAdmin"]) && $_COOKIE["isAdmin"] === "1") {
            echo '<div class="radnik">';
            echo '<img class="profile-pic" src="./img/radnik6.jpg">';
            echo '<h1 class="profile-name">Matea Cezar</h1>';
            echo '<h3 class="profile-posao">Menadžer</h3>';
            echo '<p class="profile-bio">/jodced.sks</p>';
            echo '</div>'; 
        } else {
            echo '<div class="radnik">';
            echo '<img class="profile-pic" src="./img/topsecret.jpg">';
            echo '<h1 class="profile-name">Tajni investitor</h1>';
            echo '<h3 class="profile-posao">Menadžer</h3>';
            echo '<p class="profile-bio">Informacija moguće isključivo admistratoru</p>';
            echo '</div>'; 
        }
        ?>
    </div>
</div>

<div class="KodMain" id="KodMain">
    <form method="POST" class="formPromoKod" id="passwordForm">
        <div class="gornjiDio inputkod">
            <div class="inputKod">
                <h2>Header:</h2>
                <input type="text" name="pocetna" id="pocetna" value="<?php echo htmlspecialchars($_POST['pocetna'] ?? ''); ?>">
            </div>
            <div class="inputKod">
                <h2>Meni:</h2>
                <input type="text" name="meni" id="meni" value="<?php echo htmlspecialchars($_POST['meni'] ?? ''); ?>">
            </div>
            <div class="inputKod">
                <h2>Recepti:</h2>
                <input type="text" name="recepti" id="recepti" value="<?php echo htmlspecialchars($_POST['recepti'] ?? ''); ?>">
            </div>
            <div class="inputKod">
                <h2>Prijava:</h2>
                <input type="text" name="prijavaKod" id="prijavaKod" value="<?php echo htmlspecialchars($_POST['prijava'] ?? ''); ?>">
            </div>
        </div>
        <div class="sredina inputkod">
            <button type="submit" class="promoKod" id="promoKod">Promo kod</button>
        </div>
        <div class="donjiDio inputkod">
            <div class="inputKod">
                <h2>Zavrti kolo:</h2>
                <input type="text" name="kolo" id="kolo" value="<?php echo htmlspecialchars($_POST['kolo'] ?? ''); ?>">
            </div>
            <div class="inputKod">
                <h2>Radnici:</h2>
                <input type="text" name="radnici" id="radnici" value="<?php echo htmlspecialchars($_POST['radnici'] ?? ''); ?>">
            </div>
            <div class="inputKod">
                <h2>Footer:</h2>
                <input type="text" name="footerKod" id="footerKod" value="<?php echo htmlspecialchars($_POST['footer'] ?? ''); ?>">
            </div>
        </div>
    </form>
    
</div>
<div class="footerDiv">
        <footer>
            <div class="footerMain">
                <div class="footerMainTop">
                    <div class="footerPartOne">
                        <div class="footerLogo">
                            <a href="#"> <div id="logo">
            <img src="img/logo.png" alt="logo" style="width:120px;height:120px">
            <h1 class="naslov">Kraljevstvo Krafni</h1>
        </div></a>
                        </div>
                    </div>
                    <div class="footerPartTwo">
                      
                        <div class="footerTwoContainer">
                            <h2 class="footerTitle">KONTAKTIRAJTE NAS</h2>
                            <div class="footerContact">
                                <ul>
                                    <li>
                                        <h3>Broj mobitela: <a href="">+123 456 7890</a></h3>
                                    </li>
                                    <li>
                                        <h3>E-mail:<a href=""> kraljevstvoKrafni@gmail.com</a> </h3>
                                    </li><br>
                                    <li>
                                        <h2>ZAPRATITE NAS</h2><br>
                                        <div class="footerSocialMedia">
                                            <a href="https://www.instagram.com/"><img class="instagram"
                                                    src="./img/insta.png"></a>
                                            <a href="https://www.youtube.com/"><img class="facebook"
                                                    src="./img/youtube.jpg"></a>
                                            <a href="https://www.facebook.com/"><img class="youtube"
                                                    src="./img/fb.jpg"></a>
                                        </div>
                                    </li>
                                </ul>
                                <img>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footerMainBottom">
                    <hr><br>
                    <div class="footerBottomContent">
                        <div class="footerBottomOne">
                            <h3>© 2024 Izradile Lea Dugandžić, Ana Čikeš i Ana Šimović uz mentorstvo nastavnice Nikoline Smilović</h3>
                        </div>
                        <div class="footerBottomTwo">
                            <a href="https://policies.google.com/terms?hl=en-US">
                                <h3>TERMS AND CONDITIONS</h3>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </footer>
    </div>
    <script src="main.js"></script>
    <?php
    if (isset($_GET['action']) && $_GET['action'] === 'get_flag') {
        include 'api.php'; 
        exit;
    }
    ?>
</body>
</html>
