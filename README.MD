# Truck subunits

Programmer task for Inovatyvus

### routes
The routes are default laravel api resource routes.
```
/api
    /trucks [GET, POST] 
    /trucks/{id} [GET, PATCH, DELETE]
    /subunits [GET, POST]
    /subunits/{id} [GET, PATCH, DELETE]
```
Optional trucks parameter for `/subunits` for example `/subunits?truck=abc123`.


### format
The format is in JSON as follows
```
/trucks
    {
    "unit": "123asd", (will be converted to uppercase)
    "year": 1999,
    "notes": "Available" (optional)
    }

/subunits
    {
    "main_truck": "ABC123",
    "subunit": "DEF456",
    "start_date": "2023-07-04",
    "end_date": "2023-07-04"
    }
```

## requirements
- docker

## instructions
1. Clone repository
    - rename docker containers if necessary in `docker-compose.yml`
2. In the repository folder run `docker compose up --build`
3. Once container is running, duplicate the `.env.example` file, rename it to `.env`
4. Inside the php container `laravel-php` (if you haven't renamed it) run `composer install`
    - if it does not generate the app key automatically, run `php artisan key:generate`
5. Finally, run `php artisan migrate`, you may add `--seed` to also seed a few trucks into the db
6. The project is now reachable through localhost (default port `80`)

## postman
You may use the postman file provided to quickly setup testing.
