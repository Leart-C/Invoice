<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<h1 align="center">Invoice & Payment Tracker</h1>

<p align="center">
  A full-stack web application for managing invoices, tracking payments, and monitoring client balances — built with Laravel 11.
</p>

---

## About the Project

Invoice & Payment Tracker is a business-focused application designed to replace manual invoicing workflows. It allows businesses to create and send invoices, track payment statuses in real time, manage clients, and generate financial reports — all from one platform.

Built as a personal/collaborative project to demonstrate real-world Laravel development skills including authentication, role management, PDF generation, email delivery, and RESTful API design.

---

## Features

- 🔐 Authentication & role-based access control (Admin / Accountant / Viewer)
- 🧾 Create, edit, and send invoices to clients
- 💰 Track payment status (Paid / Unpaid / Overdue / Partial)
- 👥 Client management with balance overview
- 📄 PDF invoice export with branding
- 📧 Automated email delivery to clients
- 📊 Dashboard with revenue and payment analytics
- 🔁 Recurring invoice support

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 11, PHP 8.3 |
| Frontend | Blade / Vite |
| Database | MySQL 8.0 |
| Cache & Queues | Redis 7 |
| Server | Nginx (Docker) |
| DevOps | Docker, Docker Compose |
| Version Control | Git / GitHub |

---

## Local Setup
```bash
# 1. Clone the repository
git clone https://github.com/YOUR_USERNAME/Invoice.git
cd Invoice

# 2. Install dependencies
composer install
npm install

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Start Docker services
docker compose up -d

# 5. Run migrations
php artisan migrate

# 6. Start the dev server
npm run dev
```

Visit `http://localhost:8000`

---

## Contributors

Leart Bajrami, 
Fortesa Abdullahu
---

## License

This project is open-source for portfolio purposes.
