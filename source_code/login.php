<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Login</title>
</head>
<body>

    <?php
    session_start();
    $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
    $pdo->query("set names 'utf8'");

    if(isset($_POST['login'])){
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user){
            if(password_verify($password, $user['password'])){
                if($user['role'] == 'admin') {
                    $_SESSION['admin'] = $user['email'];
                    echo "Đăng nhập thành công";
                    header("Location: homeadmin.php");
                } else {
                    $_SESSION['email'] = $user['email'];
                    echo "Đăng nhập thành công";
                    header("Location: home.php");
                }
            } else {
                echo "Sai mật khẩu";
            }
        } else {
            echo "Email không tồn tại";
        }
    }

    ?>

    <div class="bg-white p-8 rounded shadow-md max-w-md w-full mx-auto">
        <h2 class="text-2xl font-semibold mb-4">Login</h2>

        <form method="POST">
            <!-- Nom et Prénom -->
            <!-- <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="firstName" class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input type="text" id="firstName" name="firstName" class="mt-1 p-2 w-full border rounded-md">
                </div>
                <div>
                    <label for="lastName" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" id="lastName" name="lastName" class="mt-1 p-2 w-full border rounded-md">
                </div>
            </div> -->

            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full p-3 bg-green-500 text-white rounded-md hover:bg-green-400" name="login">
                    Login
                </button>
            </div>
            <div class="mt-6">
                <button class="w-full p-3 bg-green-200 text-dark rounded-md hover:bg-green-400">
                    <a href="register.php">
                        Register
                    </a>
                </button>
            </div>
        </form>
    </div>
</body>
</html>