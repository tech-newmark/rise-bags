BX.ready(function () {
  const slider = document.querySelector(".examples-slider");

  console.log(slider);

  if (slider) {
    const pagination = slider.querySelector(".swiper-pagination");
    const btnNext = slider.querySelector(".swiper-button-next");
    const btnPrev = slider.querySelector(".swiper-button-prev");

    new window.Swiper(slider, {
      slidesPerView: 1,
      spaceBetween: 20,

      breakpoints: {
        580: {
          slidesPerView: 2,
        },

        800: {
          slidesPerView: 3,
        },

        1240: {
          slidesPerView: 4,
        },
      },

      navigation: {
        nextEl: btnNext ? btnNext : null,
        prevEl: btnPrev ? btnPrev : null,
      },

      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
  }
});
