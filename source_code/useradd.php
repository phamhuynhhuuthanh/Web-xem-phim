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

    //thêm user
    if(isset($_POST['add'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $role = $_POST['role'];

        if($name == '' || $email == '' || $password == '' || $confirmPassword == '' || $role == ''){
            echo '<script>
                alert("Please fill in all fields");
                window.location.href="useradd.php";
            </script>';
        }

        if($password != $confirmPassword){
            echo '<script>
                alert("Password and confirm password do not match");
                window.location.href="useradd.php";
            </script>';
        }

        if($role != 'admin' && $role != 'user'){
            echo '<script>
                alert("Role must be admin or user");
                window.location.href="useradd.php";
            </script>';
        }

        if(strlen($password) < 6){
            echo '<script>
                alert("Password must be at least 6 characters");
                window.location.href="useradd.php";
            </script>';
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo '<script>
                alert("Email is not valid");
                window.location.href="useradd.php";
            </script>';
        }

        try {
            $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->query("set names 'utf8'");

            $password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users(name, email, password, role) VALUES(:name, :email, :password, :role)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            echo '<script>
                alert("Add successfully");
                window.location.href="useradmin.php";
            </script>';
            // header("Location: genre.php");
        } catch (PDOException $e) {
            echo '<script>
                alert("$e->getMessage()");
                window.location.href="useradmin.php";
            </script>';
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
            <h1 class="text-2xl font-semibold mb-4">Add user</h1>
            <form method="POST">
                <div class="mt-4 text-dark">
                    <label for="genre_name" class="block text-sm font-medium text-white">Name</label>
                    <input type="text" id="genre_name" name="name" class="mt-1 p-2 w-full border rounded-md text-dark" require style="color: black;">
                </div>
                <div class="mt-4 text-dark">
                    <label for="genre_name" class="block text-sm font-medium text-white">Email</label>
                    <input type="text" id="genre_name" name="email" class="mt-1 p-2 w-full border rounded-md text-dark" require style="color: black;">
                </div>
                <div class="mt-4 text-dark">
                    <label for="genre_name" class="block text-sm font-medium text-white">Password</label>
                    <input type="password" id="genre_name" name="password" class="mt-1 p-2 w-full border rounded-md text-dark" require style="color: black;">
                </div>
                <div class="mt-4 text-dark">
                    <label for="genre_name" class="block text-sm font-medium text-white">Confirm password</label>
                    <input type="password" id="genre_name" name="confirmPassword" class="mt-1 p-2 w-full border rounded-md text-dark" require style="color: black;">
                </div>
                <div class="mt-4 text-dark">
                    <label for="genre_name" class="block text-sm font-medium text-white">Role</label>
                    <input type="text" id="genre_name" name="role" class="mt-1 p-2 w-full border rounded-md text-dark" require style="color: black;">
                </div>
                <button type="submit" name="add" class="mt-4 btn">
                    <span class="z-10">Add</span>
                </button>
            </form>
            
        </div>
    </div>
</body>
</html>