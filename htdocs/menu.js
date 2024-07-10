function openPopup(src) {
    document.getElementById('popup-img').src = src;
    document.getElementById('popup').style.display = 'block';
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
}

// イベントリスナーを追加
document.addEventListener('DOMContentLoaded', function() {
    var foodmenus = document.querySelectorAll('.foodmenus');
    foodmenus.forEach(function(menu) {
        menu.addEventListener('click', function() {
            openPopup(menu.src);
        });
    });

    var closeBtn = document.querySelector('.close');
    if (closeBtn) {
        closeBtn.addEventListener('click', closePopup);
    }
});
