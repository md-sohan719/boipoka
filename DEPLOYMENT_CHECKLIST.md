# 📋 Hostinger Deployment Checklist

## Pre-Deployment (Local Machine)

- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Clear all caches: `php artisan config:clear && php artisan cache:clear`
- [ ] Export database: `mysqldump -u root -p123456789 6valley > database.sql`
- [ ] Compress database: `gzip database.sql`
- [ ] Remove development files (node_modules, .git, old folders)
- [ ] Create production `.env` file (don't upload local .env!)

## Hostinger Setup

- [ ] Create MySQL database in hPanel
- [ ] Note database credentials (host, name, user, password)
- [ ] Create FTP/SFTP account or note SSH access

## File Upload

- [ ] Upload all files to public_html via FTP/SSH
- [ ] Upload compressed files to speed up transfer
- [ ] Verify all files uploaded successfully

## Database Setup

- [ ] Import database.sql via phpMyAdmin
- [ ] Verify tables created successfully
- [ ] Check admin user exists in `admins` table

## Configuration

- [ ] Upload production `.env` file to public_html
- [ ] Update `.env` with Hostinger database credentials
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_URL=https://yourdomain.com`
- [ ] Generate new APP_KEY: `php artisan key:generate`
- [ ] Set `.env` permissions to 600

## Public Directory

- [ ] Point document root to `/public_html/public` OR
- [ ] Move public contents to root (if can't change document root)
- [ ] Verify `.htaccess` exists in public directory
- [ ] Add HTTPS redirect to `.htaccess`

## Permissions

- [ ] Set directories to 755
- [ ] Set files to 644
- [ ] Set storage/ to 775 (recursive)
- [ ] Set bootstrap/cache/ to 775 (recursive)
- [ ] Set .env to 600

## Security

- [ ] Verify `APP_DEBUG=false`
- [ ] Install SSL certificate (Let's Encrypt)
- [ ] Force HTTPS in `.htaccess`
- [ ] Change default admin login URL
- [ ] Protect storage/ with .htaccess
- [ ] Protect bootstrap/ with .htaccess
- [ ] Remove .git folder
- [ ] Verify .env is not publicly accessible

## Post-Deployment

- [ ] Run: `php artisan config:cache`
- [ ] Run: `php artisan route:cache`
- [ ] Run: `php artisan view:cache`
- [ ] Run: `php artisan storage:link`
- [ ] Setup cron job for Laravel scheduler
- [ ] Configure email settings (SMTP)
- [ ] Test email sending

## Testing

- [ ] Visit homepage: https://yourdomain.com
- [ ] Test admin login
- [ ] Test vendor/employee login
- [ ] Test customer registration
- [ ] Test image uploads
- [ ] Test all main features
- [ ] Check error logs (should be empty)

## Security Verification

- [ ] Try accessing: https://yourdomain.com/.env (should be blocked)
- [ ] Try accessing: https://yourdomain.com/storage (should be blocked)
- [ ] Verify HTTPS working (green padlock)
- [ ] Check security headers
- [ ] Verify no sensitive info in error messages

## Backup Setup

- [ ] Setup daily database backup cron
- [ ] Setup weekly file backup cron
- [ ] Test backup restoration
- [ ] Setup off-site backup storage

## Monitoring

- [ ] Setup uptime monitoring (UptimeRobot)
- [ ] Setup error tracking (Sentry - optional)
- [ ] Monitor server resources
- [ ] Check logs regularly

## Final Steps

- [ ] Change admin password from default
- [ ] Document all credentials securely
- [ ] Update DNS if needed
- [ ] Clear CDN cache (if using)
- [ ] Announce site is live!

---

## Quick Commands Reference

```bash
# Clear caches
php artisan config:clear && php artisan cache:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
php artisan storage:link

# Check current config
php artisan config:show

# View routes
php artisan route:list
```

## Important Credentials to Save

```
Domain: https://yourdomain.com
Admin URL: https://yourdomain.com/login/admin
Admin Email: admin@admin.com
Admin Password: [CHANGE THIS!]

Database Host: localhost
Database Name: u123456789_6valley
Database User: u123456789_admin
Database Password: [your password]

FTP Host: ftp.yourdomain.com
FTP User: [your username]
FTP Password: [your password]

SSH Host: yourdomain.com
SSH User: [your username]
SSH Port: 22
```

---

**🎯 Deployment Status**: ⬜ Not Started | 🟡 In Progress | ✅ Complete

**Last Updated**: _______________  
**Deployed By**: _______________
