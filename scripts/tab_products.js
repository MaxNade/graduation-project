console.log("tab_products.js работает!");

// Дождемся полной загрузки всего HTML-документа, чтобы можно было внести изменения
document.addEventListener("DOMContentLoaded", function() {
    // Устанавливаем по умолчанию отображение категории
    changeCategory('bolt');
});

function searchProducts(inputId) {
    // Скрываем строку поиска
    var searchBar = document.querySelector('.search-bar');
    searchBar.style.display = 'none';

    // Получаем значение из поля поиска по идентификатору
    var searchQuery = document.getElementById(inputId).value.trim();

    // Выводим поисковый запрос для отладки
    console.log('Search query:', searchQuery);

    if (searchQuery === '') {
        console.log('Search query is empty'); // Сообщение о пустом поисковом запросе
        alert('Введите запрос для поиска');
        return;
    }

    // Найден ли товар
    var productFound = false;

    // Получаем все карточки товаров
    var allProducts = document.querySelectorAll('.product-card');

    // Выводим количество найденных карточек для отладки
    console.log('Total products found:', allProducts.length);

    // Перебираем все карточки товаров для поиска совпадения
    allProducts.forEach(function(product) {
        var productTitle = product.querySelector('.product-title').textContent.trim();
        console.log('Checking product:', productTitle); // Сообщение для отладки

        if (productTitle === searchQuery) {
            productFound = true;

            // Находим категорию, к которой относится данный товар
            var categoryContainer = product.closest('.category-content');

            if (categoryContainer) {
                // Получаем ID категории
                var categoryId = categoryContainer.id.replace('_products', '');

                // Переключаемся на вкладку "catalog"
                changeTab('catalog');

                // Переключаемся на найденную категорию
                changeCategory(categoryId);

                // Удаляем предыдущие выделения
                allProducts.forEach(function(p) {
                    p.classList.remove('highlight');
                });

                // Выделяем найденный товар
                product.classList.add('highlight');

                // Прокрутка к найденному товару
                product.scrollIntoView({ behavior: 'smooth', block: 'center' });

                // Выход из цикла forEach после нахождения товара и выполнения прокрутки
                return;
            }
        }
    });

    if (!productFound) {
        alert('Товар не найден');
    }
}


function changeCategory(categoryId) {
    // Получаем идентификатор контейнера с продуктами для выбранной категории
    var selectedCategoryId = document.getElementById(categoryId + "_products");
    
    // Получаем все контейнеры с продуктами и скрываем их
    var allCategories = document.getElementsByClassName('category-content');
    for (var i = 0; i < allCategories.length; i++) {
        allCategories[i].style.display = 'none';
    }

    // Отображаем выбранный контейнер с продуктами
    if (selectedCategoryId) {
        selectedCategoryId.style.display = '';
    }

    // Закрываем сайдбар
    const sidebar = document.querySelector('.product_category_card');
    sidebar.style.left = "-280px"; // Закрываем сайдбар

    // Удаляем класс 'selected' со всех карточек категорий
    var allCategoryCards = document.querySelectorAll(".product_category_card .card .box");
    allCategoryCards.forEach(function(card) {
        card.classList.remove("selected");
    });

    // Добавляем класс 'selected' к выбранной карточке категории
    var selectedCategoryCard = document.getElementById("category-" + categoryId);
    if (selectedCategoryCard) {
        selectedCategoryCard.classList.add("selected");
    }
}

// Определяем функцию handleKeyPress в глобальной области видимости
function handleKeyPress(event, inputId) {
    if (event.key === 'Enter') {
        searchProducts(inputId);
    }
}

document.addEventListener("DOMContentLoaded", function() {
    // Обработчик для мобильной версии
    document.getElementById('mobileSearchInput').addEventListener('keypress', function(event) {
        handleKeyPress(event, 'mobileSearchInput');
    });

    // Обработчик для десктопной версии
    document.getElementById('desktopSearchInput').addEventListener('keypress', function(event) {
        handleKeyPress(event, 'desktopSearchInput');
    });
});

