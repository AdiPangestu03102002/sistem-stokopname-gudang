<?php
session_start();
include 'koneksi.php'; // koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek username dan password di database
    // PENTING: Untuk keamanan yang lebih baik, gunakan prepared statements
    // dan hash password di database. Contoh ini masih rentan SQL Injection
    // dan menyimpan password plain-text.
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $_SESSION['username'] = $username;
        header('Location: home.php');
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Stok Opname</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        /* Custom gradient for key icon, if desired, but Tailwind can handle most */
        .login-key-icon {
            background: linear-gradient(to right, #d827efff, #0DB8DE);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text; /* Standard property */
            color: transparent; /* Fallback for non-webkit */
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-500 to-indigo-700 min-h-screen flex items-center justify-center p-4 antialiased">

    <div class="bg-white p-8 sm:p-10 rounded-2xl shadow-2xl w-full max-w-sm ring-1 ring-gray-100 transform hover:scale-105 transition duration-300 ease-in-out">
        
        <div class="text-center mb-6">
            <span class="text-6xl login-key-icon inline-block">🔑</span>
            <h1 class="text-3xl font-extrabold text-gray-800 tracking-wide mt-2">STOK OPNAME</h1>
            <p class="text-gray-500 text-sm mt-1">Masuk untuk melanjutkan</p>
        </div>
        
        <?php if (isset($error)) : ?>
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg flex items-center gap-3 shadow-sm">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <strong class="font-semibold">Login Gagal!</strong>
                    <p class="text-sm"><?= $error ?></p>
                </div>
            </div>
        <?php endif; ?>

        <form method="post" action="" class="space-y-6">
            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-2 tracking-wide uppercase">Username</label>
                <input type="text" name="username" id="username" 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 text-gray-800"
                       placeholder="Masukkan Username" required autocomplete="username">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2 tracking-wide uppercase">Password</label>
                <input type="password" name="password" id="password" 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 text-gray-800"
                       placeholder="Masukkan Password" required autocomplete="current-password">
            </div>
            
            <button type="submit" 
                    class="w-full bg-purple-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 shadow-lg transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                LOGIN
            </button>
        </form>
    </div>

</body>
</html>