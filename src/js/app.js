const mobileMenuBtn = document.querySelector("#mobile-menu");
const closeMenuBtn = document.querySelector("#close-menu");
const sidebar = document.querySelector(".sidebar");

if (mobileMenuBtn) {
  mobileMenuBtn.addEventListener("click", function () {
    sidebar.classList.add("show");
  });
}

if (closeMenuBtn) {
  closeMenuBtn.addEventListener("click", function () {
    sidebar.classList.add("hide");
    setTimeout(() => {
      sidebar.classList.remove("show");
      sidebar.classList.remove("hide");
    }, 500);
  });
}

// Eliminar clase mostrar en tamaño tablet
const displayWidth = document.body.clientWidth;

window.addEventListener("resize", function () {
  const displayWidth = document.body.clientWidth;
  if (displayWidth >= 768) {
    sidebar.classList.remove("show");
  }
});
