# Project Setup Instructions

This README provides instructions for setting up the project and running it locally. Please follow the steps below:

## Requirements

- PHP 8 or higher
- MySQL 8

## Clone the Repository

Move to the desired repository location (e.g., `/var/www` in this case) and clone the project using the following command:

```bash
cd /var/www
git clone https://github.com/nikolaciro/nikola-cirovic-test.git
```
## Backend Setup

Now, get into the project's backend dir and create the project database by running the following commands:

```bash
cd /nikola-cirovic-test/backend
composer install
php artisan migrate
```

Now, in order to pull real data from Google Maps, run the following command in the same dir:
```bash
php artisan app:pull-google-reviews-command
```
After this, you can start the project locally by running:
```bash
php artisan serve
```
Now, the backend app should be up and running on port 127.0.0.1:8000. If it's not, please free this port and rerun the command.

## Frontend Setup

To get into the frontend directory and run the app, please run the following commands:
```bash
cd /var/www/nikola-cirovic-test/frontend
http-server -p 3000
```
Now, the frontend app should be up and running on port 127.0.0.1:3000. If it's not, please free this port and rerun the command.
