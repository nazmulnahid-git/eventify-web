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
  if (myCarousel) {
    new bootstrap.Carousel(myCarousel, {
      interval: 5000,
      ride: 'carousel'
    });
  }
});

// Service Modal Management
document.addEventListener('DOMContentLoaded', function() {
  const serviceModalElement = document.getElementById("serviceModal");
  if (serviceModalElement) {
    // Initialize the modal after DOM is loaded
    const serviceModal = new bootstrap.Modal(serviceModalElement);
    
    // Make functions globally accessible
    window.openServiceModal = function() {
        // Reset form for new service
        document.getElementById("serviceModalTitle").innerText = "Add New Service";
        document.getElementById("serviceName").value = "";
        document.getElementById("servicDescription").value = "";
        document.getElementById("price").value = "";
        document.getElementById("categoryId").value = "";
        document.getElementById("serviceId").value = "";
        
        serviceModal.show();
    };
    
    window.editService = function(id, name, description, categoryId, price) {
        document.getElementById("serviceModalTitle").innerText = "Edit Service";
        document.getElementById("serviceName").value = name;
        document.getElementById("servicDescription").value = description;
        document.getElementById("price").value = price;
        document.getElementById("categoryId").value = categoryId;
        document.getElementById("serviceId").value = id;
        
        serviceModal.show();
    };

    window.closeServiceModal = function() {
        serviceModal.hide();
    };
  }
});

// Category Modal Management
document.addEventListener('DOMContentLoaded', function() {
  const categoryModalElement = document.getElementById("categoryModal");
  if (categoryModalElement) {
    const categoryModal = new bootstrap.Modal(categoryModalElement);

    // Make category functions globally accessible
    window.openCategoryModal = function() {
        // Reset form for new category
        document.getElementById("categoryModalTitle").innerText = "Add Category";
        document.getElementById("categoryName").value = "";
        
        // Clear the categoryId for new category
        document.getElementById("categoryId").value = "";
        
        categoryModal.show();
    };

    window.editCategory = function(categoryId, categoryName) {
        // Set form for editing
        document.getElementById("categoryModalTitle").innerText = "Edit Category";
        document.getElementById("categoryName").value = categoryName;
        
        // Set the categoryId for editing
        document.getElementById("categoryId").value = categoryId;
        
        categoryModal.show();
    };

    window.closeCategoryModal = function() {
        categoryModal.hide();
    };
  }
});