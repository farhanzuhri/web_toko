<?php 
    session_start();
    // Mulai sesi

    include '../koneksi.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Periksa jika ada data yang dikirimkan melalui form
        $user = mysqli_real_escape_string($db, $_POST['username']);
        $pass = mysqli_real_escape_string($db, $_POST['password']);
        // Membersihkan input dan mengenkripsi password

        if (!empty($user) && !empty($pass)) {
            // Periksa apakah username dan password tidak kosong
            $login = mysqli_query($db, "SELECT * FROM tb_user WHERE username ='$user' and password ='$pass'");
            // Query untuk memeriksa apakah pengguna ada di database
            $ambil_data = mysqli_fetch_assoc($login);
            $user_id = $ambil_data['user_id'];
            $nama = $ambil_data['nama'];

            if (mysqli_num_rows($login) > 0) {
                $_SESSION['nama'] = $nama;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $user;
                $_SESSION['status'] = "login";
    
                // Mengarahkan pengguna berdasarkan peran (role)
                if ($ambil_data['role'] === 'admin') {
                    header("Location: ../index.php");
                } elseif ($ambil_data['role'] === 'user') {
                    header("Location: ../user.php");
                }
                exit;
            } else {
                // Jika tidak ada hasil, tampilkan pesan kesalahan
                $error = "Username atau Password salah";
            }
        } else {
            // Jika ada input yang kosong, tampilkan pesan kesalahan
            $error = "Username dan Password harus diisi";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap");
            * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Quicksand", sans-serif;
            }
            body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #000;
            }
            section {
            position: absolute;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2px;
            flex-wrap: wrap;
            overflow: hidden;
            }
            section::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(#000, #0f0, #000);
            animation: animate 5s linear infinite;
            }
            @keyframes animate {
            0% {
                transform: translateY(-100%);
            }
            100% {
                transform: translateY(100%);
            }
            }
            section span {
            position: relative;
            display: block;
            width: calc(6.25vw - 2px);
            height: calc(6.25vw - 2px);
            background: #181818;
            z-index: 2;
            transition: 1.5s;
            }
            section span:hover {
            background: #0f0;
            transition: 0s;
            }

            section .signin {
            position: absolute;
            width: 400px;
            background: #222;
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            border-radius: 4px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 9);
            }
            section .signin .content {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 40px;
            }
            section .signin .content h2 {
            font-size: 2em;
            color: #0f0;
            text-transform: uppercase;
            }
            section .signin .content .form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 25px;
            }
            section .signin .content .form .inputBox {
            position: relative;
            width: 100%;
            }
            section .signin .content .form .inputBox input {
            position: relative;
            width: 100%;
            background: #333;
            border: none;
            outline: none;
            padding: 25px 10px 7.5px;
            border-radius: 4px;
            color: #fff;
            font-weight: 500;
            font-size: 1em;
            }
            section .signin .content .form .inputBox i {
            position: absolute;
            left: 0;
            padding: 15px 10px;
            font-style: normal;
            color: #aaa;
            transition: 0.5s;
            pointer-events: none;
            }
            .signin .content .form .inputBox input:focus ~ i,
            .signin .content .form .inputBox input:valid ~ i {
            transform: translateY(-7.5px);
            font-size: 0.8em;
            color: #fff;
            }
            .signin .content .form .links {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: space-between;
            }
            .signin .content .form .links a {
            color: #fff;
            text-decoration: none;
            }
            .signin .content .form .links a:nth-child(2) {
            color: #0f0;
            font-weight: 600;
            }
            .signin .content .form .inputBox input[type="submit"] {
            padding: 10px;
            background: #0f0;
            color: #000;
            font-weight: 600;
            font-size: 1.35em;
            letter-spacing: 0.05em;
            cursor: pointer;
            }
            input[type="submit"]:active {
            opacity: 0.6;
            }
            @media (max-width: 900px) {
            section span {
                width: calc(10vw - 2px);
                height: calc(10vw - 2px);
            }
            }
            @media (max-width: 600px) {
            section span {
                width: calc(20vw - 2px);
                height: calc(20vw - 2px);
            }
            }
            .custom-control-label {
                color: #fff;
            }
    </style>
    <script>
        function myFunction() {
            var x = document.getElementById("mypassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</head>
<body>
    <section> 
        <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> 
        <!-- HTML Form Anda -->
        <div class="signin">
            <div class="content">
                <h2>Sign In</h2>
                <form action="" method="POST">
                    <div class="form">
                        <div class="inputBox">
                            <input type="text" name="username" required>
                            <i>Username</i>
                        </div>
                        <div class="inputBox">
                            <input type="password" id="mypassword" name="password" required>
                            <i>Password</i>
                        </div>
                        <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="customCheck" onclick="myFunction()">
                            <label class="custom-control-label" for="customCheck">Lihat password</label>
                        </div>
                        </div>
                        <div class="links">
                            <a href="#">Forgot Password</a>
                            <a href="#">Signup</a>
                        </div>
                        <div class="inputBox">
                            <input type="submit" value="Login">
                        </div>
                        <?php if(isset($error)) { ?>
                            <p style="color: red;"><?php echo $error; ?></p>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- partial -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
