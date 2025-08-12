document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('nav');
    const navLinks = document.querySelectorAll('nav button, nav input');
    const sidebar = document.querySelector('.product_category_card'); // Добавляем ссылку на сайдбар
    const categoryContent = document.querySelector('.category-content'); // Добавляем ссылку на контейнер

    // Функция для переключения класса 'menu-open'
    function toggleMenu() {
        nav.classList.toggle('menu-open');
    }

    // Закрыть меню
    function closeMenu() {
        nav.classList.remove('menu-open');
    }

    // Открытие/закрытие меню при нажатии на кнопку меню
    menuToggle.addEventListener('click', function(event) {
        event.stopPropagation();
        toggleMenu();
        closeSidebar(); // Вызываем функцию закрытия сайдбара
    });

    // Закрытие меню при нажатии на любую кнопку в меню
    navLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            // Проверяем, является ли целевой элемент кнопкой
            if (event.target.tagName !== 'INPUT') {
                closeMenu();
            }
        });
    });

    // Закрытие меню при клике вне меню
    document.addEventListener('click', function(event) {
        if (!nav.contains(event.target) && !menuToggle.contains(event.target)) {
            console.log('Click outside menu');
            closeMenu();
        }
    });

    // Закрытие меню при прокрутке страницы
    window.addEventListener('scroll', function() {
        closeMenu();
    });

    // Обработчик для скролла контейнера
    categoryContent.addEventListener('scroll', function() {
        closeMenu(); // Закрываем меню при скролле контейнера
        closeSidebar(); // Закрываем сайдбар при скролле контейнера
    });

    // Функция для закрытия сайдбара
    function closeSidebar() {
        sidebar.style.left = "-280px";
    }
});
