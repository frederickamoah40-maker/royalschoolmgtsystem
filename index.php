<?php
session_start();
require_once 'partials.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php renderHead('Royal School of Excellence — Student Portal', 'Welcome to the Royal School of Excellence Student Portal.'); ?>
</head>
<body>
    <div class="page-wrapper">

        <!-- Navbar -->
        <?php renderNavbar('home'); ?>

        <!-- Hero Banner with Full Background Image -->
        <section class="hero-banner">
            <div class="hero-content">
                <h1>Royal School of <span>Excellence</span></h1>
                <p>Your gateway to academic management. Register new students, view admission records, and manage student profiles — all in one place.</p>
                <div class="hero-actions">
                    <?php 
                    if (isset($_SESSION['user_id'])): 
                        $user_role = $_SESSION['user_role'] ?? 'Student';
                        $dash_url = 'dashboard.php';
                        $dash_label = 'View Dashboard';

                        if ($user_role === 'Teacher') {
                            $dash_url = 'teacher_dashboard.php';
                            $dash_label = 'Teacher Dashboard';
                        } elseif ($user_role === 'Student') {
                            $dash_url = 'student_dashboard.php';
                            $dash_label = 'My Dashboard';
                        } elseif ($user_role === 'Parent') {
                            $dash_url = 'parent_dashboard.php';
                            $dash_label = 'Parent Dashboard';
                        } elseif ($user_role === 'Admin') {
                            $dash_url = 'dashboard.php';
                            $dash_label = 'Admin Dashboard';
                        }
                    ?>
                        <?php if ($user_role === 'Admin'): ?>
                            <a href="form.php" class="btn btn-primary btn-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                                Register Student
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo $dash_url; ?>" class="btn btn-secondary btn-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                            <?php echo $dash_label; ?>
                        </a>
                    <?php else: ?>
                        <a href="register.php" class="btn btn-primary btn-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                            Create Account
                        </a>
                        <a href="login.php" class="btn btn-secondary btn-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                            Sign In
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <main class="main-content">
            <div class="container">
                <div class="features-grid">
                    <div class="glass-card feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </div>
                        <h3>Student Registration</h3>
                        <p>Complete registration form with profile image upload, personal details, and end of term score entry.</p>
                    </div>
                    <div class="glass-card feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                        </div>
                        <h3>Admin Dashboard</h3>
                        <p>Powerful dashboard with filterable records table. Search by name, admission status, gender, and score.</p>
                    </div>
                    <div class="glass-card feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <h3>Student Profiles</h3>
                        <p>Detailed profile view for each student. Update admission status in real-time with a simple toggle.</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <?php renderFooter(); ?>

    </div>
</body>
</html>
