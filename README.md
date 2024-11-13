# Background Job Helper

A robust Laravel package for managing background jobs with configurable retries, priorities, and monitoring capabilities.

## Installation

1. Clone the repository:

git clone https://github.com/sfxgizuka/background-job-runner.git


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
DB_CONNECTION=sqlite
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

## Configuration Options
### Retry Settings
- retries: Number of retry attempts (default: 3)
- backoff: Delay between retries in seconds (default: 30)
- maxExceptions: Maximum allowed exceptions before marking job as failed

### Priority Levels
- high: Processed first
- medium: Standard priority
- low: Processed when queue is clear

### Security
- Rate limiting
- Job timeout settings
- Queue encryption

### Advanced Features
Job Dashboard
Access the job monitoring dashboard at / to:

- View job statuses
- Monitor failed jobs

## Error Handling
The BackgroundJobRunner service automatically:

- Logs failures to Laravel's logging system
- Implements exponential backoff between retries
- Moves failed jobs to the failed_jobs table after all retries are exhausted
