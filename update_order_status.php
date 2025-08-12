<?php
$servername = "localhost";
$username = "m1inc3re_data";
$password = "&fX8mO62";
$database = "m1inc3re_data";

// Установка соединения с базой данных
$conn = new mysqli($servername, $username, $password, $database);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// Проверка отправки формы для изменения статуса
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buyerId']) && isset($_POST['order_status_id'])) {
    $buyerId = intval($_POST['buyerId']);
    $order_status_id = intval($_POST['order_status_id']);
    $sql_update_status = "UPDATE BuyerData SET order_status_id = $order_status_id WHERE id = $buyerId";
    if ($conn->query($sql_update_status) === TRUE) {
        echo "success";
    } else {
        echo "Ошибка: " . $conn->error;
    }
} else {
    echo "Invalid request";
}

// Закрытие соединения с базой данных
$conn->close();
?>
