const form = document.querySelector('form');
  const messageBox = document.getElementById('message-box');
  const messageText = document.getElementById('message-text');

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    // Simulated success/failure logic for demo
    const isSuccessful = Math.random() > 0.5; // Randomly decide success or failure

    if (isSuccessful) {
      showMessage("Registration Successful", true);
    } else {
      showMessage("Registration Failed. Please try again.", false);
    }
  });

  function showMessage(message, isSuccess) {
    messageText.textContent = message;
    messageBox.classList.remove('hidden');
    messageBox.classList.remove('bg-green-600', 'bg-red-600');
    messageBox.classList.add(isSuccess ? 'bg-green-600' : 'bg-red-600');

    setTimeout(() => {
      messageBox.classList.add('hidden');
    }, 3000); // Hide after 3 seconds
  }