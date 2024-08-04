<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <title>
        Web xem phim
    </title>
    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap"
        rel="stylesheet">
    <!-- OWL CAROUSEL -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" />
    <!-- BOX ICONS -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <!-- APP CSS -->
    <link rel="stylesheet" href="grid.css">
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <?php 
        session_start(); 

        $plan_id = $_SESSION['plan_id'];

        //đăng xuất
        if(isset($_POST['logout'])) {
            session_destroy();
            echo '<script>alert("Log out successfully")</script>';
            header("Location: home.php");
        }
        
        //thể loại phim
        $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
        $pdo->query("set names 'utf8'");

        $sql_genre = "SELECT * FROM genre";
        $genres = $pdo->query($sql_genre)->fetchAll(PDO::FETCH_ASSOC);

        $pdo = null;


        //phim mới nhất
        $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
        $pdo->query("set names 'utf8'");

        $sql_latest_movies = "SELECT * FROM movie ORDER BY release_year DESC LIMIT 5";
        $latest_movies = $pdo->query($sql_latest_movies)->fetchAll(PDO::FETCH_ASSOC);

        $pdo = null;


        //phim hài
        $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
        $pdo->query("set names 'utf8'");

        $sql_genre_movie = "SELECT * FROM movie_genre WHERE genre_id = 3 LIMIT 5";
        $genre_movies = $pdo->query($sql_genre_movie)->fetchAll(PDO::FETCH_ASSOC);

        $comedy_movies = array();
        foreach($genre_movies as $genre_movie) {
            $sql_comedy_movies = "SELECT * FROM movie WHERE id = " . $genre_movie['movie_id'];
            $comedy_movie = $pdo->query($sql_comedy_movies)->fetch(PDO::FETCH_ASSOC);
            array_push($comedy_movies, $comedy_movie);
        }

        $pdo = null;


        //gói dịch vụ
        $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
        $pdo->query("set names 'utf8'");

        $sql_plan = "SELECT * FROM plan";
        $plans = $pdo->query($sql_plan)->fetchAll(PDO::FETCH_ASSOC);

        $pdo = null;


        //kiểm tra người dùng đã đăng kí gói dịch vụ chưa
        if(isset($_SESSION['email'])) {
            //lấy thông tin người dùng
            $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
            $pdo->query("set names 'utf8'");

            $sql_user = "SELECT * FROM users WHERE email = '" . $_SESSION['email'] . "'";
            $user = $pdo->query($sql_user)->fetch(PDO::FETCH_ASSOC);

            $_SESSION['id'] = $user['id'];

            //lấy thông tin gói dịch vụ của người dùng
            $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
            $pdo->query("set names 'utf8'");

            $sql_user_plan = "SELECT * FROM subscription WHERE users_id = " . $_SESSION['id'];
            $user_plan = $pdo->query($sql_user_plan)->fetch(PDO::FETCH_ASSOC);


            $pdo = null;
        }


        //đăng kí gói dịch vụ
        if(isset($_GET['plan_id']) && isset($_SESSION['id'])) {
            $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
            $pdo->query("set names 'utf8'");

            $sql_subscription = "INSERT INTO subscription (users_id, plan_id, start_date, end_date, status) 
                                VALUES (:user_id, :plan_id, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'active')";
            $stmt = $pdo->prepare($sql_subscription);

            $stmt->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
            $stmt->bindParam(':plan_id', $_GET['plan_id'], PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();

            $_SESSION['plan_id'] = $_GET['plan_id'];

            echo "Subscription registered successfully.";
        }
    ?>

    <!-- NAV -->
    <div class="nav-wrapper">
        <div class="container">
            <div class="nav">
                <a href="home.php" class="logo">
                    <i class='bx bx-movie-play bx-tada main-color'></i>Mov<span class="main-color">i</span>e
                </a>
                <div class="row"> 
                    <div class="col-12 col-md-6">
                      <div class="search-box">
                        <input type="text" placeholder="Search..." class="search-input">
                        <button type="submit" class="search-button">
                          <i class='bx bx-search'></i>
                        </button>
                      </div>
                    </div>
                  </div>
                <!-- NAV MENU -->
                <ul class="nav-menu" id="nav-menu">
                    <li><a href="home.php">Home</a></li>
                    <li>
                        <!-- <a href="#">Genre</a> -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = ! open" type="button" class="text-gray-500 group p-4 inline-flex items-center rounded-md  text-white uppercase font-medium hover:text-gray-900" aria-expanded="false">
                                <span>Genre</span>
                                <svg :class="{'rotate-180 duration-300': open, 'duration-300' : !open}" class="text-gray-400 ml-2 h-5 w-5 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div
                                x-show="open" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-90"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-90"
                                class="absolute left-1/2 z-full mt-3 w-screen max-w-md -translate-x-1/2 transform px-2 sm:px-0">

                                <div class="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                                    <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                        <?php foreach($genres as $genre) { ?>
                                            <a href="movie_genre.php?genre_id=<?php echo $genre['id'] ?>" class="-m-3 flex items-start rounded-lg p-3 hover:bg-gray-50">
                                                <!-- <svg class="h-6 w-6 flex-shrink-0 text-template-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819" />
                                                </svg> -->
                                                <div class="ml-4">
                                                    <p class="text-base font-medium text-gray-900">
                                                            <?php echo $genre['genre_name']; ?>
                                                    </p>
                                                </div>
                                            </a>
                                        <?php } ?>
                                        <!-- <a href="#" class="-m-3 flex items-start rounded-lg p-3 hover:bg-gray-50">
                                            <svg class="h-6 w-6 flex-shrink-0 text-template-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819" />
                                            </svg>
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">Enterprise</p>
                                                <p class="mt-1 text-sm text-gray-500">Enterprise options.</p>
                                            </div>
                                        </a>

                                        <a href="#" class="-m-3 flex items-start rounded-lg p-3 hover:bg-gray-50">
                                            <svg class="h-6 w-6 flex-shrink-0 text-template-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9" />
                                            </svg>
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">Books</p>
                                                <p class="mt-1 text-sm text-gray-500">All books</p>
                                            </div>
                                        </a>

                                        <a href="#" class="-m-3 flex items-start rounded-lg p-3 hover:bg-gray-50">
                                            <svg class="h-6 w-6 flex-shrink-0 text-template-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                            </svg>
                                            
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">Users</p>
                                                <p class="mt-1 text-sm text-gray-500">All Users</p>
                                            </div>
                                        </a> -->
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><a href="#">Movies</a></li>
                    <?php
                        if(isset($_SESSION['email'])){
                            echo '<li><a href="playlist.php">Playlist</a></li>';
                        }
                    ?>
                    <li>
                        <?php
                            if(isset($_SESSION['email'])){
                                echo '<a class="btn btn-hover text-white z-10"> <span>' . $_SESSION['email'] . '</span></a>';
                            } else {
                                echo '<a href="login.php" class="btn btn-hover">
                                <span>Sign in</span> </a>';
                            }
                        ?>
                        <!-- <a href="login.php" class="btn btn-hover">
                            totalAmount
                        </a> -->
                    </li>
                </ul>
                <!-- MOBILE MENU TOGGLE -->
                <div class="hamburger-menu" id="hamburger-menu">
                    <div class="hamburger"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END NAV -->

    <!-- USER INFORMATION -->
    <div class="user-info">
        <div class="container">
            <div class="user-info-wrapper">
                <div class="user-info-left">
                    <div class="user-info-left-wrapper">
                        <div class="user-info-left-top">
                            <div class="user-info-left-top-wrapper">
                                <div class="user-info-left-top-avatar">
                                    <!-- <img src="https://i.imgur.com/8Km9tLL.jpg" alt=""> -->
                                </div>
                                <div class="user-info-left-top-info">
                                    <h3>Name: <?php echo $user['name']; ?></hh3>
                                    <p>Email: <?php echo $user['email']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                        if($plan_id) {
                            echo '<div class="user-info-left-bottom">
                            <div class="user-info-left-bottom-wrapper">
                                <h3>Subscription</h3>
                                <p>Plan: ' . $user_plan['plan_id'] . '</p>
                                <p>Start date: ' . $user_plan['start_date'] . '</p>
                                <p>End date: ' . $user_plan['end_date'] . '</p>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
                <form action="user.php" method="post" style="display:inline;">
                    <input type="hidden" name="useremail" value="<?php echo $_SESSION['email']; ?>">
                    <button type="submit" name="logout" class="btn btn-hover">
                        <span>log out</span>
                    </button>
                </form>
                
            </div>
        </div>
    </div>
    <!-- END USER INFORMATION -->
</body>