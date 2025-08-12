<?php
// Подключение к базе данных
$servername = "localhost";
$username = "m1inc3re_data";
$password = "&fX8mO62";
$database = "m1inc3re_data";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Проверяем, был ли передан ID товара
if (isset($_POST['id'])) {
    // Получаем ID товара из параметра запроса
    $id = $_POST['id'];

    // SQL-запрос для удаления связанных материалов товара
    $sql_delete_materials = "DELETE FROM product_materials WHERE product_id=$id";

    // Выполняем запрос на удаление материалов
    if ($conn->query($sql_delete_materials) === TRUE) {
        // Запрос для удаления самого товара
        $sql_delete_product = "DELETE FROM products WHERE id=$id";

        // Выполняем запрос на удаление товара
        if ($conn->query($sql_delete_product) === TRUE) {
            // Возвращаем сообщение об успешном удалении товара
            echo "success";
        } else {
            // Возвращаем сообщение об ошибке при удалении товара
            echo "Ошибка при удалении товара: " . $conn->error;
        }
    } else {
        // Возвращаем сообщение об ошибке при удалении связанных материалов
        echo "Ошибка при удалении связанных материалов: " . $conn->error;
    }
} else {
    // Возвращаем сообщение, если не указан ID товара
    echo "ID товара не указан";
}

// Закрываем соединение с базой данных
$conn->close();
?>
