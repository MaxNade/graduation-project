console.log("add_to_cart.js работает!");

document.addEventListener("DOMContentLoaded", function() {
    // Объект для отслеживания товаров в корзине
    var cartItems = {};
    
    // Находим все кнопки "В корзину"
    var addToCartButtons = document.querySelectorAll('.add-to-cart-button');

    // Для каждой кнопки добавляем обработчик события клика
    addToCartButtons.forEach(function(button) {
        // Получаем ID товара из атрибута id кнопки
        var productId = button.id;
    
        // Обновляем текст и стили кнопки
        updateButtonState(button, productId);
    
        button.addEventListener('click', function() {
            // Проверяем, есть ли товар уже в корзине
            if (cartItems[productId]) {
                alert('Этот товар уже добавлен в корзину!');
                return; // Прекращаем выполнение функции, если товар уже есть в корзине
            }
    
            // Получаем информацию о товаре (здесь можно реализовать ваш способ получения данных о товаре)
            var productName = productId; // В этом примере имя товара - это его ID
    
            // Добавляем товар в корзину
            cartItems[productId] = {
                name: productName,
                quantity: 1 // Устанавливаем начальное количество товара в 1
            };
    
            // Добавляем товар в таблицу корзины
            addToCartTable(productId, productName);
    
            // Обновляем текст и стили кнопки после добавления товара в корзину
            updateButtonState(button, productId);

            console.log(cartItems);

        });
    });

    // Функция для добавления товара в таблицу корзины
    function addToCartTable(productId, productName) {
        // Находим таблицу корзины
        var cartTable = document.querySelector('.cart-table tbody');
    
        // Создаем новую строку в таблице
        var newRow = document.createElement('tr');
    
        // Создаем ячейку для имени товара
        var nameCell = document.createElement('td');
    
        // Создаем элемент input для отображения и передачи названия товара
        var nameInput = document.createElement('input');
        nameInput.type = 'text'; // Устанавливаем тип input как текстовый
        nameInput.value = productName; // Устанавливаем значение поля
        nameInput.readOnly = true; // Устанавливаем атрибут readonly, чтобы сделать поле только для чтения
        nameInput.name = 'product_name[]'; // Устанавливаем атрибут name для передачи данных
    
        // Добавляем элемент input в ячейку
        nameCell.appendChild(nameInput);
    
        // Добавляем ячейку в строку
        newRow.appendChild(nameCell);
    
        // Создаем ячейку для редактирования количества товара
        var quantityCell = document.createElement('td');
    
        // Создаем элемент input для редактирования количества товара
        var quantityInput = document.createElement('input');
        quantityInput.type = 'number'; // Устанавливаем тип input как число
        quantityInput.min = '1'; // Минимальное значение - 1
        quantityInput.value = '1'; // Значение по умолчанию - 1
        quantityInput.name = 'product_quantity[]'; // Устанавливаем атрибут name для передачи данных
        quantityCell.appendChild(quantityInput); // Добавляем input в ячейку
        newRow.appendChild(quantityCell); // Добавляем ячейку в строку
    
        // Создаем ячейку для выбора типа измерения
        var unitCell = document.createElement('td');
        var unitSelect = document.createElement('select');
        unitSelect.name = 'product_unit[]'; // Устанавливаем атрибут name для передачи данных
        var piecesOption = document.createElement('option');
        piecesOption.value = 'pieces';
        piecesOption.textContent = 'Штуки';
        var kilogramsOption = document.createElement('option');
        kilogramsOption.value = 'kilograms';
        kilogramsOption.textContent = 'Килограммы';
        unitSelect.appendChild(piecesOption);
        unitSelect.appendChild(kilogramsOption);
        unitCell.appendChild(unitSelect);
        newRow.appendChild(unitCell);
    
        // Создаем ячейку для кнопки удаления
        var deleteCell = document.createElement('td');
        var deleteButton = document.createElement('button');
        deleteButton.textContent = 'Удалить';
        deleteButton.addEventListener('click', function() {
            // Удаляем товар из корзины и из таблицы
            deleteCartItem(newRow, productId);
        });
        deleteCell.appendChild(deleteButton); // Добавляем кнопку в ячейку
        newRow.appendChild(deleteCell); // Добавляем ячейку в строку
    
        // Добавляем новую строку в таблицу
        cartTable.appendChild(newRow);
    
        updateCart();
    }
    
    // Функция для удаления товара из корзины и из таблицы
    function deleteCartItem(row, productId) {
        // Удаляем товар из корзины
        delete cartItems[productId];
        // Удаляем строку из таблицы
        row.remove();
        // Обновляем текст кнопки после удаления товара из корзины
        updateButtonState(document.getElementById(productId), productId);

        updateCart();

    }

    // Функция для обновления текста кнопки в зависимости от наличия товара в корзине
    function updateButtonState(button, productId) {
        // Если товар уже в корзине, меняем текст кнопки и стили
        if (cartItems[productId]) {
            button.textContent = 'В корзине'; // Изменяем текст кнопки
            button.classList.remove('addToCart'); // Удаляем класс активной кнопки
            button.classList.add('inCart'); // Добавляем класс неактивной кнопки
            button.disabled = true; // Запрещаем нажатие кнопки
        } else {
            button.textContent = 'Добавить в корзину'; // Возвращаем стандартный текст кнопки
            button.classList.remove('inCart'); // Удаляем класс неактивной кнопки
            button.classList.add('addToCart'); // Добавляем класс активной кнопки
            button.disabled = false; // Разрешаем нажатие кнопки
        }
          
    }

    // Функция для обновления отображения корзины
    function updateCart() {
        var cartTable = document.querySelector('.cart-table');
        var emptyCartMessage = document.querySelector('.empty-cart-message');
    
        // Проверяем, есть ли товары в корзине
        if (Object.keys(cartItems).length === 0) {
            // Если корзина пуста, скрываем таблицу и показываем сообщение
            cartTable.style.display = 'none';
            emptyCartMessage.style.display = 'block';
        } else {
            // Если в корзине есть товары, показываем таблицу и скрываем сообщение
            cartTable.style.display = 'table';
            emptyCartMessage.style.display = 'none';
        }
    }

    // Вызываем функцию обновления корзины при загрузке страницы
    updateCart();
});
