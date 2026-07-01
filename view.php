<?php
require_once 'auth.php';
requireLogin();

require_once 'db.php';
require_once 'partials.php';

$message = '';
$message_type = '';

// Get student ID from query string
$student_id = intval($_GET['id'] ?? 0);

if ($student_id <= 0) {
    header('Location: index.php');
    exit;
}

// Fetch student record first to evaluate access
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
$stmt->execute([':id' => $student_id]);
$student = $stmt->fetch();

if (!$student) {
    header('Location: index.php');
    exit;
}

// Get logged-in user role & info for DAC/RBAC
$user = getCurrentUser();
$role = $user['role'] ?? 'Student';

// DAC Check: Validate if current user is authorized to view this record
if ($role === 'Student') {
    if ($student['email'] !== $user['email']) {
        header('Location: student_dashboard.php?error=unauthorized');
        exit;
    }
} elseif ($role === 'Parent') {
    if (stripos($student['next_of_kin'], $user['full_name']) === false) {
        header('Location: parent_dashboard.php?error=unauthorized');
        exit;
    }
}

// Handle admission status update via POST (Admin Only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    if ($role !== 'Admin') {
        $message = 'Unauthorized: Only Admin users can change admission status.';
        $message_type = 'error';
    } else {
        $new_status = isset($_POST['admission_status']) ? 'Admitted' : 'Undecided';
        try {
            $update_stmt = $pdo->prepare("UPDATE students SET admission_status = :status WHERE id = :id");
            $update_stmt->execute([':status' => $new_status, ':id' => $student_id]);
            $message = 'Admission status updated to <strong>' . htmlspecialchars($new_status) . '</strong> successfully!';
            $message_type = 'success';
            // Refetch student data to show updated status
            $stmt->execute([':id' => $student_id]);
            $student = $stmt->fetch();
        } catch (PDOException $e) {
            $message = 'Failed to update admission status: ' . htmlspecialchars($e->getMessage());
            $message_type = 'error';
        }
    }
}

// Handle profile picture update via POST (Admin Only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_picture'])) {
    if ($role !== 'Admin') {
        $message = 'Unauthorized: Only Admin users can change student profile pictures.';
        $message_type = 'error';
    } else {
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $file_type = $_FILES['profile_image']['type'];
            $file_size = $_FILES['profile_image']['size'];

            if (!in_array($file_type, $allowed_types)) {
                $message = 'Profile image must be a JPG, PNG, GIF, or WEBP file.';
                $message_type = 'error';
            } elseif ($file_size > 5 * 1024 * 1024) {
                $message = 'Profile image must be less than 5MB.';
                $message_type = 'error';
            } else {
                $extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                $profile_image_name = 'profile_' . uniqid() . '.' . $extension;
                $upload_path = __DIR__ . '/uploads/' . $profile_image_name;

                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_path)) {
                    // Fetch student current profile picture to delete it if exists
                    if (!empty($student['profile_image'])) {
                        $old_file = __DIR__ . '/uploads/' . $student['profile_image'];
                        if (is_file($old_file)) {
                            unlink($old_file);
                        }
                    }

                    // Update database
                    try {
                        $update_stmt = $pdo->prepare("UPDATE students SET profile_image = :img WHERE id = :id");
                        $update_stmt->execute([':img' => $profile_image_name, ':id' => $student_id]);
                        $message = 'Profile picture updated successfully!';
                        $message_type = 'success';
                        // Refetch student data to show updated picture
                        $stmt->execute([':id' => $student_id]);
                        $student = $stmt->fetch();
                    } catch (PDOException $e) {
                        $message = 'Failed to update database record: ' . htmlspecialchars($e->getMessage());
                        $message_type = 'error';
                    }
                } else {
                    $message = 'Failed to save uploaded profile image.';
                    $message_type = 'error';
                }
            }
        } else {
            $message = 'Please select a valid image file to upload.';
            $message_type = 'error';
        }
    }
}

