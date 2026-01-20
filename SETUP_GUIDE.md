# Inventory & Sales Management System

A comprehensive web-based inventory and sales management system built with Laravel, designed specifically for retail shops selling laptops, computer accessories, gaming consoles, video games, and gaming accessories.

## Features

### Core Features
- **Real-time Inventory Tracking**: Monitor stock levels across all products
- **Sales Recording**: Simple and efficient sales transaction recording
- **Low-Stock Alerts**: Automatic notifications when products fall below thresholds
- **Multi-Category Support**: Organize products into 5 predefined categories
- **Sales Reports**: Daily, weekly, and monthly sales analytics
- **Role-Based Access Control**: Separate admin and staff functionalities

### Admin Capabilities
- Product Management
  - Add, edit, view, and delete products
  - Manage product categories
  - Track cost price and selling price
  - Monitor stock levels and set low-stock thresholds
  - Store serial numbers and supplier information

- Staff Management
  - Create staff accounts
  - Manage staff access (activate/deactivate)
  - Update staff information
  - Track sales by individual staff members

- Reporting & Analytics
  - View all sales records with filters
  - Generate daily, weekly, and monthly reports
  - Track total revenue and profit
  - View profit margins and trends
  - Analyze sales by staff, date, and payment method

- Dashboard
  - Real-time key metrics
  - Low-stock product alerts
  - Top-selling products
  - Recent sales overview
  - Sales trend visualization

### Staff Capabilities
- Sales Recording
  - Quick product search and selection
  - Easy quantity adjustment
  - Real-time total calculation
  - Support for multiple payment methods

- Sales Management
  - View sales history
  - Print receipts
  - Access past transactions

## Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL 8.0 or MariaDB
- Laravel 11

### Installation Steps

1. **Clone or Extract the Project**
```bash
cd c:\xampp\htdocs\control_c_technologies
```

2. **Install Dependencies**
```bash
composer install
```

3. **Create Environment File**
```bash
copy .env.example .env
```

4. **Generate Application Key**
```bash
php artisan key:generate
```

5. **Configure Database** (in `.env`)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_sales_db
DB_USERNAME=root
DB_PASSWORD=
```

6. **Run Migrations**
```bash
php artisan migrate
```

7. **Seed Sample Data**
```bash
php artisan db:seed
```

8. **Start the Development Server**
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Demo Credentials

### Admin Account
- **Email**: admin@example.com
- **Password**: password

### Staff Accounts
- **Email**: staff@example.com or staff2@example.com
- **Password**: password

## Database Schema

### Tables
- **users**: Admin and staff accounts with role-based access
- **categories**: Product categories
- **products**: Product inventory with pricing and stock information
- **sales**: Sales transactions with payment method tracking
- **sale_items**: Individual items within each sale

## System Architecture

### Controllers
- `AdminDashboardController`: Admin dashboard with key metrics
- `CategoryController`: Category management (CRUD)
- `ProductController`: Product management and search
- `StaffController`: Staff account management
- `ReportController`: Sales reporting and filtering
- `StaffDashboardController`: Staff dashboard
- `SalesRecordingController`: Sales transaction recording

### Models
- `User`: User with roles (admin/staff)
- `Category`: Product categorization
- `Product`: Product inventory
- `Sale`: Sales transactions
- `SaleItem`: Items within a sale

### Views
Organized into separate directories:
- `admin/`: Admin panel views (dashboard, products, categories, staff, reports)
- `staff/`: Staff views (dashboard, sales recording, receipts)
- `auth/`: Authentication views
- `layouts/`: Shared layout templates

## Key Features in Detail

### Inventory Management
- Add products with detailed information (name, brand, model, serial number)
- Set cost price and selling price for profit tracking
- Define low-stock thresholds with automatic alerts
- Track supplier information for easy ordering

### Sales Recording
- Interactive product selection with real-time search
- Quantity adjustment with stock validation
- Automatic stock reduction after successful sale
- Support for multiple payment methods (Cash, Mobile Money, Card)
- Optional transaction reference tracking

### Financial Tracking
- Real-time revenue calculation
- Automatic profit calculation per transaction
- Profit margin analysis
- Cost of goods sold (COGS) tracking
- Financial summaries by period

### Reporting
- Customizable date range filtering
- Filter by payment method or staff
- Export-ready sales summaries
- Visual sales trends with charts
- Daily, weekly, and monthly breakdowns

## Real-Time Features
- Automatic stock updates after each sale
- Low-stock alerts on dashboard
- Real-time metric calculations
- Instant sales history updates

## Security Features
- Password hashing with bcrypt
- Session-based authentication
- Role-based middleware protection
- CSRF protection on all forms
- SQL injection prevention through Eloquent ORM

## File Structure
```
resources/
├── views/
│   ├── admin/
│   │   ├── dashboard.blade.php
│   │   ├── categories/
│   │   ├── products/
│   │   ├── staff/
│   │   └── reports/
│   ├── staff/
│   │   ├── dashboard.blade.php
│   │   └── sales/
│   ├── auth/
│   └── layouts/
│       └── app.blade.php
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminDashboardController.php
│   │   ├── CategoryController.php
│   │   ├── ProductController.php
│   │   ├── StaffController.php
│   │   ├── ReportController.php
│   │   ├── StaffDashboardController.php
│   │   ├── SalesRecordingController.php
│   │   └── Auth/
│   └── Middleware/
│       ├── AdminMiddleware.php
│       └── StaffMiddleware.php
├── Models/
│   ├── User.php
│   ├── Category.php
│   ├── Product.php
│   ├── Sale.php
│   └── SaleItem.php
database/
├── migrations/
├── seeders/
```

## Usage Guide

### For Admins
1. Log in with admin credentials
2. Access dashboard to view key metrics
3. Manage products and categories in the Inventory section
4. Create and manage staff accounts in the Management section
5. View detailed sales reports and analytics

### For Staff
1. Log in with staff credentials
2. View available products on the dashboard
3. Click "New Sale" to record a transaction
4. Search and select products
5. Adjust quantities as needed
6. Select payment method
7. Complete sale and print receipt

## Customization

### Adding New Product Categories
1. Navigate to Categories in the admin panel
2. Click "Add Category"
3. Enter category name and description
4. Products can now be assigned to this category

### Modifying Pricing
- Edit products to change cost or selling prices
- Profit margin is calculated automatically
- Past sales are not affected by price changes

## Performance Optimization
- Database indexes on frequently queried fields
- Pagination on large data sets
- Efficient query relationships using Eloquent eager loading

## Browser Compatibility
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Support & Maintenance
For issues or questions, refer to the following:
- Check system logs in `storage/logs/`
- Verify database connection in `.env`
- Ensure all migrations are completed
- Clear application cache with `php artisan cache:clear`

## Future Enhancements
- Customer management module
- Supplier payment tracking
- Inventory forecasting
- Export to Excel/PDF
- Mobile app
- Barcode scanning
- Multi-location support
- API integration

## License
This system is provided as-is for retail inventory management purposes.

## Version
Version 1.0.0 - January 2026
