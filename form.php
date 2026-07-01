<?php
require_once 'auth.php';
requireAdmin();

require_once 'db.php';
require_once 'partials.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $first_name        = trim($_POST['first_name'] ?? '');
    $middle_name       = trim($_POST['middle_name'] ?? '');
    $last_name         = trim($_POST['last_name'] ?? '');
    $email             = trim($_POST['email'] ?? '');
    $dob               = trim($_POST['dob'] ?? '');
    $gender            = trim($_POST['gender'] ?? '');
    $phone             = trim($_POST['phone'] ?? '');
    $address           = trim($_POST['address'] ?? '');
    $state_of_origin   = trim($_POST['state_of_origin'] ?? '');
    $lga               = trim($_POST['lga'] ?? '');
    $next_of_kin       = trim($_POST['next_of_kin'] ?? '');
    $end_of_term_score = intval($_POST['end_of_term_score'] ?? 0);

    // Validate required fields
    $errors = [];
    if (empty($first_name))     $errors[] = 'First Name is required.';
    if (empty($last_name))      $errors[] = 'Last Name is required.';
    if (empty($email))          $errors[] = 'Email is required.';
    if (empty($dob))            $errors[] = 'Date of Birth is required.';
    if (empty($gender))         $errors[] = 'Gender is required.';
    if (empty($phone))          $errors[] = 'Phone Number is required.';
    if (empty($address))        $errors[] = 'Address is required.';
    if (empty($state_of_origin)) $errors[] = 'State of Origin is required.';
    if (empty($lga))            $errors[] = 'Local Government Area is required.';
    if (empty($next_of_kin))    $errors[] = 'Next of Kin is required.';
    if ($end_of_term_score < 0 || $end_of_term_score > 100) $errors[] = 'End of Term Score must be between 0 and 100.';

    // Handle profile image upload
    $profile_image_name = '';
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $file_type = $_FILES['profile_image']['type'];
        $file_size = $_FILES['profile_image']['size'];

        if (!in_array($file_type, $allowed_types)) {
            $errors[] = 'Profile image must be a JPG, PNG, GIF, or WEBP file.';
        } elseif ($file_size > 5 * 1024 * 1024) {
            $errors[] = 'Profile image must be less than 5MB.';
        } else {
            $extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $profile_image_name = 'profile_' . uniqid() . '.' . $extension;
            $upload_path = __DIR__ . '/uploads/' . $profile_image_name;

            if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_path)) {
                $errors[] = 'Failed to upload profile image. Please try again.';
                $profile_image_name = '';
            }
        }
    } else {
        $errors[] = 'Profile image is required.';
    }

    // Check for duplicate email
    if (empty($errors)) {
        $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM students WHERE email = :email");
        $check_stmt->execute([':email' => $email]);
        if ($check_stmt->fetchColumn() > 0) {
            $errors[] = 'A student with this email address already exists.';
        }
    }

    if (!empty($errors)) {
        $message = implode('<br>', $errors);
        $message_type = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO students (first_name, middle_name, last_name, email, dob, gender, phone, address, state_of_origin, lga, next_of_kin, end_of_term_score, profile_image)
                VALUES (:first_name, :middle_name, :last_name, :email, :dob, :gender, :phone, :address, :state_of_origin, :lga, :next_of_kin, :end_of_term_score, :profile_image)
            ");
            $stmt->execute([
                ':first_name'        => $first_name,
                ':middle_name'       => $middle_name,
                ':last_name'         => $last_name,
                ':email'             => $email,
                ':dob'               => $dob,
                ':gender'            => $gender,
                ':phone'             => $phone,
                ':address'           => $address,
                ':state_of_origin'   => $state_of_origin,
                ':lga'               => $lga,
                ':next_of_kin'       => $next_of_kin,
                ':end_of_term_score' => $end_of_term_score,
                ':profile_image'     => $profile_image_name,
            ]);

            $message = 'Student registration successful! <a href="dashboard.php" style="color: #86efac; text-decoration: underline;">View Dashboard</a>';
            $message_type = 'success';

            // Clear form values on success
            $first_name = $middle_name = $last_name = $email = $dob = $gender = $phone = $address = $state_of_origin = $lga = $next_of_kin = '';
            $end_of_term_score = 0;

        } catch (PDOException $e) {
            $message = 'Database error: ' . htmlspecialchars($e->getMessage());
            $message_type = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php renderHead('Student Registration', 'Register a new student in the portal.'); ?>
</head>
<body>
    <div class="page-wrapper">

        <!-- Navbar -->
        <?php renderNavbar('register-student'); ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="container" style="max-width: 900px;">

                <div class="page-title-bar">
                    <div>
                        <h1>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                            Student Registration
                        </h1>
                        <p>Fill out all the fields below to register a new student.</p>
                    </div>
                    <a href="dashboard.php" class="btn btn-secondary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                        View Dashboard
                    </a>
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
                    <form method="POST" action="form.php" enctype="multipart/form-data" id="registration-form">

                        <!-- Profile Image -->
                        <div class="form-group">
                            <label class="form-label">Profile Image <span class="required">*</span></label>
                            <div class="file-input-wrapper">
                                <input type="file" name="profile_image" id="profile_image" accept="image/*" required>
                                <div class="file-input-display" id="file-display">
                                    <div class="file-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                    </div>
                                    <div class="file-input-text">
                                        <h4 id="file-name">Click or drag to upload a photo</h4>
                                        <p>JPG, PNG, GIF or WEBP (max 5MB)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="section-divider"></div>

                        <!-- Personal Details -->
                        <div class="section-heading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <h3>Personal Details</h3>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label" for="first_name">First Name <span class="required">*</span></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="e.g. Adewale" value="<?php echo htmlspecialchars($first_name ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="middle_name">Middle Name</label>
                                <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="e.g. Olamide" value="<?php echo htmlspecialchars($middle_name ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="last_name">Last Name <span class="required">*</span></label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="e.g. Johnson" value="<?php echo htmlspecialchars($last_name ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">Email Address <span class="required">*</span></label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="e.g. student@example.com" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="dob">Date of Birth <span class="required">*</span></label>
                                <input type="date" class="form-control" name="dob" id="dob" value="<?php echo htmlspecialchars($dob ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="gender">Gender <span class="required">*</span></label>
                                <select class="form-control" name="gender" id="gender" required>
                                    <option value="" disabled <?php echo empty($gender ?? '') ? 'selected' : ''; ?>>Select Gender</option>
                                    <option value="Male" <?php echo ($gender ?? '') === 'Male' ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($gender ?? '') === 'Female' ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="phone">Phone Number <span class="required">*</span></label>
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="e.g. 08012345678" value="<?php echo htmlspecialchars($phone ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="end_of_term_score">End of Term Score <span class="required">*</span></label>
                                <input type="number" class="form-control" name="end_of_term_score" id="end_of_term_score" placeholder="e.g. 85" min="0" max="100" value="<?php echo htmlspecialchars($end_of_term_score ?? ''); ?>" required>
                            </div>
                        </div>

                        <div class="section-divider"></div>

                        <!-- Address & Origin -->
                        <div class="section-heading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <h3>Address & Origin</h3>
                        </div>

                        <div class="form-grid">
                            <div class="form-group" style="grid-column: 1 / -1;">
                                <label class="form-label" for="address">Address <span class="required">*</span></label>
                                <textarea class="form-control" name="address" id="address" placeholder="Enter your full residential address" required><?php echo htmlspecialchars($address ?? ''); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="state_of_origin">State of Origin <span class="required">*</span></label>
                                <input type="text" class="form-control" name="state_of_origin" id="state_of_origin" placeholder="e.g. Lagos" value="<?php echo htmlspecialchars($state_of_origin ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="lga">Local Government Area <span class="required">*</span></label>
                                <input type="text" class="form-control" name="lga" id="lga" placeholder="e.g. Ikeja" value="<?php echo htmlspecialchars($lga ?? ''); ?>" required>
                            </div>
                        </div>

                        <div class="section-divider"></div>

                        <!-- Next of Kin -->
                        <div class="section-heading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            <h3>Next of Kin</h3>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="next_of_kin">Next of Kin (Full Name) <span class="required">*</span></label>
                            <input type="text" class="form-control" name="next_of_kin" id="next_of_kin" placeholder="e.g. Mrs. Funke Johnson" value="<?php echo htmlspecialchars($next_of_kin ?? ''); ?>" required>
                        </div>

                        <div class="section-divider"></div>

                        <!-- Submit -->
                        <div style="display: flex; gap: var(--space-md); justify-content: flex-end; flex-wrap: wrap;">
                            <a href="index.php" class="btn btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" x2="5" y1="12" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                                Back to Home
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" x2="11" y1="2" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                Submit Registration
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </main>

        <!-- Footer -->
        <?php renderFooter(); ?>

    </div>

    <script>
        // Update file input display on file selection
        const fileInput = document.getElementById('profile_image');
        const fileName = document.getElementById('file-name');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileName.textContent = this.files[0].name;
                document.getElementById('file-display').style.borderColor = 'var(--success)';
            } else {
                fileName.textContent = 'Click or drag to upload a photo';
                document.getElementById('file-display').style.borderColor = '';
            }
        });
    </script>
</body>
</html>
