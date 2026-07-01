<?php
session_start();
require_once 'partials.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php renderHead('Admission Policy', 'Learn about the admission policies and entry requirements of Royal School of Excellence.'); ?>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            Admission Policy
                        </h1>
                        <p>Guidelines, eligibility requirements, and criteria for candidate selections and enrollments.</p>
                    </div>
                </div>

                <div class="glass-card-static">
                    
                    <div class="section-heading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 14 14"/></svg>
                        <h3>1. General Admission Guidelines</h3>
                    </div>
                    <p style="margin-bottom: var(--space-md); color: var(--neutral-700);">
                        Admissions at the Royal School of Excellence are based purely on merit, academic potential, and compatibility with our educational model. We promote equal opportunity and do not discriminate based on race, gender, religion, or state of origin.
                    </p>

                    <div class="section-divider"></div>

                    <div class="section-heading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <h3>2. Entry Requirements</h3>
                    </div>
                    <ul style="margin-left: var(--space-lg); margin-bottom: var(--space-md); color: var(--neutral-700); display: flex; flex-direction: column; gap: var(--space-sm);">
                        <li><strong>Age Limit:</strong> Candidates applying for high school must be at least 10 years of age by September of the entry year.</li>
                        <li><strong>Academic Criteria:</strong> An average end of term score of at least <strong>60%</strong> in the placement examinations or transfer evaluations.</li>
                        <li><strong>Documentation:</strong> Submission of verified birth certificate, complete transcripts from previous academic sessions, and 2 passport-sized photographs.</li>
                        <li><strong>Interview:</strong> A personal interaction assessment session with both the child and their parents/guardians to align educational values.</li>
                    </ul>

                    <div class="section-divider"></div>

                    <div class="section-heading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <h3>3. Selection & Verification Process</h3>
                    </div>
                    <p style="margin-bottom: var(--space-md); color: var(--neutral-700);">
                        Once the candidate registration details are compiled via the registry system, academic records are passed to the admissions board. Registered candidates' metrics, including their <strong>End of Term Score</strong>, are evaluated. 
                    </p>
                    <p style="color: var(--neutral-700);">
                        Approved candidates are listed on the administration dashboard. The principal administrator coordinates the final enrollment registry, toggling their official status to <strong>Admitted</strong>. Upon toggling, formal notification letters are dispatched via the student's email.
                    </p>

                </div>

            </div>
        </main>

        <!-- Footer -->
        <?php renderFooter(); ?>

    </div>
</body>
</html>
