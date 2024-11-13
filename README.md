# Background Job Helper

A Laravel helper function for easily running background jobs with configurable retries.

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
```

2. Install PHP dependencies:
```bash
composer install
```

3. Create environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure database connection in `.env` file
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run database migrations:
```bash
php artisan migrate
```

7. Start the development server:
```bash
php artisan serve
```

## Basic Usage

The `runBackgroundJob()` helper function allows you to easily dispatch background jobs:

```php
runBackgroundJob(
    EmailService::class,
    'sendWelcomeEmail', 
    ['userId' => 123]
);
```

## Function Signature
```php
runBackgroundJob(
    string $className,
    string $methodName, 
    array $parameters = [],
    int $retries = 3
)
```
### Parameters

- $className: The fully qualified class name containing the job logic
- $methodName: The method to execute within the class
- $parameters: Optional array of parameters to pass to the method
- $retries: Number of retry attempts (defaults to 3)

## Error Handling
The BackgroundJobRunner service automatically:

Logs failures to Laravel's logging system
Implements exponential backoff between retries
Moves failed jobs to the failed_jobs table after all retries are exhausted
