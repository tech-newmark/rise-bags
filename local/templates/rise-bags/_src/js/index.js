import "./modules/custom-select-instance";
import "./modules/fancybox-instance";
import "./modules/imask-instance";
import "./modules/swiper-instance";
import "./modules/accordeon";
import "./modules/bx-popup";
import "./modules/search-open";

const sliders = document.querySelectorAll(".product-item-slider");
console.log("sliders:", sliders);
if (sliders) {
	sliders.forEach((slider) => {
		const pagination = slider.querySelector(".swiper-pagination");

		console.log("pagination:", pagination);
	});
}
