<?php
session_start();
require_once 'partials.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php renderHead('Academic Calendar', 'Official Academic Calendar for the Royal School of Excellence.'); ?>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Academic Calendar
                        </h1>
                        <p>Important dates, exam schedules, and holiday schedules for the current academic session.</p>
                    </div>
                </div>

                <div class="glass-card-static">
                    
                    <!-- Term 1 -->
                    <div class="section-heading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <h3>First Term (Autumn Session)</h3>
                    </div>
                    
                    <div class="table-wrapper" style="margin-bottom: var(--space-xl);">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Event / Activity</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-weight: 600;">Resumption & Registration</td>
                                    <td>September 14, 2026</td>
                                    <td><span class="badge badge-admitted">Completed</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Lectures Begin</td>
                                    <td>September 21, 2026</td>
                                    <td><span class="badge badge-admitted">Completed</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Mid-Term Break</td>
                                    <td>October 26 - 30, 2026</td>
                                    <td><span class="badge badge-admitted">Completed</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">End of Term Examinations</td>
                                    <td>December 7 - 18, 2026</td>
                                    <td><span class="badge badge-undecided">Scheduled</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Christmas/New Year Vacation</td>
                                    <td>Dec 21, 2026 - Jan 8, 2027</td>
                                    <td><span class="badge badge-undecided">Scheduled</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Term 2 -->
                    <div class="section-heading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <h3>Second Term (Spring Session)</h3>
                    </div>
                    
                    <div class="table-wrapper" style="margin-bottom: var(--space-xl);">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Event / Activity</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-weight: 600;">Resumption & Lectures Commence</td>
                                    <td>January 11, 2027</td>
                                    <td><span class="badge badge-undecided">Scheduled</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Inter-House Sports Festival</td>
                                    <td>February 19, 2027</td>
                                    <td><span class="badge badge-undecided">Scheduled</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Mid-Term Break</td>
                                    <td>March 1 - 5, 2027</td>
                                    <td><span class="badge badge-undecided">Scheduled</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">End of Term Examinations</td>
                                    <td>April 5 - 16, 2027</td>
                                    <td><span class="badge badge-undecided">Scheduled</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Easter/Spring Break</td>
                                    <td>April 19 - May 7, 2027</td>
                                    <td><span class="badge badge-undecided">Scheduled</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Term 3 -->
                    <div class="section-heading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <h3>Third Term (Summer Session)</h3>
                    </div>
                    
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Event / Activity</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-weight: 600;">Resumption & Academic Work Begins</td>
                                    <td>May 10, 2027</td>
                                    <td><span class="badge badge-undecided">Scheduled</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Annual Cultural Day & Arts Exhibition</td>
                                    <td>June 18, 2027</td>
                                    <td><span class="badge badge-undecided">Scheduled</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Promotional & Graduation Exams</td>
                                    <td>July 12 - 23, 2027</td>
                                    <td><span class="badge badge-undecided">Scheduled</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Valedictory Service & Graduation</td>
                                    <td>July 30, 2027</td>
                                    <td><span class="badge badge-undecided">Scheduled</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Summer Vacation</td>
                                    <td>August 2 - September 10, 2027</td>
                                    <td><span class="badge badge-undecided">Scheduled</span></td>
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
