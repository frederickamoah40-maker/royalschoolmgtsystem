<?php
require_once 'auth.php';
requireStudent();

require_once 'db.php';
require_once 'partials.php';

$user = getCurrentUser();

// DAC: Students can only see their OWN student record (matched by email)
$stmt = $pdo->prepare("SELECT * FROM students WHERE email = :email LIMIT 1");
$stmt->execute([':email' => $user['email']]);
$student = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php renderHead('Student Dashboard', 'Your personal academic profile and records.'); ?>
</head>
<body>
    <div class="page-wrapper">
        <?php renderNavbar('dashboard'); ?>

        <main class="main-content">
            <div class="container" style="max-width: 900px;">

                <div class="page-title-bar">
                    <div>
                        <h1>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            My Dashboard
                        </h1>
                        <p><?php echo getGreetingMessage($user['full_name']); ?>. View your academic profile below.</p>
                    </div>
                </div>

                <?php if ($student): ?>

                    <!-- Profile Card -->
                    <div class="glass-card-static">

                        <div class="profile-header">
                            <div style="text-align: center; display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                <?php if (!empty($student['profile_image'])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($student['profile_image']); ?>" alt="" class="profile-avatar" style="margin-bottom: 0;">
                                <?php else: ?>
                                    <div class="profile-avatar" style="background: var(--primary-600); display:flex; align-items:center; justify-content:center; color: var(--gold-400); font-size: 2.5rem; font-weight: 800; margin-bottom: 0;">
                                        <?php echo strtoupper(substr($student['first_name'], 0, 1)); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="profile-name">
                                <h2><?php echo htmlspecialchars($student['first_name'] . ' ' . ($student['middle_name'] ? $student['middle_name'] . ' ' : '') . $student['last_name']); ?></h2>
                                <p><?php echo htmlspecialchars($student['email']); ?></p>
                                <div style="margin-top: var(--space-sm);">
                                    <span class="badge badge-<?php echo strtolower($student['admission_status']); ?>">
                                        <?php echo $student['admission_status']; ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="section-divider"></div>

                        <!-- Stats -->
                        <div class="stats-row" style="margin-bottom: var(--space-lg);">
                            <div class="stat-card gold">
                                <div class="stat-value"><?php echo $student['end_of_term_score']; ?>%</div>
                                <div class="stat-label">End of Term Score</div>
                            </div>
                            <div class="stat-card teal">
                                <div class="stat-value"><?php echo $student['admission_status']; ?></div>
                                <div class="stat-label">Admission Status</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value"><?php echo htmlspecialchars($student['gender']); ?></div>
                                <div class="stat-label">Gender</div>
                            </div>
                        </div>

                        <!-- Personal Details -->
                        <div class="section-heading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <h3>My Information</h3>
                        </div>

                        <div class="profile-grid">
                            <div class="profile-field">
                                <div class="profile-field-label">Date of Birth</div>
                                <div class="profile-field-value"><?php echo htmlspecialchars(date('F j, Y', strtotime($student['dob']))); ?></div>
                            </div>
                            <div class="profile-field">
                                <div class="profile-field-label">Phone</div>
                                <div class="profile-field-value"><?php echo htmlspecialchars($student['phone']); ?></div>
                            </div>
                            <div class="profile-field">
                                <div class="profile-field-label">Address</div>
                                <div class="profile-field-value"><?php echo htmlspecialchars($student['address']); ?></div>
                            </div>
                            <div class="profile-field">
                                <div class="profile-field-label">State of Origin</div>
                                <div class="profile-field-value"><?php echo htmlspecialchars($student['state_of_origin']); ?></div>
                            </div>
                            <div class="profile-field">
                                <div class="profile-field-label">Local Government</div>
                                <div class="profile-field-value"><?php echo htmlspecialchars($student['lga']); ?></div>
                            </div>
                            <div class="profile-field">
                                <div class="profile-field-label">Next of Kin</div>
                                <div class="profile-field-value"><?php echo htmlspecialchars($student['next_of_kin']); ?></div>
                            </div>
                        </div>
                    </div>

                <?php else: ?>

                    <div class="glass-card-static">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            </div>
                            <h3>No Student Record Found</h3>
                            <p>Your account email (<strong><?php echo htmlspecialchars($user['email']); ?></strong>) does not match any registered student record. Please contact the school administrator to have your record linked.</p>
                        </div>
                    </div>

                <?php endif; ?>

            </div>
        </main>

        <?php renderFooter(); ?>
    </div>
</body>
</html>
