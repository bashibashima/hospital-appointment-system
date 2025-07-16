# 🏥 Hospital Appointment Management System – Laravel 12

A modern web-based hospital appointment system built using Laravel 12. This system allows patients to book, cancel, and track appointments, while doctors and admins manage availability and status updates through role-based dashboards.

---

## ✨ Key Features

### 👤 Patient Panel
- Browse doctors and specializations
- Book, cancel, or reschedule appointments
- View upcoming & past appointment history
- Receive email confirmations

### 🩺 Appointment Management
- Dynamic time slot selection based on doctor availability
- Status tracking: Pending, Confirmed, Cancelled, Completed
- Add notes: symptoms, diagnosis, prescriptions

---

## 💡 Bonus Features (Optional)
- 🔍 Search doctors by specialization
- 📄 Export appointment history as PDF
- 📆 Calendar view with FullCalendar.js
- 📱 Mobile responsive layout
- 🌙 Dark/Light theme toggle

---

## 🛠 Technologies Used

- *Laravel 12* – MVC Architecture
- *Blade Templates* – UI Views
- *MySQL* – Relational Database
- *Eloquent ORM* – Relationships & Soft Deletes
- *AJAX* – Dynamic availability loading
- *Laravel Breeze* – Authentication scaffolding
- *Form Validation* – Secure input handling
- *Middleware* – Role-based access control

---

## 🗃 Database Schema Overview

| Table | Description |
|-------|-------------|
| users | id, name, email, password, role (admin/doctor/patient),status |
| specializations | id, name |
| doctors | id, user_id, specialization_id, bio |
| availabilities | id, doctor_id, day_of_week, time_slot |
| appointments | id, patient_id, doctor_id, date, time, status, notes |
| notifications | Laravel notification system |

---

## 🚀 Getting Started Locally

```bash
# Clone the repository
git clone https://github.com/yourusername/hospital-appointment-system.git
cd hospital-appointment-system

# Install dependencies
composer install

# Set up environment
cp .env.example .env
php artisan key:generate

# Configure your database settings in .env

# Run migrations and seeders
php artisan migrate --seed

# Serve the app
php artisan serve
