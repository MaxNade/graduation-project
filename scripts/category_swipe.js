// Обработка свайпа для вызова контейнера с категориями
let startX = 0;
let isSwiping = false;

document.querySelector('.container_with_products').addEventListener('touchstart', function(e) {
    startX = e.touches[0].clientX;
    isSwiping = true;
});

document.querySelector('.container_with_products').addEventListener('touchmove', function(e) {
    if (!isSwiping) return;

    let currentX = e.touches[0].clientX;
    let diffX = currentX - startX;

    if (diffX > 50) { // Свайп вправо
        document.querySelector('.product_category_card').style.transform = 'translateX(0)';
    }
});

document.querySelector('.container_with_products').addEventListener('touchend', function() {
    isSwiping = false;
});
