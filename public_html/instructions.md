Of course! It's a great idea to document the setup process for your old projects. Running a project with multiple, distinct versions like this can be tricky, so clear instructions are key.

Here are the detailed instructions for setting up and running your "Books4Sale" project locally on a Mac. I have written them to a markdown file as requested.

---

### instructions.md

```markdown
# How to Run the Books4Sale Project Locally on macOS

This guide provides step-by-step instructions for setting up the necessary environment on a Mac to run the various homework assignments in the Books4Sale project.

The repository is structured into directories for each assignment (e.g., `1-hw01`, `2-hw02`, etc.). Assignments 1 through 6 are built with vanilla PHP, while assignments 7 through 11 are full Laravel applications.

## Table of Contents
1.  [System Prerequisites](#1-system-prerequisites)
2.  [Database Setup (One-Time Setup)](#2-database-setup-one-time-setup)
3.  [Running Vanilla PHP Assignments (hw01 - hw06)](#3-running-vanilla-php-assignments-hw01---hw06)
4.  [Running Laravel Assignments (hw07 - hw11)](#4-running-laravel-assignments-hw07---hw11)

---

## 1. System Prerequisites

You'll need to install a few tools to create a local development environment. We'll use [Homebrew](https://brew.sh/), the most popular package manager for macOS, to simplify this process.

### 1.1 Install Homebrew
If you don't have Homebrew, open your Terminal and run this command:
```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

### 1.2 Install PHP
The project's `composer.json` files specify a requirement for PHP `^7.3` or `^8.0`. Let's install PHP 8.0.
```bash
brew install php@8.3
```
After installation, follow the instructions provided by Homebrew to add PHP to your `PATH`.

### 1.3 Install Composer
Composer is the dependency manager for PHP.
```bash
brew install composer
```

### 1.4 Install PostgreSQL
The project uses a PostgreSQL database.
```bash
brew install postgresql
```
Once installed, start the PostgreSQL service:
```bash
brew services start postgresql
```

### 1.5 Install Node.js & npm
The Laravel projects require Node.js and npm to manage frontend dependencies.
```bash
brew install node
```

---

## 2. Database Setup (One-Time Setup)

All database-driven assignments (hw03 onwards) rely on the same PostgreSQL database schema. The original connection was to a remote school database which is likely no longer accessible. You will need to create this database locally.

### 2.1 Create Database and User
First, create a new PostgreSQL user and database. Open your terminal and run:
```bash
# Create a new user (you will be prompted to set a password)
createuser --interactive --pwprompt

# Enter name of role to add: books_user
# Enter password for new role: your_secure_password
# Enter it again: your_secure_password
# Shall the new role be a superuser? (y/n) n
# Shall the new role be allowed to create databases? (y/n) y
# Shall the new role be allowed to create more new roles? (y/n) n

# Create the database, owned by your new user
createdb -U books_user -O books_user books4sale_db
```

### 2.2 Create Tables
Now, connect to your new database and create the necessary schema and tables.

```bash
psql -U books_user -d books4sale_db
```

Once inside the `psql` shell, run the following SQL commands. These were inferred from the project's PHP files and Laravel migrations.

```sql
-- Create the schema that the application expects
CREATE SCHEMA stephen;

-- Grant your user permissions on this schema
GRANT ALL ON SCHEMA stephen TO books_user;

-- Create the users table
CREATE TABLE stephen.book_users (
    user_id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    api_token VARCHAR(80) UNIQUE,
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Create the books table
CREATE TABLE stephen.books (
    book_id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    condition VARCHAR(255),
    book_condition VARCHAR(255), -- Some versions use this column name
    price NUMERIC(8, 2) NOT NULL,
    created_by INTEGER REFERENCES stephen.book_users(user_id) ON DELETE SET NULL,
    user_id INTEGER REFERENCES stephen.book_users(user_id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);

-- Grant your user permissions to the tables
GRANT ALL ON stephen.book_users TO books_user;
GRANT ALL ON stephen.books TO books_user;
GRANT USAGE, SELECT ON SEQUENCE stephen.book_users_user_id_seq TO books_user;
GRANT USAGE, SELECT ON SEQUENCE stephen.books_book_id_seq TO books_user;
```

