<?php
include 'config.php';
require_once __DIR__ . '/crud.php';

$categories = getCategories();
$services = getServices();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'save') {
    $serviceName = trim($_POST['serviceName'] ?? '');
    $serviceDescription = trim($_POST['serviceDescription'] ?? '');
    $categoryId = isset($_POST['categoryId']) ? intval($_POST['categoryId']) : null;
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $serviceId = isset($_POST['serviceId']) ? intval($_POST['serviceId']) : null;

    if ($serviceName === '') {
      $error = 'Service name cannot be empty.';
    } elseif (!$categoryId || $categoryId <= 0) {
      $error = 'Please select a valid category.';
    } elseif ($price <= 0) {
      $error = 'Price must be greater than 0.';
    } else {
      if ($serviceId) {
        $result = updateService($serviceId, $serviceName, $serviceDescription, $categoryId, $price);
        $message = $result['success'] ? 'Service updated successfully.' : 'Failed to update service.';
      } else {
        $result = createService($serviceName, $categoryId, $price);
        $message = $result['success'] ? 'Service created successfully.' : 'Failed to create service.';
      }
    }
  } elseif ($action === 'delete') {
    $serviceId = intval($_POST['serviceId'] ?? 0);
    if ($serviceId > 0) {
      $result = deleteService($serviceId);
      $message = $result['success'] ? 'Service deleted successfully.' : 'Failed to delete service.';
    } else {
      $error = 'Invalid service ID for deletion.';
    }
  }

  // Refresh service list after changes
  $services = getServices();
}
?>

<div class="container-fluid px-4 py-4">
  <?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i>
      <?= htmlspecialchars($message) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      <?= htmlspecialchars($error) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- Header Section -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div></div>
        <button class="btn btn-lg px-4 shadow-sm" style="background-color: #ff6b6b; border-color: #ff6b6b; color: white;" onclick="openServiceModal()">
          <i class="bi bi-plus-circle me-2"></i>Add New Service
        </button>
      </div>
    </div>
  </div>

  <!-- Modern Table Card -->
  <div class="card border-0 shadow-lg">
    <div class="card-header bg-white border-bottom py-3">
      <div class="row align-items-center">
        <div class="col">
          <h5 class="mb-0 text-dark fw-semibold">Services Overview</h5>
          <small class="text-muted">Total services: <?= count($services) ?></small>
        </div>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
          <thead class="table-light">
            <tr>
              <th scope="col" class="px-4 py-3 text-uppercase text-muted fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                <div class="d-flex align-items-center">
                  #
                </div>
              </th>
              <th scope="col" class="px-4 py-3 text-uppercase text-muted fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                <div class="d-flex align-items-center">
                  <i class="bi bi-gear me-2"></i>Service Name
                </div>
              </th>
              <th scope="col" class="px-4 py-3 text-uppercase text-muted fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                <div class="d-flex align-items-center">
                  <i class="bi bi-tags me-2"></i>Category
                </div>
              </th>
              <th scope="col" class="px-4 py-3 text-uppercase text-muted fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                <div class="d-flex align-items-center">
                  <i class="bi bi-currency-dollar me-2"></i>Price
                </div>
              </th>
              <th scope="col" class="px-4 py-3 text-center text-uppercase text-muted fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                Actions
              </th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($services) > 0): ?>
              <?php foreach ($services as $index => $service): ?>
                <tr class="border-bottom">
                  <td class="px-4 py-4">
                    <span class="badge bg-light text-dark rounded-pill px-3 py-2 fw-normal">
                      <?= $index + 1 ?>
                    </span>
                  </td>
                  <td class="px-4 py-4">
                    <div class="d-flex align-items-center">
                      <div class="rounded-circle p-2 me-3" style="background-color: rgba(255, 107, 107, 0.1);">
                        <i class="bi bi-gear" style="color: #ff6b6b;"></i>
                      </div>
                      <div>
                        <h6 class="mb-0 fw-semibold text-dark"><?= htmlspecialchars($service['name']) ?></h6>
                        <?php if (!empty($service['description'])): ?>
                          <small class="text-muted"><?= htmlspecialchars(substr($service['description'], 0, 50)) ?>...</small>
                        <?php endif; ?>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-4">
                    <span class="badge bg-opacity-10 border border-opacity-25 px-3 py-2 fw-normal" style="background-color: rgba(255, 107, 107, 0.1) !important; color: #ff6b6b !important; border-color: rgba(255, 107, 107, 0.25) !important;">
                      <?= htmlspecialchars($service['category_name'] ?? 'N/A') ?>
                    </span>
                  </td>
                  <td class="px-4 py-4">
                    <span class="fw-bold text-success fs-6">
                      $<?= number_format($service['price'], 2) ?>
                    </span>
                  </td>
                  <td class="px-4 py-4 text-center">
                    <div class="btn-group" role="group">
                      <button type="button" class="btn btn-outline-warning btn-sm px-3 py-2"
                        onclick="editService(<?= $service['id'] ?>, '<?= htmlspecialchars($service['name'], ENT_QUOTES) ?>','<?= htmlspecialchars($service['description'], ENT_QUOTES) ?>',<?= $service['category_id'] ?>, <?= $service['price'] ?>)"
                        data-bs-toggle="tooltip" title="Edit Service">
                        <i class="bi bi-pencil-square me-1"></i>Edit
                      </button>
                      <form method="POST" action="" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this service?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="serviceId" value="<?= $service['id'] ?>">
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 py-2"
                          data-bs-toggle="tooltip" title="Delete Service">
                          <i class="bi bi-trash me-1"></i>Delete
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center py-5">
                  <div class="py-4">
                    <i class="bi bi-inbox display-4 text-muted mb-3"></i>
                    <h5 class="text-muted">No services found</h5>
                    <p class="text-muted mb-3">Get started by adding your first service</p>
                    <button class="btn btn-lg px-4 shadow-sm" style="background-color: #ff6b6b; border-color: #ff6b6b; color: white;" onclick="openServiceModal()">
                      <i class="bi bi-plus-circle me-2"></i>Add Service
                    </button>
                  </div>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Enhanced Service Modal -->
