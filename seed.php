<?php
/**
 * Database Seeder Script
 * Run this to seed the database with diverse roles: Admin, Teacher, Student, Parent
 */
require_once 'db.php';

try {
    // Drop existing tables to ensure clean schema rebuild
    $pdo->exec("DROP TABLE IF EXISTS users");
    $pdo->exec("DROP TABLE IF EXISTS students");

    // Re-run initialization by requiring db.php again (db.php code will execute and build tables)
    require 'db.php';

    // Password hash for all seeded accounts
    $password_hash = password_hash('password123', PASSWORD_DEFAULT);

    // Insert system users with different roles
    $user_stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (:name, :email, :password, :role)");

    // Admin account
    $user_stmt->execute([
        ':name' => 'Principal Admin',
        ':email' => 'admin@royal.edu',
        ':password' => $password_hash,
        ':role' => 'Admin'
    ]);

    // Teacher account
    $user_stmt->execute([
        ':name' => 'Mrs. Elizabeth Smith',
        ':email' => 'teacher@royal.edu',
        ':password' => $password_hash,
        ':role' => 'Teacher'
    ]);

    // Student account (shares email with student record for DAC match)
    $user_stmt->execute([
        ':name' => 'Adewale Johnson',
        ':email' => 'student@royal.edu',
        ':password' => $password_hash,
        ':role' => 'Student'
    ]);

    // Parent account (linked to student's next of kin / matching surname for DAC match)
    $user_stmt->execute([
        ':name' => 'Mrs. Funke Johnson',
        ':email' => 'parent@royal.edu',
        ':password' => $password_hash,
        ':role' => 'Parent'
    ]);


    // Insert student records
    $student_stmt = $pdo->prepare("
        INSERT INTO students (first_name, middle_name, last_name, email, dob, gender, phone, address, state_of_origin, lga, next_of_kin, end_of_term_score, profile_image, admission_status)
        VALUES (:first_name, :middle_name, :last_name, :email, :dob, :gender, :phone, :address, :state_of_origin, :lga, :next_of_kin, :end_of_term_score, :profile_image, :admission_status)
    ");

    // Student 1 (linked to Student user by email)
    $student_stmt->execute([
        ':first_name' => 'Adewale',
        ':middle_name' => 'Olamide',
        ':last_name' => 'Johnson',
        ':email' => 'student@royal.edu', // links with student account
        ':dob' => '2005-04-12',
        ':gender' => 'Male',
        ':phone' => '08012345678',
        ':address' => '12, Herbert Macaulay Way, Yaba, Lagos State',
        ':state_of_origin' => 'Lagos',
        ':lga' => 'Lagos Mainland',
        ':next_of_kin' => 'Mrs. Funke Johnson', // matches Parent user's name
        ':end_of_term_score' => 88,
        ':profile_image' => '',
        ':admission_status' => 'Admitted'
    ]);

    // Student 2 (other records)
    $student_stmt->execute([
        ':first_name' => 'Chioma',
        ':middle_name' => 'Grace',
        ':last_name' => 'Okonkwo',
        ':email' => 'chioma@example.com',
        ':dob' => '2004-09-24',
        ':gender' => 'Female',
        ':phone' => '08087654321',
        ':address' => '45, Awolowo Road, Ikoyi, Lagos State',
        ':state_of_origin' => 'Anambra',
        ':lga' => 'Idemili North',
        ':next_of_kin' => 'Mr. Emeka Okonkwo',
        ':end_of_term_score' => 92,
        ':profile_image' => '',
        ':admission_status' => 'Admitted'
    ]);

    $student_stmt->execute([
        ':first_name' => 'Amina',
        ':middle_name' => '',
        ':last_name' => 'Bello',
        ':email' => 'amina@example.com',
        ':dob' => '2006-01-15',
        ':gender' => 'Female',
        ':phone' => '08123450987',
        ':address' => '78, Gwarinpa Estate, Abuja FCT',
        ':state_of_origin' => 'Kano',
        ':lga' => 'Nasarawa',
        ':next_of_kin' => 'Alhaji Ibrahim Bello',
        ':end_of_term_score' => 64,
        ':profile_image' => '',
        ':admission_status' => 'Undecided'
    ]);

    $student_stmt->execute([
        ':first_name' => 'Tunde',
        ':middle_name' => 'Moses',
        ':last_name' => 'Adebayo',
        ':email' => 'tunde@example.com',
        ':dob' => '2005-11-05',
        ':gender' => 'Male',
        ':phone' => '09011223344',
        ':address' => '3, Ring Road, Ibadan, Oyo State',
        ':state_of_origin' => 'Oyo',
        ':lga' => 'Ibadan North',
        ':next_of_kin' => 'Dr. Segun Adebayo',
        ':end_of_term_score' => 78,
        ':profile_image' => '',
        ':admission_status' => 'Undecided'
    ]);

    echo "Database successfully reseeded with multi-role accounts:\n";
    echo "1. Admin:   admin@royal.edu   / password123\n";
    echo "2. Teacher: teacher@royal.edu / password123\n";
    echo "3. Student: student@royal.edu / password123\n";
    echo "4. Parent:  parent@royal.edu  / password123\n";

} catch (PDOException $e) {
    die("Reseeding failed: " . $e->getMessage());
}
