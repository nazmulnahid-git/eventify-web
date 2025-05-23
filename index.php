<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Eventify - Home</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="d-flex flex-column min-vh-100">

<!--NavBar-->
<nav id='navBar' class="navbar navbar-expand-lg navbar-light bg-white sticky-top"></nav>

<!-- Header -->
<header class="hero-header text-white d-flex align-items-center">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 text-lg-start text-center">
        <h1 class="display-4 fw-bold mb-3">Transform Your Events with Eventify</h1>
        <p class="lead mb-4">We create unforgettable experiences. Your perfect event planning partner for weddings, corporate events, and special occasions.</p>
        <div class="d-flex gap-3 justify-content-lg-start justify-content-center">
          <a href="services.php" class="btn btn-primary btn-lg shadow">Our Services</a>
          <a href="contact.php" class="btn btn-outline-light btn-lg">Get in Touch</a>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Carousel Section - Improved -->
<div id="eventCarousel" class="carousel slide" data-bs-ride="carousel">
  <!-- Indicators -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="2"></button>
  </div>
  
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/event1.jpg" class="d-block w-100" alt="Wedding Event">
      <div class="carousel-caption">
        <h5>Elegant Weddings</h5>
        <p>We craft personalized and magical wedding celebrations that reflect your unique love story.</p>
        <a href="services.php#weddings" class="btn btn-primary">Learn More</a>
      </div>
    </div>
    
    <div class="carousel-item">
      <img src="images/event2.jpg" class="d-block w-100" alt="Corporate Event">
      <div class="carousel-caption">
        <h5>Corporate Excellence</h5>
        <p>Elevate your business gatherings with our professional planning and execution services.</p>
        <a href="services.php#corporate" class="btn btn-primary">Learn More</a>
      </div>
    </div>
    
    <div class="carousel-item">
      <img src="images/event3.jpg" class="d-block w-100" alt="Concert Event">
      <div class="carousel-caption">
        <h5>Spectacular Celebrations</h5>
        <p>From concerts to festivals, we create electrifying experiences that leave lasting memories.</p>
        <a href="services.php#special" class="btn btn-primary">Learn More</a>
      </div>
    </div>
  </div>
  
  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- Stats Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row text-center">
      <div class="col-md-3 col-6 mb-4 mb-md-0">
        <div class="counter-box">
          <div class="counter-number">500+</div>
          <div class="counter-label">Events Completed</div>
        </div>
      </div>
      <div class="col-md-3 col-6 mb-4 mb-md-0">
        <div class="counter-box">
          <div class="counter-number">100%</div>
          <div class="counter-label">Client Satisfaction</div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="counter-box">
          <div class="counter-number">50+</div>
          <div class="counter-label">Venues Partnered</div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="counter-box">
          <div class="counter-number">10+</div>
          <div class="counter-label">Years Experience</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Upcoming Events Section -->
