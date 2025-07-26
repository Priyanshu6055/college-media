🎓 College Media
College Media is a full-stack social platform designed specifically for students and teachers. It offers user authentication with role-based access, student-teacher interaction, real-time chat functionality, and media sharing — all tailored to a campus environment.

🚀 Features
🔐 Authentication & Role Management
Secure user authentication with the ability to register as either a Teacher or Student, each with role-specific access and permissions.

👨‍🏫 Teacher Role
Teachers can view, edit, or delete student profiles, allowing effective moderation and management within the system.

👨‍🎓 Student Role
Students can:

Send friend requests

Engage in real-time chat with accepted friends

Upload and share photos with visibility controls (public or friends-only)

💬 Chat System

Single tick indicates the message was delivered (friend is online)

Double tick confirms the message was read

🛠 Tech Stack
Frontend: HTML, CSS, JavaScript.

Backend: Laravel, PHP
Database: SQL

Authentication: Session-based.



## 🛠️ Project Setup (Laravel)

Follow the steps below to set up and run the project locally.

---

### 📆 1. Clone the Repository

```bash
git clone https://github.com/your-username/college-media.git
cd college-media
```

---

### 📁 2. Install Dependencies

Make sure you have **PHP**, **Composer**, and **Laravel** installed.

```bash
composer install
```

---

### 🔐 3. Configure Environment

Create a `.env` file by copying the example file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Update the `.env` file with your database credentials and other environment settings:

```env
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---

### 🧰 4. Set Up the Database

Run the migrations and seed the database (if you have seeders):

```bash
php artisan migrate
```

---

### 🚀 5. Start the Development Server

```bash
php artisan serve
```

Visit `http://127.0.0.1:8000` in your browser to access the app.

---

### ✅ Storage & Permissions

Run this for file uploads or uses storage:

```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```