<div class="modal fade" id="serviceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form class="modal-content border-0 shadow-lg" method="POST" action="">
      <div class="modal-header py-3" style="background-color: #ff6b6b;">
        <div class="d-flex align-items-center">
          <i class="bi bi-gear-fill me-2 fs-5 text-white"></i>
          <h5 class="modal-title mb-0 text-white" id="serviceModalTitle">Add Service</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" name="action" value="save">
        <input type="hidden" id="serviceId" name="serviceId" value="">

        <div class="row">
          <div class="col-12 mb-3">
            <label for="serviceName" class="form-label fw-semibold text-dark">
              <i class="bi bi-gear me-2" style="color: #ff6b6b;"></i>Service Name
            </label>
            <input type="text" id="serviceName" name="serviceName"
              class="form-control form-control-lg border-2"
              placeholder="Enter service name..." required>
          </div>

          <div class="col-12 mb-3">
            <label for="servicDescription" class="form-label fw-semibold text-dark">
              <i class="bi bi-file-text me-2" style="color: #ff6b6b;"></i>Service Description
            </label>
            <textarea id="servicDescription" name="serviceDescription"
              class="form-control border-2" rows="3"
              placeholder="Describe your service..."></textarea>
          </div>

          <div class="col-md-6 mb-3">
            <label for="categoryId" class="form-label fw-semibold text-dark">
              <i class="bi bi-tags me-2" style="color: #ff6b6b;"></i>Category
            </label>
            <select id="categoryId" name="categoryId" class="form-select form-select-lg border-2" required>
              <option value="">-- Select Category --</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-6 mb-3">
            <label for="price" class="form-label fw-semibold text-dark">
              <i class="bi bi-currency-dollar me-2" style="color: #ff6b6b;"></i>Price ($)
            </label>
            <input type="number" id="price" name="price"
              class="form-control form-control-lg border-2"
              step="0.01" min="0.01" placeholder="0.00" required>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light py-3">
        <button type="submit" class="btn btn-lg px-4 me-2" style="background-color: #ff6b6b; border-color: #ff6b6b; color: white;">
          <i class="bi bi-check-circle me-2"></i>Save Service
        </button>
        <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-2"></i>Cancel
        </button>
      </div>
    </form>
  </div>
</div>