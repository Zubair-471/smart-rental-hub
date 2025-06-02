
````markdown
# 🚀 Smart Rental Hub – Laravel-Based Device Rental System

**Smart Rental Hub** is a powerful full-stack rental management solution built with Laravel. It enables users to rent electronic devices while providing an intuitive admin dashboard for complete control over rentals, users, and devices.

---

## 🔑 Key Features

### 👥 Authentication & Authorization
- Secure user registration & login
- Role-based access control (User / Admin)
- Profile management

### 📦 Device Management
- Device listing by category
- Detailed device view
- Admin: Create, Read, Update, Delete (CRUD) operations

### 📅 Rental System
- Rent devices with start/end dates
- Track rental status & returns
- Rental history for users

### 🛠️ Admin Dashboard
- Manage devices, rentals, categories, and users
- Role and permission management
- Clean, responsive UI using Tailwind CSS

---

## 🧑‍💻 Tech Stack

| Layer        | Technology                     |
| ------------ | ------------------------------ |
| Backend      | Laravel 10                     |
| Frontend     | Blade, Tailwind CSS            |
| Authentication | Laravel Breeze, Sanctum      |
| Database     | MySQL                          |
| API          | RESTful routes with Sanctum    |

---

## 🌐 Route Structure

### 🔸 Web Routes – `routes/web.php`

```php
Route::get('/', [HomeController::class, 'index']);
Route::get('/devices/{id}', [DeviceController::class, 'show']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    // Additional protected routes
});
````

### 🔹 API Routes – `routes/api.php`

```php
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/devices', [API\DeviceController::class, 'index']);
    Route::post('/rentals', [API\RentalController::class, 'store']);
});
```

---

## 🔐 Role-Based Access Overview

| Role  | Permissions                                    |
| ----- | ---------------------------------------------- |
| User  | Browse & rent devices, view profile            |
| Admin | Full CRUD on users, devices, rentals, and more |

---

## 📸 Screenshots 

![image](https://github.com/user-attachments/assets/f04f400b-623f-40bd-9075-2a217acec64a)

![image](https://github.com/user-attachments/assets/872ba908-4083-4c8f-8c08-631678024cb7)

![image](https://github.com/user-attachments/assets/c6a5fd45-7c7b-4b7d-8fad-65274b9891d5)


---

## ⚙️ Getting Started

### ✅ Prerequisites

* PHP >= 8.1
* Composer
* MySQL
* Node.js & npm

### 🛠 Installation Steps

```bash
# Clone the repo
git clone https://github.com/YOUR_USERNAME/smart-rental-hub.git
cd smart-rental-hub

# Install dependencies
composer install
npm install && npm run dev

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure your database in .env

# Run migrations and seeders
php artisan migrate --seed

# Start the server
php artisan serve
```

---

## 🧪 Testing Guide

* 🖥 Web UI: Test authentication, CRUD, rentals
* 🧪 API: Use Postman for `/api/v1` endpoints (e.g., device listings, create rentals)

---

## 🧠 Development Challenges & Solutions

| Challenge         | Solution                                       |
| ----------------- | ---------------------------------------------- |
| Role-based access | Implemented using Laravel Gates & Policies     |
| API security      | Used Laravel Sanctum with token-based auth     |
| UI/UX design      | Tailwind CSS + Blade templates for flexibility |
| Data validation   | Laravel Form Request classes                   |

---

## 📁 Project Structure (Highlights)

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

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

## 👨‍💻 Author & Contact

* **M. Zubair Tariq**
* 📧 [M.ZubairTariq20@gmail.com](mailto:M.ZubairTariq20@gmail.com)
* 💼 [LinkedIn](https://www.linkedin.com/in/muhammad-zubair-tariq-70209b364)
* 🎯 [Fiverr – ZubairWebWorks](https://www.fiverr.com/ZubairWebWorks)

---


