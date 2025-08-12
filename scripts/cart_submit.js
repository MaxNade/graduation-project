console.log("cart_submit.js работает!");

// Функция для сбора всех данных перед отправкой на сервер
function collectFormData() {
    var formData = new FormData(); // Создаем объект FormData для сбора данных

    // Собираем данные из формы о покупателе
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;
    var msg = document.getElementById('msg').value;

    formData.append('name', name);
    formData.append('email', email);
    formData.append('phone', phone);
    formData.append('msg', msg);

    // Собираем данные о товарах в корзине
    var cartItems = collectCartData();
    formData.append('cartItems', JSON.stringify(cartItems));

    tableRows.forEach(function(row) {
        var productName = row.cells[0].innerText;
        var quantity = row.cells[1].querySelector('input[type="number"]').value;
        var unit = row.cells[2].querySelector('select').value;

        var item = {
            productName: productName,
            quantity: quantity,
            unit: unit
        };
        cartItemsArray.push(item);
    });

    formData.append('cartItems', JSON.stringify(cartItemsArray));

    return formData;
}



// Функция для отправки данных на сервер
function sendDataToServer(formData) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'send_to_server.php');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Обработка успешной отправки данных
            console.log('Данные успешно отправлены на сервер.');
            // Можно выполнить какие-то дополнительные действия после успешной отправки данных, если необходимо
        } else {
            // Обработка ошибок при отправке данных
            console.error('Ошибка отправки данных на сервер:', xhr.statusText);
        }
    };
    xhr.onerror = function() {
        // Обработка ошибок соединения
        console.error('Ошибка соединения при отправке данных на сервер.');
    };
    xhr.send(formData);
}

// Обработчик события отправки формы
document.getElementById('formData').addEventListener('submit', function(event) {
    event.preventDefault(); // Отменяем стандартное действие отправки формы

    // Собираем все данные перед отправкой на сервер
    var formData = collectFormData();

    // Отправляем данные на сервер
    sendDataToServer(formData);
});
