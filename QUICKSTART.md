# Quick Start Guide - Inventory & Sales Management System

## Step-by-Step Installation

### 1. Initial Setup (First Time Only)

Open Command Prompt/PowerShell and navigate to the project:
```bash
cd c:\xampp\htdocs\control_c_technologies
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Create Environment File
```bash
copy .env.example .env
```

### 4. Generate App Key
```bash
php artisan key:generate
```

### 5. Configure Database in .env
Edit the `.env` file and set these values:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_sales
DB_USERNAME=root
DB_PASSWORD=
```

Create the database using phpMyAdmin:
- Go to http://localhost/phpmyadmin
- Create a new database named `inventory_sales`

### 6. Run Migrations & Seed Data
```bash
php artisan migrate --seed
```

This will:
- Create all necessary database tables
- Create a demo admin user
- Add sample products across all categories

### 7. Start the Server
```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

---

## Demo Login Credentials

### Admin Account
- **URL**: http://localhost:8000
- **Email**: admin@example.com
- **Password**: password

---

## First-Time Usage Guide

### As an Admin:
1. Log in with admin credentials
2. Check the **Dashboard** for key metrics
3. Visit **Categories** to view product categories
4. Go to **Products** to see the sample inventory
5. Navigate to **Reports** to view sales data
6. Click **New Sale** to record a transaction
7. Select products and quantities, choose payment method, and complete the sale

---

## Sample Data Included

### Products (Across All Categories)
- **Laptops**: Dell XPS, MacBook Air, Lenovo ThinkPad
- **Accessories**: Wireless Mouse, Mechanical Keyboard
- **Consoles**: PlayStation 5, Xbox Series X
- **Games**: Elden Ring
- **Gaming Accessories**: Gaming Headset, Game Controller

All sample products have realistic pricing and stock levels.

---

## Troubleshooting

### Database Connection Error
- Ensure MySQL is running in XAMPP Control Panel
- Check database name in `.env` matches created database
- Run `php artisan migrate --seed` again

### "Class not found" Error
- Run `composer dump-autoload`
- Then `php artisan serve` again

### Migrations Failed
- Delete the database and create it again
- Run `php artisan migrate:refresh --seed`

### Port 8000 Already in Use
```bash
php artisan serve --port=8001
```

---

## Common Tasks

### Add a New Product
1. Log in as Admin
2. Go to Products → Add Product
3. Fill in all required fields
4. Save and product appears in inventory

### Record a Sale
1. Log in as Admin
2. Click "New Sale"
3. Search and select products
4. Adjust quantities as needed
5. Choose payment method
6. Complete sale

### View Sales Reports
1. Log in as Admin
2. Go to Reports
3. Choose report type (Daily, Weekly, Monthly)
4. Use filters if needed
5. View detailed analytics

---

## Key Features to Explore

✓ Real-time stock updates  
✓ Low-stock alerts  
✓ Sales filtering by date and product  
✓ Profit margin calculations  
✓ Interactive dashboards with charts  
✓ Receipt printing  
✓ Multiple payment method tracking  

---

## Support

If you encounter any issues:
1. Check the SETUP_GUIDE.md for detailed documentation
2. Verify all requirements are met
3. Check logs in `storage/logs/` directory
4. Ensure database migrations completed successfully

---

## Next Steps

After installation:
1. Explore the admin dashboard
2. Manage product inventory
3. Practice recording sales
4. Review generated reports
5. Customize system settings as needed

Happy selling! 🚀