<section class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h2 class="section-title mb-4">Upcoming Events</h2>
        
        <!-- Event 1 -->
        <div class="card mb-4">
          <div class="card-body">
            <div class="row g-0 align-items-center">
              <div class="col-md-2 text-center mb-3 mb-md-0">
                <div class="event-date mx-auto">
                  <span class="month">May</span>
                  <span class="day">12</span>
                </div>
              </div>
              <div class="col-md-7 mb-3 mb-md-0">
                <h4 class="mb-1">Summer Music Festival</h4>
                <p class="text-muted mb-2"><i class="fas fa-map-marker-alt me-2"></i>Central Park, New York</p>
                <p class="mb-0">A day of amazing music performances, food, and fun activities for all ages.</p>
              </div>
              <div class="col-md-3 text-md-end text-center">
                <a href="#" class="btn btn-outline-primary">Register</a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Event 2 -->
        <div class="card mb-4">
          <div class="card-body">
            <div class="row g-0 align-items-center">
              <div class="col-md-2 text-center mb-3 mb-md-0">
                <div class="event-date mx-auto">
                  <span class="month">Jun</span>
                  <span class="day">08</span>
                </div>
              </div>
              <div class="col-md-7 mb-3 mb-md-0">
                <h4 class="mb-1">Business Leadership Conference</h4>
                <p class="text-muted mb-2"><i class="fas fa-map-marker-alt me-2"></i>Grand Hotel, Chicago</p>
                <p class="mb-0">Connect with industry leaders and gain insights on the future of business.</p>
              </div>
              <div class="col-md-3 text-md-end text-center">
                <a href="#" class="btn btn-outline-primary">Register</a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Event 3 -->
        <div class="card">
          <div class="card-body">
            <div class="row g-0 align-items-center">
              <div class="col-md-2 text-center mb-3 mb-md-0">
                <div class="event-date mx-auto">
                  <span class="month">Jul</span>
                  <span class="day">22</span>
                </div>
              </div>
              <div class="col-md-7 mb-3 mb-md-0">
                <h4 class="mb-1">Food & Wine Festival</h4>
                <p class="text-muted mb-2"><i class="fas fa-map-marker-alt me-2"></i>Riverside Gardens, Boston</p>
                <p class="mb-0">Experience the finest culinary creations and wine pairings from top chefs.</p>
              </div>
              <div class="col-md-3 text-md-end text-center">
                <a href="#" class="btn btn-outline-primary">Register</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Sidebar -->
      <div class="col-lg-4 mt-5 mt-lg-0">
        <div class="card">
          <div class="card-body">
            <h4 class="mb-4">Event Categories</h4>
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Weddings
                <span class="badge bg-primary rounded-pill">15</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Corporate Events
                <span class="badge bg-primary rounded-pill">12</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Birthday Parties
                <span class="badge bg-primary rounded-pill">9</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Workshops & Seminars
                <span class="badge bg-primary rounded-pill">8</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Music & Entertainment
                <span class="badge bg-primary rounded-pill">10</span>
              </li>
            </ul>
          </div>
        </div>
        
        <!-- Newsletter -->
        <div class="card mt-4">
          <div class="card-body">
            <h4 class="mb-3">Subscribe to Our Newsletter</h4>
            <p class="text-muted mb-4">Stay updated with our latest events and offers.</p>
            <form>
              <div class="mb-3">
                <input type="email" class="form-control" placeholder="Your Email Address">
              </div>
              <button type="submit" class="btn btn-primary w-100">Subscribe Now</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="display-5 fw-bold">What Our Clients Say</h2>
      <p class="lead text-muted">Hear from those who experienced our services</p>
    </div>
    
    <div class="row">
      <!-- Testimonial 1 -->
      <div class="col-md-4 mb-4 mb-md-0">
        <div class="testimonial h-100">
          <div class="d-flex align-items-center mb-4">
            <img src="images/client1.jpg" class="testimonial-image me-3" alt="Client">
            <div>
              <h5 class="mb-0">Sarah Johnson</h5>
              <small class="text-muted">Wedding Client</small>
            </div>
          </div>
          <p class="mb-0">"Eventify made our wedding day absolutely perfect! Their attention to detail and personalized approach exceeded all our expectations."</p>
        </div>
      </div>
      
      <!-- Testimonial 2 -->
      <div class="col-md-4 mb-4 mb-md-0">
        <div class="testimonial h-100">
          <div class="d-flex align-items-center mb-4">
            <img src="images/client3.jpg" class="testimonial-image me-3" alt="Client">
            <div>
              <h5 class="mb-0">Michael Brown</h5>
              <small class="text-muted">Corporate Client</small>
            </div>
          </div>
          <p class="mb-0">"Our annual conference was flawlessly executed thanks to the Eventify team. Professional, responsive, and creative from start to finish."</p>
        </div>
      </div>
      
      <!-- Testimonial 3 -->
      <div class="col-md-4">
        <div class="testimonial h-100">
          <div class="d-flex align-items-center mb-4">
            <img src="images/client2.jpg" class="testimonial-image me-3" alt="Client">
            <div>
              <h5 class="mb-0">Emily Davis</h5>
              <small class="text-muted">Birthday Client</small>
            </div>
          </div>
          <p class="mb-0">"My daughter's sweet sixteen party was a huge success! Eventify created a magical experience that she and her friends will never forget."</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Call to Action Section -->
<section class="cta-section text-center">
  <div class="container">
    <h2 class="display-5 fw-bold mb-4">Ready to Plan Your Next Event?</h2>
    <p class="lead mb-4">Contact us today and let's create something unforgettable together.</p>
    <a href="contact.php" class="btn btn-light btn-lg">Get Started</a>
  </div>
</section>

<!-- Footer -->
<footer id="footer" class="bg-dark text-white py-5 mt-auto"></footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>