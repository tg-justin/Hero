# Hero Quests

This is a Laravel-based web application for managing and participating in quests. It uses PHP for server-side logic, JavaScript for client-side interactivity, and Blade for templating.

## Features

- User authentication and role-based access control
- Quest creation, management, and participation
- Dynamic quest details page with conditional display based on user role and quest status
- Mobile-friendly navigation

## Setup

1. Clone the repository
2. Install PHP dependencies with Composer: `composer install`
3. Install JavaScript dependencies with npm: `npm install`
4. Copy `.env.example` to `.env` and configure your environment variables
5. Run database migrations: `php artisan migrate`
6. Start the local development server: `php artisan serve`

## Development

This project uses PhpStorm as the IDE and is configured to use a Vagrant VM as the CLI interpreter. The project is loaded and synchronized with the Vagrant VM. The local development domain `hero.test` serves the Laravel application from the `public` directory.

## Testing

PHPUnit is set up for testing the application. Run tests with `php artisan test`.

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](https://choosealicense.com/licenses/mit/)