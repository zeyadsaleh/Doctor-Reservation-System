# Doctor Reservation System

A simple reservation system where patient can register into the website with his details including the type of pain that he suffers, and then he can make a reservation to meet a specialiest. <br> The admin manually assign the patient with the doctors who is specilize in that kind of patient's pain.

## Prerequisites

- [node.js & npm](https://nodejs.org/)
- [Composer](https://getcomposer.org/download/)
- [laravel](http://laravel.com/)


# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)


1. Clone the repository
    ```sh
    git clone https://github.com/zeyadsaleh/Doctor-Reservation-System.git
    ```
2. Switch to the repo folder
    ```sh
    cd Doctor-Reservation-System
    ```
3. Install all the dependencies using composer
    ```sh
    composer install
    ```
4. Copy the example env file and make the required configuration changes in the .env file
    ```sh
    cp .env.example .env
    ```  
5. configure your email provider and your database settings in .env file

6. database migration and seed
    ```sh
    $ php artisan migrate --seed
    ```

7. You can access the superadmin account by => username: superadmin, password: 123456789

8. You can access any doctor's account within the seed and the password wil be 123456789

Start the local development server
    ```
    php artisan serve
    ```
You can now access the server at http://localhost:8000


## Authors

[Zeyad Saleh](https://www.linkedin.com/in/zeyad-saleh-612ab7124/)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

Copyright (c) 2020 Zeyad Mostafa Saleh

