<?php

// Database connection
function dbConnect() {
    $host = 'localhost'; 
    $user = 'your_username'; 
    $password = 'your_password'; 
    $database = 'your_database'; 

    $connection = new mysqli($host, $user, $password, $database);
    if ($connection->connect_error) {
        die('Connection failed: ' . $connection->connect_error);
    }
    return $connection;
}

// Security function for input sanitization
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to add a new booking
function addBooking($userId, $bookingDetails) {
    $conn = dbConnect();
    $stmt = $conn->prepare('INSERT INTO bookings (user_id, details) VALUES (?, ?)');
    $stmt->bind_param('ss', $userId, $bookingDetails);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Function to view all bookings for a user
function viewBookings($userId) {
    $conn = dbConnect();
    $stmt = $conn->prepare('SELECT * FROM bookings WHERE user_id = ?');
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookings = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conn->close();
    return $bookings;
}

// Function to delete a booking
function deleteBooking($bookingId) {
    $conn = dbConnect();
    $stmt = $conn->prepare('DELETE FROM bookings WHERE id = ?');
    $stmt->bind_param('i', $bookingId);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Function to update a booking
function updateBooking($bookingId, $bookingDetails) {
    $conn = dbConnect();
    $stmt = $conn->prepare('UPDATE bookings SET details = ? WHERE id = ?');
    $stmt->bind_param('si', $bookingDetails, $bookingId);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

?>