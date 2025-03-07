<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "connect.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input
    $query = $db->prepare("SELECT * FROM films WHERE ID = ?");
    $query->execute([$id]);
    $film = $query->fetch(PDO::FETCH_ASSOC);

    if ($film) {
        header('Content-Type: application/json'); // Ensure JSON header
        echo json_encode([
            'name' => $film['name'],
            'description' => $film['description'],
            'director' => $film['director'],
            'genre' => $film['genre'],
            'release_date' => $film['release_date'],
            'duration' => $film['duration'] ?? 'Not specified'
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Film not found']);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request']);
}
