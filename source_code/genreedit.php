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

    //đọc genre id
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->query("set names 'utf8'");

            $sql = "SELECT * FROM genre WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $genre = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        
        }
    }


    //cập nhật genre
    if(isset($_POST['edit'])){
        $id = $_POST['id'];
        $name = $_POST['name'];

        try {
            $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->query("set names 'utf8'");

            $sql = "UPDATE genre SET genre_name = :name WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->execute();

            echo '<script>
                alert("Update successfully");
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
            <h1 class="text-2xl font-semibold mb-4">Edit Genre</h1>
            <form method="POST">
                <div class="mt-4 text-dark">
                    <label>id</label>
                    <input type="text" name="id" value="<?php echo $genre['id'] ?>" readonly class="mt-1 p-2 w-full border rounded-md" style="color: black;">
                    <label for="name" class="block text-sm text-white font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" class="mt-1 p-2 w-full border rounded-md" value="<?php echo $genre['genre_name'] ?>" style="color: black;">
                </div>
                <div class="mt-6">
                    <button type="submit" class="w-full p-3 bg-green-500 text-white rounded-md hover:bg-green-400" name="edit">
                        Edit
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>