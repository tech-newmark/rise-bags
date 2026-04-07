const reviews = document.querySelectorAll(".review-card");

reviews.forEach((review) => {
  const reviewText = review.querySelector(".review-card__text");
  const button = review.querySelector(".clear-btn");

  if (
    reviewText &&
    button &&
    reviewText.clientHeight < reviewText.scrollHeight
  ) {
    button.style.display = "flex";
  }
});
