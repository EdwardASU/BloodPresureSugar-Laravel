# Blood Pressure & Sugar Management System

This is a personal health data management system built with **Laravel 12**, designed to help users track and analyze their blood pressure and blood sugar levels. The system combines a robust RESTful API with a responsive Livewire admin dashboard.

## Key Features

- **Health Monitoring**: Record daily blood sugar (mmol/L) and blood pressure (systolic, diastolic, pulse).
- **Statistical Analytics**: Generate daily, weekly, monthly, and quarterly health summaries including averages and extremes.
- **Admin Dashboard**: A responsive management interface built with Livewire 4.2 for maintaining users and health records.
- **Mobile-Ready API**: Full RESTful suite for integration with mobile apps and third-party services.

---

## System Architecture

The project leverages **Laravel 12** as its core framework, following a modern MVC pattern with specialized layers for performance and scalability:

- **Backend Logic**: PHP 8.2+ and Laravel 12.
- **Database Layer**: **MySQL** (using Eloquent ORM for streamlined data modeling).
- **Frontend Framework**: **Livewire 4.2** provides a dynamic, component-based UI without the overhead of a full JavaScript SPA.
- **Authentication**:
    - **API**: **Laravel Sanctum** for lightweight token-based security.
    - **Web/Admin**: Integrated Laravel session-based authentication.

---

## API Design Philosophy

The API follows RESTful principles to ensure consistency and developer-friendly integration:

### 1. Resourceful Routing

Endpoints are organized around core resources (e.g., `/api/blood-sugars`, `/api/blood-pressures`), utilizing standard HTTP methods for CRUD operations.

### 2. Strategic Logic Decoupling

Business logic and statistical calculations are abstracted into a **Service Layer (`StatisticsService`)**, keeping controllers lean and focused on request/response handling.

### 3. Security & Rate Limiting

- **Throttling**: Sensitive routes (Login/Register) are protected by `throttle:6,1` to mitigate brute-force attempts.
- **Access Control**: All private data is shielded by the `auth:sanctum` middleware, ensuring data isolation and user ownership.

---

## API Reference

A complete Postman collection is included in the repository for testing and exploration.

> [!TIP]
> Import [Blood Sugar Presure.postman_collection.json] into Postman to get started.

---

## Design Rationale: Why This Stack?

### 1. MySQL for Data Integrity

**Why**: Health data requires ACID compliance and strong relational integrity. MySQL's proven performance and reliability make it the ideal choice for structured health records.

### 2. High-Performance Statistics via Service Layer

**Why**: Statistical calculations often involve heavy aggregation (`AVG`, `MIN`, `MAX`).

- **Optimization**: The `StatisticsService` uses `selectRaw` to fetch multiple aggregates in a **single database query**, significantly reducing overhead compared to multiple sequential queries.

### 3. Livewire 4 for Admin Efficiency

**Why**: Livewire allows for rapid development of interactive UIs while keeping the entire codebase in PHP. It leverages Vite for instant hot-module replacement and seamless developer experience.

### 4. Sanctum for API Scalability

**Why**: Sanctum strikes the perfect balance between security and simplicity, providing a robust solution for mobile and SPA authentication without the complexity of OAuth2.

---

## Getting Started

### Prerequisites

- PHP 8.2+
- **MySQL** 8.0+
- Composer
- Node.js & NPM

### Setup Instructions

```bash
# Clone the repository and copy configuration
cp .env.example .env

# Configure your database settings in .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# Install PHP dependencies
composer install

# Generate application key and run migrations
php artisan key:generate
php artisan migrate

# Install and compile frontend assets
npm install
npm run build

# Start the local development server
php artisan serve
```

---

## Developer Toolkit

The project includes several tools to maintain high code quality:

- **Pest**: For expressive and readable unit and feature tests.
- **Laravel Pint**: To enforce PSR-standard code styling.
- **Laravel Pail**: For real-time log monitoring in the terminal.
- **Laravel Sail**: Dockerized development environment support.
