window.addEventListener('scroll', function() {
    var scrollPosition = window.scrollY || document.documentElement.scrollTop;
    var opacity = 1 - (scrollPosition / 300);
    if(opacity >= 0) {
        document.querySelector('.milieu').style.opacity = opacity;
    }
});

document.addEventListener("DOMContentLoaded", function() {
    var observer = new IntersectionObserver(function(entries) {
        if(entries[0].isIntersecting === true)
            document.querySelector('.infos').style.animationPlayState = "running";
    }, { threshold: [0] });

    observer.observe(document.querySelector('.infos'));
});