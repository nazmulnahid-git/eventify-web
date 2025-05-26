<?php
include 'config.php';
require_once __DIR__ . '/crud.php';

$categories = getCategories();
$events = getEvents();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'save') {
    $eventName = trim($_POST['eventName'] ?? '');
    $eventDescription = trim($_POST['eventDescription'] ?? '');
    $eventLocation = trim($_POST['eventLocation'] ?? '');
    $eventDate = trim($_POST['eventDate'] ?? '');
    $categoryId = isset($_POST['categoryId']) ? intval($_POST['categoryId']) : null;
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $eventId = isset($_POST['eventId']) ? intval($_POST['eventId']) : null;

    if ($eventName === '') {
      $error = 'Event name cannot be empty.';
    } elseif ($eventDate === '') {
      $error = 'Event date cannot be empty.';
    } elseif (!$categoryId || $categoryId <= 0) {
      $error = 'Please select a valid category.';
    } elseif ($price < 0) {
      $error = 'Price cannot be negative.';
    } else {
      if ($eventId) {
        $result = updateEvent($eventId, $eventName, $eventDescription, $eventLocation, $eventDate, $price, $categoryId);
        $message = $result['success'] ? 'Event updated successfully.' : 'Failed to update event.';
      } else {
        $result = createEvent($eventName, $eventDescription, $eventDate, $eventLocation, $price, $categoryId);
        $message = $result['success'] ? 'Event created successfully.' : 'Failed to create event.';
      }
    }
  } elseif ($action === 'delete') {
    $eventId = intval($_POST['eventId'] ?? 0);
    if ($eventId > 0) {
      $result = deleteEvent($eventId);
      $message = $result['success'] ? 'Event deleted successfully.' : 'Failed to delete event.';
    } else {
      $error = 'Invalid event ID for deletion.';
    }
  }

  // Refresh event list after changes
  $events = getEvents();
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
        <button class="btn btn-lg px-4 shadow-sm" style="background-color: #ff6b6b; border-color: #ff6b6b; color: white;" onclick="openEventModal()">
          <i class="bi bi-plus-circle me-2"></i>Add New Event
        </button>
      </div>
    </div>
  </div>

  <!-- Modern Table Card -->
  <div class="card border-0 shadow-lg">
    <div class="card-header bg-white border-bottom py-3">
      <div class="row align-items-center">
        <div class="col">
          <h5 class="mb-0 text-dark fw-semibold">Events Overview</h5>
          <small class="text-muted">Total events: <?= count($events) ?></small>
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
                  <i class="bi bi-calendar-event me-2"></i>Event Name
                </div>
              </th>
              <th scope="col" class="px-4 py-3 text-uppercase text-muted fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                <div class="d-flex align-items-center">
                  <i class="bi bi-geo-alt me-2"></i>Location
                </div>
              </th>
              <th scope="col" class="px-4 py-3 text-uppercase text-muted fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                <div class="d-flex align-items-center">
                  <i class="bi bi-clock me-2"></i>Date
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
            <?php if (count($events) > 0): ?>
              <?php foreach ($events as $index => $event): ?>
                <tr class="border-bottom">
                  <td class="px-4 py-4">
                    <span class="badge bg-light text-dark rounded-pill px-3 py-2 fw-normal">
                      <?= $index + 1 ?>
                    </span>
                  </td>
                  <td class="px-4 py-4">
                    <div class="d-flex align-items-center">
                      <div class="rounded-circle p-2 me-3" style="background-color: rgba(255, 107, 107, 0.1);">
                        <i class="bi bi-calendar-event" style="color: #ff6b6b;"></i>
                      </div>
                      <div>
                        <h6 class="mb-0 fw-semibold text-dark"><?= htmlspecialchars($event['name']) ?></h6>
                        <?php if (!empty($event['description'])): ?>
                          <small class="text-muted"><?= htmlspecialchars(substr($event['description'], 0, 50)) ?>...</small>
                        <?php endif; ?>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-4">
                    <span class="text-muted">
                      <i class="bi bi-geo-alt me-1"></i>
                      <?= htmlspecialchars($event['location'] ?? 'TBD') ?>
                    </span>
                  </td>
                  <td class="px-4 py-4">
                    <span class="fw-semibold text-primary">
                      <?= date('M d, Y g:i A', strtotime($event['start_date'])) ?>
                    </span>
                  </td>
                  <td class="px-4 py-4">
                    <span class="badge bg-opacity-10 border border-opacity-25 px-3 py-2 fw-normal" style="background-color: rgba(255, 107, 107, 0.1) !important; color: #ff6b6b !important; border-color: rgba(255, 107, 107, 0.25) !important;">
                      <?php
                        $categoryName = 'N/A';
                        foreach ($categories as $cat) {
                          if ($cat['id'] == $event['category_id']) {
                            $categoryName = $cat['name'];
                            break;
                          }
                        }
                        echo htmlspecialchars($categoryName);
                      ?>
                    </span>
                  </td>
                  <td class="px-4 py-4">
                    <span class="fw-bold text-success fs-6">
                      <?php if ($event['price'] > 0): ?>
                        $<?= number_format($event['price'], 2) ?>
                      <?php else: ?>
                        <span class="text-info">Free</span>
                      <?php endif; ?>
                    </span>
                  </td>
                  <td class="px-4 py-4 text-center">
                    <div class="btn-group" role="group">
                      <button type="button" class="btn btn-outline-warning btn-sm px-3 py-2"
                        onclick="editEvent(<?= $event['id'] ?>, '<?= htmlspecialchars($event['name'], ENT_QUOTES) ?>', '<?= htmlspecialchars($event['description'], ENT_QUOTES) ?>', '<?= htmlspecialchars($event['location'], ENT_QUOTES) ?>', '<?= $event['start_date'] ?>', <?= $event['price'] ?>, <?= $event['category_id'] ?>)"
                        data-bs-toggle="tooltip" title="Edit Event">
                        <i class="bi bi-pencil-square me-1"></i>Edit
                      </button>
                      <form method="POST" action="" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this event?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="eventId" value="<?= $event['id'] ?>">
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 py-2"
                          data-bs-toggle="tooltip" title="Delete Event">
                          <i class="bi bi-trash me-1"></i>Delete
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center py-5">
                  <div class="py-4">
                    <i class="bi bi-calendar-x display-4 text-muted mb-3"></i>
                    <h5 class="text-muted">No events found</h5>
                    <p class="text-muted mb-3">Get started by adding your first event</p>
                    <button class="btn btn-lg px-4 shadow-sm" style="background-color: #ff6b6b; border-color: #ff6b6b; color: white;" onclick="openEventModal()">
                      <i class="bi bi-plus-circle me-2"></i>Add Event
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

