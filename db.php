<?php
/**
 * Database Connection & Initialization
 * Autocreates the SQLite database and sets up the schemas.
 */

$db_path = __DIR__ . '/database.sqlite';
$uploads_dir = __DIR__ . '/uploads';

// Create uploads directory if it doesn't exist
if (!is_dir($uploads_dir)) {
    mkdir($uploads_dir, 0755, true);
}

try {
    $pdo = new PDO('sqlite:' . $db_path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Enable WAL mode for better concurrent access
    $pdo->exec('PRAGMA journal_mode=WAL');

    // Create users table (includes role for RBAC, MAC, DAC)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            full_name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            role TEXT NOT NULL DEFAULT 'Student',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Create students table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS students (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            first_name TEXT NOT NULL,
            middle_name TEXT DEFAULT '',
            last_name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            dob TEXT NOT NULL,
            gender TEXT NOT NULL,
            phone TEXT NOT NULL,
            address TEXT NOT NULL,
            state_of_origin TEXT NOT NULL,
            lga TEXT NOT NULL,
            next_of_kin TEXT NOT NULL,
            end_of_term_score INTEGER NOT NULL,
            profile_image TEXT DEFAULT '',
            admission_status TEXT NOT NULL DEFAULT 'Undecided',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

} catch (PDOException $e) {
    die("Database connection/init failed: " . htmlspecialchars($e->getMessage()));
}
