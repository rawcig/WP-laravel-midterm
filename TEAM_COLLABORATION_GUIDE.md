# 🚀 Team Collaboration Guide - Laravel Event Management System

## 📦 What's Already Done (Pushed to GitHub)

✅ **Code Files:**
- All Controllers (Event, Organizer, Guest, Auth, Profile, Report, Home)
- All Models (Event, Organizer, Guest, User)
- All Views (Blade templates)
- Migrations (database structure)
- Seeders (sample data)
- Routes (web.php)
- Middleware (RoleMiddleware)
- Form Requests (validation)
- CSS assets

❌ **NOT Included in Git (by .gitignore):**
- `.env` file (contains database credentials)
- `vendor/` folder (Composer dependencies)
- `node_modules/` folder (NPM dependencies)
- `storage/` folder (logs, uploads)
- `public/storage` symlink
- `database/database.sqlite` (if using SQLite)

---

## 📋 What Your Teammates Need to Do

### Option 1: Automated Setup (Windows - Recommended)

```bash
# 1. Clone the repository
git clone https://github.com/YOUR_USERNAME/YOUR_REPO.git
cd YOUR_REPO

# 2. Run the setup script
setup.bat

# 3. Follow the prompts
# - Choose database type (MySQL or SQLite)
# - If MySQL, configure .env file manually
# - Script will install dependencies and set up database

# 4. Start the server
php artisan serve

# 5. Visit http://localhost:8000
```

### Option 2: Manual Setup (All Platforms)

```bash
# 1. Clone the repository
git clone https://github.com/YOUR_USERNAME/YOUR_REPO.git
cd YOUR_REPO

# 2. Install PHP dependencies
composer install

# 3. Install JavaScript dependencies
npm install

# 4. Setup environment
cp .env.example .env
php artisan key:generate

# 5. Configure database (edit .env file)
# See "Database Configuration" section below

# 6. Run migrations
php artisan migrate:fresh --seed

# 7. Build assets
npm run dev

# 8. Start server
php artisan serve
```

---

## 🗄️ Database Configuration

### For Teammates Using MySQL

**Step 1: Create Database**
```sql
CREATE DATABASE event_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**Step 2: Update `.env` file**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_management
DB_USERNAME=root
DB_PASSWORD=THEIR_MYSQL_PASSWORD
```

**Step 3: Run migrations**
```bash
php artisan migrate:fresh --seed
```

### For Teammates Using SQLite (Simpler)

**Step 1: Create SQLite file**
```bash
# In project root
type nul > database\database.sqlite
# Or on Mac/Linux:
touch database/database.sqlite
```

**Step 2: Update `.env` file**
```env
DB_CONNECTION=sqlite
# Remove or comment out DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

**Step 3: Run migrations**
```bash
php artisan migrate:fresh --seed
```

---

## 🔐 Default Login Credentials (After Seeding)

Share these with your teammates:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| Organizer | organizer@example.com | password |
| User | user@example.com | password |

---

## 📝 Step-by-Step Guide for Each Teammate

### Teammate 1 (Authentication & User Management)
```bash
# Setup
git clone [repo-url]
cd midterm
composer install
npm install
cp .env.example .env
# Configure database
php artisan migrate:fresh --seed
php artisan serve

# Test authentication
# Visit: http://localhost:8000/login
# Login with admin@example.com / password
# Test registration, profile editing
```

### Teammate 2 (Event Management)
```bash
# Same setup as above
# Test events
# Visit: http://localhost:8000/events
# Create, edit, delete events
```

### Teammate 3 (Organizer Management)
```bash
# Same setup as above
# Test organizers
# Visit: http://localhost:8000/organizer
# Add organizer, test validation
```

### Teammate 4 (Guest Management)
```bash
# Same setup as above
# Test guests
# Visit: http://localhost:8000/guests
# Add guest, test bulk update
```

### Teammate 5 (Dashboard & Reports)
```bash
# Same setup as above
# Test dashboard
# Visit: http://localhost:8000/ (dashboard)
# Visit: http://localhost:8000/reports
```

---

## 🔧 Common Issues & Solutions

### Issue 1: "Database not found" error

**Solution:**
```bash
# Make sure database is created
# MySQL: CREATE DATABASE event_management;
# SQLite: Create database/database.sqlite file

# Then run migrations
php artisan migrate:fresh --seed
```

### Issue 2: "Class not found" errors

**Solution:**
```bash
composer dump-autoload
```

### Issue 3: Permission denied on storage/

**Solution (Windows):**
```bash
# Right-click storage folder → Properties → Security
# Give "Users" full control
# Repeat for bootstrap/cache folder
```

**Solution (Mac/Linux):**
```bash
chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Issue 4: npm install fails

