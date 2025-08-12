console.log("Скрипт cart успешно запущен и работает!");

// Собираем данные о товарах в корзине перед отправкой формы
function collectCartData() {
    var cartItems = []; // Массив для хранения данных о товарах в корзине
    var tableRows = document.querySelectorAll('.cart-table tbody tr'); // Выбираем все строки таблицы корзины

    // Перебираем каждую строку таблицы корзины
    tableRows.forEach(function(row) {
        var productName = row.cells[0].textContent; // Получаем название товара из первой ячейки
        var quantity = row.cells[1].querySelector('input[type="number"]').value; // Получаем количество товара из второй ячейки
        var unit = row.cells[2].querySelector('select').value; // Получаем тип измерения из третьей ячейки
        
        // Создаем объект для текущего товара и добавляем его в массив cartItems
        var item = {
            productName: productName,
            quantity: quantity,
            unit: unit
        };
        cartItems.push(item);
    });
    
    // Отладочный вывод для проверки содержимого массива cartItems
    console.log(cartItems);
    
    var cartDataInput = document.getElementById('cart-data');
    cartDataInput.value = JSON.stringify(cartItems);
}

// Находим форму отправки данных на сервер
var formData = document.getElementById('formData');

// Добавляем обработчик события отправки формы
formData.addEventListener('submit', function(event) {
    // Получаем скрытое поле cart-data
    var cartDataInput = document.getElementById('cart-data');
    
    // Обновляем значение скрытого поля с данными о товарах
    cartDataInput.value = JSON.stringify(cartItems);
    
    // Предотвращаем отправку формы
    event.preventDefault();
});