$full_name = htmlspecialchars(trim($student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name']));
$is_admitted = ($student['admission_status'] === 'Admitted');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php renderHead($full_name . ' — Student Profile', 'Detailed student profile for ' . $full_name); ?>
</head>
<body>
    <div class="page-wrapper">

        <!-- Navbar -->
        <?php renderNavbar(''); ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="container" style="max-width: 900px;">

                <div class="page-title-bar">
                    <div>
                        <h1>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Student Profile
                        </h1>
                        <p>Detailed information for the selected student.</p>
                    </div>
                    <div style="display: flex; gap: var(--space-sm); flex-wrap: wrap;">
                        <?php 
                        // Route back based on user role
                        $backUrl = 'dashboard.php';
                        if ($role === 'Teacher') $backUrl = 'teacher_dashboard.php';
                        elseif ($role === 'Student') $backUrl = 'student_dashboard.php';
                        elseif ($role === 'Parent') $backUrl = 'parent_dashboard.php';
                        ?>
                        <a href="<?php echo $backUrl; ?>" class="btn btn-secondary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" x2="5" y1="12" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                            Back to Dashboard
                        </a>
                    </div>
                </div>

                <!-- Alert Message -->
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $message_type; ?>">
                        <?php if ($message_type === 'success'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <?php else: ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <?php endif; ?>
                        <div><?php echo $message; ?></div>
                    </div>
                <?php endif; ?>

                <div class="glass-card-static">

                    <!-- Profile Header -->
                    <div class="profile-header">
                        <div style="text-align: center; display: flex; flex-direction: column; align-items: center; gap: 8px;">
                            <?php if (!empty($student['profile_image'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($student['profile_image']); ?>"
                                     alt="<?php echo $full_name; ?>"
                                     class="profile-avatar" style="margin-bottom: 0;">
                            <?php else: ?>
                                <div class="profile-avatar" style="background: var(--primary-600); display:flex; align-items:center; justify-content:center; color: var(--gold-400); font-size: 2.5rem; font-weight: 800; margin-bottom: 0;">
                                    <?php echo strtoupper(substr($student['first_name'], 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Quick Picture Upload Form - ONLY ADMIN CAN CHANGE -->
                            <?php if ($role === 'Admin'): ?>
                                <form method="POST" action="view.php?id=<?php echo $student_id; ?>" enctype="multipart/form-data" style="margin-top: 4px;">
                                    <input type="hidden" name="update_picture" value="1">
                                    <label class="btn btn-secondary btn-sm" style="cursor: pointer; padding: 4px 10px; font-size: 0.75rem; border-radius: var(--radius-sm);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                        Change Photo
                                        <input type="file" name="profile_image" accept="image/*" style="display: none;" onchange="this.form.submit();">
                                    </label>
                                </form>
                            <?php endif; ?>
                        </div>
                        <div class="profile-name">
                            <h2><?php echo $full_name; ?></h2>
                            <p><?php echo htmlspecialchars($student['email']); ?></p>
                            <div style="margin-top: var(--space-sm);">
                                <span class="badge badge-<?php echo strtolower($student['admission_status']); ?>">
                                    <?php echo htmlspecialchars($student['admission_status']); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <!-- All Details -->
                    <div class="section-heading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        <h3>Personal Information</h3>
                    </div>
                    <div class="profile-grid">
                        <div class="profile-field">
                            <div class="profile-field-label">First Name</div>
                            <div class="profile-field-value"><?php echo htmlspecialchars($student['first_name']); ?></div>
                        </div>
                        <div class="profile-field">
                            <div class="profile-field-label">Middle Name</div>
                            <div class="profile-field-value"><?php echo htmlspecialchars($student['middle_name'] ?: '—'); ?></div>
                        </div>
                        <div class="profile-field">
                            <div class="profile-field-label">Last Name</div>
                            <div class="profile-field-value"><?php echo htmlspecialchars($student['last_name']); ?></div>
                        </div>
                        <div class="profile-field">
                            <div class="profile-field-label">Email Address</div>
                            <div class="profile-field-value"><?php echo htmlspecialchars($student['email']); ?></div>
                        </div>
                        <div class="profile-field">
                            <div class="profile-field-label">Date of Birth</div>
                            <div class="profile-field-value"><?php echo htmlspecialchars(date('F j, Y', strtotime($student['dob']))); ?></div>
                        </div>
                        <div class="profile-field">
                            <div class="profile-field-label">Gender</div>
                            <div class="profile-field-value"><?php echo htmlspecialchars($student['gender']); ?></div>
                        </div>
                        <div class="profile-field">
                            <div class="profile-field-label">Phone Number</div>
                            <div class="profile-field-value"><?php echo htmlspecialchars($student['phone']); ?></div>
                        </div>
                        <div class="profile-field">
                            <div class="profile-field-label">State of Origin</div>
                            <div class="profile-field-value"><?php echo htmlspecialchars($student['state_of_origin']); ?></div>
                        </div>
                        <div class="profile-field">
                            <div class="profile-field-label">Local Government Area</div>
                            <div class="profile-field-value"><?php echo htmlspecialchars($student['lga']); ?></div>
                        </div>
                        <div class="profile-field">
                            <div class="profile-field-label">Next of Kin</div>
                            <div class="profile-field-value"><?php echo htmlspecialchars($student['next_of_kin']); ?></div>
                        </div>
                        <div class="profile-field">
                            <div class="profile-field-label">End of Term Score</div>
                            <div class="profile-field-value" style="font-weight: 700; color: var(--gold-600);"><?php echo $student['end_of_term_score']; ?>%</div>
                        </div>
                        <div class="profile-field" style="grid-column: span 2;">
                            <div class="profile-field-label">Residential Address</div>
                            <div class="profile-field-value"><?php echo htmlspecialchars($student['address']); ?></div>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <!-- Admission Status Update Block -->
                    <div class="admission-toggle-card">
                        <div>
                            <h3>Admission Status</h3>
                            <p>Current status is: <strong><?php echo $student['admission_status']; ?></strong></p>
                        </div>
                        
                        <?php if ($role === 'Admin'): ?>
                            <!-- Toggle switch form for Admin -->
                            <form method="POST" action="view.php?id=<?php echo $student_id; ?>">
                                <input type="hidden" name="update_status" value="1">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="admission_status" <?php echo $is_admitted ? 'checked' : ''; ?> onchange="this.form.submit();">
                                    <span class="toggle-slider"></span>
                                    <span class="toggle-label"><?php echo $is_admitted ? 'Admitted' : 'Undecided'; ?></span>
                                </label>
                            </form>
                        <?php else: ?>
                            <!-- Read-only status info for non-admins -->
                            <div>
                                <span class="badge badge-<?php echo strtolower($student['admission_status']); ?>">
                                    <?php echo $student['admission_status']; ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>

            </div>
        </main>

        <!-- Footer -->
        <?php renderFooter(); ?>

    </div>
</body>
</html>
