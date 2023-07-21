if (window.innerWidth > 835) {
    const styleNav = document.querySelector('.hidden-navbar');
    window.addEventListener("scroll", function () {
        let form = document.querySelector('.form-js').getBoundingClientRect().y;
        let nav = document.querySelector('.navbar-js').getBoundingClientRect().y;
        if (nav > form) {
            styleNav.style.display = "initial";
        } else {
            styleNav.style.display = "none";
        }
    });
}
