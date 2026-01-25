# Troubleshooting Guide

## Common Issues & Solutions

### Installation Issues

#### Issue: "Composer not found"
**Solution:**
1. Download Composer from https://getcomposer.org
2. Install Composer globally
3. Restart your terminal/command prompt
4. Try `composer install` again

#### Issue: "PHP version requirements not met"
**Solution:**
- Check PHP version: `php --version`
- Should be PHP 8.2 or higher
- Update PHP in XAMPP Control Panel if needed

#### Issue: "Database connection refused"
**Solution:**
1. Verify MySQL is running in XAMPP Control Panel
2. Check `.env` file has correct credentials:
   ```
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inventory_sales
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Create database manually in phpMyAdmin if needed
4. Run `php artisan migrate --seed` again

---

### Login Issues

#### Issue: "Invalid email or password"
**Solution:**
- Ensure you're using exact demo credentials:
  - Email: admin@example.com
  - Password: password
- Check Caps Lock is off
- Clear browser cache and try again

#### Issue: Stuck on login page
**Solution:**
1. Clear browser cookies and cache
2. Try a different browser
3. Log out from all other sessions
4. Restart the server: `php artisan serve`

---

### Database Issues

#### Issue: "Column not found" or migration errors
**Solution:**
```bash
php artisan migrate:refresh --seed
```
This will:
- Rollback all migrations
- Re-run all migrations
- Seed sample data

⚠️ **Warning**: This deletes all data. Only use in development.

#### Issue: "Table already exists"
**Solution:**
1. Delete the database in phpMyAdmin
2. Create a new empty database with same name
3. Run `php artisan migrate --seed`

#### Issue: "Integrity constraint violation"
**Solution:**
- This means a foreign key relationship is broken
- Run full reset: `php artisan migrate:refresh --seed`
- Or manually delete related records first

---

### Server Issues

#### Issue: "Port 8000 is already in use"
**Solution:**
Use a different port:
```bash
php artisan serve --port=8001
```
Then access: http://localhost:8001

#### Issue: Server won't start
**Solution:**
1. Check if another instance is running: `tasklist | find "artisan"`
2. Kill the process if needed
3. Check for syntax errors: `php artisan tinker` (should work)
4. Clear config cache: `php artisan config:clear`
5. Try again: `php artisan serve`

#### Issue: "Class not found" error
**Solution:**
```bash
composer dump-autoload
php artisan serve
```

---

### Feature-Related Issues

#### Issue: Sales not saving
**Solution:**
1. Check database is running
2. Verify product has stock available
3. Check payment method is selected
4. Verify at least one item is in cart
5. Check browser console for JavaScript errors (F12)

#### Issue: Stock not updating after sale
**Solution:**
1. Refresh the product page
2. Check database: `SELECT * FROM products WHERE id=X`
3. Run `php artisan cache:clear`
4. Try recording sale again

#### Issue: Reports showing no data
**Solution:**
1. Record a test sale first
2. Check date range in filter is correct
3. Verify sale date matches filter criteria
4. Run database query to verify sale exists:
   ```sql
   SELECT * FROM sales;
   ```

#### Issue: Profit calculations incorrect
**Solution:**
- Profit = Selling Price - Cost Price
- Check product cost_price and selling_price
- Verify sale items have correct unit_price
- Check sale total_cost field is being set

---

### Performance Issues

#### Issue: Slow dashboard/reports
**Solution:**
1. Clear application cache: `php artisan cache:clear`
2. Optimize database: `php artisan db:seed`
3. Close other applications using resources
4. Clear browser cache (Ctrl+Shift+Delete)

#### Issue: High memory usage
**Solution:**
1. Restart the server
2. Check for large file uploads
3. Clear logs: `php artisan logs:clear` (if available)
4. Restart XAMPP/MySQL

---

### Security Issues

#### Issue: "CSRF token mismatch"
**Solution:**
1. Clear browser cookies
2. Close and reopen browser
3. Clear Laravel session: `php artisan session:clear`
4. Try again

#### Issue: "Unauthorized" error on page load
**Solution:**
1. Log out: click Logout button
2. Log back in
3. If still issues, clear browser cookies
4. Check user role matches expected page:
   - Admin pages: user must be admin
   - Admin pages: user must be admin

---

### View/Template Issues

#### Issue: Page shows blank or formatting broken
**Solution:**
1. Check browser console for errors (F12)
2. Verify assets loaded: check Network tab
3. Clear cache: `php artisan view:clear`
4. Hard refresh browser: Ctrl+Shift+R
5. Try different browser

#### Issue: Images or icons not showing
**Solution:**
1. Check Bootstrap CSS loaded in Network tab
2. Clear cache: `php artisan cache:clear`
3. Hard refresh: Ctrl+Shift+R
4. Check CDN is accessible (internet connection)

---

### API/Route Issues

#### Issue: "404 Not Found" on valid page
**Solution:**
1. Check route exists in `routes/web.php`
2. Verify middleware is correct
3. Check user is authenticated (if required)
4. Restart server: `php artisan serve`

#### Issue: Redirect loop
**Solution:**
1. Clear cookies and session
2. Log out
3. Log back in with correct role
4. Check middleware in `bootstrap/app.php`

---

### Data Issues

#### Issue: Duplicate products or sales
**Solution:**
1. Check if record already exists before adding
2. Use unique SKU or serial numbers
3. Delete duplicates manually in database

#### Issue: Can't delete product
**Solution:**
- Products can only be deleted if they have no sales history
- If product has sales, you can:
  - Deactivate by setting quantity to 0
  - Edit product name/details instead
  - Keep it for historical reference

#### Issue: Product search not working
**Solution:**
1. Check product exists (verify in Products list)
2. Clear browser cache
3. Try different search term
4. Check search function: should match name, brand, or SKU

---

### Browser-Specific Issues

#### Chrome Issues
- Clear cache: Settings → Privacy → Clear browsing data
- Disable extensions temporarily
- Try incognito mode

#### Firefox Issues
- Clear cache: Preferences → Privacy → Clear Data
- Disable extensions
- Try Private Window

#### Safari Issues
- Clear cache: Develop → Empty Caches
- Reset Safari: Safari → Reset Safari
- Allow cookies for the site

---

### Windows-Specific Issues

#### Issue: "Permission denied" when running commands
**Solution:**
1. Run Command Prompt as Administrator
2. Or use PowerShell as Administrator
3. Retry the command

#### Issue: File path not found
**Solution:**
- Use forward slashes in paths: `c:/xampp/htdocs/...`
- Or escaped backslashes: `c:\\xampp\\htdocs\\...`
- Use quotes around paths with spaces

---

### Mac-Specific Issues

#### Issue: "Command not found: php"
**Solution:**
1. Install PHP: `brew install php`
2. Or use full path: `/usr/local/bin/php`
3. Add to PATH if needed

#### Issue: Permissions errors
**Solution:**
```bash
sudo chmod -R 755 storage/
sudo chmod -R 755 bootstrap/cache/
```

---

### Linux-Specific Issues

#### Issue: MySQL connection refused
**Solution:**
```bash
sudo systemctl start mysql
# or
sudo service mysql start
```

#### Issue: Permission denied on storage
**Solution:**
```bash
sudo chmod -R 755 storage/
sudo chmod -R 755 bootstrap/cache/
sudo chown -R www-data:www-data .
```

---

## Diagnostic Commands

Run these to check system status:

```bash
# Check PHP version
php --version

