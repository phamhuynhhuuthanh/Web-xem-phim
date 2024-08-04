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

    //đọc dữ liêụ bảng users
    $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
    $pdo->query("set names 'utf8'");

    $sql = "SELECT id, name, email, password, role FROM users";
    $stmt = $pdo->prepare($sql);

    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


    //xóa user
    if(isset($_POST['remove'])){
        $id = $_POST['id'];
        echo $id;
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=online_movie", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // $pdo->query("set names 'utf8'");

            
                $sql = "DELETE FROM users WHERE id = :id";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':id', $id);
                $stmt->execute();

                echo '<script>
                    alert("Delete successfully");
                    window.location.href="useradmin.php";
                </script>';

            // echo '<script>
            //     alert("Delete successfully");
            //     window.location.href="genre.php";
            // </script>';
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
                    <a href="home.php" class="btn btn-hover text-white" >
                        <span>log out</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-span-10 p-5">
            <button class="btn btn-hover">
                <a href="useradd.php" class="z-10">
                    Add user
                </a>
            </button>
            <table class="border-collapse w-full">
                <thead>
                    <tr>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">id</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Name</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Email</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Password</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Role</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($users as $user){
                    ?>
                    <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <!-- <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Company name</span> -->
                            <?php echo $user['id']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                            <!-- <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Country</span> -->
                            <?php echo $user['name']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                            <!-- <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Country</span> -->
                            <?php echo $user['email']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                            <!-- <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Country</span> -->
                            <?php echo $user['password']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                            <!-- <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Country</span> -->
                            <?php echo $user['role']; ?>
                        </td>
                        <!-- <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                            <span class="rounded bg-red-400 py-1 px-3 text-xs font-bold">deleted</span>
                        </td> -->
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Actions</span>
                            <a href="useredit.php?id=<?php echo $user['id'];?>" class="text-blue-400 hover:text-blue-600 underline">Edit</a>
                            <!-- <a href="" class="text-blue-400 hover:text-blue-600 underline pl-6">Remove</a> -->
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="id" value=<?php echo $user['id']; ?>>
                                <button type="submit" name="remove" class="text-blue-400 hover:text-blue-600 underline pl-6">
                                    <span>Remove</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                    <!-- <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Company name</span>
                            Squary
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Country</span>
                            Schweden
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                            <span class="rounded bg-green-400 py-1 px-3 text-xs font-bold">active</span>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Actions</span>
                            <a href="#" class="text-blue-400 hover:text-blue-600 underline">Edit</a>
                            <a href="#" class="text-blue-400 hover:text-blue-600 underline pl-6">Remove</a>
                        </td>
                    </tr> -->
                    <!-- <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Company name</span>
                            ghome
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Country</span>
                            Switzerland
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                            <span class="rounded bg-yellow-400 py-1 px-3 text-xs font-bold">inactive</span>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Actions</span>
                            <a href="#" class="text-blue-400 hover:text-blue-600 underline">Edit</a>
                            <a href="#" class="text-blue-400 hover:text-blue-600 underline pl-6">Remove</a>
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>