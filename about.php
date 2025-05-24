<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us - Eventify</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!--NavBar-->
<?php $currentPage='about.php'; require_once 'navbar.php'; ?>

<!-- About Content -->
<div class="container my-5">
  <h1 class="text-center mb-4">About Eventify</h1>
  <div class="row">
    <div class="col-md-6 mb-4">
      <img src="images/event4.jpg" class="img-fluid rounded" alt="About Eventify">
    </div>
    <div class="col-md-6">
      <p>At Eventify, we believe that every event is special and deserves to be unforgettable. With over 10 years of experience, our team of professional planners handles everything from weddings to corporate gatherings.</p>
      <p>We work closely with our clients to turn their vision into reality, ensuring flawless execution and lasting memories. Whether it's an intimate birthday party or a large-scale business conference, Eventify is your trusted partner for exceptional events.</p>
      <a href="services.php" class="btn btn-primary mt-3">Explore Our Services</a>
    </div>
  </div>
</div>

<?php require_once 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
