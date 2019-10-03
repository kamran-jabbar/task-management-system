# Steps to setup the project kindly run these command in the project directory

1. `git clone https://github.com/kamran-jabbar/task-management-system.git`

2. update `.env` with database credential, database name

3. `composer install`

4. `php artisan migrate --seed`

5. `php artisan key:generate` (to avoid the key error)

6. `php artisan serve`

# Default user for testing

email: kamran@test.com 
password: 123456

# User manual: 

User can register by visiting `/register`

![alt text](http://www.kamranjabbar.com/img/register-page.png)

User can login by visiting `/login`

![alt text](http://www.kamranjabbar.com/img/login-page.png)

User can view listing of added tasks with detail after login `/dashboard`. 

![alt text](http://www.kamranjabbar.com/img/listing-page.png)

User can create task by visiting `/create-task`

![alt text](http://www.kamranjabbar.com/img/create-task.png)

# Database Schema

![alt text](http://www.kamranjabbar.com/img/task-schema.png)

