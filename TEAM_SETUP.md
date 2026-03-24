# 🎉 Laravel Event Management System - Team Setup Guide

## 📋 Quick Start for New Team Members

Follow these steps to set up the project on your local machine.

---

## ⚙️ Prerequisites

Before starting, make sure you have installed:

- **PHP 8.2 or higher** - [Download](https://www.php.net/downloads)
- **Composer** - [Download](https://getcomposer.org/download)
- **Node.js & NPM** - [Download](https://nodejs.org/)
- **MySQL/MariaDB** or **SQLite**
- **Git** - [Download](https://git-scm.com/)
- **Code Editor** (VS Code recommended) - [Download](https://code.visualstudio.com/)

### Verify Installation
```bash
php -v          # Should show PHP 8.2+
composer -V     # Should show Composer version
node -v         # Should show Node.js version
npm -v          # Should show NPM version
mysql --version # Should show MySQL version
git --version   # Should show Git version
```

---

## 🚀 Installation Steps

### Step 1: Clone the Repository

```bash
# Navigate to your projects folder
cd path/to/your/projects

# Clone the repository
git clone https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git

# Enter the project directory
cd YOUR_REPO_NAME
```

### Step 2: Install PHP Dependencies

```bash
# Install Composer dependencies
composer install
```

### Step 3: Install JavaScript Dependencies

```bash
# Install NPM packages
npm install
```

### Step 4: Environment Configuration

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 5: Database Setup

#### Option A: MySQL (Recommended)

1. **Create the database:**
```bash
# Using MySQL CLI
mysql -u root -p
```

```sql
CREATE DATABASE event_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

2. **Update `.env` file:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_management
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

#### Option B: SQLite (Simpler)

1. **Create SQLite database:**
```bash
# In project root
touch database/database.sqlite
# Or on Windows
type nul > database\database.sqlite
```

2. **Update `.env` file:**
```env
DB_CONNECTION=sqlite
# Comment out or remove DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

### Step 6: Run Migrations & Seeders

```bash
# Run migrations to create tables
php artisan migrate

# Seed the database with sample data
php artisan db:seed

# Or run both together
php artisan migrate:fresh --seed
```

### Step 7: Build Frontend Assets

```bash
# Build for development
npm run dev

# Or build for production
npm run build
```

### Step 8: Start the Development Server

```bash
# Start Laravel development server
php artisan serve
```

Visit: **http://localhost:8000**

---

## 🔐 Default Login Credentials

After seeding the database, you can login with:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@example.com | password |
| **Organizer** | organizer@example.com | password |
| **User** | user@example.com | password |

---

## 📁 Project Structure

```
midterm/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Event, Organizer, Guest, Auth controllers
│   │   ├── Middleware/        # RoleMiddleware
│   │   └── Requests/          # Form validation classes
│   └── Models/                # Event, Organizer, Guest, User
├── database/
│   ├── migrations/            # Database schema
│   └── seeders/               # Sample data
├── resources/
│   └── views/
│       └── backend/
│           ├── auth/          # Login, Register pages
│           ├── layout/        # Header, Footer, Sidebar
│           └── pages/         # Event, Organizer, Guest pages
├── routes/
│   └── web.php                # Route definitions
└── public/
    ├── css/                   # Compiled CSS
    └── images/                # Uploaded images
```

---

## 🛠️ Common Tasks

### Update Database After Changes

```bash
# Run new migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset and reseed database
php artisan migrate:fresh --seed
```

### Clear Caches

```bash
# Clear all caches
php artisan optimize:clear

# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear
```

### View Available Routes

```bash
# List all routes
php artisan route:list
```

### Run Tests

```bash
# Run PHPUnit tests
php artisan test
```

---

## 🔧 Troubleshooting

### Issue: "Class not found" errors

```bash
# Regenerate autoload files
composer dump-autoload
```

### Issue: Permission denied on storage

```bash
# Windows (run as Administrator)
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T

# Or manually grant permissions to storage/ and bootstrap/cache/ folders
```

### Issue: Database connection error

```bash
# Check if MySQL is running
# Windows: Open Services, look for MySQL
# Mac: brew services list

# Verify .env database credentials
# Test connection:
php artisan tinker
DB::connection()->getPdo();
```

### Issue: npm install fails

```bash
# Delete node_modules and package-lock.json
rm -rf node_modules package-lock.json

# Clear npm cache
npm cache clean --force

# Reinstall
npm install
```

### Issue: 500 Server Error

```bash
# Check logs
storage/logs/laravel.log

# Clear all caches
php artisan optimize:clear

# Check .env file for syntax errors
```

---

## 📝 Git Workflow for Team

### Daily Workflow

```bash
# Start of day - Pull latest changes
git pull origin main

# Create a new branch for your feature
git checkout -b feature/your-feature-name

# Make changes and commit
git add .
git commit -m "Description of changes"

# Push your branch
git push origin feature/your-feature-name

# Create Pull Request on GitHub
```

### Before Committing

```bash
# Check what files changed
git status

# Review changes
git diff

# Make sure .env is NOT committed (should be in .gitignore)
```

### Resolve Merge Conflicts

```bash
# If conflict occurs during pull
git pull origin main

# Edit conflicted files (look for <<<<<<< and >>>>>>>)
# Save and stage resolved files
git add path/to/resolved/file

# Complete merge
git commit
```

---

## 🎯 Testing the Application

### Test Authentication
1. Visit http://localhost:8000/login
2. Login with admin credentials
3. Test registration at http://localhost:8000/register

### Test Event Management
1. Go to Events → Create Event
2. Fill form and submit
3. Edit and delete events

### Test Organizer Management
1. Go to Organizer → Add Organizer
2. Test duplicate email/phone validation
3. View organizer profile

### Test Guest Management
1. Go to Guests → Add Guest
2. Test bulk status update
3. Filter by event/status

### Test Reports
1. Visit Reports dashboard
2. Check charts and statistics
3. Test event/organizer filters

---

## 📞 Getting Help

If you encounter issues:

1. **Check the logs:** `storage/logs/laravel.log`
2. **Search Laravel docs:** https://laravel.com/docs
3. **Ask team members** in the group chat
4. **Google the error message** - someone likely had it before

---

## ✅ Setup Checklist

Before starting development, verify:

- [ ] Repository cloned successfully
- [ ] Composer dependencies installed
- [ ] NPM packages installed
- [ ] `.env` file configured
- [ ] Application key generated
- [ ] Database created and migrated
- [ ] Sample data seeded
- [ ] Development server running
- [ ] Can login with test credentials
- [ ] Can access all main pages

---

## 🎓 Learning Resources

- **Laravel Docs:** https://laravel.com/docs
- **Laracasts:** https://laracasts.com (Free videos available)
- **Laravel News:** https://laravel-news.com
- **Stack Overflow:** https://stackoverflow.com/questions/tagged/laravel

---

**Welcome to the team! Happy coding! 🚀**
