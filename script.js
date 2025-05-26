// Simple error removal on input
document.addEventListener("DOMContentLoaded", function () {
  const inputs = document.querySelectorAll("input");
  inputs.forEach(function (input) {
    input.addEventListener("input", function () {
      const errorDiv = this.parentNode.querySelector(".error-text");
      if (errorDiv) {
        errorDiv.remove();
      }
    });
  });
});

// Initialize carousels with custom options
document.addEventListener("DOMContentLoaded", function () {
  var myCarousel = document.getElementById("eventCarousel");
  if (myCarousel) {
    new bootstrap.Carousel(myCarousel, {
      interval: 5000,
      ride: "carousel",
    });
  }
});

// Service Modal Management
document.addEventListener("DOMContentLoaded", function () {
  const serviceModalElement = document.getElementById("serviceModal");
  if (serviceModalElement) {
    // Initialize the modal after DOM is loaded
    const serviceModal = new bootstrap.Modal(serviceModalElement);

    // Make functions globally accessible
    window.openServiceModal = function () {
      // Reset form for new service
      document.getElementById("serviceModalTitle").innerText =
        "Add New Service";
      document.getElementById("serviceName").value = "";
      document.getElementById("servicDescription").value = "";
      document.getElementById("price").value = "";
      document.getElementById("categoryId").value = "";
      document.getElementById("serviceId").value = "";

      serviceModal.show();
    };

    window.editService = function (id, name, description, categoryId, price) {
      document.getElementById("serviceModalTitle").innerText = "Edit Service";
      document.getElementById("serviceName").value = name;
      document.getElementById("servicDescription").value = description;
      document.getElementById("price").value = price;
      document.getElementById("categoryId").value = categoryId;
      document.getElementById("serviceId").value = id;

      serviceModal.show();
    };

    window.closeServiceModal = function () {
      serviceModal.hide();
    };

    document.addEventListener("DOMContentLoaded", function () {
      var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
      );
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
  }
});

// Category Modal Management
document.addEventListener("DOMContentLoaded", function () {
  const categoryModalElement = document.getElementById("categoryModal");
  if (categoryModalElement) {
    const categoryModal = new bootstrap.Modal(categoryModalElement);

    // Make category functions globally accessible
    window.openCategoryModal = function () {
      // Reset form for new category
      document.getElementById("categoryModalTitle").innerText = "Add Category";
      document.getElementById("categoryName").value = "";

      // Clear the categoryId for new category
      document.getElementById("categoryId").value = "";

      categoryModal.show();
    };

    window.editCategory = function (categoryId, categoryName) {
      // Set form for editing
      document.getElementById("categoryModalTitle").innerText = "Edit Category";
      document.getElementById("categoryName").value = categoryName;

      // Set the categoryId for editing
      document.getElementById("categoryId").value = categoryId;

      categoryModal.show();
    };

    window.closeCategoryModal = function () {
      categoryModal.hide();
    };
  }
});


// Event Modal Management
document.addEventListener("DOMContentLoaded", function () {
  const eventModalElement = document.getElementById("eventModal");
  if (eventModalElement) {
    const eventModal = new bootstrap.Modal(eventModalElement);

    // Make event functions globally accessible
    window.openEventModal = function () {
      // Reset form for new event
      document.getElementById("eventModalTitle").innerText = "Add New Event";
      document.getElementById("eventName").value = "";
      document.getElementById("eventDescription").value = "";
      document.getElementById("eventLocation").value = "";
      document.getElementById("eventDate").value = "";
      document.getElementById("price").value = "0";
      document.getElementById("categoryId").value = "";
      document.getElementById("eventId").value = "";

      eventModal.show();
    };

    window.editEvent = function (id, name, description, location, date, price, categoryId) {
      document.getElementById("eventModalTitle").innerText = "Edit Event";
      document.getElementById("eventName").value = name;
      document.getElementById("eventDescription").value = description;
      document.getElementById("eventLocation").value = location;
      
      // Format the date for datetime-local input
      const eventDate = new Date(date);
      const formattedDate = eventDate.toISOString().slice(0, 16);
      document.getElementById("eventDate").value = formattedDate;
      
      document.getElementById("price").value = price;
      document.getElementById("categoryId").value = categoryId;
      document.getElementById("eventId").value = id;

      eventModal.show();
    };

    window.closeEventModal = function () {
      eventModal.hide();
    };
  }
});