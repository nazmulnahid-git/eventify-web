<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Us - Eventify</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!--NavBar-->
<nav id='navBar' class="navbar navbar-expand-lg navbar-light bg-white sticky-top"></nav>

<!-- Contact Form -->
<div class="container my-5">
  <h1 class="text-center mb-5">Contact Us</h1>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <form id="contactForm">
        <div class="mb-3">
          <label for="name" class="form-label">Your Name</label>
          <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Your Email</label>
          <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Your Message</label>
          <textarea class="form-control" id="message" rows="4" placeholder="Write your message here..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Send Message</button>
      </form>
    </div>
  </div>
</div>

<!-- Footer -->
<footer id="footer" class="bg-dark text-white py-5 mt-auto"></footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
