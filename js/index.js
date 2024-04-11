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

    var observer2 = new IntersectionObserver(function(entries) {
        if(entries[0].isIntersecting === true)
            document.querySelector('.text1').style.animationPlayState = "running";
    }, { threshold: [0] });

    observer2.observe(document.querySelector('.text1'));

    var observer3 = new IntersectionObserver(function(entries) {
        if(entries[0].isIntersecting === true)
            document.querySelector('.text2').style.animationPlayState = "running";
    }, { threshold: [0] });

    observer3.observe(document.querySelector('.text2'));

    var observer4 = new IntersectionObserver(function(entries) {
        if(entries[0].isIntersecting === true)
            document.querySelector('.text3').style.animationPlayState = "running";
    }, { threshold: [0] });

    observer4.observe(document.querySelector('.text3'));

    
    var observer5 = new IntersectionObserver(function(entries) {
        if(entries[0].isIntersecting === true)
            document.querySelector('.textBas').style.animationPlayState = "running";
    }, { threshold: [0] });

    observer5.observe(document.querySelector('.textBas'));
    
});

