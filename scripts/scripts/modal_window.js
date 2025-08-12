console.log("modal_window.js работает!");

document.addEventListener("DOMContentLoaded", function () {
    var modal = document.getElementById('openModal');
    var openButton = document.querySelector('[href="#openModal"]');
    var closeButton = document.querySelector('.modal .close');
    var modalContent = document.querySelector('.modal .modal-dialog');
    var form = document.getElementById('formData');
    var successMessage = document.getElementById('successMessage');

    // Функция для открытия модального окна
    function openModal() {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        history.pushState(null, null, ' '); // Удаляем якорь из URL
        sessionStorage.setItem('modalOpened', 'true');
    }

    // Функция для закрытия модального окна
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'visible';
        history.pushState(null, null, ' '); // Удаляем якорь из URL
        sessionStorage.removeItem('modalOpened');
        // Очищаем поля формы
        form.reset();
    }

    // Проверяем, было ли модальное окно открыто после перезагрузки страницы
    var isModalOpened = sessionStorage.getItem('modalOpened');
    if (isModalOpened) {
        openModal();
        document.body.style.overflow = 'visible';
    }

    // Обработчик клика на кнопке открытия модального окна
    openButton.addEventListener('click', function() {
        openModal();
    });

    // Обработчик клика на кнопке закрытия модального окна
    closeButton.addEventListener('click', function(event) {
        event.preventDefault(); // Предотвращаем переход по якорю
        closeModal();
    });

    // Обработчик отправки формы
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Предотвращаем стандартное поведение отправки формы
        
        // Создаем объект FormData для сбора данных формы
        var formData = new FormData(form);

        // Отправляем данные формы на сервер через AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'send_to_server.php');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Если запрос успешен, закрываем модальное окно, обновляем страницу и выводим уведомление
                closeModal();
                location.reload(); // Обновляем страницу
                successMessage.style.display = 'block';
            } else {
                // Если произошла ошибка, выводим сообщение об ошибке
                console.error('Ошибка отправки данных на сервер:', xhr.statusText);
            }
        };
        xhr.onerror = function() {
            // Если произошла ошибка при отправке запроса, выводим сообщение об ошибке
            console.error('Ошибка отправки запроса на сервер.');
        };
        xhr.send(formData);
    });

});
