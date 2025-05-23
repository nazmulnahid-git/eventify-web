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

const navSection = document.getElementById('navBar');
const currentPage = window.location.pathname.split("/").pop();

navSection.innerHTML = `
  <div class="container">
    <a class="navbar-brand" href="index.php">Eventify</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link ${currentPage === 'index.php' ? 'active' : ''}" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link ${currentPage === 'about.php' ? 'active' : ''}" href="about.php">About Us</a></li>
        <li class="nav-item"><a class="nav-link ${currentPage === 'services.php' ? 'active' : ''}" href="services.php">Services</a></li>
        <li class="nav-item"><a class="nav-link ${currentPage === 'contact.php' ? 'active' : ''}" href="contact.php">Contact</a></li>
        <li class="nav-item"><a class="nav-link btn btn-outline-primary ms-2 px-3" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link btn btn-primary text-white ms-2 px-3" href="register.php">Register</a></li>
      </ul>
    </div>
  </div>
`;

const footerSection = document.getElementById('footer');
footerSection.innerHTML = `
<div class="container">
    <div class="row">
      <div class="col-lg-4 mb-4 mb-lg-0">
        <h5 class="mb-3">About Eventify</h5>
        <p>We are passionate about creating unforgettable events. With our expertise and creativity, we transform your vision into reality.</p>
        <div class="d-flex gap-3 mt-3">
          <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
          <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
          <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
      <div class="col-lg-4 mb-4 mb-lg-0">
        <h5 class="mb-3">Quick Links</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="index.php" class="text-white text-decoration-none">Home</a></li>
          <li class="mb-2"><a href="about.php" class="text-white text-decoration-none">About Us</a></li>
          <li class="mb-2"><a href="services.php" class="text-white text-decoration-none">Services</a></li>
          <li class="mb-2"><a href="contact.php" class="text-white text-decoration-none">Contact</a></li>
          <li><a href="faq.php" class="text-white text-decoration-none">FAQ</a></li>
        </ul>
      </div>
      <div class="col-lg-4">
        <h5 class="mb-3">Contact Us</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Event St, New York, NY 10001</li>
          <li class="mb-2"><i class="fas fa-phone me-2"></i> (123) 456-7890</li>
          <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@eventify.com</li>
          <li><i class="fas fa-clock me-2"></i> Mon-Fri: 9am-6pm</li>
        </ul>
      </div>
    </div>
    <hr class="my-4">
    <div class="text-center">
      <p class="mb-0">&copy; 2025 Eventify. All Rights Reserved.</p>
    </div>
  </div>
`;
