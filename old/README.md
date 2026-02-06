# Boipoka - Book Marketplace

A Laravel-based platform for buying, selling, and exchanging books online.

## Features

- **Book Listing**: Sellers can post books for sale, exchange, or both
- **Browse & Search**: Users can search and filter books by title, author, category, and listing type
- **Book Exchange**: Users can propose book exchanges with other users
- **User Roles**: Buyer, Seller, and Admin roles with appropriate permissions
- **Book Conditions**: Support for multiple book conditions (new, like new, very good, good, acceptable)
- **Image Upload**: Upload book cover images
- **Exchange Management**: Accept, reject, or complete exchange requests

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Set up environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure database in `.env` file

5. Run migrations:
   ```bash
   php artisan migrate
   ```

6. Create storage link:
   ```bash
   php artisan storage:link
   ```

7. (Optional) Seed sample data:
   ```bash
   php artisan db:seed --class=BookSeeder
   ```

8. Compile assets:
   ```bash
   npm run dev
   ```

9. Start the development server:
   ```bash
   php artisan serve
   ```

## Test Accounts

After running the seeder, you can use these accounts:

- **Seller Account**
  - Email: seller@boipoka.com
  - Password: password

- **Buyer Account**
  - Email: buyer@boipoka.com
  - Password: password

## Usage

### For Sellers
1. Register or login with a seller role
2. Navigate to "Browse Books" and click "List a Book"
3. Fill in book details and choose listing type (sell, exchange, or both)
4. Upload a book image (optional)
5. Manage your books from "My Books"

### For Buyers
1. Register or login
2. Browse available books
3. Search by title, author, or filter by type
4. Click on a book to view details
5. Buy or propose an exchange

### Book Exchanges
1. Click "Propose Exchange" on a book available for exchange
2. Select one of your books to offer
3. Add a message (optional)
4. Wait for the owner to accept or reject
5. Once accepted, complete the exchange

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates, Tailwind CSS
- **Database**: MySQL/PostgreSQL/SQLite
- **Authentication**: Laravel Breeze

## Database Schema

### Users Table
- Role (buyer, seller, admin)
- Contact information (phone, address)

### Books Table
- Title, author, description, ISBN
- Price, condition, listing type
- Category, publication year, language
- Status (available, sold, exchanged, reserved)
- Image

### Book Exchanges Table
- Requester and owner information
- Books involved in the exchange
- Status (pending, accepted, rejected, completed)
- Message

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
