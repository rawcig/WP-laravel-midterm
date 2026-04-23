# Event Management System - Q&A Guide
## A Beginner's Guide to Understanding Our Laravel Project

---

## TABLE OF CONTENTS
1. [Project Overview](#project-overview)
2. [Laravel Basics](#laravel-basics)
3. [Project Structure](#project-structure)
4. [Models & Relationships](#models--relationships)
5. [Controllers & Authorization](#controllers--authorization)
6. [Routes & Navigation](#routes--navigation)
7. [Database & Migrations](#database--migrations)
8. [Blade Templates](#blade-templates)
9. [Common Syntax & Patterns](#common-syntax--patterns)
10. [Features Explained](#features-explained)

---

## PROJECT OVERVIEW

### Q: What is this project about?
**A:** This is an **Event Management System** built with Laravel. It allows users to:
- **Browse** and **register** for events
- **Create** and **manage** events (if you're an organizer)
- **Check in/out** guests at events
- **View** event details and manage registrations
- Control access based on **user roles** (Admin, Organizer, User)

### Q: What are the main user roles?
**A:** There are three main roles:
1. **Admin** - Can manage everything: users, events, organizers, guests
2. **Organizer** - Can create events, view guests, manage registrations for their events
3. **User** - Can browse events, register as a guest, view their own registrations

### Q: What does "Gates" and "Policies" mean?
**A:** These are Laravel's authorization features:
- **Gates** - Simple rule-based access control (e.g., "is this user an admin?")
- **Policies** - Class-based rules tied to specific models (e.g., "can this user update this guest?")

Both prevent unauthorized users from performing actions they shouldn't be able to do.

---

## LARAVEL BASICS

### Q: What is Laravel?
**A:** Laravel is a **PHP web framework** that makes building web applications easier by providing:
- Pre-built features (authentication, database handling, routing)
- Clean, organized code structure
- Built-in security features
- Easy way to interact with databases

### Q: What is MVC (Model-View-Controller)?
**A:** A design pattern that separates your application into three parts:
```
MODEL (Database) ← handles data
         ↑
         ↓
CONTROLLER (Logic) ← processes requests
         ↑
         ↓
VIEW (HTML) ← displays to user
```

### Q: What's the difference between GET and POST requests?
**A:** 
- **GET** - Retrieve data (like clicking a link or viewing a page)
  ```
  Route::get('/events', [EventController::class, 'index']); // View list of events
  ```
- **POST** - Send data (like submitting a form)
  ```
  Route::post('/events', [EventController::class, 'store']); // Create new event
  ```

Other common ones: **PUT** (update), **DELETE** (delete), **PATCH** (partial update)

---

## PROJECT STRUCTURE

### Q: What's inside each folder?

| Folder | Purpose |
|--------|---------|
| `app/Models` | Database models (Event, Guest, User, etc.) |
| `app/Controllers` | Request handlers & business logic |
| `app/Policies` | Authorization rules for models |
| `app/Providers` | Service providers (setup/configuration) |
| `database/migrations` | Database schema changes |
| `database/factories` | Fake data generators for testing |
| `resources/views` | HTML templates (Blade) |
| `routes/web.php` | URL routes definition |
| `config/` | Configuration files |
| `tests/` | Automated tests |

### Q: What's in `app/Providers/AuthServiceProvider.php`?
**A:** This file sets up authorization:
```php
<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    // Register which policy applies to which model
    protected $policies = [
        Guest::class => GuestPolicy::class,
        Event::class => EventPolicy::class,
    ];
    
    public function boot()
    {
        // Define gates (simple authorization rules)
        Gate::define('isAdmin', function(User $user) {
            return $user->isAdmin();
        });
    }
}
```

---

## MODELS & RELATIONSHIPS

### Q: What is a Model?
**A:** A Model represents a table in the database. It's a PHP class that:
- Maps to a database table
- Handles interactions with that data
- Defines relationships with other models

### Q: How do you create a Model?
**A:** 
```bash
php artisan make:model Event
```

This creates `app/Models/Event.php`

### Q: What's in an Event Model?
**A:**
```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';  // Database table name
    
    protected $fillable = [      // Columns allowed to be mass-assigned
        'title',
        'description',
        'date',
        'location',
        'status',
    ];
    
    protected $casts = [         // Type conversions
        'date' => 'datetime',    // Convert date column to PHP DateTime
    ];
    
    // Relationship: One Event has many Guests
    public function guests()
    {
        return $this->hasMany(Guest::class);
    }
}
```

### Q: What are Model Relationships?
**A:** They define how models connect to each other:

| Relationship | Meaning | Example |
|---|---|---|
| `hasMany()` | One-to-many | One Event has many Guests |
| `belongsTo()` | Many-to-one | Many Guests belong to one Event |
| `belongsToMany()` | Many-to-many | Users have many Roles, Roles have many Users |

**Example Usage:**
```php
$event = Event::find(1);           // Get event with ID 1
$guests = $event->guests();        // Get all guests for this event
$guest = Guest::find(1);
$event = $guest->event;            // Get the event this guest is registered for
```

### Q: What does `$fillable` mean?
**A:** It's a security feature that specifies which columns can be mass-assigned (set at once):
```php
protected $fillable = ['name', 'email', 'status'];

// This works (only fillable columns are updated)
$guest->update(['name' => 'John', 'email' => 'john@example.com']);

// This is ignored (role is not in fillable)
$guest->update(['role' => 'admin']); // Won't change!
```

This prevents users from accidentally or maliciously changing sensitive fields.

### Q: What does `protected $casts` do?
**A:** It automatically converts database values to PHP types:
```php
protected $casts = [
    'date' => 'datetime',
    'checked_in' => 'boolean',
];

$event->date;        // Returns DateTime object (not string)
$guest->checked_in;  // Returns true/false (not 0/1)
```

---

## CONTROLLERS & AUTHORIZATION

### Q: What is a Controller?
**A:** A Controller handles requests and returns responses. It contains the logic for your application.

```bash
php artisan make:controller EventController
```

### Q: What's a typical controller method?
**A:**
```php
public function show($id)
{
    // 1. Get data from database
    $event = Event::find($id);
    
    // 2. Do something with the data
    if (!$event) {
        return abort(404); // Show "Not found" error
    }
    
    // 3. Return a response (view, JSON, etc.)
    return view('events.show', ['event' => $event]);
}
```

### Q: What are the 7 RESTful Controller Methods?

| Method | Route | Purpose | Example |
|--------|-------|---------|---------|
| `index()` | GET `/events` | List all events | Show events list page |
| `create()` | GET `/events/create` | Show form to create | Show "New Event" form |
| `store()` | POST `/events` | Save new event | Process form submission |
| `show()` | GET `/events/{id}` | Display one event | Show event details |
| `edit()` | GET `/events/{id}/edit` | Show edit form | Show "Edit Event" form |
| `update()` | PUT/PATCH `/events/{id}` | Save changes | Process edit submission |
| `destroy()` | DELETE `/events/{id}` | Delete event | Remove from database |

### Q: What does `$this->authorize()` do?
**A:** It checks if the user is allowed to perform an action:
```php
public function update(Request $request, Guest $guest)
{
    // Check if user can update this guest
    // Uses GuestPolicy::update() method
    $this->authorize('update', $guest);
    
    // If not authorized, throws 403 Forbidden error
    // If authorized, continues...
    $guest->update($request->validated());
}
```

### Q: How does the Authorization Policy work?
**A:** Look at `GuestPolicy`:
```php
<?php
namespace App\Policies;

class GuestPolicy
{
    public function update(User $user, Guest $guest): bool
    {
        // Allow if user is admin OR organizer of the event
        return $user->isAdmin() || $user->isOrganizer();
    }
}
```

When you call `$this->authorize('update', $guest)`, Laravel:
1. Finds the policy for Guest model (GuestPolicy)
2. Calls the `update()` method with current user
3. Allows/denies based on return value (true/false)

### Q: What do methods like `isAdmin()` do?
**A:** These are custom methods in the User model:
```php
// In User.php
public function isAdmin(): bool
{
    return $this->role === 'admin';
}

public function isOrganizer(): bool
{
    return $this->role === 'organizer';
}
```

They return `true` or `false` to check user's role.

---

## ROUTES & NAVIGATION

### Q: What are Routes?
**A:** Routes map URLs to controller methods. They're defined in `routes/web.php`:

```php
// GET request - display something
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// POST request - create something
Route::post('/events', [EventController::class, 'store'])->name('events.store');

// Route with ID parameter
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
```

### Q: What does `middleware` mean?
**A:** Middleware is code that runs before reaching the controller. Common ones:

```php
// Only allow guests (not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm']);
});

// Only allow authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
```

### Q: What's `Route::resource()`?
**A:** A shortcut that creates all 7 RESTful routes at once:

```php
Route::resource('events', EventController::class);

// Equals:
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/create', [EventController::class, 'create']);
Route::post('/events', [EventController::class, 'store']);
Route::get('/events/{event}', [EventController::class, 'show']);
Route::get('/events/{event}/edit', [EventController::class, 'edit']);
Route::put('/events/{event}', [EventController::class, 'update']);
Route::delete('/events/{event}', [EventController::class, 'destroy']);
```

### Q: How do you generate a URL in Blade?
**A:**
```blade
<!-- Using route() with named route -->
<a href="{{ route('events.show', $event->id) }}">View Event</a>

<!-- Generates: /events/123 -->

<!-- Using route() with no parameters -->
<a href="{{ route('home') }}">Home</a>
```

---

## DATABASE & MIGRATIONS

### Q: What's a Migration?
**A:** A Migration is a file that defines database schema changes. It's like a version control for your database.

```bash
php artisan make:migration create_events_table
```

This creates a file in `database/migrations/`.

### Q: How do you create a table with a Migration?
**A:**
```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();                          // Auto-increment ID
            $table->string('title');               // VARCHAR column
            $table->text('description');           // Longer text
            $table->dateTime('date');              // Date & time
            $table->string('location');            // VARCHAR
            $table->enum('status', ['draft', 'published', 'completed']); // Fixed options
            $table->timestamps();                  // created_at, updated_at
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
```

### Q: What's `timestamps()`?
**A:** It creates two columns:
- `created_at` - When record was created
- `updated_at` - When record was last updated (auto-updates!)

### Q: How do you run Migrations?
**A:**
```bash
php artisan migrate              # Run all pending migrations
php artisan migrate:rollback     # Undo last batch
php artisan migrate:refresh      # Rollback all and re-run
```

### Q: What's a Factory?
**A:** A Factory generates fake test data. Useful for testing:

```php
<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'date' => $this->faker->dateTimeBetween('now', '+3 months'),
            'location' => $this->faker->city(),
            'status' => 'published',
        ];
    }
}
```

**Usage:**
```php
$event = Event::factory()->create();           // Create 1 event
$events = Event::factory()->count(10)->create(); // Create 10 events
```

### Q: What's a Seeder?
**A:** A Seeder populates the database with initial data:

```php
<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run()
    {
        // Create 20 events
        Event::factory()->count(20)->create();
    }
}
```

**Run it:**
```bash
php artisan db:seed                      # Run all seeders
php artisan db:seed --class=EventSeeder  # Run specific seeder
```

---

## BLADE TEMPLATES

### Q: What is Blade?
**A:** Blade is Laravel's templating engine. It allows PHP-like syntax in HTML:

```blade
<!-- If statement -->
@if ($event->status === 'published')
    <p>Event is live!</p>
@else
    <p>Event not published yet</p>
@endif

<!-- Loops -->
@foreach ($events as $event)
    <h3>{{ $event->title }}</h3>
@endforeach

<!-- Print variable (escapes HTML) -->
{{ $user->name }}

<!-- Print without escaping -->
{!! $content !!}
```

### Q: What's the difference between {{ }} and {!! !!}?
**A:**
- `{{ $variable }}` - Escapes HTML (safe, used most of the time)
- `{!! $html !!}` - Prints HTML as-is (use only for trusted content)

```blade
{{ '<script>alert("Bad!")</script>' }}
<!-- Output: &lt;script&gt;alert("Bad!")&lt;/script&gt; (safe) -->

{!! '<b>Bold</b>' !!}
<!-- Output: <b>Bold</b> (renders as HTML) -->
```

### Q: Common Blade Directives

| Directive | Purpose | Example |
|---|---|---|
| `@if / @else / @endif` | Conditional | `@if ($condition) ... @endif` |
| `@foreach / @endforeach` | Loop | `@foreach ($items as $item) ... @endforeach` |
| `@can / @endcan` | Check permission | `@can('edit', $post) ... @endcan` |
| `@auth / @endauth` | Check if logged in | `@auth ... @endauth` |
| `@guest / @endguest` | Check if not logged in | `@guest ... @endguest` |
| `@include()` | Include template | `@include('header')` |
| `@extends()` | Use parent template | `@extends('layouts.app')` |
| `@section / @endsection` | Define template section | `@section('content') ... @endsection` |

### Q: What's Template Inheritance?
**A:** A way to reuse layouts:

**layouts/app.blade.php** (Parent):
```blade
<html>
<head>
    <title>@yield('title')</title>
</head>
<body>
    <nav>Navigation</nav>
    
    @yield('content')
    
    <footer>Footer</footer>
</body>
</html>
```

**events/show.blade.php** (Child):
```blade
@extends('layouts.app')

@section('title', 'Event Details')

@section('content')
    <h1>{{ $event->title }}</h1>
    <p>{{ $event->description }}</p>
@endsection
```

### Q: What's `@auth` and `@guest`?
**A:**
```blade
<!-- Show only if logged in -->
@auth
    <p>Hello, {{ auth()->user()->name }}</p>
@endauth

<!-- Show only if NOT logged in -->
@guest
    <a href="{{ route('login') }}">Login</a>
@endguest
```

### Q: How do you check permissions in Blade?
**A:**
```blade
<!-- Using @can directive (checks policy) -->
@can('edit', $guest)
    <button>Edit Guest</button>
@endcan

<!-- Using @cannot directive (opposite) -->
@cannot('delete', $event)
    <p>You don't have permission to delete</p>
@endcannot
```

---

## COMMON SYNTAX & PATTERNS

### Q: What does `Auth::user()` do?
**A:** Gets the currently logged-in user:
```php
$user = Auth::user();          // Get User object
$userId = Auth::id();          // Get user ID only
$isLoggedIn = Auth::check();   // Check if logged in
```

In Blade, use `auth()` helper:
```blade
{{ auth()->user()->name }}
```

### Q: What's `Request $request`?
**A:** The Request object contains all HTTP request data:
```php
public function store(Request $request)
{
    $request->all();              // All form data
    $request->input('name');      // Get specific input
    $request->validated();        // Get validated data
    $request->file('image');      // Get uploaded file
    $request->method();           // GET, POST, PUT, DELETE, etc.
}
```

### Q: What's Request Validation?
**A:** Validates incoming data before processing:
```php
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email',
    'age' => 'required|integer|min:18',
]);

// If validation fails, returns to previous page with error messages
// If passes, $validated contains the data
```

**Common Validation Rules:**
| Rule | Meaning |
|------|---------|
| `required` | Field must have a value |
| `string` | Must be text |
| `integer` | Must be whole number |
| `email` | Must be valid email |
| `min:5` | Minimum 5 characters |
| `max:100` | Maximum 100 characters |
| `unique:users,email` | Must be unique in users table |
| `exists:events,id` | Must exist in events table |
| `in:active,inactive` | Must be one of these values |

### Q: What's a Facade?
**A:** A static-like way to access services:
```php
// These do the same thing (Facade way)
Auth::user();
Gate::allows('edit', $post);
Route::get('/path', [Controller::class, 'method']);

// Regular way (more verbose)
app('auth')->user();
```

Facades make code cleaner and shorter.

### Q: What's Eager Loading vs Lazy Loading?
**A:**
```php
// LAZY LOADING (bad - multiple database queries)
$guests = Guest::all();
foreach ($guests as $guest) {
    echo $guest->event->title;  // New query for each guest!
}
// Makes N+1 queries (1 + 20 if 20 guests)

// EAGER LOADING (good - single query)
$guests = Guest::with('event')->get();  // Use with()
foreach ($guests as $guest) {
    echo $guest->event->title;  // No new queries!
}
// Makes only 1-2 queries
```

Use `with()` to load relationships efficiently!

### Q: What's Arrow Notation (`->`)?
**A:** Accesses object properties and methods:
```php
$event->title              // Get 'title' property
$event->getTitle()         // Call getTitle() method
$event->guests()           // Call guests() relationship
$event->guests()->count()  // Chain methods
```

### Q: What's Namespace?
**A:** Organizes code into categories to avoid name conflicts:
```php
namespace App\Models;           // This file is in Models namespace

use App\Http\Controllers\EventController;  // Import class from another namespace

class Event extends Model
{
    // ...
}
```

---

## FEATURES EXPLAINED

### Q: How does Event Registration work?
**A:** 
1. User browses events
2. User registers (creates a Guest record)
3. Guest is created with `status = 'pending'` and `registration_status = 'pending'`
4. Organizer reviews and confirms registration
5. System updates both `status` and `registration_status` together
6. Guest can check in on event day

**Database Fields:**
- `status` - Simple status (pending, confirmed, declined, attended)
- `registration_status` - Tracks registration journey (pending, confirmed, cancelled, attended)
- Both are kept in sync when updated!

### Q: How does Check-in work?
**A:**
```php
// In GuestController
public function checkIn(Request $request, Guest $guest)
{
    $this->authorize('checkIn', $guest);    // Only organizers can
    
    $guest->update([
        'checked_in' => true,               // Mark as checked in
        'checked_in_at' => now(),           // Record time
    ]);
    
    return back()->with('success', 'Guest checked in!');
}
```

### Q: How does Authorization Flow work?

```
User clicks "Edit Guest"
    ↓
Route sends to GuestController@edit
    ↓
Controller calls: $this->authorize('edit', $guest)
    ↓
Laravel finds GuestPolicy
    ↓
Calls GuestPolicy::edit(User, Guest)
    ↓
Policy checks: $user->isAdmin() || $user->isOrganizer()
    ↓
Returns true? → Allow, show edit form
Returns false? → Deny, show 403 error
```

### Q: How does Bulk Update work?
**A:**
```php
public function bulkUpdate(Request $request)
{
    $request->validate([
        'guest_ids' => 'required|array',
        'status' => 'required|in:pending,confirmed,declined,attended',
    ]);
    
    // Update multiple guests at once
    Guest::whereIn('id', $request->guest_ids)->update([
        'status' => $request->status,
        'registration_status' => $status_mapping[$request->status],
    ]);
}
```

Select multiple guests → Change status for all → Single database operation

### Q: How do I add a new Feature?
**A:** Follow these steps:

1. **Create Migration** - Add database table/columns
   ```bash
   php artisan make:migration add_field_to_guests_table
   ```

2. **Create Model** - Define data object
   ```bash
   php artisan make:model MyModel
   ```

3. **Create Controller** - Add business logic
   ```bash
   php artisan make:controller MyController
   ```

4. **Create Policy** - Add authorization rules
   ```bash
   php artisan make:policy MyPolicy --model=MyModel
   ```

5. **Add Routes** - Create URL endpoints
   ```php
   Route::resource('myroute', MyController::class);
   ```

6. **Create Views** - Make HTML templates

7. **Test** - Verify it works

---

## FREQUENTLY ASKED QUESTIONS

### Q: What's the difference between `create()` and `store()`?
**A:**
- `create()` - Shows the form for creating a new item
- `store()` - Processes the form submission and saves to database

### Q: Why do I get "Column not found" error?
**A:** Usually means:
1. You didn't run migration: `php artisan migrate`
2. Column name in code doesn't match database
3. You're accessing wrong table

Solution: Check `php artisan migrate:status` and run migrations

### Q: What's the difference between `find()` and `where()`?
**A:**
```php
Event::find(1);              // Get by ID (fast)
Event::where('title', 'Party')->first();  // Search by column (more flexible)
Event::where('status', 'active')->get();  // Get multiple
```

### Q: How do I delete all data and start fresh?
**A:**
```bash
php artisan migrate:refresh     # Rollback and re-run migrations
php artisan migrate:refresh --seed  # Also run seeders
```

### Q: How do I debug problems?
**A:**
```php
// Print and stop
dd($variable);              // dump and die
dd(DB::getQueryLog());      // See SQL queries

// Log messages
Log::info('Debug message');
Log::error('Error message');

// In Blade
@dd($variable)
{{ dump($variable) }}
```

Check logs at `storage/logs/laravel.log`

### Q: What's the difference between `save()` and `update()`?
**A:**
```php
// save() - For new or modified models
$event = new Event();
$event->title = 'Party';
$event->save();

// update() - Quick update on existing model
$event->update(['title' => 'Updated Party']);

// Both do the same thing, update() is shorter
```

### Q: How do I prevent SQL Injection?
**A:** Use Laravel's query builder (it automatically escapes):
```php
// SAFE - Laravel escapes automatically
Event::where('title', $userInput)->get();

// UNSAFE - Never do this
DB::select("SELECT * FROM events WHERE title = '$userInput'");
```

### Q: What's the difference between `get()` and `first()`?
**A:**
```php
$events = Event::where('status', 'active')->get();    // Returns Collection (array-like)
$event = Event::where('status', 'active')->first();   // Returns single Model or null
```

### Q: How do I count records?
**A:**
```php
$count = Event::count();                    // Count all
$count = Event::where('status', 'active')->count();  // Count with condition
```

### Q: How do I order results?
**A:**
```php
Event::orderBy('created_at', 'desc')->get();      // Newest first
Event::orderBy('title', 'asc')->get();            // Alphabetical
Event::latest()->get();                           // Shortcut for newest first
```

---

## KEY TAKEAWAYS

✅ **Models** = Database tables (Event, Guest, User)
✅ **Controllers** = Business logic (what to do)
✅ **Views** = HTML templates (what to show)
✅ **Routes** = URL maps (where to go)
✅ **Policies** = Authorization rules (who can do what)
✅ **Migrations** = Database version control (schema changes)
✅ **Blade** = Template engine (HTML + PHP)

---

## HELPFUL COMMANDS

```bash
# Create new files
php artisan make:model Event
php artisan make:controller EventController
php artisan make:migration create_events_table
php artisan make:policy EventPolicy --model=Event
php artisan make:factory EventFactory

# Database
php artisan migrate
php artisan migrate:refresh
php artisan db:seed
php artisan tinker  # Interactive shell

# Server
php artisan serve  # Start dev server (http://localhost:8000)

# Testing
php artisan test
php artisan test tests/Feature/EventTest.php

# Cache
php artisan cache:clear
php artisan config:cache

# Other
php artisan list  # See all commands
```

---

**Last Updated:** April 2026  
**Project:** Event Management System - Midterm Project  
**Team:** SU35_G8
