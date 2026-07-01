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
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $message = 'Please enter both email and password.';
        $message_type = 'error';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_name']  = $user['full_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role']  = $user['role'] ?? 'Student';
            redirectDashboardByRole($user['role'] ?? 'Student');
        } else {
            $message = 'Invalid email or password. Please try again.';
            $message_type = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php renderHead('Sign In', 'Sign in to your Royal School of Excellence portal account.'); ?>
</head>
<body>
    <div class="page-wrapper">
        <?php renderNavbar(''); ?>
        <main class="main-content auth-page">
            <div class="container" style="max-width: 460px;">
                <div class="glass-card-static auth-card">
                    <div class="auth-header">
                        <div class="auth-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                        </div>
                        <h2>Welcome Back</h2>
                        <p>Sign in to manage student records</p>
                    </div>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-<?php echo $message_type; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            <div><?php echo $message; ?></div>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="login.php" id="login-form">
                        <div class="form-group">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                            Sign In
                        </button>
                    </form>

                    <div class="auth-footer">
                        Don't have an account? <a href="register.php">Create one here</a>
                    </div>
                </div>
            </div>
        </main>
        <?php renderFooter(); ?>
    </div>
</body>
</html>
