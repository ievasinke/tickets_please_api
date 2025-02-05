# Laravel API Master Class – Workshop Project

This repository contains my implementation of the **Laravel API Master Class** workshop from [Laracasts](https://laracasts.com/series/laravel-api-master-class), originally created with **Laravel 10**, but I have built it using **Laravel 11**.

## About the Workshop  
The **Laravel API Master Class** teaches how to **design, version, build, and secure** a web API using Laravel. Starting from scratch, it guides through constructing a fully functional API step by step.

## Project Features  
✅ Built with **Laravel 11** instead of Laravel 10  
✅ Versioned API structure  
✅ Authentication & Authorization  
✅ Request validation and policies  
✅ Resourceful controllers & data filtering  
✅ API documentation 

## Installation (Using Laravel Sail)  

1. **Clone the repository**  
   ```sh
   git clone git@github.com:ievasinke/tickets_please_api.git
   cd tickets_please_api

2. **Copy the environment file and set up Laravel Sail**  
   ```sh
   cp .env.example .env

3. **Start Laravel Sail (this may take some time on first run)**  
   ```sh
   ./vendor/bin/sail up
   
4. **Install dependencies**  
   ```sh
   ./vendor/bin/sail composer install

5. **Run migrations and seed the database**  
   ```sh
   ./vendor/bin/sail artisan migrate --seed

6. **Generate API documentation with Scribe**  
   ```sh
   ./vendor/bin/sail artisan scribe:generate

7. **Access the application**  
   ```sh
   ./vendor/bin/sail artisan serve


## 📄 API Documentation  
This project uses **Scribe** to generate API documentation.  
Once generated, you can view the documentation in your browser at:  

👉 **[http://localhost/docs](http://localhost/docs)**  

---

## 🚀 API Usage  
You can interact with the API using tools like [Postman](https://www.postman.com/).
   
## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Copyright (c) 2025 Ieva
