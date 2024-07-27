# Hero Project Summary

The "Hero" project is a web application developed by Tabletop Gaymers, a non-profit organization, to encourage the involvement of volunteers by gamifying the experience. Volunteers register as "heroes" who then complete tasks for the organization called "quests." As they complete the quests, they earn experience points (XP), gain levels, titles, and have special opportunities to earn physical rewards like t-shirts, buttons, ribbons, and enamel pins.

## System Requirements

The application is written using the Laravel 11 framework and requires:
- PHP 8.3
- MariaDB 11.4
- NodeJS 18.20
- Composer
- Artisan
- npm

The Laravel framework is configured to use:
- Tailwind CSS framework
- Breeze authentication kit
- TinyMCE rich text editor

The production application is managed using Laravel Forge and hosted on Azure servers running:
- Ubuntu
- Nginx
- MariaDB

## Development Environment

The application is developed on Windows machines running:
- Laravel Homestead through Vagrant on Oracle VirtualBox, configured to match the production environment
- PhpStorm by JetBrains (preferred IDE)
- DataGrip and other related tools

## Key Challenges

### Email Verification and Redirects
- Implemented handling for email verification links opened in different browsers.
- Configured middleware for unauthenticated email verification (`UnauthenticatedVerifyEmail`).
- Ensured proper redirects post-email verification to the login page.

### Middleware Configuration
- Added custom middleware (`LevelUpNotificationMiddleware`, `UnauthenticatedVerifyEmail`) in `bootstrap/app.php`.
- Defined middleware aliases for simplified use in routing.

### Routing and Middleware in Laravel 11
- Utilized the new method for middleware registration in Laravel 11.
- Implemented `Route::resource` for RESTful routing with implicit route naming.

### CSS and Tailwind
- Managed list styles with consistent margins and responsive visibility.
- Utilized `overflow-hidden` and other Tailwind classes for layout and design.

### File Management and Uploads
- Created a utility function to sanitize filenames using PHP regex.
- Ensured file path management compatibility across local and production environments.

### Node.js Versions
- Standardized Node.js versions across development and production using `nvm`.
- Addressed discrepancies in Node.js versions on different environments.

### TinyMCE Configuration
- Configured TinyMCE for spellcheck and autoresize.
- Customized content styles and editor behavior.

### Symbolic Links and File Access in Homestead
- Addressed issues with symbolic links and explored `rsync` as a solution.
- Managed file access and synchronization in Homestead.

### Promotional Content for Hero Program
- Drafted and refined promotional flyer content for the Hero program.

### General Development Practices
- Used PhpStorm and GitHub for development and version control.
- Managed commits, handled errors, and utilized environment variables effectively.

## Project Setup Instructions

To set up the project locally:

1. Clone the repository:
    ```sh
    git clone https://github.com/tg-justin/hero.git
    cd hero
    ```

2. Install dependencies:
    ```sh
    composer install
    npm install
    ```

3. Set up the environment variables:
    ```sh
    cp .env.example .env
    php artisan key:generate
    ```

4. Run the application:
    ```sh
    php artisan serve
    ```

## Contribution Guidelines

We welcome contributions! Please follow these steps to contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit your changes (`git commit -m 'Add new feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request.