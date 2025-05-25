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

<div class="m-5">
    <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" onclick="openServiceModal()">Add New Service</button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Service Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($services) > 0): ?>
                            <?php foreach ($services as $index => $service): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($service['name']) ?></td>
                                    <td><?= htmlspecialchars($service['category_name'] ?? 'N/A') ?></td>
                                    <td>$<?= number_format($service['price'], 2) ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" 
                                                onclick="editService(<?= $service['id'] ?>, '<?= htmlspecialchars($service['name'], ENT_QUOTES) ?>','<?= htmlspecialchars($service['description'], ENT_QUOTES) ?>',<?= $service['category_id'] ?>, <?= $service['price'] ?>)">
                                            Edit
                                        </button>
                                        <form method="POST" action="" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this service?')">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="serviceId" value="<?= $service['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No services found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Service Modal -->
<div class="modal fade" id="serviceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalTitle">Add Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="action" value="save">
                <input type="hidden" id="serviceId" name="serviceId" value="">
                
                <div class="mb-3">
                    <label for="serviceName" class="form-label">Service Name</label>
                    <input type="text" id="serviceName" name="serviceName" class="form-control" required>
                </div>
                
                <!-- Fixed: Removed duplicate label, changed to textarea, fixed ID -->
                <div class="mb-3">
                    <label for="servicDescription" class="form-label">Service Description</label>
                    <textarea id="servicDescription" name="serviceDescription" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="categoryId" class="form-label">Category</label>
                    <select id="categoryId" name="categoryId" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="price" class="form-label">Price ($)</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" min="0.01" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>