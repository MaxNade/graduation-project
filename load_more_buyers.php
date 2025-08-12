<?php
$servername = "localhost";
$username = "m1inc3re_data";
$password = "&fX8mO62";
$database = "m1inc3re_data";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 3; // Лимит записей на странице
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'created_at';
$buyerId = isset($_GET['buyerId']) && is_numeric($_GET['buyerId']) ? intval($_GET['buyerId']) : null;

// Рассчитываем offset для дозагрузки данных
$offset = ($page - 1) * $limit;

$sql_order_status = "SELECT * FROM order_status";
$result_order_status = $conn->query($sql_order_status);
$order_statuses = [];
if ($result_order_status->num_rows > 0) {
    while ($row = $result_order_status->fetch_assoc()) {
        $order_statuses[$row["id"]] = $row["status"];
    }
}

if ($buyerId !== null) {
    $sql = "SELECT * FROM BuyerData WHERE id = $buyerId ORDER BY $sort_by DESC LIMIT $limit OFFSET $offset";
} else {
    $sql = "SELECT * FROM BuyerData ORDER BY $sort_by DESC LIMIT $limit OFFSET $offset";
}

$result = $conn->query($sql);

$output = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . $row["id"] . "</td>";
        $output .= "<td>" . $row["name"] . "</td>";
        $output .= "<td>" . $row["email"] . "</td>";
        $output .= "<td>" . $row["phone"] . "</td>";
        $output .= "<td>" . $row["msg"] . "</td>";
        $output .= "<td>" . $row["created_at"] . "</td>";

        $status_class = "";
        switch ($row["order_status_id"]) {
            case 1: $status_class = "status-new"; break;
            case 2: $status_class = "status-processing"; break;
            case 3: $status_class = "status-shipped"; break;
            case 4: $status_class = "status-delivered"; break;
            case 5: $status_class = "status-cancelled"; break;
        }

        $output .= "<td>";
        $output .= "<select name='order_status_id' class='$status_class' onchange='updateOrderStatus(" . $row["id"] . ", this.value)'>";
        foreach ($order_statuses as $status_id => $status_name) {
            $selected = ($status_id == $row["order_status_id"]) ? "selected" : "";
            $output .= "<option value='" . $status_id . "' " . $selected . ">" . $status_name . "</option>";
        }
        $output .= "</select>";
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output = 'end'; // Возвращаем "end", чтобы показать, что больше данных нет
}

echo $output;

$conn->close();
?>
