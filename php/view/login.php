<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        h1 {
            font-size: 2em;
            color: #333;
            text-align: center;
            margin-bottom: 1em;
        }

        .login-form {
            width: 300px;
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .login-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <h1>CP476 Group Project</h1>
    <div class="login-form">
        <form action="user.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <input type="hidden" name="action" value="login">
        </form>
    </div>
</body>

</html>