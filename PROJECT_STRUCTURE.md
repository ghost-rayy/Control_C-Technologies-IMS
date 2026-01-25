# Project Structure & File Guide

## Complete Directory Tree

```
control_c_technologies/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminDashboardController.php      [Dashboard metrics & overview]
│   │   │   ├── CategoryController.php            [Category CRUD operations]
│   │   │   ├── ProductController.php             [Product CRUD & search]
│   │   │   ├── ReportController.php              [Sales reporting & filtering]
│   │   │   ├── SalesRecordingController.php      [Sales transaction recording]
│   │   │   └── Auth/
│   │   │       └── AuthenticatedSessionController.php [Login/Logout handler]
│   │   └── Middleware/
│   │       └── AdminMiddleware.php               [Admin access protection]
│   └── Models/
│       ├── User.php                              [User model with admin role]
│       ├── Category.php                          [Product category model]
│       ├── Product.php                           [Product inventory model]
│       ├── Sale.php                              [Sales transaction model]
│       └── SaleItem.php                          [Individual sale items]
│
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php      [Users with roles]
│   │   ├── 0001_01_01_000001_create_cache_table.php      [Cache table]
│   │   ├── 0001_01_01_000002_create_jobs_table.php       [Jobs queue]
│   │   ├── 0001_01_01_000003_create_categories_table.php [Categories]
│   │   ├── 0001_01_01_000004_create_products_table.php   [Products]
│   │   ├── 0001_01_01_000005_create_sales_table.php      [Sales]
│   │   └── 0001_01_01_000006_create_sale_items_table.php [Sale items]
│   └── seeders/
│       └── DatabaseSeeder.php                   [Sample data initialization]
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php                    [Master layout template]
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php              [Admin dashboard view]
│   │   │   ├── categories/
│   │   │   │   ├── index.blade.php              [Category list]
│   │   │   │   ├── create.blade.php             [Add category]
│   │   │   │   └── edit.blade.php               [Edit category]
│   │   │   ├── products/
│   │   │   │   ├── index.blade.php              [Product list with search]
│   │   │   │   ├── create.blade.php             [Add product]
│   │   │   │   ├── edit.blade.php               [Edit product]
│   │   │   │   └── show.blade.php               [Product details]
│   │   │   └── reports/
│   │   │       ├── sales.blade.php              [Sales report with filters]
│   │   │       ├── daily.blade.php              [Daily report]
│   │   │       ├── weekly.blade.php             [Weekly report with chart]
│   │   │       └── monthly.blade.php            [Monthly report with chart]
│   │   ├── sales/
│   │   │   ├── create.blade.php                 [Sales recording interface]
│   │   │   ├── receipt.blade.php                [Receipt display]
│   │   │   ├── print.blade.php                  [Printable receipt]
│   │   │   └── history.blade.php                [Sales history]
│   │   └── auth/
│   │       └── login.blade.php                  [Login form]
│   ├── css/
│   │   └── app.css                              [Custom styles]
│   └── js/
│       ├── app.js                               [Main app script]
│       └── bootstrap.js                         [Bootstrap initialization]
│
├── routes/
│   └── web.php                                  [All route definitions]
│
├── bootstrap/
│   ├── app.php                                  [Middleware registration]
│   └── providers.php                            [Service providers]
│
├── config/
│   ├── app.php                                  [Application config]
│   ├── auth.php                                 [Authentication config]
│   ├── database.php                             [Database config]
│   └── [other configs]
│
├── public/
│   └── index.php                                [Entry point]
│
├── storage/
│   ├── logs/
│   │   └── laravel.log                          [Application logs]
│   ├── app/
│   └── framework/
│
├── vendor/
│   └── [Composer dependencies]
│
├── .env                                         [Environment configuration]
├── .gitignore                                   [Git ignore file]
├── artisan                                      [CLI command tool]
├── composer.json                                [Composer configuration]
├── composer.lock                                [Composer lock file]
├── package.json                                 [NPM configuration]
├── phpunit.xml                                  [Testing configuration]
├── vite.config.js                               [Vite configuration]
├── README.md                                    [Original README]
├── QUICKSTART.md                                [Quick installation guide]
├── SETUP_GUIDE.md                               [Comprehensive setup guide]
├── IMPLEMENTATION_SUMMARY.md                    [What was built]
├── FEATURE_CHECKLIST.md                         [Feature verification]
├── TROUBLESHOOTING.md                           [Issue solutions]
└── PROJECT_STRUCTURE.md                         [This file]
```

