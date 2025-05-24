// Simple error removal on input
document.addEventListener('DOMContentLoaded', function() {
  const inputs = document.querySelectorAll('input');
  inputs.forEach(function(input) {
      input.addEventListener('input', function() {
          const errorDiv = this.parentNode.querySelector('.error-text');
          if (errorDiv) {
              errorDiv.remove();
          }
      });
  });
});

// Initialize carousels with custom options
document.addEventListener('DOMContentLoaded', function() {
  var myCarousel = document.getElementById('eventCarousel');
  new bootstrap.Carousel(myCarousel, {
    interval: 5000,
    ride: 'carousel'
  });
});