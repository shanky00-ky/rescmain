<?php
session_start();
include('../conn.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user profile from m18_userprofiles table using m12_id (or correct foreign key column)
$query = "SELECT 18_name, 18_email,18_bio, 18_role ,18_profile_photo_url FROM m18_userprofiles WHERE m12_id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('MySQL prepare() failed: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($user_name, $bio ,$role, $user_email, $profile_photo_url);
$stmt->fetch();
$stmt->close();

// // Initialize variables
// $matches_played = 0;
// $upcoming_matches = 0;
// $events_attended = 0;

// // Fetch number of matches played
// $query_matches = "SELECT COUNT(*) FROM m14_leaguemng WHERE user_id = ? AND m14_status = 1 AND m14_date <= NOW()";
// $stmt = $conn->prepare($query_matches);

// if ($stmt === false) {
//     die('MySQL prepare() failed: ' . $conn->error);
// }

// $stmt->bind_param("i", $user_id);
// $stmt->execute();
// $stmt->bind_result($matches_played);
// $stmt->fetch();
// $stmt->close();

// // Fetch number of upcoming matches
// $query_upcoming = "SELECT COUNT(*) FROM m14_leaguemng WHERE user_id = ? AND m14_status = 1 AND m14_date > NOW()";
// $stmt = $conn->prepare($query_upcoming);

// if ($stmt === false) {
//     die('MySQL prepare() failed: ' . $conn->error);
// }

// $stmt->bind_param("i", $user_id);
// $stmt->execute();
// $stmt->bind_result($upcoming_matches);
// $stmt->fetch();
// $stmt->close();

// // Fetch number of events attended
// $query_events = "SELECT COUNT(*) FROM m15_eventmng WHERE user_id = ? AND m15_status = 1";
// $stmt = $conn->prepare($query_events);

// if ($stmt === false) {
//     die('MySQL prepare() failed: ' . $conn->error);
// }

// $stmt->bind_param("i", $user_id);
// $stmt->execute();
// $stmt->bind_result($events_attended);
// $stmt->fetch();
// $stmt->close();

// // Fetch upcoming events
// $events_query = "SELECT m15_eventmng, m15_date, m15_location, m15_status FROM m15_eventmng WHERE m15_date >= NOW() ORDER BY m15_date ASC";
// $events_result = $conn->query($events_query);

// $events = []; // Initialize events array

// if ($events_result->num_rows > 0) {
//     while ($event = $events_result->fetch_assoc()) {
//         $events[] = $event;
//     }
// } else {
//     $events = [];
// }
// ?>
