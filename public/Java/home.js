let nums = document.querySelectorAll(".client-Feautres .num");
let section = document.querySelector(".client");
let started = false;

window.onscroll = function () {
  if (window.scrollY + window.innerHeight >= section.offsetTop) {
    if (!started) {
      nums.forEach((num) => startCount(num));
    }
    started = true;
  }
};
function startCount(el) {
  let goal = el.dataset.goal;
  let count = setInterval(() => {
    el.textContent++;
    if (el.textContent == goal) {
      clearInterval(count);
    }
  }, 1000 / goal);
}
