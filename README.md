
````markdown
# 📱 Smart Rental Hub – Laravel Device Rental System

**Smart Rental Hub** is a full-stack device rental management system built using Laravel. It provides user and admin roles, a catalog of devices, rental tracking, and a RESTful API—all in one powerful and professional solution.

---

## 🚀 Key Features

### 1. 👥 User Authentication & Authorization
- User registration & login
- Role-based access (Admin and User)
- Profile management

### 2. 📦 Device Management
- Device catalog by category
- View device details
- Admin: Create, update, delete (CRUD)

### 3. 📅 Rental System
- Book device rentals
- Track rental status
- Manage returns

### 4. 🛠️ Admin Dashboard
- Manage users, devices, rentals & categories
- Role and permission management
- Site settings & dashboard overview

---

## 🧑‍💻 Tech Stack

- **Backend:** Laravel 10 (PHP Framework)
- **Frontend:** Blade templating engine, Tailwind CSS
- **Database:** MySQL
- **Authentication:** Laravel Breeze
- **API:** RESTful routes using Sanctum (auth:sanctum middleware)

---

## 🌐 Routes Overview

### Web Routes (`routes/web.php`)
These routes render Blade templates for the frontend.
```php
Route::get('/', [HomeController::class, 'index']);
Route::get('/devices/{id}', [DeviceController::class, 'show']);
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    // More protected routes...
});
````

### API Routes (`routes/api.php`)

These return JSON responses for frontend frameworks or external apps.

```php
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/devices', [API\DeviceController::class, 'index']);
    Route::post('/rentals', [API\RentalController::class, 'store']);
});
```

---

## 🔒 Role-Based Access Control

| Role  | Access to Features                           |
| ----- | -------------------------------------------- |
| User  | Browse devices, book rentals, manage profile |
| Admin | Full access: CRUD devices, rentals, users    |

---

## 📷 Screenshots (Add Your Own)

* 📸 Homepage showing device catalog
* 📸 Admin dashboard with metrics
* 📸 Device detail and rental form

*(Upload to GitHub repo or embed using Markdown)*

---

## ⚙️ Installation Guide

### Prerequisites

* PHP >= 8.1
* Composer
* MySQL
* Node.js & npm

### Setup Instructions

```bash
# Clone the repo
git clone https://github.com/YOUR_USERNAME/smart-rental-hub.git
cd smart-rental-hub

# Install dependencies
composer install
npm install && npm run dev

# Setup .env
cp .env.example .env
php artisan key:generate

# Configure DB in .env
# DB_DATABASE=your_db
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations & seeders
php artisan migrate --seed

# Start the app
php artisan serve
```

---

## 🧪 Testing

Basic CRUD and booking operations can be tested using:

* Manual testing via the web UI
* API testing via Postman (for `/api/v1/*` endpoints)

---

## 🧠 Technical Challenges & Solutions

| Challenge       | Solution                                            |
| --------------- | --------------------------------------------------- |
| Role management | Used Laravel Policies and Gates                     |
| Securing API    | Used Laravel Sanctum for token-based authentication |
| Admin UI        | Blade + Tailwind for clean and responsive design    |
| CRUD validation | Laravel Form Requests with built-in validation      |

---

## 📂 Folder Structure (Highlights)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   ├── API/
│   │   └── Auth/
├── Models/
resources/
├── views/
│   ├── admin/
│   ├── devices/
routes/
├── web.php
├── api.php
```

---

## 🧾 License

This project is open-sourced under the [MIT license](LICENSE).

---

## 🤝 Contact

* 👨‍💻 Developed by **M. Zubair Tariq**
* 📧 Email: [M.ZubairTariq20@gmail.com](mailto:M.ZubairTariq20@gmail.com)
* 🌐 Fiverr: [ZubairWebWorks](https://www.fiverr.com/ZubairWebWorks)
* 💼 LinkedIn: [Connect with Me](https://www.linkedin.com/in/muhammad-zubair-tariq-70209b364)

---
