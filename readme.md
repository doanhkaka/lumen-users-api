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
       
5. Run the database migrations (**Set the database connection in .env before migrating**)

        php artisan migrate

6. Start the local development server

        php -S localhost:8000 -t public

You can now access the server at http://localhost:8000

7. Run the database seeder and you're done
   
        php artisan db:seed

## Routing

The api can now be accessed at: 

        http://localhost:8000/api/users
        
You can test the API using [Postman](https://www.getpostman.com/).

| HTTP Method	| Path      | Action    | Fields            | Request headers       |
| -----         | -----     | -----     | -------------     | ---------             |
| GET           | /users    | index     |                   | None                  |
| PUT           | /users    | update    | name, address, tel| x-api-key (required)  |

In order to update a user, you must send request header `x-api-key`, you can get it in `api_token` column in `users` table.