<?php
    session_start();

    // Подключение к базе данных
    $servername = "localhost";
    $username = "m1inc3re_data";
    $password = "&fX8mO62";
    $database = "m1inc3re_data";

    $conn = new mysqli($servername, $username, $password, $database);

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Обработка отправки формы на странице авторизации
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login = $_POST['login'];
        $password = $_POST['password'];

        // Защита от SQL-инъекций
        $login = stripslashes($login);
        $password = stripslashes($password);
        $login = $conn->real_escape_string($login);
        $password = $conn->real_escape_string($password);

        // Запрос к базе данных для получения данных о пользователе
        $sql = "SELECT * FROM users WHERE login='$login' AND password='$password'";
        $result = $conn->query($sql);

        // Если найден пользователь с указанным логином и паролем, устанавливаем сессию
        if ($result->num_rows == 1) {
            $_SESSION['loggedin'] = true;
            header("location: admin_panel.php"); // Перенаправляем на страницу административной панели
        } else {
            // Отправляем сообщение об ошибке через JavaScript
            echo "<script>alert('Неверный логин или пароль');</script>";
            // Или можно отправить сообщение в консоль браузера
            // echo "<script>console.log('Неверный логин или пароль');</script>";
        }
    }

    // Закрытие соединения с базой данных
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/global_style.css">
    <link rel="stylesheet" href="/style/auth_page.css">
    <script>
        function redirectToIndex() {
            window.location.href = 'index.php';
        }
    </script>
    <title>Авторизация в Админ. панель</title>
</head>
<body>
        <nav>
            <ul>
                <img src="/resources/logo.png" alt="Ошибка подгрузки">
                <li>
                <button onclick="redirectToIndex()">Перейти на основую страницу сайта</button>
                </li>
            </ul>
        </nav>  
    <div class="main">
        <div class="sec">
            <form method="post" action="auth_page.php">
                <label for="username">Логин:</label><br>
                <input type="text" id="username" name="login" required><br>
                <label for="password">Пароль:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <input type="submit" value="Войти" style="cursor: pointer; background: #4070f4; color: white;">
            </form>
        </div>
    </div>
</body>
</html>