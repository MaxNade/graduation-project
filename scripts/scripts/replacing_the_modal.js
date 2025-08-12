console.log("replacing_the_modal.js работает!");

document.addEventListener("DOMContentLoaded", function () {
    var modal = document.getElementById('openModal');
    var openButton = document.querySelector('[href="#openModal"]');
    var closeButton = document.querySelector('.modal .close');
    var modalContent = document.querySelector('.modal .modal-dialog');

    // Функция для открытия модального окна
    function openModal() {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        sessionStorage.setItem('modalOpened', 'true');
    }

    // Функция для закрытия модального окна
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'visible';
        sessionStorage.removeItem('modalOpened');
    }

    // Проверяем, было ли модальное окно открыто после перезагрузки страницы
    var isModalOpened = sessionStorage.getItem('modalOpened');
    if (isModalOpened) {
        openModal();
    }

    // Обработчик клика на кнопке открытия модального окна
    openButton.addEventListener('click', openModal);

    // Обработчик клика на кнопке закрытия модального окна
    closeButton.addEventListener('click', closeModal);

    // Закрытие модального окна при клике за его пределами
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });
});
