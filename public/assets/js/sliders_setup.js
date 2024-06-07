    var swiper = new Swiper(".mainSlider", {
    spaceBetween: 15,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
        renderBullet: function (index, className) {
          return '<span class="' + className + '">' + (index + 1) + "</span>";
        },
      },
    });
    var swiper = new Swiper(".trendSlider", {
      spaceBetween: 5,
      slidesPerView: 1,
      breakpoints: {
        500: {
          slidesPerView: 2
        },
        767: {
          slidesPerView: 3
        },
        992: {
          slidesPerView: 4
        },
        1199: {
          slidesPerView: 5
        },
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
    var swiper = new Swiper(".borsaSlider", {
      spaceBetween: 20,
      slidesPerView: 1,
      breakpoints: {
        500: {
          slidesPerView: 2
        },
        767: {
          slidesPerView: 3
        },
        992: {
          slidesPerView: 4
        },
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
