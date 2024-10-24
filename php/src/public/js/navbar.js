const dropdownArrow = document.getElementById("dropdown-arrow");
const dropdownMenu = document.getElementById("dropdown-menu");

dropdownArrow.addEventListener("click", () => {
  dropdownMenu.style.display =
    dropdownMenu.style.display === "none" || dropdownMenu.style.display === ""
      ? "block"
      : "none";
});

window.addEventListener("click", (e) => {
  if (!dropdownArrow.contains(e.target) && !dropdownMenu.contains(e.target)) {
    dropdownMenu.style.display = "none";
  }
});

const hamburgerMenu = document.getElementById("hamburger-menu");
const mobileDropdownMenu = document.getElementById("mobile-dropdown-menu");

hamburgerMenu.addEventListener("click", () => {
    mobileDropdownMenu.classList.toggle("show");
});

window.addEventListener("click", (e) => {
    if (!hamburgerMenu.contains(e.target) && !mobileDropdownMenu.contains(e.target)) {
        mobileDropdownMenu.classList.remove("show");
    }
});