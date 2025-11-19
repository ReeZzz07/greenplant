 AOS.init({
 	duration: 800,
 	easing: 'slide'
 });

(function($) {

	"use strict";

	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
			BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
			iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
			Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
			Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
			any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};


	var shouldInitParallax = document.body && document.body.dataset.enableParallax === 'true';
	if (shouldInitParallax && $.fn.stellar) {
		try {
			$(window).stellar({
	    responsive: true,
	    parallaxBackgrounds: true,
	    parallaxElements: true,
	    horizontalScrolling: false,
	    hideDistantElements: false,
	    scrollProperty: 'scroll'
	  });
		} catch (error) {
			// Suppress parallax errors when underlying DOM structure is incompatible.
		}
	}


	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	// loader
	var loader = function() {
		setTimeout(function() { 
			if($('#ftco-loader').length > 0) {
				$('#ftco-loader').removeClass('show');
			}
		}, 1);
	};
	loader();

	// Scrollax
   $.Scrollax();

	var carousel = function() {
		$('.home-slider').owlCarousel({
	    loop:true,
	    autoplay: true,
	    margin:0,
	    animateOut: 'fadeOut',
	    animateIn: 'fadeIn',
	    nav:false,
	    autoplayHoverPause: false,
	    items: 1,
	    touchDrag: true,
	    mouseDrag: true,
	    pullDrag: false,
	    freeDrag: false,
	    navText : ["<span class='ion-md-arrow-back'></span>","<span class='ion-chevron-right'></span>"],
	    responsive:{
	      0:{
	        items:1
	      },
	      600:{
	        items:1
	      },
	      1000:{
	        items:1
	      }
	    }
		});
	
	$('.carousel-testimony').owlCarousel({
		center: true,
		loop: true,
		items:1,
		margin: 30,
		stagePadding: 0,
		nav: false,
		touchDrag: true,
		mouseDrag: true,
		pullDrag: false,
		freeDrag: false,
		navText: ['<span class="ion-ios-arrow-back">', '<span class="ion-ios-arrow-forward">'],
		responsive:{
			0:{
				items: 1
			},
			600:{
				items: 1
			},
			1000:{
				items: 1
			}
		}
	});

	};
	carousel();

	$('nav .dropdown').hover(function(){
		var $this = $(this);
		// 	 timer;
		// clearTimeout(timer);
		$this.addClass('show');
		$this.find('> a').attr('aria-expanded', true);
		// $this.find('.dropdown-menu').addClass('animated-fast fadeInUp show');
		$this.find('.dropdown-menu').addClass('show');
	}, function(){
		var $this = $(this);
			// timer;
		// timer = setTimeout(function(){
			$this.removeClass('show');
			$this.find('> a').attr('aria-expanded', false);
			// $this.find('.dropdown-menu').removeClass('animated-fast fadeInUp show');
			$this.find('.dropdown-menu').removeClass('show');
		// }, 100);
	});


	$('#dropdown04').on('show.bs.dropdown', function () {
	  console.log('show');
	});

	// Раздельная логика для мобильного меню и dropdown
	// Инициализация при загрузке DOM
	(function() {
		function disableBootstrapDropdown() {
			if ($(window).width() < 992) {
				$('.navbar-collapse .dropdown-toggle').each(function() {
					var $toggle = $(this);
					// Полностью отключаем Bootstrap dropdown
					$toggle.removeAttr('data-toggle');
					$toggle.off('click.bs.dropdown');
					$toggle.off('click');
					// Удаляем все обработчики Bootstrap
					if ($toggle.data('bs.dropdown')) {
						var dropdownInstance = $toggle.data('bs.dropdown');
						if (dropdownInstance && dropdownInstance.dispose) {
							dropdownInstance.dispose();
						}
						$toggle.data('bs.dropdown', null);
					}
					// Удаляем все обработчики событий
					$toggle.off();
				});
				
				// Также отключаем обработчики на dropdown-menu
				$('.navbar-collapse .dropdown-menu').each(function() {
					var $menu = $(this);
					$menu.off('click.bs.dropdown');
				});
			}
		}
		
		// Отключаем сразу при загрузке
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', disableBootstrapDropdown);
		} else {
			disableBootstrapDropdown();
		}
		
		// Также отключаем при готовности jQuery
		$(document).ready(function() {
			disableBootstrapDropdown();
			// Повторно отключаем после небольшой задержки, чтобы убедиться, что Bootstrap инициализировался
			setTimeout(disableBootstrapDropdown, 100);
		});
		
		// При изменении размера окна
		$(window).on('resize', function() {
			if ($(window).width() < 992) {
				disableBootstrapDropdown();
			} else {
				// Восстанавливаем на десктопе
				$('.navbar-collapse .dropdown-toggle').each(function() {
					$(this).attr('data-toggle', 'dropdown');
				});
			}
		});
	})();
	
	// ЛОГИКА ОТКРЫТИЯ/ЗАКРЫТИЯ DROPDOWN (независимо от navbar-collapse)
	var lastDropdownElement = null;
	var isProcessingDropdown = false;
	var touchStartTime = 0;
	var lastTouchedToggle = null;
	
	// Единая функция для обработки открытия/закрытия dropdown
	function toggleMobileDropdown(e, $dropdownToggle) {
		if (window.innerWidth >= 992) return;
		
		isProcessingDropdown = true;
		
		var $dropdown = $dropdownToggle.closest('.dropdown');
		var $menu = $dropdown.find('.dropdown-menu');
		var isExpanded = $dropdown.hasClass('show') || $menu.hasClass('show');
		
		// Переключаем состояние dropdown
		if (isExpanded) {
			// Закрываем dropdown
			$dropdown.removeClass('show');
			$menu.removeClass('show');
			$dropdownToggle.attr('aria-expanded', 'false');
			lastDropdownElement = null;
		} else {
			// Закрываем другие открытые dropdown
			$('.navbar-collapse .dropdown').not($dropdown).removeClass('show');
			$('.navbar-collapse .dropdown-menu').not($dropdown.find('.dropdown-menu')).removeClass('show');
			$('.navbar-collapse .dropdown-toggle').not($dropdownToggle[0]).attr('aria-expanded', 'false');
			
			// Открываем текущий dropdown
			$dropdown.addClass('show');
			$menu.addClass('show');
			$dropdownToggle.attr('aria-expanded', 'true');
			lastDropdownElement = $dropdown[0];
		}
		
		// Сбрасываем флаг через небольшую задержку
		setTimeout(function() {
			isProcessingDropdown = false;
		}, 300);
	}
	
	// Обработчик touchstart для мобильных устройств
	document.addEventListener('touchstart', function(e) {
		if (window.innerWidth < 992) {
			var $target = $(e.target);
			var $dropdownToggle = $target.closest('.navbar-collapse .dropdown-toggle');
			
			if ($dropdownToggle.length) {
				e.preventDefault();
				e.stopPropagation();
				e.stopImmediatePropagation();
				
				touchStartTime = Date.now();
				lastTouchedToggle = $dropdownToggle[0];
				
				toggleMobileDropdown(e, $dropdownToggle);
				
				return false;
			}
		}
	}, true);
	
	// Обработчик click - блокируем все события Bootstrap
	document.addEventListener('click', function(e) {
		if (window.innerWidth < 992) {
			var $target = $(e.target);
			var $dropdownToggle = $target.closest('.navbar-collapse .dropdown-toggle');
			var $clickedDropdown = $target.closest('.navbar-collapse .dropdown');
			var $clickedMenu = $target.closest('.navbar-collapse .dropdown-menu');
			var $dropdownItem = $target.closest('.navbar-collapse .dropdown-item');
			
			// Если клик был на ссылку внутри dropdown, разрешаем навигацию
			if ($dropdownItem.length) {
				// Закрываем dropdown после клика на ссылку
				var $dropdown = $dropdownItem.closest('.dropdown');
				if ($dropdown.length) {
					$dropdown.removeClass('show');
					$dropdown.find('.dropdown-menu').removeClass('show');
					$dropdown.find('.dropdown-toggle').attr('aria-expanded', 'false');
					lastDropdownElement = null;
				}
				// Разрешаем событию пройти для навигации
				return;
			}
			
			// Если это тот же toggle, который был обработан через touchstart, блокируем click
			if (lastTouchedToggle && $dropdownToggle.length && $dropdownToggle[0] === lastTouchedToggle) {
				var timeSinceTouch = Date.now() - touchStartTime;
				// Если прошло меньше 500мс после touchstart, блокируем click
				if (timeSinceTouch < 500) {
					e.preventDefault();
					e.stopPropagation();
					e.stopImmediatePropagation();
					return false;
				}
			}
			
			// Если клик был внутри открытого dropdown (но не на toggle и не на ссылку), не закрываем его
			if (lastDropdownElement && $clickedDropdown.length && $clickedDropdown[0] === lastDropdownElement && !$dropdownToggle.length && !$dropdownItem.length) {
				e.preventDefault();
				e.stopPropagation();
				e.stopImmediatePropagation();
				return false;
			}
			
			// Если клик был на dropdown-menu (но не на ссылку), блокируем все события
			if ($clickedMenu.length && !$dropdownItem.length) {
				e.preventDefault();
				e.stopPropagation();
				e.stopImmediatePropagation();
				return false;
			}
			
			// Если клик был на toggle
			if ($dropdownToggle.length) {
				e.preventDefault();
				e.stopPropagation();
				e.stopImmediatePropagation();
				
				// Если dropdown еще обрабатывается, не делаем ничего
				if (isProcessingDropdown) {
					return false;
				}
				
				// Если это тот же toggle, который был обработан через touchstart, не обрабатываем
				if (lastTouchedToggle && $dropdownToggle[0] === lastTouchedToggle) {
					var timeSinceTouch = Date.now() - touchStartTime;
					if (timeSinceTouch < 500) {
						return false;
					}
				}
				
				toggleMobileDropdown(e, $dropdownToggle);
				
				return false;
			}
		}
	}, true);
	
	// Блокируем все события Bootstrap dropdown на мобильных
	// Отключаем до инициализации Bootstrap
	$(document).ready(function() {
		if ($(window).width() < 992) {
			$(document).off('click.bs.dropdown.data-api', '.navbar-collapse .dropdown-toggle');
			$(document).off('click.bs.dropdown.data-api');
			
			// Также отключаем через делегирование
			$('.navbar-collapse').off('click.bs.dropdown.data-api', '.dropdown-toggle');
		}
	});
	
	// Отключаем сразу, если DOM уже загружен
	if (document.readyState !== 'loading') {
		$(document).off('click.bs.dropdown.data-api', '.navbar-collapse .dropdown-toggle');
		$(document).off('click.bs.dropdown.data-api');
		$('.navbar-collapse').off('click.bs.dropdown.data-api', '.dropdown-toggle');
	}
	
	// Предотвращаем закрытие dropdown при клике внутри него (но не на ссылках)
	$(document).on('click', '.navbar-collapse .dropdown-menu', function(e) {
		if ($(window).width() < 992) {
			var $target = $(e.target);
			var $dropdownItem = $target.closest('.dropdown-item');
			
			// Если клик был на ссылку, разрешаем навигацию
			if ($dropdownItem.length) {
				// Закрываем dropdown, но разрешаем событию пройти
				var $dropdown = $(this).closest('.dropdown');
				$dropdown.removeClass('show');
				$dropdown.find('.dropdown-menu').removeClass('show');
				$dropdown.find('.dropdown-toggle').attr('aria-expanded', 'false');
				lastDropdownElement = null;
				// Не блокируем событие, чтобы ссылка сработала
				return;
			}
			
			// Если клик был не на ссылку, блокируем событие
			e.preventDefault();
			e.stopPropagation();
			e.stopImmediatePropagation();
			return false;
		}
	});

	// Закрытие dropdown при клике на dropdown-item (дублируем логику для надежности)
	$(document).on('click', '.navbar-collapse .dropdown-item', function(e) {
		if ($(window).width() < 992) {
			// Закрываем только dropdown, но разрешаем навигацию
			var $dropdown = $(this).closest('.dropdown');
			$dropdown.removeClass('show');
			$dropdown.find('.dropdown-menu').removeClass('show');
			$dropdown.find('.dropdown-toggle').attr('aria-expanded', 'false');
			lastDropdownElement = null;
			// Не блокируем событие, чтобы ссылка сработала
		}
	});
	
	// ЛОГИКА ОТКРЫТИЯ/ЗАКРЫТИЯ NAVBAR-COLLAPSE (независимо от dropdown)
	// Перехватываем событие закрытия navbar-collapse
	var lastClickedElement = null;
	
	// Сохраняем последний кликнутый элемент
	$(document).on('mousedown touchstart', '.navbar-collapse .dropdown-toggle, .navbar-collapse .dropdown-menu', function(e) {
		if ($(window).width() < 992) {
			lastClickedElement = e.target;
		}
	});
	
	// Перехватываем событие закрытия navbar-collapse
	$('#ftco-nav').on('hide.bs.collapse', function(e) {
		if ($(window).width() < 992) {
			// Проверяем, был ли клик на dropdown toggle или внутри dropdown
			var $clickedElement = lastClickedElement ? $(lastClickedElement) : $(document.activeElement);
			
			if ($clickedElement.closest('.navbar-collapse .dropdown-toggle').length || 
			    $clickedElement.closest('.navbar-collapse .dropdown-menu').length ||
			    $clickedElement.hasClass('dropdown-toggle') ||
			    $clickedElement.closest('.dropdown').length) {
				e.preventDefault();
				e.stopPropagation();
				e.stopImmediatePropagation();
				lastClickedElement = null;
				return false;
			}
			lastClickedElement = null;
		}
	});
	
	// Предотвращаем закрытие navbar-collapse при клике на dropdown элементы
	$(document).on('click', '.navbar-collapse .dropdown, .navbar-collapse .dropdown-menu', function(e) {
		if ($(window).width() < 992) {
			// Если это не клик на dropdown-item, предотвращаем закрытие меню
			if (!$(e.target).closest('.dropdown-item').length && !$(e.target).hasClass('dropdown-item')) {
				e.stopPropagation();
				e.stopImmediatePropagation();
			}
		}
	});

	// scroll
	var scrollWindow = function() {
		var ticking = false;
		
		function updateOnScroll() {
			var st = window.pageYOffset || document.documentElement.scrollTop || 0;
			var navbar = $('.ftco_navbar');
			var sd = $('.js-scroll-wrap');

			if (st > 150) {
				if ( !navbar.hasClass('scrolled') ) {
					navbar.addClass('scrolled');	
				}
			} 
			if (st < 150) {
				if ( navbar.hasClass('scrolled') ) {
					navbar.removeClass('scrolled sleep');
				}
			} 
			if ( st > 350 ) {
				if ( !navbar.hasClass('awake') ) {
					navbar.addClass('awake');	
				}
				
				if(sd.length > 0) {
					sd.addClass('sleep');
				}
			}
			if ( st < 350 ) {
				if ( navbar.hasClass('awake') ) {
					navbar.removeClass('awake');
					navbar.addClass('sleep');
				}
				if(sd.length > 0) {
					sd.removeClass('sleep');
				}
			}
			
			ticking = false;
		}
		
		// Используем requestAnimationFrame для оптимизации
		$(window).on('scroll', function(){
			if (!ticking) {
				window.requestAnimationFrame(updateOnScroll);
				ticking = true;
			}
		});
	};
	scrollWindow();

	
	var counter = function() {
		
		$('#section-counter').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {

				var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
				$('.number').each(function(){
					var $this = $(this),
						num = $this.data('number');
						console.log(num);
					$this.animateNumber(
					  {
					    number: num,
					    numberStep: comma_separator_number_step
					  }, 7000
					);
				});
				
			}

		} , { offset: '95%' } );

	}
	counter();

	var contentWayPoint = function() {
		var i = 0;
		$('.ftco-animate').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {
				
				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function(){

					$('body .ftco-animate.item-animate').each(function(k){
						var el = $(this);
						setTimeout( function () {
							var effect = el.data('animate-effect');
							if ( effect === 'fadeIn') {
								el.addClass('fadeIn ftco-animated');
							} else if ( effect === 'fadeInLeft') {
								el.addClass('fadeInLeft ftco-animated');
							} else if ( effect === 'fadeInRight') {
								el.addClass('fadeInRight ftco-animated');
							} else {
								el.addClass('fadeInUp ftco-animated');
							}
							el.removeClass('item-animate');
						},  k * 50, 'easeInOutExpo' );
					});
					
				}, 100);
				
			}

		} , { offset: '95%' } );
	};
	contentWayPoint();


	// navigation
	var OnePageNav = function() {
		$(".smoothscroll[href^='#'], #ftco-nav ul li a[href^='#']").on('click', function(e) {
		 	e.preventDefault();

		 	var hash = this.hash,
		 			navToggler = $('.navbar-toggler'),
		 			$target = $(hash);
		 	
		 	// Проверяем, существует ли элемент с таким hash
		 	if ($target.length && $target.offset()) {
		 		$('html, body').animate({
		    		scrollTop: $target.offset().top
		  		}, 700, 'easeInOutExpo', function(){
		    		window.location.hash = hash;
		  		});
		 	}


		  if ( navToggler.is(':visible') ) {
		  	navToggler.click();
		  }
		});
		$('body').on('activate.bs.scrollspy', function () {
		  console.log('nice');
		})
	};
	OnePageNav();


	// magnific popup
	$('.image-popup').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    closeBtnInside: false,
    fixedContentPos: true,
    mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
     gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0,1] // Will preload 0 - before current, and 1 after the current image
    },
    image: {
      verticalFit: true
    },
    zoom: {
      enabled: true,
      duration: 300 // don't foget to change the duration also in CSS
    }
  });

  $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
    disableOn: 700,
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: false,

    fixedContentPos: false
  });



	var goHere = function() {

		$('.mouse-icon').on('click', function(event){
			
			event.preventDefault();

			$('html,body').animate({
				scrollTop: $('.goto-here').offset().top
			}, 500, 'easeInOutExpo');
			
			return false;
		});
	};
	goHere();

	function makeTimer() {

		var endTime = new Date("21 December 2019 9:56:00 GMT+01:00");			
		endTime = (Date.parse(endTime) / 1000);

		var now = new Date();
		now = (Date.parse(now) / 1000);

		var timeLeft = endTime - now;

		var days = Math.floor(timeLeft / 86400); 
		var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
		var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
		var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

		if (hours < "10") { hours = "0" + hours; }
		if (minutes < "10") { minutes = "0" + minutes; }
		if (seconds < "10") { seconds = "0" + seconds; }

		$("#days").html(days + "<span>Days</span>");
		$("#hours").html(hours + "<span>Hours</span>");
		$("#minutes").html(minutes + "<span>Minutes</span>");
		$("#seconds").html(seconds + "<span>Seconds</span>");		

}

