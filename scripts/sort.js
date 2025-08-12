console.log("sort.js работает!");


function sortByPrice() {
  var productsContainer = document.querySelector('.products');
  var products = Array.from(productsContainer.querySelectorAll('.product-card'));

  products.sort(function(a, b) {
    var priceA = getPrice(a);
    var priceB = getPrice(b);
    return priceA - priceB;
  });

  // Удаляем все дочерние элементы контейнера
  while (productsContainer.firstChild) {
    productsContainer.removeChild(productsContainer.firstChild);
  }

  // Добавляем отсортированные товары обратно в контейнер
  products.forEach(function(product) {
    productsContainer.appendChild(product);
  });
}

function getPrice(product) {
  var priceText = product.querySelector('.product-price').textContent;
  var match = priceText.match(/Цена: (\d+) руб\./); // Парсим цену из текста
  if (match && match[1]) {
    return parseInt(match[1]);
  } else {
    return Infinity; // Возвращаем Infinity, если цена не найдена, чтобы такие товары оказались в конце списка
  }
}
