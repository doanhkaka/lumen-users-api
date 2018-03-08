## Build RESTFUL API with Lumen PHP Framework

A RESTful API based on Lumen micro-framework.

## Installation

Steps:
1. Clone the repository

        git clone git@github.com:truongquangchien87/lumen-users-api.git
    
2. Switch to the repo folder
   
       cd lumen-users-api
   
3. Install all the dependencies using composer
   
       composer install
   
4. Copy the example env file and make the required configuration changes in the .env file
   
       cp .env.example .env
       
Please edit database name, database username, and database password if needed.

        DB_CONNECTION=mysql
        DB_HOST=localhost
        DB_PORT=3306
        DB_DATABASE=database
        DB_USERNAME=username
        DB_PASSWORD=password
       
5. Run the database migrations (**Set the database connection in .env before migrating**)

        php artisan migrate

6. Run the database seeder and you're done
   
        php artisan db:seed

7. Start the local development server

        php -S localhost:8000 -t public

You can now access the server at http://localhost:8000

## Routing

The api can now be accessed at: 

        http://localhost:8000/api/users
        
You can test the API using [Postman](https://www.getpostman.com/).

| HTTP Method	| Path              | Action    | Fields            | Request headers       |
| -----         | -----             | -----     | -------------     | ---------             |
| GET           | /api/users        | index     |                   | None                  |
| GET           | /api/users/{id}   | show      |                   | None                  |
| PUT           | /api/users        | update    | name, address, tel| x-api-key (required)  |

## Pagination

Example Usages:

        GET /api/users?cursor=5&limit=5
        GET /books?cursor=10&previous=5&limit=5

## Security

For demonstration purpose, I added authentication layer to `update` api. 
In order to update a user, you must send request header `x-api-key`, you can get it in `api_token` column in `users` table.
Otherwise you'll get `401 Unauthorized` response.

## Running the tests

1. Create a database for testing purpose, then declare its name in `phpunit.xml`

        <env name="DB_DATABASE" value="db_testing"/>

2. At root folder, run this command:

        vendor/bin/phpunit
        
