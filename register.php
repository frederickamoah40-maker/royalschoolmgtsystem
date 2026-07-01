<?php
session_start();
require_once 'db.php';
require_once 'auth.php';
require_once 'partials.php';

$message = '';
$message_type = '';

if (isLoggedIn()) {
    redirectDashboardByRole(getUserRole());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $role      = trim($_POST['role'] ?? 'Student');
    $password  = trim($_POST['password'] ?? '');
    $confirm   = trim($_POST['confirm_password'] ?? '');

    // Validate role
    $allowed_roles = ['Admin', 'Student', 'Teacher', 'Parent'];
    if (!in_array($role, $allowed_roles)) {
        $role = 'Student';
    }

    $errors = [];
    if (empty($full_name))  $errors[] = 'Full Name is required.';
    if (empty($email))      $errors[] = 'Email is required.';
    if (empty($password))   $errors[] = 'Password is required.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($password !== $confirm) $errors[] = 'Passwords do not match.';

    if (empty($errors)) {
        // Validate single Admin rule
        if ($role === 'Admin') {
            $admin_check = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'Admin'");
            if ($admin_check->fetchColumn() > 0) {
                $errors[] = 'An Admin account has already been registered. Only one Admin is allowed in the system.';
            }
        }
        
        $check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $check->execute([':email' => $email]);
        if ($check->fetchColumn() > 0) {
            $errors[] = 'An account with this email already exists.';
        }
    }

    if (!empty($errors)) {
        $message = implode('<br>', $errors);
        $message_type = 'error';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (:name, :email, :pw, :role)");
        $stmt->execute([':name' => $full_name, ':email' => $email, ':pw' => $hash, ':role' => $role]);

        $_SESSION['user_id']    = $pdo->lastInsertId();
        $_SESSION['user_name']  = $full_name;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role']  = $role;
        redirectDashboardByRole($role);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php renderHead('Create Account', 'Register a new account on the Royal School of Excellence portal.'); ?>
</head>
<body>
    <div class="page-wrapper">
        <?php renderNavbar(''); ?>
        <main class="main-content auth-page">
            <div class="container" style="max-width: 460px;">
                <div class="glass-card-static auth-card">
                    <div class="auth-header">
                        <div class="auth-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                        </div>
                        <h2>Create Account</h2>
                        <p>Register to access the student portal</p>
                    </div>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-<?php echo $message_type; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            <div><?php echo $message; ?></div>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="register.php" id="register-form">
                        <div class="form-group">
                            <label class="form-label" for="full_name">Full Name</label>
                            <input type="text" class="form-control" name="full_name" id="full_name" placeholder="e.g. Adewale Johnson" value="<?php echo htmlspecialchars($full_name ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="role">I am a</label>
                            <select class="form-control" name="role" id="role" required>
                                <option value="Admin" <?php echo ($role ?? '') === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="Student" <?php echo ($role ?? '') === 'Student' ? 'selected' : ''; ?>>Student</option>
                                <option value="Teacher" <?php echo ($role ?? '') === 'Teacher' ? 'selected' : ''; ?>>Teacher</option>
                                <option value="Parent" <?php echo ($role ?? '') === 'Parent' ? 'selected' : ''; ?>>Parent / Guardian</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Min. 6 characters" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Re-enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                            Create Account
                        </button>
                    </form>

                    <div class="auth-footer">
                        Already have an account? <a href="login.php">Sign in here</a>
                    </div>
                </div>
            </div>
        </main>
        <?php renderFooter(); ?>
    </div>
</body>
</html>
