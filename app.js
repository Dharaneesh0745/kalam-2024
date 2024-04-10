//step 1: get DOM
let nextDom = document.getElementById("nextt");
let prevDom = document.getElementById("prevv");

let carouselDom = document.querySelector(".carousell");
let SliderDom = carouselDom.querySelector(".carousell .listt");
let thumbnailBorderDom = document.querySelector(".carousell .thumbnaill");
let thumbnailItemsDom = thumbnailBorderDom.querySelectorAll(".itemm");
let timeDom = document.querySelector(".carousell .timee");

thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);
let timeRunning = 3000;
let timeAutoNext = 7000;

nextDom.onclick = function () {
  showSlider("nextt");
};

prevDom.onclick = function () {
  showSlider("prevv");
};
let runTimeOut;
let runNextAuto = setTimeout(() => {
  next.click();
}, timeAutoNext);
function showSlider(type) {
  let SliderItemsDom = SliderDom.querySelectorAll(".carousell .listt .itemm");
  let thumbnailItemsDom = document.querySelectorAll(
    ".carousell .thumbnaill .itemm"
  );

  if (type === "nextt") {
    SliderDom.appendChild(SliderItemsDom[0]);
    thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);
    carouselDom.classList.add("nextt");
  } else {
    SliderDom.prepend(SliderItemsDom[SliderItemsDom.length - 1]);
    thumbnailBorderDom.prepend(thumbnailItemsDom[thumbnailItemsDom.length - 1]);
    carouselDom.classList.add("prevv");
  }
  clearTimeout(runTimeOut);
  runTimeOut = setTimeout(() => {
    carouselDom.classList.remove("nextt");
    carouselDom.classList.remove("prevv");
  }, timeRunning);

  clearTimeout(runNextAuto);
  runNextAuto = setTimeout(() => {
    next.click();
  }, timeAutoNext);
}
