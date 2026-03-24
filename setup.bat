@echo off
echo ============================================
echo  Laravel Event Management System Setup
echo ============================================
echo.

echo [1/8] Checking PHP installation...
php -v >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: PHP is not installed or not in PATH
    echo Please install PHP 8.2 or higher from https://www.php.net/downloads
    pause
    exit /b 1
)
echo PHP found!

echo.
echo [2/8] Checking Composer installation...
composer -V >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Composer is not installed
    echo Please install Composer from https://getcomposer.org/download
    pause
    exit /b 1
)
echo Composer found!

echo.
echo [3/8] Installing Composer dependencies...
composer install --no-interaction --prefer-dist --optimize-autoloader
if %errorlevel% neq 0 (
    echo ERROR: Composer install failed
    pause
    exit /b 1
)
echo Composer dependencies installed!

echo.
echo [4/8] Checking Node.js installation...
node -v >nul 2>&1
if %errorlevel% neq 0 (
    echo WARNING: Node.js is not installed
    echo Some features may not work without Node.js
    echo Install from https://nodejs.org/
) else (
    echo Node.js found!
    echo.
    echo [5/8] Installing NPM packages...
    call npm install
    if %errorlevel% neq 0 (
        echo WARNING: NPM install failed
        echo You can run 'npm install' manually later
    ) else (
        echo NPM packages installed!
    )
)

echo.
echo [6/8] Setting up environment file...
if not exist .env (
    copy .env.example .env
    echo .env file created!
) else (
    echo .env file already exists, skipping...
)

echo.
echo [7/8] Generating application key...
php artisan key:generate
echo Application key generated!

echo.
echo ============================================
echo  Database Setup
echo ============================================
echo.
echo Choose database type:
echo 1. MySQL (Recommended for production)
echo 2. SQLite (Simpler, good for development)
echo.
set /p DB_CHOICE="Enter your choice (1 or 2): "

if "%DB_CHOICE%"=="2" (
    echo.
    echo Creating SQLite database...
    if not exist database\database.sqlite (
        type nul > database\database.sqlite
        echo SQLite database created!
    ) else (
        echo SQLite database already exists!
    )
    
    echo.
    echo Updating .env for SQLite...
    (
        echo DB_CONNECTION=sqlite
    ) > temp_db.txt
    
    findstr /V "^DB_HOST=" .env > temp.env
    findstr /V "^DB_PORT=" temp.env > temp2.env
    findstr /V "^DB_DATABASE=" temp2.env > temp3.env
    findstr /V "^DB_USERNAME=" temp3.env > temp4.env
    findstr /V "^DB_PASSWORD=" temp4.env > temp5.env
    move /Y temp5.env .env >nul
    del temp_db.txt temp.env temp2.env temp3.env temp4.env
    
    echo SQLite configured!
) else (
    echo.
    echo MySQL selected. Please configure your .env file manually:
    echo - DB_HOST=127.0.0.1
    echo - DB_PORT=3306
    echo - DB_DATABASE=event_management
    echo - DB_USERNAME=root
    echo - DB_PASSWORD=your_password
    echo.
    echo Then run: php artisan migrate:fresh --seed
)

echo.
echo [8/8] Running database migrations...
if "%DB_CHOICE%"=="2" (
    php artisan migrate:fresh --seed
    if %errorlevel% neq 0 (
        echo WARNING: Migration failed. You can run it manually later.
    ) else (
        echo Database migrated and seeded!
    )
)

echo.
echo ============================================
echo  Setup Complete!
echo ============================================
echo.
echo Next steps:
echo 1. If using MySQL, configure .env and run: php artisan migrate:fresh --seed
echo 2. Start the development server: php artisan serve
echo 3. Visit: http://localhost:8000
echo.
echo Default login credentials:
echo - Admin: admin@example.com / password
echo - Organizer: organizer@example.com / password
echo - User: user@example.com / password
echo.
pause
