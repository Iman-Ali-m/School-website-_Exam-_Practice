# 🎓 University Management System

A web-based University Management System built with **PHP**, **MySQL**, and **PDO**. This system provides a complete platform for managing university courses, users, exams, assignments, and grades with three distinct user roles: **Student**, **Professor**, and **Staff**.

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Technology Stack](#-technology-stack)
- [System Architecture](#-system-architecture)
- [Database Schema](#-database-schema)
- [Installation](#-installation)
- [Usage](#-usage)
- [User Roles](#-user-roles)
- [File Structure](#-file-structure)
- [Security Considerations](#-security-considerations)
- [Future Improvements](#-future-improvements)

---

## 🔍 Overview

The University Management System is a comprehensive web application designed to streamline academic operations. It enables:

- **Staff members** to manage users (students, professors, and staff) and courses.
- **Professors** to create exams, grade assignments, and manage course grades.
- **Students** to enroll in courses, submit assignments, take exams, and view their grades.

The system is built using a modular approach, where each functionality is separated into its own PHP file, following a simple and readable architecture.

---

## ✨ Features

### 👨‍💼 Staff Features
- Add, delete, and manage users (students, professors, staff)
- Add and delete courses
- Assign professors to courses
- Enroll students in courses

### 👨‍🏫 Professor Features
- Create exams with multiple question types (Multiple Choice, True/False, Descriptive, Fill in the Blank)
- View student exam answers and assign grades
- View and grade student assignment submissions
- Edit course grades (assignment, exam, and final grades)

### 👨‍🎓 Student Features
- View enrolled courses
- Submit assignments (file upload)
- Take online exams
- View grades (exam, assignment, and total)

### 🔐 Authentication & Authorization
- Role-based login (Student, Professor, Staff)
- Password hashing using `password_hash()` with BCRYPT
- Session-based authentication
- Fixed code verification for staff registration

---

## 🛠 Technology Stack

| Technology | Purpose |
|------------|---------|
| **PHP 8+** | Backend logic and server-side rendering |
| **MySQL / MariaDB** | Relational database |
| **PDO** | Secure database access with prepared statements |
| **HTML5** | Page structure |
| **CSS3** | Styling (custom `styles.css`) |
| **JavaScript** | Client-side interactivity (dynamic question creation) |
| **Session Management** | User authentication state |

---

## 🏗 System Architecture

The application follows a **simple procedural PHP architecture** with the following pattern:
