<?php
session_start();
require_once 'partials.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php renderHead('FAQs', 'Frequently Asked Questions about the Royal School of Excellence student portal.'); ?>
    <style>
        .faq-item {
            margin-bottom: var(--space-lg);
            padding: var(--space-md) var(--space-lg);
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
        }
        .faq-item:hover {
            border-color: var(--gold-400);
            background: rgba(255, 255, 255, 0.4);
        }
        .faq-question {
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 1.05rem;
            color: var(--primary-900);
            margin-bottom: var(--space-xs);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .faq-question svg {
            color: var(--gold-600);
            flex-shrink: 0;
        }
        .faq-answer {
            color: var(--neutral-700);
            font-size: 0.95rem;
            line-height: 1.5;
            padding-left: 24px;
        }
    </style>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                            Frequently Asked Questions
                        </h1>
                        <p>Find quick answers to common questions about admissions, registration, and administrative records.</p>
                    </div>
                </div>

                <div class="glass-card-static">
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                            How do I register a new student?
                        </div>
                        <div class="faq-answer">
                            Admins can register new students by navigating to the "Register" tab in the navigation menu. Complete the form details (personal information, score, address, and next of kin) and upload a clear profile photo.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                            How does the Admission Status change work?
                        </div>
                        <div class="faq-answer">
                            From the Dashboard, locate the student and click "View" to open their profile. Scroll to the bottom to find the "Admission Status" section and toggle the switch. Toggling will instantly save changes to the SQLite database.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                            Can I search and filter student records?
                        </div>
                        <div class="faq-answer">
                            Yes! The Dashboard features a filter panel. You can search by full name, filter by admission status (Admitted/Undecided), filter by gender, and view students above a minimum End of Term Score.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                            How do I update a student's profile picture?
                        </div>
                        <div class="faq-answer">
                            Open the student's profile page and click the "Change Photo" button directly below their profile photo. Select a new image file, and it will upload and replace the existing photo instantly.
                        </div>
                    </div>

                </div>

            </div>
        </main>

        <!-- Footer -->
        <?php renderFooter(); ?>

    </div>
</body>
</html>
