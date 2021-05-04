

# A simple stackoverflow clone API 
> A simple API  that allows users to;
- **Register**
- **Login**
- **Ask questions**
- **Answer questions**
- **Upvote questions**
- **Downvote questions**
- **Upvote answers**
- **Downvote answers**
- **Show questions with answers and thier users,votes**
- **Sunscribe to questions and get notified when it's answered**

#Api documentation
>API End points and documentation can be found at: https://documenter.getpostman.com/view/9428869/TzRLkVvY  

## Description
This project was built with Laravel and MySQL.

##### Integration testing :
- PHPUnit (https://phpunit.de)
- Faker (https://github.com/fzaninotto/Faker)

## Running the API
To run the API, you must have:
- **PHP** (https://www.php.net/downloads)
- **MySQL** (https://dev.mysql.com/downloads/installer)

Clone the repository to your local machine using the command
```console
$ git clone *remote repo url*
```

Create an `.env` file using the command. You can use this config or change it for your purposes.

```console
$ cp .env.example .env
```

### Environment
Configure environment variables in `.env` for dev environment based on your MYSQL database configuration

```  
DB_CONNECTION=<YOUR_MYSQL_TYPE>
DB_HOST=<YOUR_MYSQL_HOST>
DB_PORT=<YOUR_MYSQL_PORT>
DB_DATABASE=<YOUR_DB_NAME>
DB_USERNAME=<YOUR_DB_USERNAME>
DB_PASSWORD=<YOUR_DB_PASSWORD>
```

### Installation
Install the dependencies and start the server

```console
$ composer install
$ php artisan key:generate
$ php artisan migrate
$ php artisan serve
$ php artisan jwt:secret
```
### Seeding the database
To run database seeds, run the below command. Users seeded have password as "password" by default
```console
$ php artisan db:seed
```

You should be able to visit your app at http://localhost:8000

## Testing
To run integration tests:
```console
$ composer test
```
#Assumptions
>Only authenticated users can ask questions,answer questions, downvote/upvote questions and subscribe to questions
