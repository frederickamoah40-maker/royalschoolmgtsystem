<?php
require_once 'auth.php';
requireParent();

require_once 'db.php';
require_once 'partials.php';

$user = getCurrentUser();

// DAC: Parents can only see student records where they are listed as next_of_kin
$stmt = $pdo->prepare("SELECT * FROM students WHERE next_of_kin LIKE :kin ORDER BY last_name ASC");
$stmt->execute([':kin' => '%' . $user['full_name'] . '%']);
$children = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php renderHead('Parent Dashboard', 'Monitor your child\'s academic performance and admission status.'); ?>
</head>
<body>
    <div class="page-wrapper">
        <?php renderNavbar('dashboard'); ?>

        <main class="main-content">
            <div class="container" style="max-width: 1000px;">

                <div class="page-title-bar">
                    <div>
                        <h1>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Parent Dashboard
                        </h1>
                        <p><?php echo getGreetingMessage($user['full_name']); ?>. Below are your ward's academic records.</p>
                    </div>
                </div>

                <?php if (!empty($children)): ?>

                    <?php foreach ($children as $child): ?>
                    <div class="glass-card-static" style="margin-bottom: var(--space-xl);">
                        
                        <div class="profile-header">
                            <div style="text-align: center; display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                <?php if (!empty($child['profile_image'])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($child['profile_image']); ?>" alt="" class="profile-avatar" style="margin-bottom: 0;">
                                <?php else: ?>
                                    <div class="profile-avatar" style="background: var(--primary-600); display:flex; align-items:center; justify-content:center; color: var(--gold-400); font-size: 2.5rem; font-weight: 800; margin-bottom: 0;">
                                        <?php echo strtoupper(substr($child['first_name'], 0, 1)); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="profile-name">
                                <h2><?php echo htmlspecialchars($child['first_name'] . ' ' . ($child['middle_name'] ? $child['middle_name'] . ' ' : '') . $child['last_name']); ?></h2>
                                <p><?php echo htmlspecialchars($child['email']); ?></p>
                                <div style="margin-top: var(--space-sm);">
                                    <span class="badge badge-<?php echo strtolower($child['admission_status']); ?>"><?php echo $child['admission_status']; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="section-divider"></div>

                        <div class="stats-row">
                            <div class="stat-card gold">
                                <div class="stat-value"><?php echo $child['end_of_term_score']; ?>%</div>
                                <div class="stat-label">End of Term Score</div>
                            </div>
                            <div class="stat-card teal">
                                <div class="stat-value"><?php echo $child['admission_status']; ?></div>
                                <div class="stat-label">Admission Status</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value"><?php echo htmlspecialchars($child['gender']); ?></div>
                                <div class="stat-label">Gender</div>
                            </div>
                        </div>

                        <div class="section-heading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <h3>Ward Details</h3>
                        </div>

                        <div class="profile-grid">
                            <div class="profile-field">
                                <div class="profile-field-label">Date of Birth</div>
                                <div class="profile-field-value"><?php echo htmlspecialchars(date('F j, Y', strtotime($child['dob']))); ?></div>
                            </div>
                            <div class="profile-field">
                                <div class="profile-field-label">Phone</div>
                                <div class="profile-field-value"><?php echo htmlspecialchars($child['phone']); ?></div>
                            </div>
                            <div class="profile-field">
                                <div class="profile-field-label">Address</div>
                                <div class="profile-field-value"><?php echo htmlspecialchars($child['address']); ?></div>
                            </div>
                            <div class="profile-field">
                                <div class="profile-field-label">State of Origin</div>
                                <div class="profile-field-value"><?php echo htmlspecialchars($child['state_of_origin']); ?></div>
                            </div>
                        </div>

                    </div>
                    <?php endforeach; ?>

                    <div class="alert alert-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <div><strong>Parent Access:</strong> You can monitor your ward's academic status. For any changes or inquiries, please contact the school administration.</div>
                    </div>

                <?php else: ?>

                    <div class="glass-card-static">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            </div>
                            <h3>No Linked Student Records</h3>
                            <p>Your name (<strong><?php echo htmlspecialchars($user['full_name']); ?></strong>) was not found as the Next of Kin for any registered student. Please contact the administrator to link your ward's record.</p>
                        </div>
                    </div>

                <?php endif; ?>

            </div>
        </main>

        <?php renderFooter(); ?>
    </div>
</body>
</html>
