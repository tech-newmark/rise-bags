BX.ready(function () {
  const slider = document.querySelector(".examples-slider");

  console.log(slider);

  if (slider) {
    const pagination = slider.querySelector(".swiper-pagination");
    const btnNext = slider.querySelector(".swiper-button-next");
    const btnPrev = slider.querySelector(".swiper-button-prev");

    new window.Swiper(slider, {
      slidesPerView: "auto",
      spaceBetween: 20,

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
