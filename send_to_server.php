<?php
// Включение отображения ошибок (для отладки)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Подключение к базе данных
$servername = "localhost";
$username = "m1inc3re_data";
$password = "&fX8mO62";
$database = "m1inc3re_data";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $database);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Обработка данных формы о клиенте и вставка их в таблицу BuyerData
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверка наличия всех необходимых данных
    if (isset($_POST["name"], $_POST["email"], $_POST["phone"], $_POST["msg"], $_POST["product_name"], $_POST["product_quantity"], $_POST["product_unit"])) {
        // Получение данных о клиенте из формы
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $msg = $_POST["msg"];

        // Установка значения статуса заказа по умолчанию (например, 1 для "поступил")
        $order_status_id = 1; // Убедитесь, что это значение существует в таблице order_status

        // Подготовка и выполнение SQL-запроса для вставки данных о клиенте в таблицу BuyerData
        $sql_customer = "INSERT INTO BuyerData (name, email, phone, msg, order_status_id) VALUES (?, ?, ?, ?, ?)";
        $stmt_customer = $conn->prepare($sql_customer);

        if ($stmt_customer === false) {
            die("Ошибка подготовки запроса: " . $conn->error);
        }

        $stmt_customer->bind_param("ssssi", $name, $email, $phone, $msg, $order_status_id);

        if ($stmt_customer->execute() === FALSE) {
            die("Ошибка выполнения запроса: " . $stmt_customer->error);
        } else {
            echo "$name, спасибо за заказ! В скором времени с вами свяжутся!";
        }

        // Получение ID покупателя после вставки данных о клиенте
        $buyerId = $stmt_customer->insert_id;

        // Получение данных о товарах в корзине из POST-запроса
        $productNames = $_POST["product_name"];
        $productQuantities = $_POST["product_quantity"];
        $productUnits = $_POST["product_unit"];

        // Подготовка и выполнение SQL-запроса для вставки данных о товарах в корзине в таблицу CartItems
        $sql_cart = "INSERT INTO CartItems (productName, quantity, unit, buyerId) VALUES (?, ?, ?, ?)";
        $stmt_cart = $conn->prepare($sql_cart);
        $stmt_cart->bind_param("sisi", $productName, $quantity, $unit, $buyerId);

        for ($i = 0; $i < count($productNames); $i++) {
            $productName = $productNames[$i];
            $quantity = $productQuantities[$i];
            $unit = $productUnits[$i];

            if ($stmt_cart->execute() === FALSE) {
                die("Ошибка выполнения запроса: " . $stmt_cart->error);
            } else {
                // echo "Данные о товаре \"$productName\" успешно добавлены в базу данных.<br>";
            }
        }
    } else {
        die("Не все данные формы были переданы.");
    }
}

// Закрытие подключения к базе данных
$conn->close();
?>
