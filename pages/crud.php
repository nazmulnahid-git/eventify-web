<?php
include 'config.php';

function createCategory($name) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}

function getCategories() {
    global $conn;
    $result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}
function updateCategory($id, $name) {
    global $conn;
    $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);
    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}

function deleteCategory($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}

function createService($name, $categoryId, $price) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO services (name, category_id, price) VALUES (?, ?, ?)");
    $stmt->bind_param("sid", $name, $categoryId, $price);
    if ($stmt->execute()) {
       return ['success' => true];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}

function getServices() {
    global $conn;
    $result = $conn->query("SELECT services.*, categories.name AS category_name FROM services JOIN categories ON services.category_id = categories.id ORDER BY services.id DESC");
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function updateService($id, $name, $description, $categoryId, $price) { 
    global $conn;
    $stmt = $conn->prepare("UPDATE services SET name = ?, description = ?, category_id = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssidd", $name, $description, $categoryId, $price, $id);
    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}

function deleteService($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
    $stmt->bind_param("i", $id);
     if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}

function getEvents() {
    global $conn;
    $result = $conn->query("SELECT * FROM events ORDER BY id DESC");
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function createEvent($name, $description, $date, $location, $price, $categoryId) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO events (name, description, location, start_date, price, category_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdi", $name, $description, $location, $date, $price, $categoryId);
    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}

function updateEvent($id, $name, $description, $location, $date, $price, $categoryId) {
    global $conn;
    $stmt = $conn->prepare("UPDATE events SET name = ?, description = ?, location = ?, start_date = ?, price = ?, category_id = ? WHERE id = ?");
    $stmt->bind_param("ssssdii", $name, $description, $location, $date, $price, $categoryId, $id);
    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}

function deleteEvent($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}
?>