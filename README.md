# Books4Sale

I developed a full stack web application called Books4Sale where users can log in, make book listings, and modify them. This was done during my junior year Web Technologies II class. I used Laravel, PHP, and a PostgreSQL database. The application is currently hosted on a VPS.

## Demo Video

https://github.com/user-attachments/assets/9ee51089-fe75-4605-baf3-487228d52e0e

## Running the Project Locally

This guide explains how to set up and run the Books4Sale project on a local machine. The application is located in the `/public_html` directory.

### Prerequisites

You need these tools to run the project:

- PHP 8.1
- Composer
- Node.js & npm
- PostgreSQL

### Setup Instructions

Follow these steps to set up the project.

1.  **Clone the Repository**

2.  **Navigate to the Project Directory**

    All commands should be run from within the `/public_html` directory.

    ```bash
    cd Books4Sale/public_html
    ```

3.  **Install Dependencies**

    Install both the PHP and Node.js dependencies.

    ```bash
    composer install
    npm install
    ```

4.  **Configure the Environment**

    Laravel uses an environment file for configuration. Copy the example file to create a new configuration.

    ```bash
    cp .env.example .env
    ```

    Now, open the new `.env` file and set the following variables.

    - **Application Key:** You must generate a unique key. Run this command and copy the output:

      ```bash
      php artisan key:generate --show
      ```

      Paste the key into the `APP_KEY` variable in your `.env` file.

    - **Database Credentials:** Update the `DB_*` variables to match your local PostgreSQL setup.
      ```dotenv
      DB_CONNECTION=pgsql
      DB_HOST=127.0.0.1
      DB_PORT=5432
      DB_DATABASE=books4sale
      DB_USERNAME=your_db_user
      DB_PASSWORD=your_db_password
      ```

5.  **Set Up the Database**
    Create a new PostgreSQL database with the same name you used in your `.env` file.

    ```bash
    createdb books4sale
    ```

    Next, run the Laravel migrations to create the necessary tables in your database.

    ```bash
    php artisan migrate
    ```

6.  **Build Frontend Assets**

    Compile the CSS and JavaScript files for the application.

    ```bash
    npm run dev
    ```

7.  **Start the Local Server**

    Run the Artisan `serve` command to start the local development server.

    ```bash
    php artisan serve
    ```

### What I Learned

- How to set up a database
- How to host a web application on a server
- PHP Syntax
- Laravel
- Event Listeners in JS
- Authentication

https://books4sale.slajuwomi.dev/
