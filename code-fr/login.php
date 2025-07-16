<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Staff Login</h2>
    <form method="post">
        <input type="password" name="password" placeholder="Inserire password" required>
        <button type="submit" name="submit">Login</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $input = $_POST['password'];
        $correct_password = '0000';

        if ($input === $correct_password) {
            header('Location: /staff/index.html');
            exit;
        } else {
            echo '<p class="error">❌ Incorrect password.</p>';
        }
    }
    ?>
</div>

</body>
</html>
