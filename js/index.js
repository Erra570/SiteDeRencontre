window.addEventListener('scroll', function() {
    var scrollPosition = window.scrollY || document.documentElement.scrollTop;
    var opacity = 1 - (scrollPosition / 300);
    if(opacity >= 0) {
        document.querySelector('.milieu').style.opacity = opacity;
    }
});