<!-- Enhanced Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form class="modal-content border-0 shadow-lg" method="POST" action="">
      <div class="modal-header py-3" style="background-color: #ff6b6b;">
        <div class="d-flex align-items-center">
          <i class="bi bi-calendar-event-fill me-2 fs-5 text-white"></i>
          <h5 class="modal-title mb-0 text-white" id="eventModalTitle">Add Event</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" name="action" value="save">
        <input type="hidden" id="eventId" name="eventId" value="">

        <div class="row">
          <div class="col-12 mb-3">
            <label for="eventName" class="form-label fw-semibold text-dark">
              <i class="bi bi-calendar-event me-2" style="color: #ff6b6b;"></i>Event Name
            </label>
            <input type="text" id="eventName" name="eventName"
              class="form-control form-control-lg border-2"
              placeholder="Enter event name..." required>
          </div>

          <div class="col-12 mb-3">
            <label for="eventDescription" class="form-label fw-semibold text-dark">
              <i class="bi bi-file-text me-2" style="color: #ff6b6b;"></i>Event Description
            </label>
            <textarea id="eventDescription" name="eventDescription"
              class="form-control border-2" rows="3"
              placeholder="Describe your event..."></textarea>
          </div>

          <div class="col-md-6 mb-3">
            <label for="eventLocation" class="form-label fw-semibold text-dark">
              <i class="bi bi-geo-alt me-2" style="color: #ff6b6b;"></i>Location
            </label>
            <input type="text" id="eventLocation" name="eventLocation"
              class="form-control form-control-lg border-2"
              placeholder="Enter event location...">
          </div>

          <div class="col-md-6 mb-3">
            <label for="eventDate" class="form-label fw-semibold text-dark">
              <i class="bi bi-clock me-2" style="color: #ff6b6b;"></i>Event Date & Time
            </label>
            <input type="datetime-local" id="eventDate" name="eventDate"
              class="form-control form-control-lg border-2" required>
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
              step="0.01" min="0" placeholder="0.00 (Free)" value="0">
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light py-3">
        <button type="submit" class="btn btn-lg px-4 me-2" style="background-color: #ff6b6b; border-color: #ff6b6b; color: white;">
          <i class="bi bi-check-circle me-2"></i>Save Event
        </button>
        <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-2"></i>Cancel
        </button>
      </div>
    </form>
  </div>
</div>