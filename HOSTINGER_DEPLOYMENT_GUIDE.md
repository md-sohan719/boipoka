# 🚀 Hostinger Deployment Guide - Secure Laravel Application

## Table of Contents
1. [Prerequisites](#prerequisites)
2. [Prepare Your Application](#prepare-your-application)
3. [Database Export](#database-export)
4. [Upload Files to Hostinger](#upload-files-to-hostinger)
5. [Database Setup on Hostinger](#database-setup-on-hostinger)
6. [Environment Configuration](#environment-configuration)
7. [Configure Public Directory](#configure-public-directory)
8. [File Permissions](#file-permissions)
9. [Security Hardening](#security-hardening)
10. [SSL Certificate Setup](#ssl-certificate-setup)
11. [Post-Deployment Tasks](#post-deployment-tasks)
12. [Troubleshooting](#troubleshooting)

---

## Prerequisites

- Active Hostinger hosting account (Business or higher recommended for Laravel)
- Domain name pointed to Hostinger
- FTP/SFTP credentials from Hostinger
- SSH access (if available in your plan)
- Database access credentials

---

## 1. Prepare Your Application

### Step 1.1: Optimize Application for Production

Run these commands in your local project:

```bash
cd /var/www/html/boipoka

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Install production dependencies only
composer install --optimize-autoloader --no-dev
```

### Step 1.2: Update Environment Settings

Create a production `.env` file (don't upload your local .env):

```bash
cp .env .env.production
```

Edit `.env.production` and set:

```env
APP_NAME="Your App Name"
APP_ENV=production
APP_DEBUG=false  # CRITICAL: Must be false in production
APP_URL=https://yourdomain.com

# Database - will be filled with Hostinger credentials
DB_CONNECTION=mysql
DB_HOST=localhost  # or Hostinger's DB host
DB_PORT=3306
DB_DATABASE=your_hostinger_database_name
DB_USERNAME=your_hostinger_db_user
DB_PASSWORD=your_strong_database_password

# Generate new key for production
APP_KEY=  # Will generate in Step 6

# Disable debug mode
APP_DEBUG=false
LOG_LEVEL=error

# Session & Cache
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=database
```

### Step 1.3: Remove Unnecessary Files

Create a clean copy without development files:

```bash
# Remove development dependencies
rm -rf node_modules
rm -rf vendor

# Remove git (optional)
rm -rf .git

# Remove old installation files
rm -rf "6Valley Mult"
rm -rf old
rm -rf installation/backup  # Keep installation folder structure but remove backups
```

---

## 2. Database Export

### Step 2.1: Export Your Database

```bash
# Export database
mysqldump -u root -p123456789 6valley > database_production.sql

# Compress for faster upload
gzip database_production.sql
# This creates: database_production.sql.gz
```

### Step 2.2: Verify Export

```bash
# Check file size
ls -lh database_production.sql.gz

# Optional: Verify it's not corrupted
gunzip -t database_production.sql.gz
```

---

## 3. Upload Files to Hostinger

### Method A: Using FileZilla (Recommended for Beginners)

1. **Download FileZilla**: https://filezilla-project.org/
2. **Get Hostinger FTP Credentials**:
   - Login to Hostinger Control Panel (hPanel)
   - Go to Files → FTP Accounts
   - Note: Host, Username, Password, Port

3. **Connect via FileZilla**:
   - Host: `ftp.yourdomain.com` or IP from Hostinger
   - Username: Your FTP username
   - Password: Your FTP password
   - Port: `21` (FTP) or `22` (SFTP - recommended if available)

4. **Upload Files**:
   - Navigate to `public_html` folder on server (right panel)
   - Upload ALL files from `/var/www/html/boipoka/` (left panel)
   - **IMPORTANT**: Upload to `public_html` NOT inside a subfolder
   - This will take 15-30 minutes depending on connection

### Method B: Using cPanel File Manager

1. **Access cPanel**:
   - Login to Hostinger
   - Open File Manager

2. **Compress Files Locally**:
   ```bash
   cd /var/www/html
   tar -czf boipoka.tar.gz boipoka/
   ```

3. **Upload Archive**:
   - In File Manager, navigate to `public_html`
   - Click Upload
   - Upload `boipoka.tar.gz`
   - Right-click → Extract

4. **Move Files to Root**:
   - Move all files from `boipoka/` folder to `public_html/`
   - Delete empty `boipoka/` folder

### Method C: Using SSH (Advanced - Fastest)

```bash
# On your local machine
cd /var/www/html
tar -czf boipoka.tar.gz boipoka/

# Upload via SCP
scp boipoka.tar.gz username@yourdomain.com:~/

# SSH into server
ssh username@yourdomain.com

# Extract
cd public_html
tar -xzf ~/boipoka.tar.gz --strip-components=1
rm ~/boipoka.tar.gz
```

---

## 4. Database Setup on Hostinger

### Step 4.1: Create Database

1. **Login to Hostinger hPanel**
2. **Go to Databases → MySQL Databases**
3. **Create New Database**:
   - Database Name: `u123456789_6valley` (Hostinger adds prefix)
   - Username: `u123456789_admin` (create new)
   - Password: **Generate strong password** (save it!)
   - Click Create

4. **Note Your Credentials**:
   ```
   Database Host: localhost (or specific host from Hostinger)
   Database Name: u123456789_6valley
   Database User: u123456789_admin
   Database Password: [your generated password]
   ```

### Step 4.2: Import Database

1. **Access phpMyAdmin**:
   - From hPanel → Databases → phpMyAdmin
   
2. **Select Your Database**:
   - Click on your database name (left panel)

3. **Import SQL File**:
   - Click "Import" tab
   - Choose file: `database_production.sql.gz` (can import .gz directly)
   - Click "Go"
   - Wait for completion (may take 2-5 minutes)

4. **Verify Import**:
   - Check tables are created
   - Verify `admins` table has your admin user
   - Check `business_settings` table has data

---

## 5. Environment Configuration

### Step 5.1: Upload .env File

**CRITICAL: Never use your local .env in production**

1. **In File Manager or FTP**:
   - Navigate to `public_html/`
   - Create new file named `.env`

2. **Add Production Configuration**:

```env
APP_NAME="6Valley Multivendor"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_MODE=live
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

# Database Configuration (from Step 4)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_6valley
DB_USERNAME=u123456789_admin
DB_PASSWORD=your_strong_database_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Redis (if available)
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail Configuration (configure later)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=your-email@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# AWS (if using)
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

# Pusher (if using)
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

# Software License (from your installation)
SOFTWARE_ID=MzE0NDg1OTc=
BUYER_USERNAME=your_username
PURCHASE_CODE=your_purchase_code
```

### Step 5.2: Generate Application Key

**Via SSH** (Recommended):
```bash
cd public_html
php artisan key:generate
```

**Via Terminal/Command (if no SSH)**:
1. Generate key locally:
   ```bash
   php artisan key:generate --show
   ```
2. Copy the output key
3. Manually add to `.env` file: `APP_KEY=base64:xxxxx...`

### Step 5.3: Set Proper .env Permissions

**Via SSH**:
```bash
chmod 600 .env
```

**Via File Manager**:
- Right-click `.env` → Permissions → Set to `600` or `-rw-------`

---

## 6. Configure Public Directory

### Option A: Point Document Root to /public (Recommended)

1. **In Hostinger hPanel**:
   - Go to Advanced → PHP Configuration
   - Or Hosting → Manage → Advanced → PHP Configuration
   
2. **Change Document Root**:
   - Find "Document Root" setting
   - Change from `/public_html` to `/public_html/public`
   - Save changes

### Option B: Move public contents to public_html (Alternative)

**Only if Option A is not available:**

```bash
# Via SSH
cd public_html
mv public public_laravel
cp -r public_laravel/* ./
cp public_laravel/.htaccess ./

# Update index.php
# Edit line: require __DIR__.'/../vendor/autoload.php';
# Change to: require __DIR__.'/vendor/autoload.php';
```

### Step 6.1: Create/Update .htaccess

In `public_html/public/.htaccess` (or `public_html/.htaccess` if Option B):

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]

    # Force HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>

# Disable directory browsing
Options -Indexes

# Prevent access to .env
<Files .env>
    Order allow,deny
    Deny from all
</Files>

# PHP settings
php_value upload_max_filesize 64M
php_value post_max_size 64M
php_value max_execution_time 300
php_value max_input_time 300
```

---

## 7. File Permissions

### Step 7.1: Set Correct Permissions

**Via SSH** (Recommended):

```bash
cd public_html

# Set ownership (replace username with your Hostinger username)
chown -R username:username .

# Set directory permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Set writable directories
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Secure .env
chmod 600 .env
```

**Via File Manager**:

Set these permissions:
- **Folders**: `755` (drwxr-xr-x)
- **Files**: `644` (-rw-r--r--)
- **storage/**: `775` (drwxrwxr-x) - All subdirectories
- **bootstrap/cache/**: `775` (drwxrwxr-x)
- **.env**: `600` (-rw-------)

---

## 8. Security Hardening

### Step 8.1: Protect Sensitive Directories

Create `.htaccess` in `/storage`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ - [F,L]
</IfModule>

Deny from all
```

Create `.htaccess` in `/bootstrap`:

```apache
Deny from all
```

### Step 8.2: Disable Directory Listing

Add to root `.htaccess`:
```apache
Options -Indexes
```

### Step 8.3: Hide Laravel Version

In `public/.htaccess`, add:
```apache
# Hide Laravel
<IfModule mod_headers.c>
    Header unset X-Powered-By
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
</IfModule>
```

### Step 8.4: Update Security Headers

Add to `.env`:
```env
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
```

### Step 8.5: Change Default Admin URL

```bash
# Via SSH or tinker
php artisan tinker

# Run:
DB::table('business_settings')->where('type', 'admin_login_url')->update(['value' => 'secure-admin-2024']);
exit
```

Now admin login: `https://yourdomain.com/login/secure-admin-2024`

---

## 9. SSL Certificate Setup

### Step 9.1: Install Free SSL (Let's Encrypt)

1. **In Hostinger hPanel**:
   - Go to Security → SSL
   - Select your domain
   - Click "Install SSL"
   - Choose "Free SSL" (Let's Encrypt)
   - Wait 5-10 minutes for activation

2. **Force HTTPS**:
   - Already added in `.htaccess` (Step 6)
   - Verify in `.env`: `APP_URL=https://yourdomain.com`

### Step 9.2: Update Database URLs

```bash
# Via SSH/Tinker
php artisan tinker

# Update any HTTP URLs in database
DB::table('business_settings')->where('value', 'like', '%http://%')->update(['value' => DB::raw("REPLACE(value, 'http://', 'https://')")]);
exit
```

---

## 10. Post-Deployment Tasks

### Step 10.1: Clear All Caches

```bash
# Via SSH
cd public_html
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

### Step 10.2: Run Migrations (if any pending)

```bash
php artisan migrate --force
```

### Step 10.3: Test Application

1. **Visit Homepage**: `https://yourdomain.com`
2. **Test Admin Login**: `https://yourdomain.com/login/admin`
   - Email: `admin@admin.com`
   - Password: `12345678`
3. **Check Vendor Panel**: `https://yourdomain.com/login/employee`
4. **Test Customer Registration/Login**

### Step 10.4: Configure Cron Jobs

1. **In Hostinger hPanel**:
   - Go to Advanced → Cron Jobs
   
2. **Add Laravel Scheduler**:
   - Command: `cd /home/username/public_html && php artisan schedule:run >> /dev/null 2>&1`
   - Interval: Every minute (`* * * * *`)

### Step 10.5: Setup Queue Worker (Optional)

If using queues, set up Supervisor or create cron:
```bash
# Every minute
* * * * * cd /home/username/public_html && php artisan queue:work --stop-when-empty
```

### Step 10.6: Configure Email Settings

1. **Get Hostinger SMTP Details**:
   - Go to Emails → Email Accounts
   - Note SMTP settings

2. **Update .env**:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.hostinger.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@yourdomain.com
   MAIL_PASSWORD=your_email_password
   MAIL_ENCRYPTION=tls
   ```

3. **Test Email**:
   ```bash
   php artisan tinker
   Mail::raw('Test email', function($msg) {
       $msg->to('test@example.com')->subject('Test');
   });
   ```

---

## 11. Security Checklist

- [ ] `APP_DEBUG=false` in production
- [ ] `.env` file has 600 permissions
- [ ] Storage and bootstrap/cache writable (775)
- [ ] SSL certificate installed and working
- [ ] HTTPS forced via .htaccess
- [ ] Admin login URL changed from default
- [ ] Strong database password set
- [ ] Admin password changed from default
- [ ] File upload size limits configured
- [ ] Cron jobs configured
- [ ] Email settings tested
- [ ] Backup system in place
- [ ] `.git` folder removed (if any)
- [ ] `composer.json` doesn't expose dev dependencies
- [ ] Error logs not publicly accessible

---

## 12. Troubleshooting

### Issue: 500 Internal Server Error

**Solutions**:
```bash
# Check error logs
tail -f storage/logs/laravel.log

# Or via cPanel: Error Log viewer

# Common fixes:
chmod -R 775 storage bootstrap/cache
php artisan config:clear
php artisan cache:clear
```

### Issue: Database Connection Error

**Check**:
- Database credentials in `.env`
- Database host (might be `localhost` or specific hostname)
- Database exists and user has privileges
- Verify in phpMyAdmin you can connect

### Issue: Images/Assets Not Loading

**Solutions**:
```bash
# Create storage symlink
php artisan storage:link

# Check .htaccess exists in public folder
# Verify file permissions (644 for files)
```

### Issue: CSS/JS Not Loading

**Check**:
- APP_URL in .env matches your domain
- Mixed content errors (HTTP vs HTTPS)
- Clear browser cache
- Check asset paths in views

### Issue: Admin Can't Login

**Reset Password**:
```bash
php artisan tinker

$admin = App\Models\Admin::where('email', 'admin@admin.com')->first();
$admin->password = bcrypt('NewPassword123');
$admin->save();
exit
```

### Issue: White Screen / Blank Page

**Enable Debug Temporarily**:
```env
# In .env (ONLY for debugging, disable after)
APP_DEBUG=true
```

Check error, fix, then set back to `false`.

---

## 13. Backup Strategy

### Daily Database Backup

Create cron job:
```bash
# Daily at 2 AM
0 2 * * * mysqldump -u username -ppassword database_name | gzip > /home/username/backups/db_$(date +\%Y\%m\%d).sql.gz
```

### Weekly File Backup

```bash
# Weekly on Sunday at 3 AM
0 3 * * 0 tar -czf /home/username/backups/files_$(date +\%Y\%m\%d).tar.gz /home/username/public_html
```

### Keep Only Last 7 Days

```bash
# Daily cleanup
0 4 * * * find /home/username/backups/ -name "*.gz" -mtime +7 -delete
```

---

## 14. Performance Optimization

### Enable OPcache

In PHP configuration (hPanel):
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60
```

### Optimize Composer Autoloader

```bash
composer install --optimize-autoloader --no-dev
```

### Use CDN for Assets (Optional)

Configure in `.env`:
```env
ASSET_URL=https://cdn.yourdomain.com
```

---

## 15. Monitoring

### Setup Uptime Monitoring

- Use UptimeRobot (free): https://uptimerobot.com
- Monitor: `https://yourdomain.com`
- Get alerts if site goes down

### Setup Error Monitoring

- Use Sentry (has free tier): https://sentry.io
- Install: `composer require sentry/sentry-laravel`
- Configure in `.env`

---

## 🎉 Deployment Complete!

Your Laravel application should now be live and secure on Hostinger!

### Quick Access Links:
- **Website**: https://yourdomain.com
- **Admin Panel**: https://yourdomain.com/login/admin
- **Employee Panel**: https://yourdomain.com/login/employee

### Important Notes:
1. **Change default admin password immediately**
2. **Setup regular backups**
3. **Monitor error logs regularly**
4. **Keep Laravel and dependencies updated**
5. **Never set APP_DEBUG=true in production**

---

## Need Help?

- **Hostinger Support**: https://www.hostinger.com/contact
- **Laravel Docs**: https://laravel.com/docs
- **Community**: Laravel Forums, Stack Overflow

---

**Created**: February 17, 2026  
**Version**: 1.0  
**Application**: 6Valley Multivendor E-commerce
