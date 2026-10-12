# Village Registry System - Recent Updates (2025-08-01)

## Recent Changes

### 1. Death Registration
- Added new required fields: **village**, **sector**, and **family_contact** to the death registration form and database.
- Added a **Date of Death** field to the form (date picker).
- Fixed warnings for undefined array keys by checking all POST fields before use.
- Improved form validation and error handling.
- Improved form layout: added left and right padding to the card container for better appearance.
- Removed duplicate fields from the death registration form.

### 2. Birth Registration
- Added new required fields: **village** and **sector** to the birth registration form and database.
- Fixed warnings for undefined array keys by checking all POST fields before use.

### 3. User Registration & Login
- Updated user registration to include **village** and **sector** fields (requires users table to be altered).
- Updated login and registration logic to match new users table structure.
- Passwords are securely hashed using PHP's `password_hash()`.

### 4. Database Schema
- **users** table: now includes `village` and `sector` columns.
- **births** table: now includes `village` and `sector` columns.
- **deaths** table: now includes `village`, `sector`, and `family_contact` columns.

### 5. General Bug Fixes
- Fixed all PHP warnings about undefined array keys in forms and backend.
- Ensured all form fields are validated and repopulated after submission errors.

### 6. UI Improvements
- Added padding to form containers to prevent content from touching the card edges.
- Improved error and success message display.

---
For more details, see the relevant PHP files (register_birth.php, register_death.php, register.php, login.php, view_births.php, view_deaths.php) and the database migration scripts.

# Village Birth and Death Register System

A comprehensive PHP-based web application for managing birth and death registrations in villages, built with HTML, CSS, JavaScript, MySQL, and Bootstrap.

## 🚀 Features

### Core Functionality
- **User Authentication**: Secure login/logout system with PHP sessions
- **Role-based Access Control**: Admin and Officer roles with different permissions
- **Birth Registration**: Complete birth record management with detailed forms
- **Death Registration**: Comprehensive death record tracking
- **Record Viewing**: Paginated lists with search functionality
- **PDF Certificate Generation**: Professional birth and death certificates
- **Responsive Design**: Mobile-friendly interface using Bootstrap 5
- **Accessibility**: All forms and navigation are accessible and screen-reader friendly
- **Interactive UI**: Live feedback, modals, and auto-hiding alerts

### Technical Features
- **Security**: Input validation, SQL injection prevention using prepared statements
- **Database**: MySQL with proper foreign key relationships
- **Search**: Advanced search across multiple fields
- **Pagination**: Efficient record browsing
- **Print-friendly PDFs**: Certificate generation with print optimization
- **Consistent Database Name**: Uses `village_register` everywhere for reliability
- **Enhanced Feedback**: All forms provide clear, actionable, and dismissible feedback
- **UI/UX Polish**: Modern look, button hover effects, favicon, and consistent layout

## 📋 Requirements

- **Web Server**: Apache (XAMPP/WAMP/LAMP)
- **PHP**: Version 7.4 or higher
- **MySQL**: Version 5.7 or higher
- **Web Browser**: Modern browser with JavaScript enabled

## 🛠️ Installation

### 1. Setup Environment
```bash
# If using XAMPP, start Apache and MySQL services
# Place project in htdocs folder: C:\xampp\htdocs\Village-registry-system
```

### 2. Database Setup
1. Access the setup page: `http://localhost/Village-registry-system/setup.php`
2. This will automatically:
   - Create the `village_register` database
   - Create all necessary tables
   - Insert default admin and officer users

### 3. Default Login Credentials
- **Administrator**: 
  - Email: `admin@village.com`
  - Password: `admin123`
- **Officer**: 
  - Email: `officer@village.com`
  - Password: `officer123`

## 📁 Project Structure

```
Village-registry-system/
├── includes/
│   ├── db.php              # Database connection (uses 'village_register')
│   ├── auth.php            # Authentication and session management
│   ├── header.php          # Page header, navigation, and CSS
│   └── footer.php          # Page footer and JS
├── register_birth.php      # Birth registration form
├── register_death.php      # Death registration form
├── view_births.php         # List/search birth records
├── view_deaths.php         # List/search death records
├── generate_birth_cert.php # Generate birth certificate PDF
├── generate_death_cert.php # Generate death certificate PDF
├── login.php               # Login page
├── logout.php              # Logout script
├── index.php               # Dashboard
├── setup.php               # Database setup script
├── assets/                 # Static assets (favicon, images, etc.)
└── pdf/                    # PDF generation libraries
```

## 🧑‍💻 Usage Guide

1. **Login**: Go to `http://localhost/Village-registry-system/` and log in with the provided credentials.
2. **Dashboard**: View system statistics, quick actions, and recent activities.
3. **Register Birth/Death**: Use the forms to register new records. All fields are required and validated.
4. **View Records**: Browse, search, and view details of all records. Generate certificates as needed.
5. **Logout**: Use the user menu to securely log out.

## 🔒 Security & Data Validation
- All user input is validated and sanitized on both client and server.
- Prepared statements are used for all database queries.
- Session-based authentication and role checks are enforced.
- Passwords are securely hashed.

## 🎨 Customization
- **Styling**: Bootstrap 5 and custom CSS in `includes/header.php`.
- **Favicon**: Located in `assets/favicon.png`.
- **Color scheme**: Easily modified in CSS variables.

## ✅ Testing
- All features have been tested for errors, usability, and responsiveness.
- Forms provide instant feedback and clear error/success messages.
- Works on both desktop and mobile devices.

---

**Project developed as a Web Design Final Exam. All requirements for front-end, back-end, interactivity, security, and user-friendliness have been met.**