# Check Composer
composer --version

# Check Laravel installation
php artisan --version

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Check migrations
php artisan migrate:status

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# View application logs
tail -f storage/logs/laravel.log
```

---

## Getting Help

If issue persists:

1. **Check Logs**
   ```
   storage/logs/laravel.log
   ```

2. **Enable Debug Mode**
   In `.env`:
   ```
   APP_DEBUG=true
   ```

3. **Database Check**
   - Use phpMyAdmin: http://localhost/phpmyadmin
   - Verify all tables exist
   - Check data is present

4. **Clear Everything**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   php artisan route:clear
   composer dump-autoload
   php artisan serve
   ```

5. **Fresh Install**
   ```bash
   php artisan migrate:refresh --seed
   php artisan serve
   ```

---

## Performance Optimization Tips

- Use incognito/private browsing mode to avoid cache issues
- Close unused browser tabs
- Restart MySQL if system is slow
- Use Chrome DevTools to check load times
- Clear logs periodically: `storage/logs/`

---

## Backup & Recovery

### Create Backup
```bash
# Export database
mysqldump -u root inventory_sales > backup.sql
```

### Restore Backup
```bash
# Import database
mysql -u root inventory_sales < backup.sql
```

---

## When All Else Fails

1. **Complete System Reset**
   ```bash
   php artisan migrate:refresh --seed
   php artisan serve
   ```

2. **Fresh Installation**
   - Delete project
   - Re-extract from backup
   - Follow QUICKSTART.md from step 2

3. **Ask for Help**
   - Share error messages
   - Provide `php --version` output
   - Mention steps already taken
   - Include any relevant logs

---

**Last Updated**: January 2026
**Version**: 1.0.0
