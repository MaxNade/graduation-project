<?php
    // Проверяем, авторизован ли пользователь
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        // Если не авторизован, перенаправляем на страницу авторизации
        header("location: auth_page.php");
        exit;
    }
    // Обработчик нажатия на кнопку "Выйти"
    if (isset($_POST['logout'])) {
        // Разрываем сеанс
        session_unset();
        session_destroy();
        // Перенаправляем на страницу авторизации
        header("location: auth_page.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <link rel="stylesheet" href="/style/admin_panel.css">
    <link rel="stylesheet" href="/style/global_style.css">
    <!-- <link rel="stylesheet" href="/style/mobile_styles.css"> -->
    <script src="/scripts/nav_toggle.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css">

    <script>
        function redirectToIndex() {
            window.location.href = 'index.php';
        }

        // Переместим определение функции submitForm() выше использования
        function submitForm() {
            document.getElementById("logoutForm").submit();
        }
    </script>

    <!-- ВКЛАДКИ -->
    <script>
        // Дождемся полной загрузки всего HTML-документа, чтобы можно было внести изменения
        document.addEventListener("DOMContentLoaded", function() {
            // Восстанавливаем выбранную вкладку из localStorage или по умолчанию открываем 'zakaz'
            var savedTabId = localStorage.getItem('selectedTab') || 'zakaz';
            changeTab(savedTabId);

            // Добавляем обработчики событий для свайпов
            addSwipeListeners();
        });

        // Функция для изменения отображения вкладок и кнопок
        function changeTab(tabId) {
            // Получаем все элементы с классом 'tab-content' и скрываем их
            var allTabs = document.getElementsByClassName('tab-content');
            for (var i = 0; i < allTabs.length; i++) {
                allTabs[i].style.display = 'none';
            }

            // Отображаем выбранную вкладку на основе ее идентификатора
            var selectedTab = document.getElementById(tabId);
            if (selectedTab) {
                selectedTab.style.display = 'block';
            }

            // Удаляем класс 'darkened' у всех кнопок в навигации
            var allButtons = document.querySelectorAll('nav button');
            for (var i = 0; i < allButtons.length; i++) {
                allButtons[i].classList.remove('darkened');
            }

            // Добавляем класс 'darkened' активной кнопке в навигации на основе идентификатора вкладки
            var activeButton = document.querySelector('nav button[data-tab="' + tabId + '"]');
            if (activeButton) {
                activeButton.classList.add('darkened');
            }

            // Сохраняем идентификатор выбранной вкладки в localStorage
            localStorage.setItem('selectedTab', tabId);
        }
    </script>


    <link rel="icon" href="/resources/logo.png" type="image/x-icon">

    <title>Админ панель</title>
</head>
<body>

    <!-- <div class="menu-toggle"><img src="/resources/sidebar-bottom-svgrepo-com.svg" alt=""></div> -->

    <nav>
        <ul>
            <img src="/resources/logo.png" alt="Ошибка подгрузки">
            <li><button onclick="redirectToIndex()">Сайт</button></li>
            <li><button class="zakaz" data-tab="zakaz" onclick="changeTab('zakaz')">Заказы</button></li>
            <li><button class="tovar" data-tab="tovar" onclick="changeTab('tovar')">Товары</button></li>
        
            <!-- Завершить сеанс -->
            <li>
                <!-- Используем функцию submitForm() -->
                <button onclick="submitForm()">Завершить сеанс</button>
                <form id="logoutForm" method="post" action="">
                    <input type="hidden" name="logout">
                </form>
            </li>

        </ul>
    </nav>

    <div id="zakaz" class="tab-content">
        <div class="main_con">
            <div class="split">
                <!-- Поисковая форма по ID клиента -->
                <form class="search_form" method="post" action="" style="margin: 10px">
                    <input type="text" id="buyerId" name="buyerId" placeholder="Введите ID покупателя...">
                    <button type="submit" value="Поиск">Поиск</button>
                    <!-- <button type="submit" name="reset">Сбросить</button> -->
                </form>
        
                <!-- Кнопки для сортировки -->
                <div class="sort-buttons" style="margin: 10px">
                    <form id="sortForm" method="post" action="">
                        <button type="submit" id="sortByCreatedAt" name="sort_by" value="created_at">по дате создания</button>
                        <button type="submit" id="sortByOrderStatus" name="sort_by" value="order_status_id">по статусу</button>
                    </form>
                </div>

            </div>
        </div>

        <!-- вывод таблиц бд -->
        <?php
            // Подключение к базе данных
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

            // Инициализация переменных для хранения ID клиента и сортировки
            $buyerId = null;
            $sort_by = 'order_status_id'; // Сортировка по умолчанию по статусу заказа
            $order_by = 'ASC'; // По умолчанию сортировка по возрастанию

            // Проверка отправки формы для изменения статуса
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_status_id'])) {
                $buyerId = intval($_POST['buyerId']);
                $order_status_id = intval($_POST['order_status_id']);
                $sql_update_status = "UPDATE BuyerData SET order_status_id = $order_status_id WHERE id = $buyerId";
                $conn->query($sql_update_status);
                // Перенаправление для предотвращения повторной отправки формы при обновлении страницы
                echo '<script>window.location.href = window.location.href;</script>';
                exit;
            }

            // Проверка отправки формы для фильтрации по ID покупателя
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['reset'])) {
                    $buyerId = null;
                } else if (isset($_POST['buyerId']) && $_POST['buyerId'] !== '') {
                    $buyerId = intval($_POST['buyerId']);
                }
            }

            // Проверка отправки формы для сортировки
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sort_by'])) {
                $sort_by = $_POST['sort_by'];
                // Если сортируем по статусу заказа, то по умолчанию убывание и исключаем выполненные заказы (order_status_id = 4)
                if ($sort_by == 'order_status_id') {
                    $sort_by = "CASE order_status_id 
                                    WHEN 1 THEN 1 
                                    WHEN 2 THEN 2 
                                    WHEN 3 THEN 3 
                                    WHEN 4 THEN 4
                                    ELSE 5 END";
                    $order_by = 'ASC'; // Сортируем по возрастанию для правильного отображения статусов
                } elseif ($sort_by == 'created_at') {
                    // Если сортируем по дате создания, то сортируем от нового к старому
                    $sort_by = 'created_at';
                    $order_by = 'DESC';
                }
            }

            // Выполнение запроса для таблицы BuyerData с учетом сортировки
            if ($buyerId !== null) {
                $sql_buyer_data = "SELECT * FROM BuyerData WHERE id = $buyerId ORDER BY $sort_by $order_by";
            } else {
                $sql_buyer_data = "SELECT * FROM BuyerData ORDER BY $sort_by $order_by";
            }

            $result_buyer_data = $conn->query($sql_buyer_data);

            // Выполнение запроса для таблицы CartItems
            if ($buyerId !== null) {
                $sql_cart_items = "SELECT * FROM CartItems WHERE buyerId = $buyerId ORDER BY created_at DESC";
            } else {
                $sql_cart_items = "SELECT * FROM CartItems ORDER BY created_at DESC";
            }
            $result_cart_items = $conn->query($sql_cart_items);

            // Выполнение запроса для таблицы order_status
            $sql_order_status = "SELECT * FROM order_status";
            $result_order_status = $conn->query($sql_order_status);
            $order_statuses = [];
            if ($result_order_status->num_rows > 0) {
                while ($row = $result_order_status->fetch_assoc()) {
                    $order_statuses[$row["id"]] = $row["status"];
                }
            }

            // Проверка наличия результатов и вывод данных из таблиц
            if ($result_buyer_data->num_rows > 0 || $result_cart_items->num_rows > 0) {
                echo "<div class='split'>"; // Начало контейнера split

                // Вывод данных из таблицы BuyerData
                if ($result_buyer_data->num_rows > 0) {
                    echo "<div class='table-container'>";
                    echo "<h2>Лист заказчиков</h2>";
                    echo "<table>";
                    echo "<tr><th>ID</th><th>Имя</th><th>Email</th><th>Телефон</th><th>Сообщение</th><th>Дата создания</th><th>Статус заказа</th></tr>";
                    while ($row = $result_buyer_data->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row["id"]."</td>";
                        echo "<td>".$row["name"]."</td>";
                        echo "<td>".$row["email"]."</td>";
                        echo "<td>".$row["phone"]."</td>";
                        echo "<td>".$row["msg"]."</td>";
                        echo "<td>".$row["created_at"]."</td>";

                        $status_class = "";
                        switch ($row["order_status_id"]) {
                            case 1:
                                $status_class = "status-new";
                                break;
                            case 2:
                                $status_class = "status-processing";
                                break;
                            case 3:
                                $status_class = "status-shipped";
                                break;
                            case 4:
                                $status_class = "status-delivered";
                                break;
                            case 5:
                                $status_class = "status-cancelled";
                                break;
                            default:
                                $status_class = "";
                                break;
                        }

                        echo "<td>";
                        echo "<form method='post' action=''>";
                        echo "<input type='hidden' name='buyerId' value='".$row["id"]."'>";
                        echo "<select name='order_status_id' class='$status_class' onchange='this.form.submit()'>";
                        foreach ($order_statuses as $status_id => $status_name) {
                            $selected = ($status_id == $row["order_status_id"]) ? "selected" : "";
                            echo "<option value='".$status_id."' ".$selected.">".$status_name."</option>";
                        }
                        echo "</select>";
                        echo "</form>";
                        echo "</td>";

                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p>Нет данных в таблице BuyerData</p>";
                }

                // Вывод данных из таблицы CartItems
                if ($result_cart_items->num_rows > 0) {
                    echo "<div class='table-container'>";
                    echo "<h2>Лист товаров</h2>";
                    echo "<table>";
                    echo "<tr><th>ID</th><th>Название товара</th><th>Количество</th><th>Единица измерения</th><th>ID покупателя</th><th>Дата создания</th></tr>";
                    while ($row = $result_cart_items->fetch_assoc()) {
                        echo "<tr><td>".$row["id"]."</td><td>".$row["productName"]."</td><td>".$row["quantity"]."</td><td>".$row["unit"]."</td><td>".$row["buyerId"]."</td><td>".$row["created_at"]."</td></tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p>Нет данных в таблице CartItems</p>";
                }

                echo "</div>"; // Конец контейнера split
            }

            // Закрытие соединения с базой данных
            $conn->close();
        ?>
        <input type="hidden" id="currentSort" value="<?php echo $_POST['sort_by'] ?? 'order_status_id'; ?>">





       </div> 



    
    <div id="tovar" class="tab-content">
        <div class="split">
            <div class="add_product">
                <form id="productForm" onsubmit="event.preventDefault(); addProduct();" method="post">
                    <div class="namesel">
                        <input type="text" id="product_code" name="product_code" placeholder="Название продукта">
                        <select id="category_id" name="category_id">
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

                                // Получение списка категорий из базы данных
                                $sql = "SELECT id, name FROM categories";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                                    }
                                }

                                $conn->close();
                            ?>
                        </select>
                    </div>

                    <div class="sliderCon">
                        <div id="diameterSlider"></div>
                        <label class="slideName" for="diameter">Диаметр</label>
                        <input type="hidden" id="diameter" name="diameter">
                    </div>

                    <div class="sliderCon">
                        <div id="strengthClassSlider"></div>
                        <label class="slideName" for="strengthClass">Класс прочности</label>
                        <input type="hidden" id="strengthClass" name="strength_class">
                    </div>

                    <div class="sliderCon">
                        <div id="threadPitchSlider"></div>
                        <label class="slideName" for="threadPitch">Шаг резьбы</label>
                        <input type="hidden" id="threadPitch" name="thread_pitch">
                    </div>

                    <div class="selmater" style="display: flex; flex-wrap: wrap;">
                        <label for="materials">Материал:</label>
                        <div style="display: flex; flex-wrap: wrap;">
                            <?php
                                // Подключение к базе данных
                                $conn = new mysqli($servername, $username, $password, $database);
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Получение списка материалов из базы данных
                                $sql = "SELECT id, name FROM materials";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<div style='display: flex; align-items: center; margin-right: 10px;'>";
                                        echo "<input type='checkbox' id='material_" . $row["id"] . "' name='materials[]' value='" . $row["id"] . "'>";
                                        echo "<label for='material_" . $row["id"] . "'>" . $row["name"] . "</label>";
                                        echo "</div>";
                                    }
                                }

                                $conn->close();
                            ?>
                        </div>
                    </div>
                    <input id="add_product" type="submit" value="Добавить">
                </form>
            </div>

            <div class="bdtovar">
                <div class="search-sort-con">
                    <div class="search-con">
                        <input type="text" id="searchInput" placeholder="Поиск по названию продукта" onkeyup="searchTable(event)" onkeydown="if(event.keyCode==13) { performSearch(); return false; }">
                        <button onclick="performSearch()">Искать</button>
                    </div>
                    <div class="select-con">
                        <label for="recordsPerPage">Записей на странице:</label>
                            <select id="recordsPerPage" onchange="changeRecordsPerPage(this)">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="all">Все</option>
                            </select>
                    </div>    

                </div>

                <table id="productTable">
                    <tr>
                        <th>ID</th>
                        <th>ГОСТ</th>
                        <th>Категория</th>
                        <th>Диаметр</th>
                        <th>Класс прочности</th>
                        <th>Шаг резьбы</th>
                        <th>Материалы</th>
                        <th>Действия</th>
                    </tr>
                    <!-- вывод -->
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

                        // Устанавливаем количество записей на странице
                        $records_per_page = isset($_GET['records']) && $_GET['records'] !== 'all' ? (int)$_GET['records'] : null;

                        // Получаем текущую страницу из параметра запроса, если он существует, иначе устанавливаем 1
                        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                        // Получаем параметры сортировки
                        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
                        $order = isset($_GET['order']) ? $_GET['order'] : 'DESC';  // по умолчанию сортировка по убыванию

                        // Переключаем порядок сортировки
                        $new_order = ($order == 'ASC') ? 'DESC' : 'ASC';

                        // Вычисляем начальное значение для SQL LIMIT
                        $start_from = ($records_per_page !== null) ? ($current_page - 1) * $records_per_page : 0;

                        // Основной SQL-запрос для получения списка товаров с учетом ограничения и смещения
                        $sql = "
                            SELECT 
                                p.id, 
                                p.product_code, 
                                c.name AS category, 
                                p.diameter, 
                                p.strength_class, 
                                p.thread_pitch, 
                                GROUP_CONCAT(m.name SEPARATOR ', ') AS materials 
                            FROM 
                                products p 
                                LEFT JOIN categories c ON p.category_id = c.id 
                                LEFT JOIN product_materials pm ON p.id = pm.product_id 
                                LEFT JOIN materials m ON pm.material_id = m.id 
                            GROUP BY 
                                p.id
                            ORDER BY 
                                $sort $order
                        ";

                        if ($records_per_page !== null) {
                            $sql .= " LIMIT $start_from, $records_per_page";
                        }

                        // Добавляем условие поиска, если задан параметр search
                        if (isset($_GET['search'])) {
                            $search = $conn->real_escape_string($_GET['search']);
                            $sql = "
                                SELECT 
                                    p.id, 
                                    p.product_code, 
                                    c.name AS category, 
                                    p.diameter, 
                                    p.strength_class, 
                                    p.thread_pitch, 
                                    GROUP_CONCAT(m.name SEPARATOR ', ') AS materials 
                                FROM 
                                    products p 
                                    LEFT JOIN categories c ON p.category_id = c.id 
                                    LEFT JOIN product_materials pm ON p.id = pm.product_id 
                                    LEFT JOIN materials m ON pm.material_id = m.id 
                                WHERE 
                                    p.product_code LIKE '%$search%'
                                GROUP BY 
                                    p.id
                                ORDER BY 
                                    $sort $order
                            ";

                            if ($records_per_page !== null) {
                                $sql .= " LIMIT $start_from, $records_per_page";
                            }
                        }

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Выводим каждый товар в виде строки таблицы
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . htmlspecialchars($row["product_code"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["category"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["diameter"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["strength_class"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["thread_pitch"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["materials"]) . "</td>";
                                // Добавляем кнопку "Удалить" с передачей ID товара в качестве параметра
                                echo "<td><button onclick='deleteProduct(" . $row["id"] . ")'>Удалить</button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>Товары не найдены</td></tr>";
                        }

                        // Получаем общее количество записей для вычисления количества страниц
                        $sql_total_records = "SELECT COUNT(*) AS total FROM products";
                        $total_result = $conn->query($sql_total_records);
                        $total_row = $total_result->fetch_assoc();
                        $total_records = $total_row['total'];

                        if ($records_per_page !== null) {
                            $total_pages = ceil($total_records / $records_per_page);
                        } else {
                            $total_pages = 1;
                        }

                        $conn->close();
                    ?>

                </table>

                <div class="pagination">
                    <?php
                        // Ограничение количества отображаемых страниц
                        $num_links = 3;

                        // Определение диапазона отображаемых страниц
                        $start_page = max(1, $current_page - $num_links);
                        $end_page = min($total_pages, $current_page + $num_links);

                        // Сохранение текущего значения количества записей в ссылках пагинации
                        $records_param = "&records=" . urlencode($records_per_page);

                        // Добавление кнопок "Предыдущая" и "Следующая"
                        if ($current_page > 1) {
                            echo '<a href="?page=' . ($current_page - 1) . $records_param . '">&laquo; Предыдущая</a>';
                        }

                        // Показ номеров страниц
                        for ($i = $start_page; $i <= $end_page; $i++) {
                            if ($i == $current_page) {
                                echo '<a class="active" href="?page=' . $i . $records_param . '">' . $i . '</a>';
                            } else {
                                echo '<a href="?page=' . $i . $records_param . '">' . $i . '</a>';
                            }
                        }

                        if ($current_page < $total_pages) {
                            echo '<a href="?page=' . ($current_page + 1) . $records_param . '">Следующая &raquo;</a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Скрипт для изменения статуса заказа -->
    <script>
        function updateOrderStatus(buyerId, statusId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    location.reload();
                }
            };
            xhr.send("order_status_id=" + statusId + "&buyerId=" + buyerId);
        }
    </script>

    <!-- сбив изменения статуса заказа -->
    <script>
        function updateOrderStatus(buyerId, statusId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    location.reload();
                }
            };
            xhr.send("order_status_id=" + statusId + "&buyerId=" + buyerId);
        }
    </script>

    <!-- поиск и кол-во отображаемых записей \ товары -->
    <script>
        function changeRecordsPerPage(select) {
            var records = select.value;
            var url = new URL(window.location.href);
            url.searchParams.set('records', records);
            url.searchParams.set('page', 1); // Сбрасываем на первую страницу при изменении количества записей
            window.location.href = url.toString();
        }

        function setSelectedRecordsPerPage() {
            var url = new URL(window.location.href);
            var records = url.searchParams.get('records');
            if (!records) {
                records = '10'; // Значение по умолчанию
                url.searchParams.set('records', records);
                window.location.href = url.toString(); // Перезагружаем страницу с новым значением
            } else {
                document.getElementById('recordsPerPage').value = records;
            }
        }


        function performSearch() {
            var searchInput = document.getElementById('searchInput').value;
            var url = new URL(window.location.href);
            url.searchParams.set('search', searchInput);
            url.searchParams.set('page', 1); // Сбрасываем на первую страницу при новом поиске
            window.location.href = url.toString();
        }

        document.getElementById('searchInput').addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                performSearch();
            }
        });

        // Вызов функции при загрузке страницы
        window.onload = setSelectedRecordsPerPage;
    </script>

    <!-- сбив при удалении \ товары -->
    <script>
        function deleteProduct(productId) {
            if (confirm("Вы уверены, что хотите удалить этот товар?")) {
                // Отправляем AJAX-запрос на удаление товара
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_product.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Проверяем, удаление прошло успешно или нет
                        if (xhr.responseText.trim() === "success") {
                            // Если успешно, обновляем страницу
                            location.reload();
                        } else {
                            // Если есть ошибка, выводим её в консоль
                            console.error(xhr.responseText);
                        }
                    }
                };
                // Отправляем запрос с ID товара
                xhr.send("id=" + productId);
            }
        }
    </script>

    <!-- сбив при добавлении позиции \ товары -->
    <script>
        function addProduct() {
            // Получение данных формы
            var formData = new FormData(document.getElementById("productForm"));

            // Отправка данных через AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "add_product.php", true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Вывод сообщения об успешном добавлении
                    // alert(xhr.responseText);
                    // Перезагрузка страницы после успешного добавления
                    location.reload();
                } else {
                    // Вывод сообщения об ошибке
                    alert("Ошибка при добавлении товара: " + xhr.responseText);
                }
            };
            xhr.send(formData);
        }
    </script>

    <!-- ползунки -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wnumb/1.2.0/wNumb.min.js"></script>
    <!-- ВОЗВРАТ ЗНАЧЕНИЙ ПОЛЗУНКОВ -->
    <script>
        // Функция для обновления скрытого поля с диапазоном значений
        function updateHiddenField(slider, hiddenField) {
            var values = slider.noUiSlider.get(); // Получаем текущие значения ползунка
            hiddenField.value = values.join(' - '); // Обновляем значение скрытого поля
        }

        // Создаем слайдеры для каждого поля
        var diameterSlider = document.getElementById('diameterSlider');
        var diameterRange = document.getElementById('diameter');
        noUiSlider.create(diameterSlider, {
            start: [1, 100],
            connect: true,
            range: {
                'min': 1,
                'max': 100
            },
            tooltips: [wNumb({decimals: 0}), wNumb({decimals: 0})], // Отображение цифровых значений
            format: wNumb({decimals: 0}) // Форматирование значений
        });
        diameterSlider.noUiSlider.on('update', function () {
            updateHiddenField(diameterSlider, diameterRange);
        });

        // Аналогично для других ползунков
        var strengthClassSlider = document.getElementById('strengthClassSlider');
        var strengthClassRange = document.getElementById('strengthClass');
        noUiSlider.create(strengthClassSlider, {
            start: [1, 100],
            connect: true,
            range: {
                'min': 1,
                'max': 100
            },
            tooltips: [wNumb({decimals: 0}), wNumb({decimals: 0})],
            format: wNumb({decimals: 0})
        });
        strengthClassSlider.noUiSlider.on('update', function () {
            updateHiddenField(strengthClassSlider, strengthClassRange);
        });

        var threadPitchSlider = document.getElementById('threadPitchSlider');
        var threadPitchRange = document.getElementById('threadPitch');
        noUiSlider.create(threadPitchSlider, {
            start: [1, 100],
            connect: true,
            range: {
                'min': 1,
                'max': 100
            },
            tooltips: [wNumb({decimals: 0}), wNumb({decimals: 0})],
            format: wNumb({decimals: 0})
        });
        threadPitchSlider.noUiSlider.on('update', function () {
            updateHiddenField(threadPitchSlider, threadPitchRange);
        });
    </script>

    <!-- стили кнопок сортировки -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var currentSort = document.getElementById("currentSort").value;
            var form = document.getElementById("sortForm");
            var buttons = form.querySelectorAll("button[name='sort_by']");

            buttons.forEach(function(button) {
                if (button.value === currentSort) {
                    button.classList.add("active");
                }

                button.addEventListener("click", function(event) {
                    event.preventDefault(); // Предотвращаем отправку формы

                    // Удаляем класс 'active' у всех кнопок
                    buttons.forEach(function(btn) {
                        btn.classList.remove("active");
                    });

                    // Добавляем класс 'active' к текущей нажатой кнопке
                    this.classList.add("active");

                    // Устанавливаем значение в скрытое поле формы и отправляем форму
                    var hiddenInput = document.createElement("input");
                    hiddenInput.type = "hidden";
                    hiddenInput.name = "sort_by";
                    hiddenInput.value = this.value;
                    form.appendChild(hiddenInput);
                    form.submit();
                });
            });
        });
    </script>




</body>
</html>
