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