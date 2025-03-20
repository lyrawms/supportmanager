# To-Do List Application

This is a To-Do List web application built with Laravel 11, Vue 3, Inertia.js, and Jetstream. The project follows a
domain-driven folder structure for better organization.

## Tech Stack

- **Laravel 11**: Backend framework
- **Vue 3**: Frontend framework
- **Inertia.js**: Bridges Laravel and Vue without the need for a REST API
- **Jetstream**: Authentication and user management
- **Vite**: Asset bundling and frontend optimization

## Project Structure

The project follows a **multi-domain folder structure** to keep controllers and logic organized. The routes are
stored in `Domains/{domainName}/Routes` instead of the default `routes/web.php`.

## Features

- Task management with a clean UI
- Multi-domain organization for better scalability
- Authentication with Jetstream

## Installation

1. Clone the repository:
   ```sh
   git clone https://github.com/https://github.com/lyrawms/supportmanager.git
    ```

2. Install dependencies:
   ```sh
   composer install
   npm install
   ```

3. Create a ```.env``` file and copy all the contents from ```.env.example``` file to it.

4. Create a database and update the `.env` file:
   ```sh
   DB_CONNECTION=mysql
   DB_DATABASE='your_database'
   ```

5. Run the migrations and seed the database:
   ```sh
   php artisan migrate --seed
   ```

6. Run the application:
   ```sh
   npm run dev
   ```

   and in another terminal run the following command for schedule:

    ```sh
    php artisan schedule:work
   ```

   I am using valet for testing and running the application locally. But you can also use the following command in
   another
   terminal to run the application.

   ```sh
   php artisan serve
   ```
