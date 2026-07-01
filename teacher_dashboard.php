<?php
require_once 'auth.php';
requireTeacher();

require_once 'db.php';
require_once 'partials.php';

$user = getCurrentUser();

// Fetch all students for read-only viewing
$stmt = $pdo->query("SELECT * FROM students ORDER BY last_name ASC");
$students = $stmt->fetchAll();

$total    = count($students);
$admitted = count(array_filter($students, fn($s) => $s['admission_status'] === 'Admitted'));
$undecided = $total - $admitted;
$avg_score = $total > 0 ? round(array_sum(array_column($students, 'end_of_term_score')) / $total) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php renderHead('Teacher Dashboard', 'Teacher view of student records at Royal School of Excellence.'); ?>
</head>
<body>
    <div class="page-wrapper">
        <?php renderNavbar('dashboard'); ?>

        <main class="main-content">
            <div class="container">

                <div class="page-title-bar">
                    <div>
                        <h1>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Teacher Dashboard
                        </h1>
                        <p><?php echo getGreetingMessage($user['full_name']); ?>. You can view student records and academic performance below.</p>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="stats-row">
                    <div class="stat-card gold">
                        <div class="stat-value"><?php echo $total; ?></div>
                        <div class="stat-label">Total Students</div>
                    </div>
                    <div class="stat-card success">
                        <div class="stat-value"><?php echo $admitted; ?></div>
                        <div class="stat-label">Admitted</div>
                    </div>
                    <div class="stat-card teal">
                        <div class="stat-value"><?php echo $undecided; ?></div>
                        <div class="stat-label">Undecided</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value"><?php echo $avg_score; ?>%</div>
                        <div class="stat-label">Avg. Score</div>
                    </div>
                </div>

                <!-- Student Table (Read-Only) -->
                <div class="glass-card-static">
                    <div class="section-heading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        <h3>Student Records (Read-Only)</h3>
                    </div>

                    <?php if (empty($students)): ?>
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            </div>
                            <h3>No Student Records</h3>
                            <p>No students have been registered yet.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-wrapper">
                            <table class="data-table" id="teacher-students-table">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Full Name</th>
                                        <th>Gender</th>
                                        <th>Score</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $s): ?>
                                    <tr>
                                        <td>
                                            <?php if (!empty($s['profile_image'])): ?>
                                                <img src="uploads/<?php echo htmlspecialchars($s['profile_image']); ?>" class="table-avatar" alt="">
                                            <?php else: ?>
                                                <div class="table-avatar" style="background: var(--primary-600); display:flex; align-items:center; justify-content:center; color: var(--gold-400); font-size:0.9rem; font-weight:700;">
                                                    <?php echo strtoupper(substr($s['first_name'], 0, 1)); ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td style="font-weight: 600;"><?php echo htmlspecialchars($s['first_name'] . ' ' . $s['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($s['gender']); ?></td>
                                        <td><?php echo $s['end_of_term_score']; ?>%</td>
                                        <td><span class="badge badge-<?php echo strtolower($s['admission_status']); ?>"><?php echo $s['admission_status']; ?></span></td>
                                        <td>
                                            <a href="view.php?id=<?php echo $s['id']; ?>" class="btn btn-teal btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="alert alert-info" style="margin-top: var(--space-xl);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    <div><strong>Teacher Access:</strong> You can view student records and profiles. To register new students or change admission status, please contact the school administrator.</div>
                </div>

            </div>
        </main>

        <?php renderFooter(); ?>
    </div>
</body>
</html>