setInterval(function() { makeTimer(); }, 1000);

	// Исправление для мобильных устройств: разрешаем вертикальную прокрутку на слайдере
$(document).ready(function() {
	var touchStartX = 0;
	var touchStartY = 0;
	var touchEndX = 0;
	var touchEndY = 0;
	var isSwiping = false;
	
	// Обработчик для всех слайдеров
	$('.home-slider, .carousel-testimony, .owl-carousel').each(function() {
		var $slider = $(this);
		var sliderEl = $slider[0];
		
		// Используем нативный addEventListener с passive: true для touchstart
		if (sliderEl) {
			sliderEl.addEventListener('touchstart', function(e) {
				touchStartX = e.touches[0].clientX;
				touchStartY = e.touches[0].clientY;
				isSwiping = false;
			}, { passive: true });
			
			// touchmove должен быть non-passive, если мы хотим предотвратить прокрутку при горизонтальном свайпе
			sliderEl.addEventListener('touchmove', function(e) {
				if (!e.touches || e.touches.length === 0) return;
				
				touchEndX = e.touches[0].clientX;
				touchEndY = e.touches[0].clientY;
				
				var deltaX = Math.abs(touchEndX - touchStartX);
				var deltaY = Math.abs(touchEndY - touchStartY);
				
				// Определяем направление свайпа
				// Если вертикальное движение больше горизонтального на 30%
				if (deltaY > deltaX * 1.3 && deltaY > 10) {
					// Это вертикальная прокрутка - не блокируем
					isSwiping = false;
				} else if (deltaX > deltaY * 1.3 && deltaX > 10) {
					// Это горизонтальный свайп - для слайдера
					isSwiping = true;
					// Блокируем прокрутку страницы при горизонтальном свайпе
					e.preventDefault();
				}
			}, { passive: false });
			
			sliderEl.addEventListener('touchend', function() {
				isSwiping = false;
			}, { passive: true });
		}
	});
});


})(jQuery);

