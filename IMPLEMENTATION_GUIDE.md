# 🎉 Laravel Event Management System - Complete Implementation Guide

## 📋 Table of Contents
1. [Project Overview](#project-overview)
2. [System Architecture](#system-architecture)
3. [Directory Structure](#directory-structure)
4. [Features by User Type](#features-by-user-type)
5. [Installation Guide](#installation-guide)
6. [Middleware & Routes](#middleware--routes)
7. [Database Structure](#database-structure)
8. [Testing Guide](#testing-guide)
9. [Troubleshooting](#troubleshooting)

---

## 🎯 Project Overview

**Project Name:** Laravel Event Management System  
**Framework:** Laravel 12  
**Database:** MySQL  
**Frontend:** Bootstrap 4 + Custom CSS  
**Architecture:** MVC with Separated Frontend/Backend  

### Purpose
A comprehensive web application for managing events with proper separation between:
- **Frontend** - Public event browsing and registration
- **User Panel** - Registered user event management
- **Backend** - Admin/Staff event and guest management

---

## 🏗️ System Architecture

### User Types & Access Levels

```
┌─────────────────────────────────────────────────┐
│                  Guest Users                     │
│  - Browse published events                       │
│  - View event details                            │
│  - Register account                              │
└─────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────┐
│               Registered Users                   │
│  - All Guest features                            │
│  - Register for events                           │
│  - View own registrations                        │
│  - Manage profile                                │
└─────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────┐
│            Organizers / Admins                   │
│  - All User features                             │
│  - Create/manage events                          │
│  - Create/manage organizers                      │
│  - Manage all guests                             │
│  - View reports & analytics                      │
└─────────────────────────────────────────────────┘
```

---

## 📁 Directory Structure

### Views Structure (Separated)

```
resources/views/
│
├── frontend/                    # Public/Guest Users
│   ├── layout/
│   │   └── app.blade.php       # Frontend layout
│   ├── events/
│   │   ├── index.blade.php     # Browse events
│   │   ├── show.blade.php      # Event details
│   │   └── register.blade.php  # Event registration
│   └── auth/
│       ├── login.blade.php
│       ├── register.blade.php
│       └── forgot-password.blade.php
│
├── user/                        # Registered Users
│   ├── layout/
│   │   └── app.blade.php       # User panel layout
│   └── events/
│       └── my-events.blade.php # User's registrations
│
└── backend/                     # Admin/Staff Only
    ├── layout/
    │   ├── app.blade.php       # Admin layout
    │   ├── header.blade.php
    │   ├── sidebar.blade.php
    │   └── footer.blade.php
    ├── pages/
    │   ├── events/             # Event management
    │   ├── organizer/          # Organizer management
    │   ├── guests/             # Guest management
    │   └── reports/            # Analytics
    └── assets/
        ├── css/
        └── js/
```

### Complete Project Structure

```
midterm/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   ├── RegisterController.php
│   │   │   │   └── ForgotPasswordController.php
│   │   │   ├── EventController.php
│   │   │   ├── OrganizerController.php
│   │   │   ├── GuestController.php
│   │   │   ├── ReportController.php
│   │   │   ├── HomeController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php
│   │   └── Requests/
│   │       ├── CreateEventRequest.php
│   │       ├── CreateOrganizerRequest.php
│   │       └── UpdateOrganizerRequest.php
│   └── Models/
│       ├── User.php
│       ├── Event.php
│       ├── Organizer.php
│       └── Guest.php
│
├── database/
│   ├── migrations/
│   │   ├── *_create_users_table.php
│   │   ├── *_create_events_table.php
│   │   ├── *_create_organizers_table.php
│   │   ├── *_create_guests_table.php
│   │   └── *_add_*_to_*.php
│   └── seeders/
│       ├── UserSeeder.php
│       └── EventSeeder.php
│
├── routes/
│   └── web.php                # All route definitions
│
└── resources/views/           # See above
```

---

## ✨ Features by User Type

### Guest Users (No Login Required)

| Feature | Route | Description |
|---------|-------|-------------|
| Browse Events | `/events` | View all published events |
| View Event Details | `/event/{id}` | See event information |
| Register Account | `/register` | Create user account |
| Login | `/login` | Access account |

### Registered Users

| Feature | Route | Description |
|---------|-------|-------------|
| All Guest Features | - | Plus features below |
| Register for Event | `/event/{id}/register` | Sign up for events |
| My Events | `/my-events` | View registrations |
| Edit Profile | `/profile/edit` | Update information |
| Change Password | `/profile/password` | Update password |

### Admins/Organizers Only

| Feature | Route | Description |
|---------|-------|-------------|
| Create Event | `/create-event` | Add new events |
| Manage Events | `/events` | CRUD operations |
| Manage Organizers | `/organizer` | CRUD operations |
| Manage Guests | `/guests` | All guest management |
| View Reports | `/reports` | Analytics dashboard |

---

## 🚀 Installation Guide

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Git

### Step-by-Step Setup

```bash
# 1. Clone repository
git clone <your-repo-url>
cd midterm

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database (.env)
DB_CONNECTION=mysql
DB_DATABASE=event_management
DB_USERNAME=root
DB_PASSWORD=your_password

# 5. Create database
mysql -u root -p
CREATE DATABASE event_management;
EXIT;

# 6. Run migrations
php artisan migrate:fresh --seed

# 7. Build assets
npm run dev

# 8. Start server
php artisan serve
```

Visit: **http://localhost:8000**

### Default Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| Organizer | organizer@example.com | password |
| User | user@example.com | password |

---

## 🔐 Middleware & Routes

### Middleware Types

**1. Guest Middleware**
```php
Route::middleware('guest')->group(function () {
    // Login, Register routes
});
```
- Redirects authenticated users
- Used for auth forms

**2. Auth Middleware**
```php
Route::middleware('auth')->group(function () {
    // All authenticated routes
});
```
- Requires login
- Protects user routes

**3. Role Middleware**
```php
Route::middleware('role:admin,organizer')->group(function () {
    // Admin-only routes
});
```
- Checks user role
- Restricts to admin/organizer

### Route Groups

```php
// Public routes
Route::get('/events', 'EventController@publicIndex');
Route::get('/event/{event}', 'EventController@publicShow');

// User routes (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/my-events', 'GuestController@myEvents');
    Route::get('/event/{event}/register', 'GuestController@publicRegister');
});

// Admin routes (role required)
Route::middleware('role:admin,organizer')->group(function () {
    Route::resource('events', EventController::class);
    Route::resource('organizer', OrganizerController::class);
    Route::resource('guests', GuestController::class);
});
```

---

## 🗄️ Database Structure

### Main Tables

**users**
```
- id
- name
- email
- password
- role (admin/organizer/user)
- avatar
- phone
- bio
- timestamps
```

**organizers**
```
- id
- name
- email (unique)
- phone (unique)
- description
- website
- timestamps
```

**events**
```
- id
- title
- organizer_id (FK → organizers)
- description
- date
- location
- status (draft/published/cancelled/completed)
- timestamps
```

**guests**
```
- id
- name
- email
- phone
- event_id (FK → events)
- user_id (FK → users, nullable)
- participation_type (attendee/speaker/sponsor/volunteer/vip)
- registration_status (pending/confirmed/cancelled/attended)
- ticket_count
- checked_in (boolean)
- checked_in_at
- company
- position
- dietary_requirements
- notes
- timestamps
```

### Relationships

```php
// User Model
public function events() { return $this->hasMany(Event::class); }
public function guests() { return $this->hasMany(Guest::class); }

// Organizer Model
public function events() { return $this->hasMany(Event::class); }

// Event Model
public function organizer() { return $this->belongsTo(Organizer::class); }
public function guests() { return $this->hasMany(Guest::class); }

// Guest Model
public function event() { return $this->belongsTo(Event::class); }
public function user() { return $this->belongsTo(User::class); }
```

---

## 🧪 Testing Guide

### Test User Registration Flow

```
1. Visit /events (browse without login)
2. Click event → View details
3. Click "Register Now"
4. Login or Register
5. Fill registration form
6. Submit → Redirects to /my-events
7. Verify registration appears
```

### Test Admin Features

```
1. Login as admin@example.com
2. Create Event:
   - Events → Create Event
   - Fill form → Submit
3. Create Organizer:
   - Organizer → Add Organizer
   - Fill form → Submit
4. Manage Guests:
   - Guests → Register Guest
   - Fill admin registration → Submit
5. View Reports:
   - Reports → Dashboard
   - Check statistics
```

### Test Role Separation

```
1. Login as regular user
2. Try accessing /events (admin route)
   → Should get 403 Forbidden
3. Try accessing /my-events (user route)
   → Should work
4. Logout and browse /events (public)
   → Should work
```

---

## 🔧 Troubleshooting

### Common Issues

**Issue: Route not defined**
```bash
php artisan route:clear
php artisan route:cache
```

**Issue: View not found**
```bash
php artisan view:clear
php artisan optimize:clear
```

**Issue: Permission denied**
```bash
# Windows
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T

# Mac/Linux
chmod -R 775 storage bootstrap/cache
```

**Issue: Database connection error**
```bash
# Verify .env settings
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_management
DB_USERNAME=root
DB_PASSWORD=your_password

# Test connection
php artisan tinker
DB::connection()->getPdo();
```

---

## 📊 Feature Checklist

### Frontend (Public)
- ✅ Browse published events
- ✅ View event details
- ✅ Event registration (requires login)
- ✅ User registration
- ✅ Login/Logout
- ✅ Forgot password

### User Panel
- ✅ View registered events
- ✅ Registration status tracking
- ✅ Participation type display
- ✅ Check-in status
- ✅ Profile management
- ✅ Password change

### Backend (Admin)
- ✅ Event CRUD
- ✅ Organizer CRUD
- ✅ Guest management
- ✅ Bulk operations
- ✅ Reports & analytics
- ✅ Role-based access

### Security
- ✅ CSRF protection
- ✅ Password hashing
- ✅ Role middleware
- ✅ Input validation
- ✅ SQL injection prevention
- ✅ XSS protection

---

## 🎓 Presentation Tips

### Demo Flow (5-7 minutes)

1. **Public Features (1 min)**
   - Browse events without login
   - View event details

2. **User Registration (1 min)**
   - Register account
   - Register for event
   - Show "My Events"

3. **Admin Features (2 min)**
   - Login as admin
   - Create event
   - Create organizer
   - Manage guests

4. **Reports (1 min)**
   - Show dashboard
   - View analytics

5. **Q&A (2 min)**
   - Explain architecture
   - Answer questions

### Key Points to Highlight

- ✅ Separated frontend/backend architecture
- ✅ Role-based access control
- ✅ Event registration system
- ✅ Participation types (attendee, speaker, etc.)
- ✅ Guest management with check-in
- ✅ Security best practices

---

**Good luck with your presentation! 🚀**