**Solution:**
```bash
# Delete node_modules and package-lock.json
rm -rf node_modules package-lock.json

# Clear cache
npm cache clean --force

# Reinstall
npm install
```

### Issue 5: 500 Server Error

**Solution:**
```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear caches
php artisan optimize:clear

# Check .env for syntax errors
```

---

## 📦 Files Each Teammate Should Have

After setup, verify these exist:

```
midterm/
├── .env                    ✅ (Created from .env.example)
├── artisan                 ✅ (Already in repo)
├── composer.json           ✅ (Already in repo)
├── package.json            ✅ (Already in repo)
├── vendor/                 ✅ (Created by composer install)
├── node_modules/           ✅ (Created by npm install)
├── database/
│   ├── migrations/         ✅ (Already in repo)
│   └── database.sqlite     ⚠️ (Only if using SQLite)
├── storage/
│   ├── logs/              ✅ (Should exist)
│   └── framework/         ✅ (Should exist)
└── public/
    └── storage            ⚠️ (Symlink, created if needed)
```

---

## 🔄 Daily Workflow for Teammates

### Morning (Start of Day)

```bash
# 1. Pull latest changes
git pull origin main

# 2. Update dependencies (if composer.json changed)
composer install

# 3. Update frontend (if package.json changed)
npm install

# 4. Run new migrations (if any)
php artisan migrate

# 5. Start server
php artisan serve
```

### During Development

```bash
# 1. Create feature branch
git checkout -b feature/your-feature

# 2. Make changes

# 3. Test locally
php artisan test

# 4. Commit changes
git add .
git commit -m "Description of changes"

# 5. Push to GitHub
git push origin feature/your-feature

# 6. Create Pull Request on GitHub
```

### End of Day

```bash
# 1. Make sure all changes are committed
git status

# 2. Push any remaining changes
git push

# 3. Stop server (Ctrl+C)
```

---

## 📞 Communication Tips

### Before Asking for Help

1. Check the error message carefully
2. Search in `storage/logs/laravel.log`
3. Google the error message
4. Check Laravel docs: https://laravel.com/docs

### When Asking for Help

Provide:
1. Error message (screenshot or text)
2. What you were trying to do
3. What you've tried already
4. Your setup (MySQL or SQLite, Windows/Mac/Linux)

Example:
```
Hey team! Having an issue with migrations.

Error: "SQLSTATE[HY000] [1049] Unknown database 'event_management'"

What I did:
1. Cloned repo
2. Ran composer install
3. Created .env file
4. Ran php artisan migrate

Setup: MySQL on Windows

Tried:
- Created database manually
- Still getting error

Any help appreciated! 🙏
```

---

## ✅ Setup Checklist for Teammates

Share this checklist with your team:

```
Setup Checklist:
[ ] 1. Cloned repository from GitHub
[ ] 2. Installed Composer dependencies (composer install)
[ ] 3. Installed NPM packages (npm install)
[ ] 4. Created .env from .env.example
[ ] 5. Generated app key (php artisan key:generate)
[ ] 6. Configured database in .env
[ ] 7. Created database (MySQL or SQLite)
[ ] 8. Ran migrations (php artisan migrate:fresh --seed)
[ ] 9. Built assets (npm run dev)
[ ] 10. Started server (php artisan serve)
[ ] 11. Can access http://localhost:8000
[ ] 12. Can login with test credentials
[ ] 13. Joined team chat/Discord
[ ] 14. Read PROJECT_SUMMARY.md
[ ] 15. Understood their assigned features
```

---

## 📚 Additional Resources

Share these with your team:

- **Project Summary:** `PROJECT_SUMMARY.md` (in repo root)
- **Team Setup Guide:** `TEAM_SETUP.md` (in repo root)
- **Laravel Docs:** https://laravel.com/docs
- **Laracasts:** https://laracasts.com (Free videos)
- **Stack Overflow:** https://stackoverflow.com/questions/tagged/laravel

---

## 🎯 Quick Start Commands Cheat Sheet

```bash
# Setup
composer install              # Install PHP dependencies
npm install                   # Install JS dependencies
php artisan key:generate      # Generate app key
php artisan migrate:fresh --seed  # Setup database

# Development
php artisan serve             # Start development server
npm run dev                   # Watch for frontend changes
php artisan test              # Run tests

# Debugging
php artisan optimize:clear    # Clear all caches
tail -f storage/logs/laravel.log  # View logs (Mac/Linux)
Get-Content storage/logs/laravel.log -Tail -f  # View logs (Windows)

# Git
git pull origin main          # Get latest changes
git status                    # Check file changes
git add . && git commit -m "msg"  # Commit changes
git push                      # Push to GitHub
```

---

**Good luck with your project! 🚀**

If your teammates follow this guide, they should have no trouble setting up and contributing to the project!
