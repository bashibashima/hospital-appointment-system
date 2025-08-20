# 🏥 Laravel 12 Hospital Appointment System

A **web-based hospital appointment management system** built with **Laravel 12**, **MySQL**, and **Breeze authentication**.  
This project provides separate dashboards for **Admin**, **Doctor**, and **Patient** roles, enabling easy appointment booking, doctor availability management, and hospital scheduling.

---

## 🚀 Features

### 🔑 Authentication
- Laravel Breeze authentication (Login, Register, Forgot Password).
- Role-based access (Admin, Doctor, Patient).
- Middleware to protect role-specific routes.

### 👩‍⚕️ Admin Panel
- Approve or reject doctor registrations.
- Manage doctor profiles and specializations.
- Create and manage **global time slots** (e.g., Mon–Fri, 9 AM – 5 PM, 30 min).
- Assign availability slots to doctors.
- View statistics: doctors, patients, and appointment counts.
- Export data (CSV, PDF).
- Send email notifications to doctors after approval.

### 🩺 Doctor Panel
- View upcoming, accepted, pending, and completed appointments.
- Accept / Reject / Reschedule appointments.
- View **patient history** (past appointments).
- Profile management (bio, specialization, contact).
- View assigned availability (set by Admin).

### 👨‍🦱 Patient Panel
- Book appointments with doctors based on availability.
- View upcoming and past appointments.
- Cancel appointments.
- Add notes/symptoms during booking.

### 📅 Time Slot Management
- **Admin defines global weekly slots** (start time, end time, duration, working days).
- System auto-generates slots for doctors.
- Only free slots are displayed to patients when booking.
- Booked slots are automatically removed from availability.

### 🔔 Notifications
- Doctors receive notifications for new bookings, cancellations, and reschedules.
- Patients receive confirmation/cancellation updates.

---

## 🛠️ Tech Stack

- **Framework:** Laravel 12
- **Authentication:** Laravel Breeze
- **Database:** MySQL (XAMPP)
- **Frontend:** Blade Templates + TailwindCSS
- **PDF/CSV Export:** DomPDF / Laravel Excel
- **Mail:** Laravel Mail (for doctor approval + booking notifications)

---

## 📂 Database Schema (Key Tables)

- `users` – Stores Admin, Doctor, and Patient accounts (with role).
- `specializations` – Stores doctor specialization fields.
- `doctors` – Links doctors with user_id, specialization_id, and bio.
- `appointments` – Stores appointments (doctor_id, patient_id, date, time, status).
- `availabilities` – Doctor availability per day/slot.
- `global_time_slots` – Stores default slot settings for all doctors.
- `notifications` – Stores in-app notifications.

---

## ⚡ Installation Guide

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/hospital-appointment-system.git
   cd hospital-appointment-system
