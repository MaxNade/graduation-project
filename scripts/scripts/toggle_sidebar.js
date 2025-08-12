document.addEventListener('DOMContentLoaded', function() {
    // Проверяем наличие сайдбара на странице каталога
    const sidebar = document.querySelector('.product_category_card');
    if (!sidebar) {
        return; // Если сайдбар не найден, выходим из функции
    }

    const toggleButton = document.querySelector('.toggle-button');

    let startX; // Начальная позиция касания
    let isSidebarSwipe = false; // Флаг для определения, является ли свайпом для сайдбара

    // Функция для открытия/закрытия сайдбара
    function handleSwipe() {
        if (sidebar.style.left === "0px") {
            sidebar.style.left = "-280px"; // Закрываем сайдбар
        } else {
            sidebar.style.left = "0px"; // Открываем сайдбар
        }
    }

    // Обработчик касания на кнопке для открытия/закрытия сайдбара
    toggleButton.addEventListener('click', function(event) {
        event.stopPropagation();
        handleSwipe();
    });

    // Обработчик касания для отслеживания начальной позиции касания
    document.addEventListener('touchstart', function(event) {
        // Проверяем, открыт ли сайдбар
        if (sidebar.style.left === "0px") {
            return; // Игнорируем свайпы, если сайдбар открыт
        }

        startX = event.touches[0].clientX; // Запоминаем начальную позицию касания
        isSidebarSwipe = startX < 50; // Устанавливаем флаг, если касание началось близко к левой границе экрана
    });

    // Обработчик перемещения пальца для отслеживания свайпа
    document.addEventListener('touchmove', function(event) {
        // Проверяем, открыт ли сайдбар
        if (sidebar.style.left === "0px") {
            return; // Игнорируем свайпы, если сайдбар открыт
        }

        if (startX && event.touches[0].clientX - startX > 50 && isSidebarSwipe) {
            handleSwipe(); // Вызываем функцию открытия/закрытия сайдбара
            startX = null; // Сбрасываем начальную позицию касания
            isSidebarSwipe = false; // Сбрасываем флаг свайпа для сайдбара
        }
    });

    // Закрытие сайдбара при скролле
    document.addEventListener('scroll', function() {
        sidebar.style.left = "-280px";
    });

    // Закрытие сайдбара при клике вне его области
    document.addEventListener('mousedown', function(event) {
        if (sidebar.style.left === "0px" && !sidebar.contains(event.target) && event.target !== toggleButton) {
            event.stopPropagation();
            sidebar.style.left = "-280px";
        }
    });

    // Закрытие сайдбара при касании вне его области на мобильных устройствах
    document.addEventListener('touchstart', function(event) {
        if (sidebar.style.left === "0px" && !sidebar.contains(event.target) && event.target !== toggleButton) {
            event.stopPropagation();
            sidebar.style.left = "-280px";
        }
    });
});