## File Descriptions

### Controllers (app/Http/Controllers/)

#### AdminDashboardController.php
**Purpose**: Display admin dashboard with metrics
**Key Methods**:
- `index()` - Returns dashboard view with all metrics

**Metrics Calculated**:
- Total products and low-stock count
- Today's sales count, revenue, and profit
- Total revenue and profit (all-time)
- Top selling products (monthly)
- Sales trend (last 7 days)
- Staff count

#### CategoryController.php
**Purpose**: Manage product categories
**Key Methods**:
- `index()` - List all categories
- `create()` - Show create form
- `store()` - Save new category
- `edit()` - Show edit form
- `update()` - Update category
- `destroy()` - Delete category

#### ProductController.php
**Purpose**: Manage product inventory
**Key Methods**:
- `index()` - List products with pagination
- `create()` - Show create form
- `store()` - Save new product
- `show()` - View product details
- `edit()` - Show edit form
- `update()` - Update product
- `destroy()` - Delete product
- `search()` - API endpoint for product search

#### StaffController.php
**Purpose**: Manage staff accounts
**Key Methods**:
#### ReportController.php
**Purpose**: Generate sales reports and analytics
**Key Methods**:
- `index()` - Sales report with 30-day default
- `filter()` - Apply filters to reports
- `daily()` - Daily report for specific date
- `weekly()` - Weekly report with daily breakdown
- `monthly()` - Monthly report with daily breakdown
- `generateSummary()` - Calculate report metrics

#### SalesRecordingController.php
**Purpose**: Handle sales transactions
**Key Methods**:
- `create()` - Show sales recording form
- `store()` - Save new sale and update stock
- `receipt()` - Show sale receipt
- `print()` - Show printable receipt
- `history()` - Show sales history

#### AuthenticatedSessionController.php
**Purpose**: Handle authentication
**Key Methods**:
- `store()` - Process login
- `destroy()` - Process logout

### Models (app/Models/)

#### User.php
**Relationships**:
- `hasMany('Sale')` - User to sales
**Methods**:
- `isAdmin()` - Check if admin
- `isActive()` - Check if account active
**Fields**: id, name, email, password, role, is_active, timestamps

#### Category.php
**Relationships**:
- `hasMany('Product')` - Category to products
**Fields**: id, name, slug, description, timestamps

#### Product.php
**Relationships**:
- `belongsTo('Category')` - Product to category
- `hasMany('SaleItem')` - Product to sale items
**Methods**:
- `isLowStock()` - Check if below threshold
- `getProfit()` - Calculate profit per unit
- `getProfitMargin()` - Calculate profit percentage
**Fields**: id, category_id, name, brand, model, serial_number, cost_price, selling_price, quantity_in_stock, low_stock_threshold, supplier, description, sku, timestamps

#### Sale.php
**Relationships**:
- `belongsTo('User')` - Sale to user
- `hasMany('SaleItem')` - Sale to items
**Methods**:
- `getProfit()` - Calculate total profit
- `getProfitMargin()` - Calculate profit percentage
**Fields**: id, user_id, total_amount, total_cost, payment_method, transaction_ref, timestamps

#### SaleItem.php
**Relationships**:
- `belongsTo('Sale')` - Item to sale
- `belongsTo('Product')` - Item to product
**Methods**:
- `getProfit()` - Calculate item profit
**Fields**: id, sale_id, product_id, quantity, unit_price, total_price, unit_cost, timestamps

### Middleware (app/Http/Middleware/)

