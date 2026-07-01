# Royal School of Excellence — Student Portal Web Application

A premium, highly secure, and mobile-responsive Student Portal Web Application designed for **Royal School of Excellence**. Built with a lightweight backend using **PHP** and **SQLite (PDO)**, this project incorporates modern design principles like frosted glassmorphism, a light clean aesthetic, dynamic stats dashboards, and robust security controls (RBAC, MAC, and DAC).

---

## 🌟 Key Features

### 🎨 Visual & Design System
* **Premium Glassmorphism**: High-contrast, translucent frosted glass cards (`rgba(255, 255, 255, 0.42)`) with a deep `blur(25px)` effect system-wide.
* **Full-Opacity Background**: High-resolution, professional campus scenery background displaying at 100% opacity without dark layers.
* **Clean Light Theme**: Whitish background cards, soft border gradients, and highly legible deep navy (`var(--primary-900)`) typography.
* **Modern Typography & Icons**: Dynamic fonts (Outfit & Inter via Google Fonts) paired with minimalist, clean SVG icons.
* **Interactive Navigation**: Header menu bar with hover micro-animations that scrolls naturally with the page.
* **Rich Footer**: Four-column footer with clickable quick links, contact info, social handles, and active links to school resources.

### 🔒 Security & Access Control
* **RBAC (Role-Based Access Control)**:
  * **Admin**: Registers students, manages profiles, updates student photos, and toggles official admission status.
  * **Teacher**: Read-only directory access to monitor performance across all students.
  * **Student**: Access to personal academic stats and profile details.
  * **Parent / Guardian**: Access to monitor linked child/ward details and progress.
* **DAC (Discretionary Access Control)**:
  * Students can only view records matching their personal registration email.
  * Parents can only view records where their name matches the student's *Next of Kin*.
* **MAC (Mandatory Access Control)**: State-changing requests (updating admission status, uploading profile pictures, registering students) are strictly guarded at the server and transaction level to prevent privilege escalation.
* **Strict Single-Admin Rule**: Database validation limits the system to one and only one active Admin account. Subsequent Admin signup attempts are automatically blocked.

### 📁 Application Workflows
* **Register Student Profile**: Multi-field form including personal information, contact info, state of origin/LGA, next of kin details, and **End of Term Score** with automated file validation for profile image uploads.
* **Filterable Stats Dashboard**: Admins and Teachers can filter directory lists in real-time by name query, gender, admission status, and minimum End of Term Score.
* **Admission Toggle**: Admins can toggle candidates between `Admitted` and `Undecided` with instant database persistence.
* **Profile Picture Editor**: Admins can change or replace student photos directly from the profile view (automatically cleans up overwritten files from the server).
* **Clickable Resources**: Active subpages for **Academic Calendar**, **Admission Policy**, **Student Handbook** (with grading scale explanation table), and **FAQs**.
* **Time-Based Greetings**: Dynamic greetings greeting users based on the time of day (e.g. *"Good morning, Adewale Johnson"*).
* **Mobile-Responsive Layout**: Custom media queries optimized for mobile devices, featuring collapsing grid structures, swipeable data tables, and full-width touch targets.

---

## 🛠️ Technology Stack
* **Frontend**: HTML5, Vanilla CSS3 (custom tokens/variables), SVG Icons.
* **Backend**: PHP (PHP Sessions for authentication state tracking).
* **Database**: SQLite (configured with WAL mode for fast concurrency).

---

## 🚀 Installation & Local Setup

### Prerequisites
* PHP (version 7.4 or above) installed on your system.

### Steps
1. Clone this repository to your local directory:
   ```bash
   git clone https://github.com/your-username/royal-school-portal.git
   cd royal-school-portal
   ```
2. Set up the SQLite database and directory paths:
   The database (`database.sqlite`) and `uploads/` folder are automatically created and initialized upon first page load.
3. Start the PHP built-in server:
   ```bash
   php -S localhost:8000
   ```
4. Access the application in your browser at `http://localhost:8000`.

---

## 📋 Getting Started Guide
1. Run a clean setup by launching the web application.
2. Go to **Create Account** and register as an **Admin**.
3. Log in and navigate to the **Register** tab to add new students and scores.
4. Sign out and create accounts as a **Teacher**, **Student**, or **Parent** (matching the seeded emails or Next of Kin parameters) to verify the custom dashboard layouts and read-only access levels.
