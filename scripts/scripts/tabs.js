console.log("tabs.js работает!");

document.addEventListener("DOMContentLoaded", function() {
    // Получаем значение куки 'selectedTab' или устанавливаем значение по умолчанию
    var savedTabId = getCookie('selectedTab') || 'info';
    changeTab(savedTabId);
});

// Функция для изменения отображения вкладок и кнопок
function updateBottomBar(tabId) {
    // Удаляем класс 'selected' у всех кнопок в нижней навигационной панели
    var bottomButtons = document.querySelectorAll('#bottom-bar button');
    bottomButtons.forEach(function(button) {
        button.classList.remove('selected');
    });

    // Добавляем класс 'selected' к кнопке с выбранным идентификатором вкладки
    var selectedBottomButton = document.querySelector('#bottom-bar button[data-tab="' + tabId + '"]');
    if (selectedBottomButton) {
        selectedBottomButton.classList.add('selected');
    }
}

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

    // Удаляем класс 'darkened' у всех кнопок в основной навигационной панели
    var allButtons = document.querySelectorAll('nav button');
    for (var i = 0; i < allButtons.length; i++) {
        allButtons[i].classList.remove('darkened');
    }

    // Добавляем класс 'darkened' активной кнопке в основной навигационной панели на основе идентификатора вкладки
    var activeButton = document.querySelector('nav button[data-tab="' + tabId + '"]');
    if (activeButton) {
        activeButton.classList.add('darkened');
    }

    // Вызываем функцию для изменения стиля кнопок в нижней навигационной панели
    updateBottomBar(tabId);

    // Устанавливаем куки 'selectedTab' с идентификатором выбранной вкладки
    setCookie('selectedTab', tabId, 365);
}

// Функция для установки значения куки
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

// Функция для получения значения куки по имени
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}


// Добавляем обработчики событий для свайпов
function addSwipeListeners() {
    var touchstartX = 0;
    var touchendX = 0;
    var swipeThreshold = 50; // Порог для определения области свайпа
    var sidebar = document.querySelector('.product_category_card');

    document.addEventListener('touchstart', function(event) {
        // Проверяем, открыт ли сайдбар
        if (sidebar && sidebar.style.left === "0px") {
            return; // Игнорируем свайпы, если сайдбар открыт
        }

        var touchStartPosX = event.touches[0].clientX;
        var isSwipingInSidebarArea = touchStartPosX < swipeThreshold;
        var isSwipingInCartArea = event.target.closest('.table_con') !== null; // Проверяем, находится ли касание в области корзины

        if (!isSwipingInSidebarArea && !isSwipingInCartArea) { // Если свайп не начинается в области сайдбара или корзины
            touchstartX = touchStartPosX;
        } else {
            touchstartX = -1; // Сбрасываем начальную позицию, чтобы игнорировать свайп
        }
    });

    document.addEventListener('touchend', function(event) {
        // Проверяем, открыт ли сайдбар
        if (sidebar && sidebar.style.left === "0px") {
            return; // Игнорируем свайпы, если сайдбар открыт
        }

        if (touchstartX !== -1) {
            touchendX = event.changedTouches[0].clientX;
            var swipeDistance = Math.abs(touchendX - touchstartX);

            // Если разница меньше порога, игнорируем свайп
            if (swipeDistance >= swipeThreshold) {
                handleSwipeGesture();
            }
        }
    });

    function handleSwipeGesture() {
        if (touchendX < touchstartX - swipeThreshold) {
            // Свайп влево
            switchToNextTab();
        }
        if (touchendX > touchstartX + swipeThreshold) {
            // Свайп вправо
            switchToPreviousTab();
        }
    }

    function switchToNextTab() {
        var currentTab = document.querySelector('.tab-content[style="display: block;"]');
        if (currentTab) {
            var allTabs = Array.from(document.querySelectorAll('.tab-content'));
            var currentIndex = allTabs.indexOf(currentTab);
            var nextIndex = (currentIndex + 1) % allTabs.length;
            changeTab(allTabs[nextIndex].id);
        }
    }

    function switchToPreviousTab() {
        var currentTab = document.querySelector('.tab-content[style="display: block;"]');
        if (currentTab) {
            var allTabs = Array.from(document.querySelectorAll('.tab-content'));
            var currentIndex = allTabs.indexOf(currentTab);
            var previousIndex = (currentIndex - 1 + allTabs.length) % allTabs.length;
            changeTab(allTabs[previousIndex].id);
        }
    }
}
