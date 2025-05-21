// Wait until the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {

  // Target the profile settings form
  const form = document.getElementById('profileForm');

  // Add a submit event listener to the form
  form.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form from actually submitting (for demo)

    // Simulate form submission action
    alert('Changes saved successfully!');
    
    // Optional: you can reset the form after submission
    // form.reset();
  });

});
