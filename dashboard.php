<?php
require_once 'auth.php';
requireAdmin();

require_once 'db.php';
require_once 'partials.php';

// ---- Build query with filters ----
$where_clauses = [];
$params = [];

// Filter: Search by name
$search_name = trim($_GET['search_name'] ?? '');
if (!empty($search_name)) {
    $where_clauses[] = "(first_name LIKE :name OR middle_name LIKE :name2 OR last_name LIKE :name3)";
    $params[':name']  = '%' . $search_name . '%';
    $params[':name2'] = '%' . $search_name . '%';
    $params[':name3'] = '%' . $search_name . '%';
}

// Filter: Admission status
$filter_status = trim($_GET['filter_status'] ?? '');
if (!empty($filter_status) && in_array($filter_status, ['Admitted', 'Undecided'])) {
    $where_clauses[] = "admission_status = :status";
    $params[':status'] = $filter_status;
}

// Filter: Gender
$filter_gender = trim($_GET['filter_gender'] ?? '');
if (!empty($filter_gender) && in_array($filter_gender, ['Male', 'Female'])) {
    $where_clauses[] = "gender = :gender";
    $params[':gender'] = $filter_gender;
}

// Filter: Minimum End of term score
$filter_score = trim($_GET['filter_score'] ?? '');
if ($filter_score !== '' && is_numeric($filter_score)) {
    $where_clauses[] = "end_of_term_score >= :score";
    $params[':score'] = intval($filter_score);
}

$sql = "SELECT id, first_name, middle_name, last_name, gender, end_of_term_score, admission_status, profile_image FROM students";
if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}
$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$students = $stmt->fetchAll();

// Get statistics
$total_students = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$admitted_count = $pdo->query("SELECT COUNT(*) FROM students WHERE admission_status = 'Admitted'")->fetchColumn();
$undecided_count = $pdo->query("SELECT COUNT(*) FROM students WHERE admission_status = 'Undecided'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php renderHead('Dashboard', 'Student records dashboard — view, search, and filter all registered students.'); ?>
</head>
<body>
    <div class="page-wrapper">

        <!-- Navbar -->
        <?php renderNavbar('dashboard'); ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="container">

                <div class="page-title-bar">
                    <div>
                        <h1>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                            Student Dashboard
                        </h1>
                        <p><?php echo getGreetingMessage($_SESSION['user_name']); ?>. View and manage all registered student records.</p>
                    </div>
                    <a href="form.php" class="btn btn-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Register New Student
                    </a>
                </div>

                <!-- Stats Row -->
                <div class="stats-row">
                    <div class="stat-card gold">
                        <div class="stat-value"><?php echo $total_students; ?></div>
                        <div class="stat-label">Total Students</div>
                    </div>
                    <div class="stat-card success">
                        <div class="stat-value"><?php echo $admitted_count; ?></div>
                        <div class="stat-label">Admitted</div>
                    </div>
                    <div class="stat-card teal">
                        <div class="stat-value"><?php echo $undecided_count; ?></div>
                        <div class="stat-label">Undecided</div>
                    </div>
                </div>

                <!-- Filter Bar -->
                <form method="GET" action="dashboard.php" id="filter-form">
                    <div class="filter-bar">
                        <div class="filter-group" style="flex: 2;">
                            <label for="search_name">Search by Name</label>
                            <input type="text" class="form-control" name="search_name" id="search_name"
                                   placeholder="Type a name..."
                                   value="<?php echo htmlspecialchars($search_name); ?>">
                        </div>
                        <div class="filter-group">
                            <label for="filter_status">Admission Status</label>
                            <select class="form-control" name="filter_status" id="filter_status">
                                <option value="">All</option>
                                <option value="Admitted" <?php echo $filter_status === 'Admitted' ? 'selected' : ''; ?>>Admitted</option>
                                <option value="Undecided" <?php echo $filter_status === 'Undecided' ? 'selected' : ''; ?>>Undecided</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="filter_gender">Gender</label>
                            <select class="form-control" name="filter_gender" id="filter_gender">
                                <option value="">All</option>
                                <option value="Male" <?php echo $filter_gender === 'Male' ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo $filter_gender === 'Female' ? 'selected' : ''; ?>>Female</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="filter_score">Min End of Term Score</label>
                            <input type="number" class="form-control" name="filter_score" id="filter_score"
                                   placeholder="e.g. 70" min="0" max="100"
                                   value="<?php echo htmlspecialchars($filter_score); ?>">
                        </div>
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-teal btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                                Filter
                            </button>
                            <a href="dashboard.php" class="btn btn-secondary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                Clear
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Results Table -->
                <div class="glass-card-static" style="padding: 0; overflow: hidden;">
                    <?php if (count($students) > 0): ?>
                        <div class="table-wrapper">
                            <table class="data-table" id="students-table">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Photo</th>
                                        <th>Full Name</th>
                                        <th>Gender</th>
                                        <th>End of Term Score</th>
                                        <th>Admission Status</th>
                                        <th style="width: 100px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $i => $student): ?>
                                        <tr>
                                            <td style="color: var(--neutral-500);"><?php echo $i + 1; ?></td>
                                            <td>
                                                <?php if (!empty($student['profile_image'])): ?>
                                                    <img src="uploads/<?php echo htmlspecialchars($student['profile_image']); ?>"
                                                         alt="<?php echo htmlspecialchars($student['first_name']); ?>"
                                                         class="table-avatar">
                                                <?php else: ?>
                                                    <div class="table-avatar" style="background: var(--primary-600); display:flex; align-items:center; justify-content:center; color: var(--neutral-400); font-size: 0.8rem;">
                                                        <?php echo strtoupper(substr($student['first_name'], 0, 1)); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td style="font-weight: 600; color: var(--neutral-100);">
                                                <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name']); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($student['gender']); ?></td>
                                            <td style="font-weight: 600; color: var(--gold-400);"><?php echo $student['end_of_term_score']; ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo strtolower($student['admission_status']); ?>">
                                                    <?php echo htmlspecialchars($student['admission_status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="view.php?id=<?php echo $student['id']; ?>" class="btn btn-teal btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0z"/><circle cx="12" cy="12" r="3"/></svg>
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="8" x2="12" y1="12" y2="12"/><line x1="12" x2="16" y1="12" y2="12"/></svg>
                            </div>
                            <h3>No Records Found</h3>
                            <p>
                                <?php if (!empty($where_clauses)): ?>
                                    No students match your current filters. <a href="dashboard.php" style="color: var(--gold-400);">Clear filters</a>
                                <?php else: ?>
                                    No students have been registered yet. <a href="form.php" style="color: var(--gold-400);">Register the first student</a>
                                <?php endif; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

                <p style="color: var(--neutral-500); font-size: 0.85rem; margin-top: var(--space-md); text-align: right;">
                    Showing <?php echo count($students); ?> record(s)
                </p>

            </div>
        </main>

        <!-- Footer -->
        <?php renderFooter(); ?>

    </div>
</body>
</html>
