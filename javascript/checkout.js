const form = document.querySelector("#checkoutForm");
const checkoutButton = document.querySelector("#checkButton");

// Kirim data ketika tombol checkout diklik
checkoutButton.addEventListener("click", async function (e) {
  e.preventDefault();
  const formData = new FormData(form);
  const data = new URLSearchParams(formData);
  const objData = Object.fromEntries(data);

  // console.log(objData);

  //minta transaction token menggunakan ajax / fetch
  try {
    const response = await fetch("../transaction/placeOrder.php", {
      method: "POST",
      body: data,
    });
    const token = await response.text();
    window.snap.pay(token, {
      onSuccess: async function () {
        try {
          const response = await fetch("../pages/checkout.php", {
            method: "POST",
            body: data,
          });
          await response.text();
        } catch (err) {
          console.log(err.message);
        }
        alert("payment succes");
      },
    });
  } catch (err) {
    console.log(err.message);
  }
});
