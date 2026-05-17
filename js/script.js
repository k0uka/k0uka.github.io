const menuIcon = document.querySelector('#menu-icon');
const navLink = document.querySelector('.nav-link');

menuIcon.onclick = () => {
    navLink.classList.toggle('active')
}

