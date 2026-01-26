# Admin Panel Setup - Boipoka

## Admin Access

The admin panel has been successfully configured. You can now access it with the following credentials:

### Admin Login Credentials
- **URL**: http://localhost/admin/dashboard
- **Email**: admin@boipoka.com
- **Password**: admin123

## Features

### Admin Dashboard
- View statistics:
  - Total users
  - Total books
  - Total exchanges
  - Pending exchanges
  - User role distribution (Buyers, Sellers, Admins)

### User Management
- View all registered users
- Change user roles (Buyer, Seller, Admin)
- Delete users (with protection for last admin)
- Filter and search users

### Book Management
- View all listed books
- See book details (title, author, condition, price, status)
- Delete books
- View book owners

### Exchange Management
- Monitor all book exchanges
- View exchange status (pending, accepted, rejected, completed)
- See requester and owner information
- Track exchange timeline

## Admin Middleware

The admin panel is protected by custom middleware that:
- Requires authentication
- Verifies admin role
- Redirects unauthorized users with appropriate error messages

## Routes

All admin routes are prefixed with `/admin` and protected by the `admin` middleware:

```php
/admin/dashboard    - Admin dashboard
/admin/users        - User management
/admin/books        - Book management
/admin/exchanges    - Exchange management
```

## User Roles

The system supports three user roles:
1. **Buyer** - Can browse and request book exchanges
2. **Seller** - Can list books and manage exchange requests
3. **Admin** - Full access to admin panel and all management features

## Security Notes

⚠️ **Important**: Change the default admin password after first login!

To change the admin password:
1. Login as admin
2. Go to your profile
3. Update your password

Or manually update via database/seeder.

## Setup Commands

The admin panel is ready to use. The following has been completed:

```bash
# Migrations run
php artisan migrate:fresh --seed

# Admin user created
# Assets copied to public/admin directory
```

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   │       └── AdminController.php
│   └── Middleware/
│       └── AdminMiddleware.php
├── Models/
│   └── User.php (with isAdmin() method)

database/
└── seeders/
    └── AdminSeeder.php

public/
└── admin/
    ├── css/
    └── js/

resources/
└── views/
    └── admin/
        ├── dashboard.blade.php
        ├── users/
        │   └── index.blade.php
        ├── books/
        │   └── index.blade.php
        └── exchanges/
            └── index.blade.php

routes/
└── web.php (admin routes added)

bootstrap/
└── app.php (admin middleware registered)
```

## Troubleshooting

### Cannot access admin panel
- Ensure you're logged in with an admin account
- Check that migrations have run successfully
- Verify the admin seeder created the admin user

### Assets not loading
- Run: `php artisan storage:link` if needed
- Check that assets were copied to `public/admin/`
- Clear browser cache

### Permission denied errors
- Verify user role is set to 'admin'
- Check middleware is properly registered in bootstrap/app.php

## Development

To create additional admin users, use the AdminSeeder or create manually:

```php
User::create([
    'name' => 'New Admin',
    'email' => 'newadmin@example.com',
    'password' => Hash::make('password'),
    'role' => 'admin',
    'email_verified_at' => now(),
]);
```
