Steps to setup the project kindly run these command in the project directory

1. `git clone https://github.com/kamran-jabbar/task-management-system.git`

2. update `.env` with database credential, database name

3. `composer install`

4. `php artisan migrate --seed`

5. `php artisan key:generate` (to avoid the key error)

6. `php artisan serve`

Default user for testing
email: kamran@test.com 
password: 123456

URLs

/login

/register

/dashboard

/create-task
