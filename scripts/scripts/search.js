console.log("search.js работает!");

function searchProducts() {
  var input, filter, products, product, i, title;
  input = document.getElementById('searchInput');
  filter = input.value.toLowerCase().trim(); // Приводим введенный текст к нижнему регистру и убираем лишние пробелы
  products = document.querySelectorAll('.product-card');

  var found = false; // Флаг для определения наличия совпадений

  products.forEach(function(product) {
    title = product.querySelector('.product-title').textContent.toLowerCase().trim(); // Получаем текст названия товара и приводим к нижнему регистру
    if (title.includes(filter)) { // Проверяем, содержит ли название товара введенный текст
      product.style.display = ''; // Показываем товар, если найдено совпадение
      found = true; // Устанавливаем флаг в true, если найдено совпадение
    } else {
      product.style.display = 'none'; // Скрываем товар, если совпадение не найдено
    }
  });

  // Выводим сообщение, если совпадений не найдено
  var notFoundMessage = document.getElementById('notFoundMessage');
  if (!found) {
    notFoundMessage.style.display = ''; // Показываем сообщение
  } else {
    notFoundMessage.style.display = 'none'; // Скрываем сообщение
  }

  // Обработчик события keypress для поля ввода
searchInput.addEventListener('keypress', function(event) {
  if (event.key === 'Enter') { // Проверка нажатия клавиши Enter
      searchProducts(); // Вызов функции поиска при нажатии Enter
  }
});
}