#### AdminMiddleware.php
**Purpose**: Protect admin routes
**Checks**:
- User is authenticated
- User has admin role
- Account is active
**Redirects to**: Home with error message

### Views

#### layouts/app.blade.php
Master layout with:
- Navigation sidebar
- Top navigation bar
- Alert displays
- Authentication user info
- Logout button
- Mobile responsive design

#### admin/dashboard.blade.php
Contains:
- 4 main metric cards
- 3 financial metric cards
- Low stock products table
- Top selling products table
- Recent sales table
- 7-day sales trend chart

#### Product Management Views
- **index**: Product list with search, pagination
- **create**: Form for adding new product
- **edit**: Form for editing product
- **show**: Product details with sales history

#### Report Views
- **sales**: Sales list with filter form
- **daily**: Daily transactions for specific date
- **weekly**: Weekly overview with daily chart
- **monthly**: Monthly overview with daily chart

#### Sales Views
- **create**: Interactive sales recording interface
- **receipt**: Professional receipt display
- **print**: Thermal printer-optimized receipt
- **history**: Staff's sales transaction history

### Routes (routes/web.php)

**Public Routes**:
- GET `/` - Home/redirect to dashboard
- GET `/login` - Login form
- POST `/login` - Process login

**Admin Routes** (prefix: `/admin`, middleware: `admin`):
- GET `/dashboard` - Dashboard
- Resources: categories, products, staff
- GET `/products/search` - Product search API
- PATCH `/staff/{staff}/toggle-active` - Toggle staff
- Reports: daily, weekly, monthly, filter

**Staff Routes** (prefix: `/staff`, middleware: `staff`):
- GET `/dashboard` - Dashboard
- POST `/logout` - Logout
- GET `/sales/create` - New sale form
- POST `/sales` - Save sale
- GET `/sales/{sale}/receipt` - View receipt
- GET `/sales/{sale}/print` - Print receipt
- GET `/sales/history` - Sales history

### Database Migrations

#### users_table
Columns: id, name, email, password, role, is_active, email_verified_at, remember_token, timestamps

#### categories_table
Columns: id, name, slug, description, timestamps

#### products_table
Columns: id, category_id, name, brand, model, serial_number, cost_price, selling_price, quantity_in_stock, low_stock_threshold, supplier, description, sku, timestamps

#### sales_table
Columns: id, user_id, total_amount, total_cost, payment_method, transaction_ref, timestamps

#### sale_items_table
Columns: id, sale_id, product_id, quantity, unit_price, total_price, unit_cost, timestamps

## Key Configuration Files

### .env
Database connection and application settings

### bootstrap/app.php
Middleware registration and application setup

### routes/web.php
All route definitions and route groups

### config/database.php
Database connection configuration

## External Libraries

- **Laravel 11** - Web framework
- **Bootstrap 5** - CSS framework
- **Bootstrap Icons** - Icon library
- **Chart.js** - Charts and graphs
- **Composer** - PHP package manager

## Development Tools

- **Artisan** - CLI command tool
- **Laravel Tinker** - Interactive PHP shell
- **Vite** - Build tool
- **PHPUnit** - Testing framework

---

## How to Navigate the Code

### To Find a Feature
1. Check routes/web.php for the URL
2. Find controller in app/Http/Controllers/
3. View corresponds to resources/views/

### To Add a New Feature
1. Create migration: `php artisan make:migration`
2. Create model: `php artisan make:model`
3. Create controller: `php artisan make:controller`
4. Add routes in routes/web.php
5. Create views in resources/views/

### To Modify a Feature
1. Find the controller method
2. Update business logic
3. Update/check migrations if schema changes
4. Update views if UI changes
5. Test thoroughly

---

## File Statistics

- **Total Controllers**: 8
- **Total Models**: 5
- **Total Migrations**: 7
- **Total Views**: 25+
- **Total Routes**: 40+
- **Middleware**: 2
- **Documentation Files**: 4

---

**Last Updated**: January 2026  
**Version**: 1.0.0
