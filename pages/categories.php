<?php
include 'config.php';
require_once __DIR__ . '/crud.php';

$categories = getCategories();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'save') {
    $categoryName = trim($_POST['categoryName'] ?? '');
    $categoryId = isset($_POST['categoryId']) ? intval($_POST['categoryId']) : null;

    if ($categoryName === '') {
      $error = 'Category name cannot be empty.';
    } else {
      if ($categoryId) {
        $result = updateCategory($categoryId, $categoryName);
        $message = $result['success'] ? 'Category updated successfully.' : 'Failed to update category.';
      } else {
        $result = createCategory($categoryName);
        $message = $result['success'] ? 'Category created successfully.' : 'Failed to create category.';
      }
    }
  } elseif ($action === 'delete') {
    $categoryId = intval($_POST['categoryId'] ?? 0);
    if ($categoryId > 0) {
      $result = deleteCategory($categoryId);
      $message = $result['success'] ? 'Category deleted successfully.' : 'Failed to delete category.';
    } else {
      $error = 'Invalid category ID for deletion.';
    }
  }

  // Refresh category list after changes
  $categories = getCategories();
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
        <div>
        </div>
        <button class="btn btn-lg px-4 shadow-sm" style="background-color: #ff6b6b; border-color: #ff6b6b; color: white;" onclick="openCategoryModal()">
          <i class="bi bi-plus-circle me-2"></i>Add New Category
        </button>
      </div>
    </div>
  </div>

  <!-- Modern Table Card -->
  <div class="card border-0 shadow-lg">
    <div class="card-header bg-white border-bottom py-3">
      <div class="row align-items-center">
        <div class="col">
          <h5 class="mb-0 text-dark fw-semibold">Categories Overview</h5>
          <small class="text-muted">Total categories: <?= count($categories) ?></small>
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
                  Category Name
                </div>
              </th>
              <th scope="col" class="px-4 py-3 text-center text-uppercase text-muted fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                Actions
              </th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($categories) > 0): ?>
              <?php foreach ($categories as $index => $cat): ?>
                <tr class="border-bottom">
                  <td class="px-4 py-4">
                    <span class="badge bg-light text-dark rounded-pill px-3 py-2 fw-normal">
                      <?= $index + 1 ?>
                    </span>
                  </td>
                  <td class="px-4 py-4">
                    <div class="d-flex align-items-center">
                      <div>
                        <h6 class="mb-0 fw-semibold text-dark"><?= htmlspecialchars($cat['name']) ?></h6>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-4 text-center">
                    <div class="btn-group" role="group">
                      <button type="button" class="btn btn-outline-warning btn-sm px-3 py-2"
                        onclick="editCategory(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['name'], ENT_QUOTES) ?>')"
                        data-bs-toggle="tooltip" title="Edit Category">
                        <i class="bi bi-pencil-square me-1"></i>Edit
                      </button>
                      <form method="POST" action="" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this category?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="categoryId" value="<?= $cat['id'] ?>">
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 py-2"
                          data-bs-toggle="tooltip" title="Delete Category">
                          <i class="bi bi-trash me-1"></i>Delete
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="3" class="text-center py-5">
                  <div class="py-4">
                    <i class="bi bi-inbox display-4 text-muted mb-3"></i>
                    <h5 class="text-muted">No categories found</h5>
                    <p class="text-muted mb-3">Get started by adding your first category</p>
                    <button class="btn btn-lg px-4 shadow-sm" style="background-color: #ff6b6b; border-color: #ff6b6b; color: white;" onclick="openCategoryModal()">
                      <i class="bi bi-plus-circle me-2"></i>Add Category
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

<!-- Enhanced Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form class="modal-content border-0 shadow-lg" method="POST" action="">
      <div class="modal-header py-3" style="background-color: #ff6b6b;">
        <div class="d-flex align-items-center">
          <i class="bi bi-tags-fill me-2 fs-5 text-white"></i>
          <h5 class="modal-title mb-0 text-white" id="categoryModalTitle">Add Category</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" name="action" value="save">
        <input type="hidden" id="categoryId" name="categoryId" value="">

        <div class="row">
          <div class="col-12 mb-3">
            <label for="categoryName" class="form-label fw-semibold text-dark">
              <i class="bi bi-tags me-2" style="color: #ff6b6b;"></i>Category Name
            </label>
            <input type="text" id="categoryName" name="categoryName"
              class="form-control form-control-lg border-2"
              placeholder="Enter category name..." required>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light py-3">
        <button type="submit" class="btn btn-lg px-4 me-2" style="background-color: #ff6b6b; border-color: #ff6b6b; color: white;">
          <i class="bi bi-check-circle me-2"></i>Save Category
        </button>
        <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-2"></i>Cancel
        </button>
      </div>
    </form>
  </div>
</div>