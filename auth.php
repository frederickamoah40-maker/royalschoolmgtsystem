<?php
/**
 * Authentication Guard & RBAC Control
 * Include this at the top of any page that requires login or role-based check.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function getUserRole(): string {
    return $_SESSION['user_role'] ?? 'Student';
}

function getCurrentUser(): ?array {
    if (!isLoggedIn()) return null;
    return [
        'id'        => $_SESSION['user_id'],
        'full_name' => $_SESSION['user_name'] ?? '',
        'email'     => $_SESSION['user_email'] ?? '',
        'role'      => $_SESSION['user_role'] ?? 'Student',
    ];
}

function requireAdmin(): void {
    requireLogin();
    if (getUserRole() !== 'Admin') {
        header('Location: index.php?error=unauthorized');
        exit;
    }
}

function requireTeacher(): void {
    requireLogin();
    if (getUserRole() !== 'Teacher' && getUserRole() !== 'Admin') {
        header('Location: index.php?error=unauthorized');
        exit;
    }
}

function requireStudent(): void {
    requireLogin();
    if (getUserRole() !== 'Student' && getUserRole() !== 'Admin') {
        header('Location: index.php?error=unauthorized');
        exit;
    }
}

function requireParent(): void {
    requireLogin();
    if (getUserRole() !== 'Parent' && getUserRole() !== 'Admin') {
        header('Location: index.php?error=unauthorized');
        exit;
    }
}

/**
 * Route user to their respective dashboard based on their role
 */
function redirectDashboardByRole(string $role): void {
    switch ($role) {
        case 'Admin':
            header('Location: dashboard.php');
            exit;
        case 'Teacher':
            header('Location: teacher_dashboard.php');
            exit;
        case 'Student':
            header('Location: student_dashboard.php');
            exit;
        case 'Parent':
            header('Location: parent_dashboard.php');
            exit;
        default:
            header('Location: index.php');
            exit;
    }
}
