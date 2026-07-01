<?php
session_start();
require_once 'partials.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php renderHead('Student Handbook', 'Rules, guidelines, code of conduct, and academic grading metrics for students.'); ?>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5v-15z"/></svg>
                            Student Handbook
                        </h1>
                        <p>Essential guidance, institutional regulations, code of conduct, and academic systems.</p>
                    </div>
                </div>

                <div class="glass-card-static">
                    
                    <div class="section-heading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <h3>1. Code of Conduct</h3>
                    </div>
                    <p style="margin-bottom: var(--space-md); color: var(--neutral-700);">
                        Students at the Royal School of Excellence are expected to exhibit the highest levels of honesty, respect, and academic integrity. We focus on building character alongside intellectual growth.
                    </p>
                    <ul style="margin-left: var(--space-lg); margin-bottom: var(--space-md); color: var(--neutral-700); display: flex; flex-direction: column; gap: var(--space-sm);">
                        <li><strong>Attendance:</strong> A minimum of 90% attendance is required to qualify for promotional end of term exams.</li>
                        <li><strong>Uniform:</strong> The official school uniform must be worn neatly and completely during all school activities.</li>
                        <li><strong>Bullying & Harassment:</strong> Zero-tolerance policy. Any form of intimidation, bullying, or discrimination is met with immediate disciplinary action.</li>
                    </ul>

                    <div class="section-divider"></div>

                    <div class="section-heading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <h3>2. Academic Grading & Evaluation</h3>
                    </div>
                    <p style="margin-bottom: var(--space-md); color: var(--neutral-700);">
                        Student progress is continuously measured through homework, project research, periodic test cycles, and end of term examinations.
                    </p>
                    
                    <div class="table-wrapper" style="margin-bottom: var(--space-md);">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Score Range</th>
                                    <th>Letter Grade</th>
                                    <th>Interpretation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-weight: 600; color: var(--success);">85 - 100</td>
                                    <td>A</td>
                                    <td>Distinction (Excellent)</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: var(--teal-600);">70 - 84</td>
                                    <td>B</td>
                                    <td>Very Good</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: var(--info);">55 - 69</td>
                                    <td>C</td>
                                    <td>Good / Credit</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: var(--warning);">40 - 54</td>
                                    <td>D</td>
                                    <td>Pass</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: var(--danger);">0 - 39</td>
                                    <td>F</td>
                                    <td>Fail</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </main>

        <!-- Footer -->
        <?php renderFooter(); ?>

    </div>
</body>
</html>
