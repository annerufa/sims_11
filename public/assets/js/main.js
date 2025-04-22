/**
 * Main
 */

'use strict';

let menu, 
  animate;
document.addEventListener('DOMContentLoaded', function () {
  // class for ios specific styles
  if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {
    document.body.classList.add('ios');
  }
});

(function () {
  // Initialize menu
  //-----------------

  let layoutMenuEl = document.querySelectorAll('#layout-menu');
  layoutMenuEl.forEach(function (element) {
    menu = new Menu(element, {
      orientation: 'vertical',
      closeChildren: false
    });
    // Change parameter to true if you want scroll animation
    window.Helpers.scrollToActive((animate = false));
    window.Helpers.mainMenu = menu;
  });

  // Initialize menu togglers and bind click on each
  let menuToggler = document.querySelectorAll('.layout-menu-toggle');
  menuToggler.forEach(item => {
    item.addEventListener('click', event => {
      event.preventDefault();
      window.Helpers.toggleCollapsed();
    });
  });

  // Display menu toggle (layout-menu-toggle) on hover with delay
  let delay = function (elem, callback) {
    let timeout = null;
    elem.onmouseenter = function () {
      // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
      if (!Helpers.isSmallScreen()) {
        timeout = setTimeout(callback, 300);
      } else {
        timeout = setTimeout(callback, 0);
      }
    };

    elem.onmouseleave = function () {
      // Clear any timers set to timeout
      document.querySelector('.layout-menu-toggle').classList.remove('d-block');
      clearTimeout(timeout);
    };
  };
  if (document.getElementById('layout-menu')) {
    delay(document.getElementById('layout-menu'), function () {
      // not for small screen
      if (!Helpers.isSmallScreen()) {
        document.querySelector('.layout-menu-toggle').classList.add('d-block');
      }
    });
  }

  // Display in main menu when menu scrolls
  let menuInnerContainer = document.getElementsByClassName('menu-inner'),
    menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
  if (menuInnerContainer.length > 0 && menuInnerShadow) {
    menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
      if (this.querySelector('.ps__thumb-y').offsetTop) {
        menuInnerShadow.style.display = 'block';
      } else {
        menuInnerShadow.style.display = 'none';
      }
    });
  }
  // Mark all as read
   // Elemen utama
  const markAllBtn = document.querySelector(".dropdown-notifications-all");
  const markSingleBtns = document.querySelectorAll(".dropdown-notifications-read");
  const headerBadgeDot = document.querySelector(".badge-notifications.badge-dot");
  const notificationCounter = document.querySelector(".dropdown-header .badge");

  // Fungsi untuk update counter notifikasi
  function updateCounter() {
    const unreadCount = document.querySelectorAll(".dropdown-notifications-item:not(.marked-as-read)").length;
    if (notificationCounter) {
      notificationCounter.textContent = `${unreadCount} New`;
      notificationCounter.classList.toggle("d-none", unreadCount === 0);
    }
    if (headerBadgeDot) {
      headerBadgeDot.classList.toggle("d-none", unreadCount === 0);
    }
  }

  // Mark all as read
  if (markAllBtn) {
    markAllBtn.addEventListener("click", () => {
      document.querySelectorAll(".dropdown-notifications-item").forEach(item => {
        item.classList.add("marked-as-read");
        const badgeDot = item.querySelector(".badge-dot");
        if (badgeDot) badgeDot.classList.add("d-none");
      });
      
      // Update UI
      if (headerBadgeDot) headerBadgeDot.classList.add("d-none");
      updateCounter();
    });
  }

  // Mark single as read
  markSingleBtns.forEach(btn => {
    btn.addEventListener("click", (e) => {
      const item = btn.closest(".dropdown-notifications-item");
      item.classList.toggle("marked-as-read");
      
      // Toggle badge dot
      // const badgeDot = btn.querySelector(".badge-dot");
      // if (badgeDot) badgeDot.classList.toggle("d-none", item.classList.contains("marked-as-read"));
      
      // Update UI
      updateCounter();
    });
  });

  // Inisialisasi counter
  updateCounter();

  // Init helpers & misc
  // --------------------

  // Init BS Tooltip
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Accordion active class
  const accordionActiveFunction = function (e) {
    if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
      e.target.closest('.accordion-item').classList.add('active');
    } else {
      e.target.closest('.accordion-item').classList.remove('active');
    }
  };

  const accordionTriggerList = [].slice.call(document.querySelectorAll('.accordion'));
  const accordionList = accordionTriggerList.map(function (accordionTriggerEl) {
    accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
    accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
  });

  // Auto update layout based on screen size
  window.Helpers.setAutoUpdate(true);

  // Toggle Password Visibility
  window.Helpers.initPasswordToggle();

  // Speech To Text
  window.Helpers.initSpeechToText();

  // Manage menu expanded/collapsed with templateCustomizer & local storage
  //------------------------------------------------------------------

  // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
  if (window.Helpers.isSmallScreen()) {
    return;
  }

  // If current layout is vertical and current window screen is > small

  // Auto update menu collapsed/expanded based on the themeConfig
      window.Helpers.setCollapsed(true, false);
})();
// Utils
function isMacOS() {
  return /Mac|iPod|iPhone|iPad/.test(navigator.userAgent);
}