Type `\q` to exit `psql`. Your database is now ready.

---

## 3. Running Vanilla PHP Assignments (hw01 - hw06)

These assignments are simple PHP applications that can be run using PHP's built-in web server.

1.  **Navigate to the Assignment Directory**:
    Open your terminal and `cd` into the directory for the assignment you want to run. For example:
    ```bash
    cd public_html/5-hw05
    ```

2.  **Update Database Connection**:
    This is a critical step. The PHP files contain a hardcoded connection string to a remote database. You must replace it with your local connection details.
    *   Open all `.php` files in the directory (e.g., `addbook.php`, `index.php`, `login.php`).
    *   Find this line:
        ```php
        $db = pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");
        ```
    *   Replace it with your local connection string:
        ```php
        $db = pg_connect("host=localhost dbname=books4sale_db user=books_user password=your_secure_password");
        ```

3.  **Start the PHP Server**:
    From within the assignment directory, run the following command:
    ```bash
    php -S localhost:8000
    ```

4.  **View in Browser**:
    Open your web browser and navigate to `http://localhost:8000`. You should now be able to test the functionality of that specific homework assignment.

> **Note**: Assignment `1-hw01` does not have a database, so you can skip step 2 and run it directly.

---

## 4. Running Laravel Assignments (hw07 - hw11)

These assignments are full Laravel applications. Each one needs to be set up individually. The following steps should be repeated for each directory (`7-hw07`, `8-hw08`, `9-hw09`, `ten-hw10`, `eleven-hw11`).

Let's use `9-hw09` as the example:

1.  **Navigate to the Directory**:
    ```bash
    cd public_html/9-hw09
    ```

2.  **Create `.env` File**:
    Laravel uses a `.env` file for environment configuration. Copy the example file (if it exists) or create a new one.
    ```bash
    cp .env.example .env
    ```
    If `.env.example` does not exist, create `.env` and paste the following content into it. **Update the `DB_*` values with the credentials you created in the database setup step.**

    ```dotenv
    APP_NAME=Books4Sale
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_URL=http://localhost

    LOG_CHANNEL=stack
    LOG_LEVEL=debug

    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=books4sale_db
    DB_USERNAME=books_user
    DB_PASSWORD=your_secure_password
    ```

3.  **Install Dependencies**:
    Install both the PHP and Node.js packages.
    ```bash
    composer install
    npm install
    ```

4.  **Generate Application Key**:
    Every Laravel app needs a unique security key.
    ```bash
    php artisan key:generate
    ```

5.  **Run Database Migrations**:
    This command will set up the tables that Laravel manages (like `users`, `password_resets`, etc.) using the files in the `database/migrations` directory.
    ```bash
    php artisan migrate:fresh
    ```
    > **Important**: None of the Laravel projects include a migration file for the `books` table. This is why you must create it manually as described in the **Database Setup** section.

6.  **Insert Mock User Data**:
    Using the values in the .env file, run the following command to insert the mock user data:
    ```bash
    psql -h [HOST] -p [PORT] -U [USERNAME] -d [DATABASE_NAME] -f schema.sql
    ```

6.  **Compile Frontend Assets**:
    This step compiles JavaScript and CSS files.
    ```bash
    npm run dev
    ```

7.  **Start the Laravel Server**:
    This starts a local development server for the application.
    ```bash
    php artisan serve
    ```

8.  **View in Browser**:
    The command will output a URL, usually `http://127.0.0.1:8000`. Open this URL in your browser to see the running application.

### Notes on Specific Laravel Versions

*   **hw07 & hw08**: These are early versions. Authentication was not fully set up, so login/register functionality may be incomplete or non-existent in the web interface.
*   **hw09**: This version introduces `laravel/ui`, which provides a complete authentication system. After running the migrations, you should be able to register and log in. The database schema for users also changes to `book_users` in this version, which aligns with the manual SQL setup.
*   **hw10 & hw11**: These versions focus on building a REST API. While there may be some web pages, the primary functionality is exposed via API endpoints (check `routes/api.php`). You would typically use a tool like Postman or Insomnia to test these endpoints (e.g., `POST /api/register`, `POST /api/login`, `GET /api/books`). `hw11` adds token-based authentication and authorization middleware.
