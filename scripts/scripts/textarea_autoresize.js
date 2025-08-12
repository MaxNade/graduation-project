console.log("textarea_autoresize.js работает!");

// Находим элемент textarea
var textarea = document.getElementById('msg');

// Устанавливаем начальную высоту, равную одной строке
textarea.style.height = 'auto';

// Функция для автоматического изменения высоты textarea
function autoresize() {
    // Устанавливаем высоту textarea так, чтобы весь текст вместился без прокрутки
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

// Вызываем функцию autoresize при изменении текста в textarea
textarea.addEventListener('input', autoresize);
