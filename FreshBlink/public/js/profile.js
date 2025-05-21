document.addEventListener("DOMContentLoaded", () => {
  const editBtn = document.getElementById("editBtn");
  const changePasswordBtn = document.getElementById("changePasswordBtn");
  const slideBtnRight = document.getElementById("slideBtnRight");
  const slideBtnLeft = document.getElementById("slideBtnLeft");
  const ordersContainer = document.getElementById("ordersContainer");

  if (editBtn) {
    editBtn.addEventListener("click", () => {
      alert("Edit account info clicked.");
    });
  }

  if (changePasswordBtn) {
    changePasswordBtn.addEventListener("click", () => {
      alert("Change password clicked.");
    });
  }

  // Slide right on mobile for Recent Orders
  if (slideBtnRight && ordersContainer) {
    slideBtnRight.addEventListener("click", () => {
      ordersContainer.scrollBy({ left: 300, behavior: "smooth" });
    });
  }

  // Slide left on mobile for Recent Orders
  if (slideBtnLeft && ordersContainer) {
    slideBtnLeft.addEventListener("click", () => {
      ordersContainer.scrollBy({ left: -300, behavior: "smooth" });
    });
  }
});
