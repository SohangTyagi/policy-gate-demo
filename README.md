# PolicyGate Demo 🛡️

A sophisticated Laravel-based demonstration project showcasing advanced **Authorization Policies**, **Layered Architecture**, and **Clean Code** principles. This project illustrates how to manage complex access controls in a modern web application while maintaining a scalable and maintainable codebase.

---

## 🚀 Overview

**PolicyGate Demo** is built to demonstrate the seamless integration of Laravel's authorization mechanisms (Policies & Gates) within a structured API environment. It features a three-layered architecture (Controller → Service → Repository) to ensure that business logic, data access, and authorization are decoupled and easily testable.

### Core Features:
- **Role-Based Access Control (RBAC):** Distinct permissions for Admins and Regular Users.
- **Advanced Authorization:** Fine-grained control over Post management using Laravel Policies.
- **Layered Architecture:** Implements Service and Repository patterns for better modularity.
- **RESTful API:** A clean, standardized API for resource management.
- **Sanctum Authentication:** Secure token-based authentication for all protected endpoints.

---

## 🛠️ Tech Stack

- **Framework:** [Laravel 11.x](https://laravel.com/)
- **Authentication:** [Laravel Sanctum](https://laravel.com/docs/sanctum)
- **Database:** SQLite (default for easy setup)
- **Architecture:** Repository & Service Pattern
- **Language:** PHP 8.2+

---

## 📂 Architecture Layers

This project follows a professional-grade layered architecture to ensure separation of concerns:

### 1. Repository Layer (`app/Repositories`)
Handles all direct database interactions using Eloquent. This layer abstracts the data source from the rest of the application, making it easier to swap or mock during testing.
- **Files:** `PostRepository`, `PostRepositoryInterface`

### 2. Service Layer (`app/Services`)
The "Brain" of the application. It contains the business logic and coordinates between repositories. It ensures that the controllers remain thin and focused only on handling requests and responses.
- **Files:** `PostService`

### 3. Controller Layer (`app/Http/Controllers`)
Responsible for handling incoming HTTP requests, validating inputs (via Request Classes), and returning JSON responses. Authorization is enforced here at the entry point of each action.
- **Files:** `PostController`

### 4. Validation & Presentation Layers
- **Requests (`app/Http/Requests`):** Encapsulates validation logic for incoming API requests (e.g., `StorePostRequest`).
- **Resources (`app/Http/Resources`):** Transforms Eloquent models into consistent JSON structures for API responses (e.g., `PostResource`).

---

## 🔐 Authorization Logic (Policy)

The project uses `PostPolicy` to define specific rules for interacting with `Post` resources.

| Action | Logic |
| :--- | :--- |
| **View (List/Show)** | Publicly accessible to anyone. |
| **Create** | Allowed for **Regular Users** only (Admins are restricted from creating posts in this demo). |
| **Update** | Allowed only for the **Owner** of the post OR any **Admin**. |
| **Delete** | Allowed only for the **Owner** of the post OR any **Admin**. |

*Implementation can be found in `app/Policies/PostPolicy.php`.*

---

## 📡 API Documentation

### Authentication
| Endpoint | Method | Description | Auth Required |
| :--- | :--- | :--- | :--- |
| `/api/login` | `POST` | Authenticate user and receive Bearer Token | No |
| `/api/logout` | `POST` | Revoke the current access token | Yes |

### Posts Management
| Endpoint | Method | Description | Auth Required |
| :--- | :--- | :--- | :--- |
| `/api/posts` | `GET` | List all posts | No |
| `/api/posts/{id}` | `GET` | View a single post | No |
| `/api/posts` | `POST` | Create a new post | Yes |
| `/api/posts/{id}` | `PUT` | Update an existing post | Yes |
| `/api/posts/{id}` | `DELETE` | Delete a post | Yes |

---

## ⚙️ Setup & Installation

Follow these steps to get the project running locally:

### 1. Clone the Repository
```bash
git clone <repository-url>
cd policy-gate-demo
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup
The project uses SQLite by default. Ensure your `.env` is configured (the default should work if you create the database file).
```bash
# Create the sqlite file if it doesn't exist
touch database/database.sqlite
```

### 5. Run Migrations & Seeders
This will create the tables and seed the initial users (Admin and Regular Users).
```bash
php artisan migrate --seed
```

### 6. Start the Server
```bash
php artisan serve
```

---

## 🧪 Testing the API

### Default Credentials (Seeded):
- **Admin:** `admin@example.com` / `password`
- **User 1:** `user1@example.com` / `password`
- **User 2:** `user2@example.com` / `password`

### Example Login Request:
```bash
curl -X POST http://localhost:8000/api/login \
     -H "Content-Type: application/json" \
     -d '{"email": "user1@example.com", "password": "password"}'
```

---

## 📄 License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
