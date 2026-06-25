(function () {
    'use strict';

    function ready(fn) {
        if (document.readyState !== 'loading') {
            fn();
            return;
        }
        document.addEventListener('DOMContentLoaded', fn);
    }

    function closeDesktopDropdowns() {
        document.querySelectorAll('.header-navigation-content li.dropdown.nsp-dropdown-open').forEach(function (item) {
            item.classList.remove('nsp-dropdown-open');
        });
    }

    function directDropdownMenu(item) {
        if (!item) {
            return null;
        }

        for (var i = 0; i < item.children.length; i++) {
            if (item.children[i].classList.contains('dropdown-menu')) {
                return item.children[i];
            }
        }

        return null;
    }

    ready(function () {
        document.querySelectorAll('.header-navigation-content li.dropdown > a').forEach(function (link) {
            link.addEventListener('click', function (event) {
                var item = link.parentElement;
                var menu = directDropdownMenu(item);

                if (window.innerWidth > 991 && menu) {
                    event.preventDefault();
                    event.stopPropagation();

                    var isOpen = item.classList.contains('nsp-dropdown-open');
                    closeDesktopDropdowns();
                    if (!isOpen) {
                        item.classList.add('nsp-dropdown-open');
                    }
                }
            });
        });

        document.querySelectorAll('.mobile-main-navigation li.dropdown > a').forEach(function (link) {
            link.addEventListener('click', function (event) {
                var item = link.parentElement;
                var menu = directDropdownMenu(item);

                if (menu) {
                    event.preventDefault();
                    item.classList.toggle('nsp-dropdown-open');
                }
            });
        });

        document.addEventListener('click', closeDesktopDropdowns);
        document.querySelectorAll('.header-navigation-content li.dropdown .dropdown-menu').forEach(function (menu) {
            menu.addEventListener('click', function (event) {
                event.stopPropagation();
            });
        });

        if (window.jQuery) {
            window.jQuery(window).on('load', function () {
                var $slider = window.jQuery('.clinox-service-slider-3');
                if ($slider.length && $slider.hasClass('slick-initialized')) {
                    $slider.slick('setPosition');
                }
            });
        }
    });
})();
