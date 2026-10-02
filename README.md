# ☕ Life Caffe - Coffee Shop Management System

A comprehensive internal management system for coffee shop operations built with Laravel 11 and PostgreSQL. This web application enables staff and administrators to efficiently manage daily operations including product catalog, order processing, inventory control, and sales analytics.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat&logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-Database-4169E1?style=flat&logo=postgresql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-CSS-06B6D4?style=flat&logo=tailwindcss&logoColor=white)

---

## 🎯 Project Overview

**Life Caffe** is an internal management system designed for coffee shop operations. It is **NOT** a customer-facing e-commerce platform, but rather a tool for staff members to:

- Manage product catalog and categories
- Process customer orders with multiple items
- Track inventory with automatic stock deduction
- Generate sales reports and analytics
- Control access based on user roles (Admin/Staff)

This project was developed as part of the **Web Programming** university course, demonstrating proficiency in:
- Full-stack web development
- Database design and relationships
- MVC architecture
- Authentication and authorization
- RESTful API design

---

## ✨ Key Features

### 🔐 Authentication & Authorization
- Secure login system with password hashing (bcrypt)
- Role-based access control (Admin & Staff)
- Session management with remember me functionality
- CSRF protection on all forms
- Middleware-based route protection

### 📦 Product Management (Admin Only)
- Complete CRUD operations for products
- Category assignment and organization
- Price management with decimal precision
- Availability toggle (available/unavailable)
- Many-to-many relationship with ingredients

### 🏷️ Category Management (Admin Only)
- Create, read, update, delete categories
- Organize products by category (Hot Drinks, Cold Drinks, Pastries)
- Track product count per category
- Cascade deletion (deleting category removes related products)

### 🛒 Order Processing (Admin & Staff)
- Create orders with customer name
- Multi-product selection with quantity controls
- Real-time total calculation
- Automatic order number generation (ORD-XXXXX format)
- Order status tracking (Pending, Completed, Canceled)
- Database transactions for data integrity

### 📊 Inventory Management (Admin Only)
- Track ingredients with stock quantities
- Set minimum quantity thresholds
- Low stock alerts on dashboard
- Automatic stock deduction on order completion
- Unit of measurement support (g, ml, pcs, etc.)
- Many-to-many relationship with products

### 📈 Sales Reporting (Admin Only)
- Daily, weekly, or custom date range reports
- Total revenue calculations
- Order count statistics (total, completed, canceled)
- Product sales breakdown
- Best-selling products analysis

### 📱 Dashboard
- Real-time statistics (orders, revenue)
- Recent orders table
- Low stock ingredient alerts
- Quick action buttons
- Role-specific content display

---

## 🛠️ Technologies Used

### Backend
- **Laravel 11** - PHP web application framework
- **PHP 8.4** - Server-side programming language
- **PostgreSQL** - Relational database management system
- **Eloquent ORM** - Database abstraction and query builder

### Frontend
- **HTML5** - Markup structure
- **CSS3** - Styling
- **Tailwind CSS 3** - Utility-first CSS framework
- **JavaScript** - Client-side interactivity
- **Blade Templating** - Laravel's template engine

### Development Tools
- **Laravel Herd** - Local development environment
- **Vite** - Frontend build tool and asset bundler
- **Composer** - PHP dependency manager
- **npm** - Node.js package manager
- **Git** - Version control system

---

## 📊 Database Schema

The application uses **7 normalized tables** with the following relationships:

### Tables

1. **users** - User authentication and roles
   - id, name, email, password, role, timestamps

2. **categories** - Product categories
   - id, name, description, timestamps

3. **products** - Menu items
   - id, category_id (FK), name, description, price, image, is_available, timestamps

4. **orders** - Customer orders
   - id, user_id (FK), customer_name, order_number, status, total_amount, timestamps

5. **order_items** - Order line items (bridge table)
   - id, order_id (FK), product_id (FK), quantity, price, subtotal, timestamps

6. **ingredients** - Inventory items
   - id, name, unit, quantity_in_stock, minimum_quantity, timestamps

7. **ingredient_product** - Product-ingredient relationships (pivot table)
   - id, ingredient_id (FK), product_id (FK), quantity_needed, timestamps

### Relationships

**One-to-Many:**
- User → Orders (one user creates many orders)
- Category → Products (one category has many products)
- Order → Order Items (one order has many items)
- Product → Order Items (one product in many orders)

**Many-to-Many:**
- Products ↔ Ingredients (many products use many ingredients)
  - Pivot table: `ingredient_product` with extra field `quantity_needed`
  - Example: Cappuccino uses 18g coffee beans, 150ml milk

---

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.4 or higher
- PostgreSQL 12 or higher
- Composer
- Node.js & npm
- Laravel Herd (or any PHP local server)

### Step 1: Clone Repository
```bash
git clone https://github.com/fatlum1300/life-caffe.git
cd life-caffe
```

### Step 2: Install PHP Dependencies
```bash
composer install
```

### Step 3: Install Node Dependencies
```bash
npm install
```

### Step 4: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 5: Configure Database
Open `.env` file and update database credentials:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=life_caffe
DB_USERNAME=postgres
DB_PASSWORD=your_password_here
```

### Step 6: Create Database
Using PostgreSQL:
```sql
CREATE DATABASE life_caffe;
```

### Step 7: Run Migrations & Seeders
```bash
# Run migrations (create tables)
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### Step 8: Build Frontend Assets
```bash
npm run build
```

### Step 9: Start Application
If using Laravel Herd, the application is automatically available at:
```
http://life-caffe.test
```

Otherwise, use:
```bash
php artisan serve
```
Then visit: `http://localhost:8000`

---

## 🔑 Login Credentials

