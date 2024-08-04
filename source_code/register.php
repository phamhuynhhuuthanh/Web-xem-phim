<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Document</title>
</head>
<body>

<?php 

    $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
    $pdo->query("set names 'utf8'");

    if(isset($_POST['register'])){
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm = trim($_POST['confirm']);

        // $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // $emailQuery = $pdo->query($sql);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user){
            echo "Email đã tồn tại";
            exit();
        } else {
            if ($password !== $confirm) {
                echo "Mật khẩu không khớp";
                exit();
            }
            $role = 'user';
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users(name, email, password, role) VALUES(:name, :email, :password, :role)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);

            if($stmt->execute()){
                echo "Đăng ký thành công";
                header("Location: login.php");
            } else {
                echo "Đăng ký thất bại";
            }
        }

        // $sql = "INSERT INTO user(name, email, password, confirm) VALUES(?, ?, ?, ?)";
        // $stmt = $pdo->prepare($sql);
        // $stmt->execute([$name, $email, $password, $confirm]);
    }

//     if(isset($_POST['register'])){
//         $name = trim($_POST['name']);
//         $email = trim($_POST['email']);
//         $password = trim($_POST['password']);
//         $confirm = trim($_POST['confirm']);

//         $password = password_hash($password, PASSWORD_DEFAULT);
//         // Create connection
//         $conn = mysqli_connect('localhost', 'root', '', 'online_movie');

//         // Check connection
//         if (!$conn) {
//             die("Connection failed: " . mysqli_connect_error());
//         }
//         echo "Connected successfully";

//         // Perform query
//         $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
//         $result = mysqli_query($conn, $sql);

        
//         if (mysqli_num_rows($result) > 0) {
//             echo '<script language="javascript">alert("Bị trùng tên hoặc chưa nhập tên!"); window.location="register.php";</script>';

// // Dừng chương trình

//         } else {
//             echo "0 results";
//         }

//         // Close connection
//         mysqli_close($conn);
//     }

?>

    <!-- component -->
<!-- Create by joker banny -->
<div class="h-screen bg-indigo-100 flex justify-center items-center">
	<div class="lg:w-2/5 md:w-1/2 w-2/3">
		<form class="bg-white p-10 rounded-lg shadow-lg min-w-full" method="post">
			<h1 class="text-center text-2xl mb-6 text-gray-600 font-bold font-sans">Register</h1>
			<div>
				<label class="text-gray-800 font-semibold block my-3 text-md" for="username">Name</label>
				<input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="name" id="username" placeholder="username" required />
            </div>
			<div>
				<label class="text-gray-800 font-semibold block my-3 text-md" for="email">Email</label>
				<input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="email" id="email" placeholder="@email" required />
            </div>
			<div>
				<label class="text-gray-800 font-semibold block my-3 text-md" for="password">Password</label>
				<input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="password" name="password" id="password" placeholder="password" required />
            </div>
			<div>
				<label class="text-gray-800 font-semibold block my-3 text-md" for="confirm">Confirm password</label>
				<input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="password" name="confirm" id="confirm" placeholder="confirm password" required />
            </div>
            <button type="" class="w-full mt-6 mb-3 bg-lime-500 rounded-lg px-4 py-2 text-lg text-white tracking-wide font-semibold font-sans">
                <a href="login.php">
                    Login
                </a>
            </button>
            <button type="submit" class="w-full mt-6 bg-lime-300 rounded-lg px-4 py-2 text-lg text-dark tracking-wide font-semibold font-sans" name="register">
                <!-- <a href="ohtmlglin."> -->
                    Register
                <!-- </a> -->
            </button>
		</form>
	</div>
</div>
</body>
</html>