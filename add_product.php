<?php
    // Подключение к базе данных
    $servername = "localhost";
    $username = "m1inc3re_data";
    $password = "&fX8mO62";
    $database = "m1inc3re_data";

    // Получение данных из формы
    $product_code = $_POST['product_code'];
    $category_id = $_POST['category_id'];
    $diameter = isset($_POST['diameter']) ? $_POST['diameter'] : '';
    $strength_class = isset($_POST['strength_class']) ? $_POST['strength_class'] : '';
    $thread_pitch = isset($_POST['thread_pitch']) ? $_POST['thread_pitch'] : '';
    $materials = isset($_POST['materials']) ? $_POST['materials'] : [];

    // Создание подключения к базе данных
    $conn = new mysqli($servername, $username, $password, $database);

    // Проверка подключения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Включение транзакции
    $conn->begin_transaction();

    try {
        // Вставка данных в таблицу products
        $stmt = $conn->prepare("INSERT INTO products (product_code, category_id, diameter, strength_class, thread_pitch) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $product_code, $category_id, $diameter, $strength_class, $thread_pitch);
        $stmt->execute();
        
        // Получение ID последнего вставленного продукта
        $product_id = $stmt->insert_id;

        // Вставка данных в таблицу product_materials
        if (!empty($materials)) {
            $stmt = $conn->prepare("INSERT INTO product_materials (product_id, material_id) VALUES (?, ?)");
            foreach ($materials as $material_id) {
                $stmt->bind_param("ii", $product_id, $material_id);
                $stmt->execute();
            }
        }

        // Завершение транзакции
        $conn->commit();
        echo "Product and materials added successfully!";
    } catch (Exception $e) {
        // Откат транзакции в случае ошибки
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Закрытие подготовленного запроса и соединения с базой данных
    $stmt->close();
    $conn->close();
?>