### Admin Account
- **Email:** admin@lifecaffe.com
- **Password:** password
- **Access:** Full system access

### Staff Account
- **Email:** staff@lifecaffe.com
- **Password:** password
- **Access:** Limited to orders only

---

## 📸 Screenshots

### Login Page
Clean authentication interface with role-based access.

### Dashboard
Real-time statistics, recent orders, and low stock alerts.

### Product Management
Complete CRUD operations with category assignment and ingredient relationships.

### Order Creation
Multi-product selection with automatic total calculation.

### Inventory Management
Track ingredients with automatic stock deduction system.

### Sales Reports
Date-filtered analytics with revenue calculations.

---

## 🏗️ Project Structure
```
life-caffe/
├── app/
│   ├── Http/
│   │   ├── Controllers/         # Application controllers
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── ProductController.php
│   │   │   ├── OrderController.php
│   │   │   ├── IngredientController.php
│   │   │   └── ReportController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php  # Admin authorization
│   └── Models/                  # Eloquent models
│       ├── User.php
│       ├── Category.php
│       ├── Product.php
│       ├── Order.php
│       ├── OrderItem.php
│       └── Ingredient.php
├── database/
│   ├── migrations/              # Database migrations
│   └── seeders/                 # Database seeders
├── resources/
│   ├── views/                   # Blade templates
│   │   ├── layouts/
│   │   │   └── app.blade.php    # Main layout
│   │   ├── auth/
│   │   │   └── login.blade.php
│   │   ├── categories/
│   │   ├── products/
│   │   ├── orders/
│   │   ├── ingredients/
│   │   ├── reports/
│   │   └── dashboard.blade.php
│   └── css/
│       └── app.css              # Tailwind CSS
├── routes/
│   └── web.php                  # Application routes
├── public/                      # Public assets
├── .env                         # Environment configuration
├── composer.json                # PHP dependencies
├── package.json                 # Node dependencies
└── tailwind.config.js           # Tailwind configuration
```

---

## 🔒 Security Features

- **Password Hashing:** Bcrypt algorithm with automatic salting
- **CSRF Protection:** Token validation on all state-changing requests
- **SQL Injection Prevention:** Eloquent ORM with parameterized queries
- **XSS Protection:** Automatic output escaping via Blade templates
- **Mass Assignment Protection:** Fillable attributes on models
- **Session Security:** HTTP-only cookies with regeneration
- **Role-Based Access Control:** Middleware authorization
- **Input Validation:** Server-side form validation

---

## 🎓 Learning Outcomes

This project demonstrates proficiency in:

### Technical Skills
✅ **Full-Stack Development** - Complete application from database to UI  
✅ **MVC Architecture** - Strict separation of concerns  
✅ **Database Design** - Normalized schema with complex relationships  
✅ **RESTful API** - Resource controllers with proper HTTP methods  
✅ **Authentication** - Secure login with role-based access  
✅ **ORM Usage** - Eloquent for database abstraction  
✅ **Frontend Design** - Responsive UI with Tailwind CSS  
✅ **Version Control** - Git for source code management  

### Concepts Implemented
- CRUD operations (Create, Read, Update, Delete)
- One-to-Many relationships (User → Orders, Category → Products)
- Many-to-Many relationships (Products ↔ Ingredients)
- Database transactions for atomic operations
- Event-driven architecture (automatic stock deduction)
- Middleware for authorization
- Form validation and error handling
- Database seeding for development data

---

## 🔄 Future Enhancements

Potential features for future development:

- [ ] User profile management
- [ ] Email notifications for low stock
- [ ] PDF export for sales reports
- [ ] Product image upload functionality
- [ ] Multi-store support
- [ ] Order receipt printing
- [ ] API endpoints for mobile app
- [ ] Advanced analytics dashboard
- [ ] Customer management system
- [ ] Payment integration

---

## 📝 API Routes

### Authentication Routes
```
GET  /                    - Login page
POST /                    - Process login
POST /logout              - Logout
```

### Admin Routes (Requires 'admin' role)
```
# Categories
GET    /categories             - List all categories
GET    /categories/create      - Show create form
POST   /categories             - Store new category
GET    /categories/{id}/edit   - Show edit form
PUT    /categories/{id}        - Update category
DELETE /categories/{id}        - Delete category

# Products (same pattern as categories)
# Ingredients (same pattern as categories)

# Reports
GET /reports                   - Sales reports with date filtering
```

### Staff Routes (Requires authentication)
```
GET  /dashboard                - Dashboard with statistics

# Orders
GET    /orders                 - List all orders
GET    /orders/create          - Show create form
POST   /orders                 - Store new order
GET    /orders/{id}            - Show order details
POST   /orders/{id}/update-status - Update order status
DELETE /orders/{id}            - Delete order
```

---

## 🤝 Contributing

This is an educational project developed for university coursework. However, suggestions and improvements are welcome!

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is developed for educational purposes as part of the Web Programming university course.

---

## 👨‍💻 Author

**Fatlum Asani**  
Computer Science Student  
GitHub: [@Iven](https://github.com/IvenLagowan)

---

## 🙏 Acknowledgments

- **Laravel Framework** - For providing an excellent PHP framework
- **Tailwind CSS** - For the utility-first CSS framework
- **PostgreSQL** - For the robust database system
- **University Professors** - For guidance and web programming education

---

## 📞 Contact

For questions or feedback about this project:
- GitHub: [Chua DF](https://github.com/IvenLagowan)
- Repository: [https://github.com/IvenLagowan/coffe-live.git](https://github.com/IvenLagowan/coffe-live.git)
- Email: cuaocuq@gmail.com
---

**⭐ If you find this project helpful, please consider giving it a star!**
