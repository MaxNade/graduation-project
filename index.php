<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="/style/global_style.css">
        <link rel="stylesheet" href="/style/info_tab.css">
        <link rel="stylesheet" href="/style/modal_window.css">
        <link rel="stylesheet" href="/style/product_card.css">
        <link rel="stylesheet" href="/style/product_category_card.css">
        <link rel="stylesheet" href="/style/cart.css">
        <link rel="stylesheet" href="/style/mobile_styles.css">
        
        <!-- Большие скрипты -->
        <script src="/scripts/add_to_cart.js"></script>
        <script src="/scripts/tabs.js"></script>
        <script src="/scripts/tab_products.js"></script>
        <script src="/scripts/nav_toggle.js"></script>
        <script src="/scripts/toggle_sidebar.js"></script>


        <!-- Звонок по кнопке в навбаре -->
        <script>
            function callNumber() {
                window.location.href = 'tel:+74951504272';
            }
        </script>
        
        <!-- Письмо на почту по кнопке в навбаре -->
        <script>
            function sendEmail() {
                window.location.href = 'mailto:mail@td-zki.ru';
            }
        </script>
        
        <!-- Переход на карты по кнопке в навбаре -->
        <script>
            function redirectToSite() {
                window.location.href = 'https://yandex.ru/maps/-/CDRKVXPK';
            }
        </script>

        <!-- Скрипт для добавления маски номера телефона -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

        <link rel="icon" href="/resources/logo.png" type="image/x-icon">

        <title>ООО «ТД «ЗКИ»</title>
    </head> 
    <body>
        
        <!-- Кнопки мобильной версии -->
        <!-- <div class="menu-toggle"><img src="/resources/sidebar-bottom-svgrepo-com.svg" alt=""></div> -->
        <div id="main-swipe-area"></div>

        <!-- Десктоп навбар -->
        <nav>
            <ul>
                <img class="logo_pic" src="/resources/logo.png" alt="Ошибка подгрузки" id="logoPic">
                <li><button class="mbutton info" data-tab="info" onclick="changeTab('info')">Главная</button></li>
                <li><button class="catalog" data-tab="catalog" onclick="changeTab('catalog')">Каталог</button></li>
                <li><input type="text" id="desktopSearchInput" placeholder="Поиск..." onkeypress="handleKeyPress(event)"></li>
                <li><button id="desktopSearchButton" onclick="searchProducts('desktopSearchInput')">Найти</button></li>
                <li><button class="cart" data-tab="cart" onclick="changeTab('cart')">Корзина</button></li>
                <li><button id="callNumber" onclick="callNumber()">+7-(495)-150-42-72</button></li>
                <li><button id="sendEmail" onclick="sendEmail()">mail@td-zki.ru</button></li>
                <li><button id="redirectToSite" onclick="redirectToSite()">Нарвская улица, 2с5</button></li>
            </ul>
        </nav> 

        <!-- мобильная панель навигации -->
        <div id="bottom-bar">
            <button class="info" data-tab="info" onclick="changeTab('info')">Главная</button>
            <button class="catalog" data-tab="catalog" onclick="changeTab('catalog')">Каталог</button>
            <button class="cart" data-tab="cart" onclick="changeTab('cart')">Корзина</button>
        </div>
        
        <div id="info" class="tab-content">
            <div class="info_tab">
                <div class="info_container">
                    <!-- главная Информация -->
                    <div class="mappage">
                        <img src="/resources/infimg.jpg" class="pic">
                        <div class="mapinfo">
                            <h2> ООО «ТД «Завод Крепёжных Изделий» </h2>
                            <p>Мы специализируемся на комплексном обеспечении 
                                производственных предприятий РФ высококачественной крепежной 
                                продукцией в широком ассортименте.    
                            </p>
                            <p>Основными потребителями нашей продукции являются 
                                заводы радио-, приборо-, электротехнической 
                                отрасли, а также машиностроительные, 
                                судостроительные заводы, предприятия РЖД и ЖКХ.
                            </p>
                        </div>
                    </div>
                    
                    <div class="mappage">
                        <div class="mapinfo">
                            <h2>Маршрут</h2>
                            <p>
                                Мы находимся в 10 минутах пути от м. Войковская.<br>
                                Пешком удобнее всего проехать на автобусе 90
                                (или на маршрутке 90м) до остановки "Мебельная фабрика".<br> 
                            </p>
                            <p>
                                Если вы на автомобиле и планируете забрать продукцию 
                                со склада, вам потребуются паспорт/водительские права 
                                и документы на автомобиль.
                            </p>
                            <p>
                                Уважаемые клиенты! Пожалуйста, не забывайте 
                                доверенность или печать принимающей организации! <br>
                                Без них мы Вам не сможем сделать отгрузку товара.
                            </p>
                        </div>
                        <div class="mapdisplay">
                            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A98716f16b405271881960b3433118c2d55867159aacac876f00fd5fb34f41de2&amp;source=constructor" width="500" height="500" frameborder="0"></iframe>
                            <div class="undermaptext">
                                <p>Наш адрес: г. Москва, ул. Нарвская, д.2</p>
                                <p>Часы работы офиса: Пн-Пт с 08:00 до 17:00 (Мск)</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="moreinfo">
                        <div class="moreinfo-con">

                            <h2>Информация для самовывоза заказов:</h2>
                            <p>
                                Первым делом вам необходимо посетить офис (вход через главную проходную). <br>
                                В офисе менеджер Вам даст отгрузочные документы, а также выдаст 
                                пропуск на выезд с территории.
                            </p>
                            <p>
                                Въезд на территорию 
                                осуществляется справа от здания (красная табличка «Въезд №2»).
                                На КПП охране необходимо сказать, что Вы направляетесь в «ТД ЗКИ».
                            </p>
                        </div>
                    </div>
                    
                    <div class="requisites">
                        <h2>Наши реквизиты:</h2>
                        <p>
                            Адрес электронной почты: mail@td-zki.ru
                        </p>
                        <p>
                            Многоканальный телефон/Факс: +7-(495)-150-42-72
                        </p>
                        <p>
                            <a href="https://td-zki.ru/pub_files/ZKI_reg_sberbank.pdf">Посмотреть реквизиты ООО «ТД «ЗКИ» в формате PDF</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <div id="catalog" class="tab-content">
            <div class="show-sidebar"><img src="/resources/sidebar-right-svgrepo-com.svg"></div>
            <div class="show-search"><img src="/resources/search-svgrepo-com.svg"></div>
            <div class="search-bar">
                <input type="text" id="mobileSearchInput" placeholder="Поиск..." onkeypress="handleKeyPress(event)">
                <button id="mobileSearchButton" onclick="searchProducts('mobileSearchInput')">Найти</button>
            </div>

            <div id="sidebar-swipe-area"></div>
            
            <div class="split">   
                <!-- категории -->
                <div class="product_category_card">
                    <?php
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

                        // Запрос к базе данных для получения категорий
                        $sql = "SELECT id, name FROM categories";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Вывод данных каждой категории
                            while($row = $result->fetch_assoc()) {
                                // Генерация HTML-кода для карточки категории
                                echo '<div class="card">';
                                echo '<div class="box" id="category-' . $row["name"] . '">';
                                echo '<div class="content">';
                                echo '<img class="card" src="/resources/card_images/index_' . $row["name"] . '.jpg" alt="' . $row["name"] . '" data-category="' . $row["name"] . '" onclick="changeCategory(\'' . $row["name"] . '\')">';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo "0 results";
                        }

                        // Закрытие соединения с базой данных
                        $conn->close();
                    ?>
                </div>               
                <!-- содержимое категорий -->
                <div class="container_with_products">
                    <?php
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

                        // Запрос к базе данных для получения категорий
                        $sql = "SELECT id, name FROM categories";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Вывод данных каждой категории
                            while($row = $result->fetch_assoc()) {
                                // Генерация HTML-кода для раздела
                                echo '<div id="' . $row["name"] . '_products" class="category-content">';
                                
                                // Запрос к базе данных для получения товаров данной категории
                                $category_id = $row["id"];
                                $products_sql = "SELECT p.*, GROUP_CONCAT(m.name) AS materials 
                                                FROM products p 
                                                LEFT JOIN product_materials pm ON p.id = pm.product_id 
                                                LEFT JOIN materials m ON pm.material_id = m.id 
                                                WHERE p.category_id = $category_id 
                                                GROUP BY p.id";
                                $products_result = $conn->query($products_sql);

                                if ($products_result->num_rows > 0) {
                                    // Вывод товаров данной категории
                                    while($product_row = $products_result->fetch_assoc()) {
                                        // Генерация HTML-кода для карточки товара
                                        echo '<div class="product-card" data-id="' . $product_row["product_code"] . '">';
                                        echo '<div class="cardinfo">';
                                        echo '<div class="product-title">' . $product_row["product_code"] . '</div>';
                                        echo '<div class="product-materials">';
                                        echo '<p>Диаметр: ' . $product_row["diameter"] . '</p>';
                                        echo '<p>Класс прочности: ' . $product_row["strength_class"] . '</p>';
                                        echo '<p>Шаг резьбы: ' . $product_row["thread_pitch"] . '</p>';
                                        echo '<p>Материалы: ' . $product_row["materials"] . '</p>';
                                        // Добавьте вывод других характеристик товара по аналогии с примерами выше
                                        echo '</div>';
                                        echo '<button class="add-to-cart-button" id="' . $product_row["product_code"] . '">В корзину</button>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "0 results";
                                }
                                
                                echo '</div>';
                            }
                        } else {
                            echo "0 results";
                        }

                        // Закрытие соединения с базой данных
                        $conn->close();
                    ?>
                </div>
            </div>
        </div>

        <div id="cart" class="tab-content">
            <form action="send_to_server.php" method="post" id="formData" > 
                <div class="cart_con">
                    <div class="contents_cart">
                        <div class="table_con">
                            <h1>Корзина</h1>
                            <table class="cart-table" style="display: none;">
                                <thead>
                                    <tr>
                                        <th>Название товара</th>
                                        <th>Количество</th>
                                        <th>Тип измерения</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Здесь будут добавляться строки с товарами -->
                                </tbody>
                            </table>
                            <input type="hidden" id="cart-data" name="cart-data">
                            <div class="empty-cart-message" style="display: none;">
                                <h2>Пока здесь ничего нет</h2>    
                            </div>
                        </div>
                        <div class="information_about_buyer">
                            <h1>Ваши данные</h1>
                            <div class="form_con">
                                <label for="name">Как к вам обращаться?</label> 
                                <input type="text" id="name" name="name" required> 

                                <label for="email">Почтовый адрес</label> 
                                <input type="email" id="email" name="email" required> 

                                <label for="phone">Номер мобильного аппарата</label>
                                <input type="tel" id="phone" name="phone" required> 

                                <label for="msg">Дополнительная информация</label>
                                <textarea id="msg" name="msg" required class="bixtextarea" maxlength="1000"></textarea>

                                <div class="but_con">
                                    <div class="msg-counter half" id="msg-counter"></div>
                                    <div class="half">
                                        <button id="submit" type="submit">Отправить</button> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>    
        </div>

        <footer>
            <p><a href="admin_panel.php">Администрации</a></p>
            <p>ООО «ТД «ЗКИ»</p>
            <p>ОГРН 5177746000691</p>
            <p>ИНН 7743226882</p>
            <p>&copy;2013 Все права защищены</p>
        </footer>

        <!-- вызов поисковой строки в мобилке -->
        <script>
            // Показать/скрыть строку поиска при клике на иконку поиска
            document.querySelector('.show-search').addEventListener('click', function() {
                var searchBar = document.querySelector('.search-bar');
                if (searchBar.style.display === 'none' || searchBar.style.display === '') {
                    searchBar.style.display = 'flex';
                    // Автоматически фокусируемся на поле поиска и открываем клавиатуру
                    var searchInput = document.getElementById('searchInput');
                    searchInput.focus();
                    searchInput.select(); // Выделяем текст в поле поиска
                } else {
                    searchBar.style.display = 'none';
                }
            });

            // Скрывать строку поиска при клике вне неё
            document.addEventListener('click', function(event) {
                var searchBar = document.querySelector('.search-bar');
                var showSearchIcon = document.querySelector('.show-search');
                var isClickInsideSearchBar = searchBar.contains(event.target);
                var isClickInsideShowSearchIcon = showSearchIcon.contains(event.target);
                if (!isClickInsideSearchBar && !isClickInsideShowSearchIcon) {
                    searchBar.style.display = 'none';
                }
            });

            // Скрывать строку поиска при нажатии кнопки "Назад" на телефоне
            window.addEventListener('popstate', function(event) {
                var searchBar = document.querySelector('.search-bar');
                if (searchBar.style.display === 'flex') {
                    searchBar.style.display = 'none';
                }
            });

            // Скрыть строку поиска при завершении анимации отображения
            document.querySelector('.search-bar').addEventListener('transitionend', function() {
                var searchBar = document.querySelector('.search-bar');
                if (searchBar.style.display === 'flex') {
                    // Автоматически фокусируемся на поле поиска и открываем клавиатуру
                    var searchInput = document.getElementById('searchInput');
                    searchInput.focus();
                    searchInput.select(); // Выделяем текст в поле поиска
                }
            });


        </script>

        <!-- кол-во оставшихся символов в форме -->
        <script>
            // Функция для обновления счетчика сообщений
            function updateCounter() {
                const msgInput = document.getElementById('msg');
                const counter = document.getElementById('msg-counter');
                const currentLength = msgInput.value.length;
                const maxLength = parseInt(msgInput.getAttribute('maxlength'));
                counter.textContent = `${currentLength}/${maxLength}`;
            }
        
            // Вызываем функцию обновления счетчика при загрузке страницы
            window.addEventListener('DOMContentLoaded', updateCounter);
        
            // Добавляем обработчик события input для поля ввода сообщения
            const msgInput = document.getElementById('msg');
            msgInput.addEventListener('input', updateCounter);
        </script>

        <!-- маска на мобильник -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Применяем маску к полю ввода номера телефона
                var phoneInput = document.getElementById('phone');
                if (phoneInput) {
                    var maskOptions = {
                        mask: "+7 (999) 999-99-99",
                        onincomplete: function () {
                            // alert("Заполните полностью номер телефона.");
                        }
                    };
                    Inputmask(maskOptions).mask(phoneInput);
                }
            });
        </script>

        <!-- сбив отправки формы -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var form = document.getElementById("formData");

                form.addEventListener("submit", function(event) {
                    var phoneVal = document.getElementById("phone").value;
                    if (phoneVal.indexOf('_') !== -1 || phoneVal.length !== 18) {
                        alert("Заполните полностью номер телефона.");
                        event.preventDefault(); // Останавливаем отправку формы
                    } else {
                        event.preventDefault(); // Останавливаем стандартное поведение формы

                        var formData = new FormData(form);

                        fetch(form.action, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            alert(data); // Отображаем alert с сообщением
                            window.location.reload(); // Перезагружаем страницу после закрытия alert
                        })
                        .catch(error => {
                            console.error('Ошибка:', error);
                            alert('Произошла ошибка при отправке данных.');
                        });
                    }
                });
            });
        </script>
           
        <!-- авторесайз текстового поля в форме   -->
        <script>
            console.log("textarea_autoresize.js работает!");

            // Находим элемент textarea
            var textarea = document.getElementById('msg');

            // Устанавливаем начальную высоту, равную одной строке
            textarea.style.height = 'auto';

            // Функция для автоматического изменения высоты textarea
            function autoresize() {
                // Устанавливаем высоту textarea так, чтобы весь текст вместился без прокрутки
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            }

            // Вызываем функцию autoresize при изменении текста в textarea
            textarea.addEventListener('input', autoresize);
        </script>
    </body>
</html>