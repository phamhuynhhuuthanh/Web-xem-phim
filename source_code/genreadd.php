<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="app.css">
    <title>Admin</title>
</head>
<body>
    <?php
    session_start();

    //thêm genre
    if(isset($_POST['add'])){
        $genre_name = $_POST['genre_name'];

        try {
            $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->query("set names 'utf8'");

            $sql = "INSERT INTO genre(genre_name) VALUES(:genre_name)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':genre_name', $genre_name);
            $stmt->execute();

            echo '<script>
                alert("Add successfully");
                window.location.href="genre.php";
            </script>';
            // header("Location: genre.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    
    ?>


    <div class="grid grid-cols-12">
        <div class="col-span-2 p-5  h-dvh">
            <ul>
                <li class="py-5">
                    <a href="homeadmin.php" class="btn btn-hover text-white" >
                        <span>Home</span>
                    </a>
                </li>
                <li class="py-5">
                    <a href="homeadmin.php" class="btn btn-hover text-white" >
                        <span>User</span>
                    </a>
                </li>
                <li class="py-5">
                    <a href="homeadmin.php" class="btn btn-hover text-white" >
                        <span>Movie</span>
                    </a>
                </li>
                <li class="py-5">
                    <a href="genre.php" class="btn btn-hover text-white" >
                        <span>Genre</span>
                    </a>
                </li>
                <li class="py-5">
                    <a href="homeadmin.php" class="btn btn-hover text-white" >
                        <span>Actor</span>
                    </a>
                </li>
                <li class="py-5">
                    <a href="homeadmin.php" class="btn btn-hover text-white" >
                        <span>director</span>
                    </a>
                </li>
                <li class="py-5">
                    <a href="homeadmin.php" class="btn btn-hover text-white" >
                        <span>log out</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-span-10 p-5">
            <h1 class="text-2xl font-semibold mb-4">Add Genre</h1>
            <form method="POST">
                <div class="mt-4 text-dark">
                    <label for="genre_name" class="block text-sm font-medium text-white">Genre Name</label>
                    <input type="text" id="genre_name" name="genre_name" class="mt-1 p-2 w-full border rounded-md text-dark">
                </div>
                <button type="submit" name="add" class="mt-4 btn">
                    <span class="z-10">Add</span>
                </button>
            </form>
            
        </div>
    </div>
</body>
</html>