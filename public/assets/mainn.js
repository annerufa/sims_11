/**
 * Main
 */

'use strict';

let menu, 
  animate,
  isHorizontalLayout = false;
document.addEventListener('DOMContentLoaded', function () {
  // class for ios specific styles
  if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {
    document.body.classList.add('ios');
  }
});

(function () {
  // Initialize menu
  //-----------------
  const templateName = document.documentElement.getAttribute('data-template');
  const assetsPath = document.documentElement.getAttribute('data-assets-path');
  let layoutMenuEl = document.querySelectorAll('#layout-menu');
  isHorizontalLayout = document.getElementById('layout-menu')?.classList.contains('menu-horizontal');
  
  layoutMenuEl.forEach(function (element) {
    menu = new Menu(element, {
      orientation: isHorizontalLayout ? 'horizontal' : 'vertical',
      closeChildren: !!isHorizontalLayout,
      showDropdownOnHover: localStorage.getItem(`templateCustomizer-${templateName}--ShowDropdownOnHover`) ? 
        localStorage.getItem(`templateCustomizer-${templateName}--ShowDropdownOnHover`) === 'true' : 
        (window.templateCustomizer?.settings.defaultShowDropdownOnHover)
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
      
      if (config.enableMenuLocalStorage && !window.Helpers.isSmallScreen()) {
        try {
          localStorage.setItem(`templateCustomizer-${templateName}--LayoutCollapsed`, String(window.Helpers.isCollapsed()));
          const layoutsOptions = document.querySelector('.template-customizer-layouts-options');
          if (layoutsOptions) {
            const value = window.Helpers.isCollapsed() ? 'collapsed' : 'expanded';
            layoutsOptions.querySelector(`input[value="${value}"]`).click();
          }
        } catch (e) {}
      }
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
      updateCounter();
    });
  });

  // Archive notifications
  document.querySelectorAll(".dropdown-notifications-archive").forEach(btn => {
    btn.addEventListener("click", (e) => {
      btn.closest(".dropdown-notifications-item").remove();
    });
  });

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

  // Navbar dropdown scrollbar
  window.Helpers.initNavbarDropdownScrollbar();

  // Horizontal layout specific
  const horizontalMenu = document.querySelector("[data-template^='horizontal-menu']");
  if (horizontalMenu) {
    if (window.innerWidth < window.Helpers.LAYOUT_BREAKPOINT) {
      window.Helpers.setNavbarFixed("fixed");
    } else {
      window.Helpers.setNavbarFixed("");
    }
  }

  window.addEventListener("resize", function(e) {
    if (horizontalMenu) {
      if (window.innerWidth < window.Helpers.LAYOUT_BREAKPOINT) {
        window.Helpers.setNavbarFixed("fixed");
      } else {
        window.Helpers.setNavbarFixed("");
      }
      
      setTimeout(function() {
        if (window.innerWidth < window.Helpers.LAYOUT_BREAKPOINT) {
          if (document.getElementById("layout-menu") && document.getElementById("layout-menu").classList.contains("menu-horizontal")) {
            menu.switchMenu("vertical");
          }
        } else {
          if (document.getElementById("layout-menu") && document.getElementById("layout-menu").classList.contains("menu-vertical")) {
            menu.switchMenu("horizontal");
          }
        }
      }, 100);
    }
  }, true);

  // Manage menu expanded/collapsed with templateCustomizer & local storage
  if (!isHorizontalLayout && !window.Helpers.isSmallScreen()) {
    if (typeof window.templateCustomizer !== 'undefined') {
      if (window.templateCustomizer.settings.defaultMenuCollapsed) {
        window.Helpers.setCollapsed(true, false);
      } else {
        window.Helpers.setCollapsed(false, false);
      }
      
      if (window.templateCustomizer.settings.semiDark) {
        document.querySelector("#layout-menu").setAttribute("data-bs-theme", "dark");
      }
    }

    if (typeof config !== 'undefined' && config.enableMenuLocalStorage) {
      try {
        if (localStorage.getItem(`templateCustomizer-${templateName}--LayoutCollapsed`) !== null) {
          window.Helpers.setCollapsed(
            localStorage.getItem(`templateCustomizer-${templateName}--LayoutCollapsed`) === 'true', 
            false
          );
        }
      } catch (e) {}
    }
  }

  // Theme initialization
  const storedTheme = localStorage.getItem(`templateCustomizer-${templateName}--Theme`) || 
    (window.templateCustomizer?.settings?.defaultStyle ?? document.documentElement.getAttribute("data-bs-theme"));
  
  window.Helpers.switchImage(storedTheme);
  window.Helpers.setTheme(window.Helpers.getPreferredTheme());
  
  window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", () => {
    const storedTheme = window.Helpers.getStoredTheme();
    if (storedTheme !== 'light' && storedTheme !== 'dark') {
      window.Helpers.setTheme(window.Helpers.getPreferredTheme());
    }
  });

  // Initialize PerfectScrollbar for menu
  function initScrollbarWidth() {
    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
    document.body.style.setProperty("--bs-scrollbar-width", `${scrollbarWidth}px`);
  }
  
  initScrollbarWidth();
  window.addEventListener("resize", initScrollbarWidth);

  // Initialize theme switcher
  document.addEventListener("DOMContentLoaded", () => {
    window.Helpers.showActiveTheme(window.Helpers.getPreferredTheme());
    initScrollbarWidth();
    window.Helpers.initSidebarToggle();
    
    document.querySelectorAll("[data-bs-theme-value]").forEach(button => {
      button.addEventListener("click", () => {
        const themeValue = button.getAttribute("data-bs-theme-value");
        window.Helpers.setStoredTheme(templateName, themeValue);
        window.Helpers.setTheme(themeValue);
        window.Helpers.showActiveTheme(themeValue, true);
        window.Helpers.syncCustomOptions(themeValue);
        
        let effectiveTheme = themeValue;
        if (themeValue === 'system') {
          effectiveTheme = window.matchMedia("(prefers-color-scheme: dark)").matches ? 'dark' : 'light';
        }
        
        const semiDarkOption = document.querySelector(".template-customizer-semiDark");
        if (semiDarkOption) {
          if (effectiveTheme === 'dark') {
            semiDarkOption.classList.add("d-none");
          } else {
            semiDarkOption.classList.remove("d-none");
          }
        }
        
        window.Helpers.switchImage(effectiveTheme);
      });
    });
  });

  // Initialize i18n
  if (typeof i18next !== 'undefined' && typeof i18NextHttpBackend !== 'undefined') {
    i18next.use(i18NextHttpBackend).init({
      lng: window.templateCustomizer ? window.templateCustomizer.settings.lang : "en",
      debug: false,
      fallbackLng: "en",
      backend: {
        loadPath: assetsPath + "json/locales/{{lng}}.json"
      },
      returnObjects: true
    }).then(function() {
      updateTranslations();
    });
  }

  // Language dropdown
  const languageDropdown = document.getElementsByClassName("dropdown-language");
  if (languageDropdown.length) {
    const languageItems = languageDropdown[0].querySelectorAll(".dropdown-item");
    
    for (let i = 0; i < languageItems.length; i++) {
      languageItems[i].addEventListener("click", function() {
        const lang = this.getAttribute("data-language");
        const dir = this.getAttribute("data-text-direction");
        
        // Remove active class from all items
        for (const item of this.parentNode.children) {
          for (let node = item.parentElement.parentNode.firstChild; node; node = node.nextSibling) {
            if (node.nodeType === 1 && node !== node.parentElement) {
              node.querySelector(".dropdown-item").classList.remove("active");
            }
          }
        }
        
        this.classList.add("active");
        
        i18next.changeLanguage(lang, (err, t) => {
          if (window.templateCustomizer) {
            window.templateCustomizer.setLang(lang);
          }
          
          document.documentElement.setAttribute("dir", dir);
          
          if (dir === "rtl") {
            if (localStorage.getItem(`templateCustomizer-${templateName}--Rtl`) !== "true") {
              window.templateCustomizer && window.templateCustomizer.setRtl(true);
            }
          } else {
            if (localStorage.getItem(`templateCustomizer-${templateName}--Rtl`) === "true") {
              window.templateCustomizer && window.templateCustomizer.setRtl(false);
            }
          }
          
          if (err) {
            return console.log("something went wrong loading", err);
          }
          
          updateTranslations();
          window.Helpers.syncCustomOptionsRtl(dir);
        });
      });
    }
  }

  function updateTranslations() {
    const elements = document.querySelectorAll("[data-i18n]");
    const currentLangItem = document.querySelector(`.dropdown-item[data-language="${i18next.language}"]`);
    
    if (currentLangItem) {
      currentLangItem.click();
    }
    
    elements.forEach(function(element) {
      element.innerHTML = i18next.t(element.dataset.i18n);
    });
  }

  // Swipe gestures
  window.Helpers.swipeIn(".drag-target", function(e) {
    window.Helpers.setCollapsed(false);
  });
  
  window.Helpers.swipeOut("#layout-menu", function(e) {
    if (window.Helpers.isSmallScreen()) {
      window.Helpers.setCollapsed(true);
    }
  });

  // Window scroll handler
  function handleWindowScroll() {
    const layoutPage = document.querySelector(".layout-page");
    if (layoutPage) {
      if (window.scrollY > 0) {
        layoutPage.classList.add("window-scrolled");
      } else {
        layoutPage.classList.remove("window-scrolled");
      }
    }
  }
  
  setTimeout(() => {
    handleWindowScroll();
  }, 200);
  
  window.onscroll = function() {
    handleWindowScroll();
  };

  // Initialize Waves effect
  if (typeof Waves !== 'undefined') {
    Waves.init();
    Waves.attach(".btn[class*='btn-']:not(.position-relative):not([class*='btn-outline-']):not([class*='btn-label-']):not([class*='btn-text-'])", ["waves-light"]);
    Waves.attach("[class*='btn-outline-']:not(.position-relative)");
    Waves.attach("[class*='btn-label-']:not(.position-relative)");
    Waves.attach("[class*='btn-text-']:not(.position-relative)");
    Waves.attach('.pagination:not([class*="pagination-outline-"]) .page-item.active .page-link', ["waves-light"]);
    Waves.attach(".pagination .page-item .page-link");
    Waves.attach(".dropdown-menu .dropdown-item");
    Waves.attach('[data-bs-theme="light"] .list-group .list-group-item-action');
    Waves.attach('[data-bs-theme="dark"] .list-group .list-group-item-action', ["waves-light"]);
    Waves.attach(".nav-tabs:not(.nav-tabs-widget) .nav-item .nav-link");
    Waves.attach(".nav-pills .nav-item .nav-link", ["waves-light"]);
  }

//   // Initialize custom options check
//   setTimeout(function() {
//     window.Helpers.initCustomOptionCheck();
//   }, 1000);
})();

// Utils
function isMacOS() {
  return /Mac|iPod|iPhone|iPad/.test(navigator.userAgent);
}