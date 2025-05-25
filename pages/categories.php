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
    <button class="btn btn-primary" onclick="openCategoryModal()">Add New Category</button>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-bordered text-center align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Category Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($categories) > 0): ?>
              <?php foreach ($categories as $index => $cat): ?>
                <tr>
                  <td><?= $index + 1 ?></td>
                  <td><?= htmlspecialchars($cat['name']) ?></td>
                  <td>
                    <button type="button" class="btn btn-sm btn-warning" onclick="editCategory(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['name'], ENT_QUOTES) ?>')">Edit</button>
                    <form method="POST" action="" style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="categoryId" value="<?= $cat['id'] ?>">
                      <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="3">No categories found.</td>
              </tr>
            <?php endif; ?>
          </tbody>

        </table>
      </div>
      <div id="noCategoryMessage" class="alert alert-secondary text-center my-4" style="display: none;">
        No categories found.
      </div>
    </div>
  </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="">
      <div class="modal-header">
        <h5 class="modal-title" id="categoryModalTitle">
          <?= isset($editCategory) ? 'Edit Category' : 'Add Category' ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="action" value="save">
        <input type="hidden" id="categoryId" name="categoryId" value="">
        <div class="mb-3">
          <label for="categoryName" class="form-label">Category Name</label>
          <input type="text" id="categoryName" name="categoryName" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>