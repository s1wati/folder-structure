# Laravel 8 Files/Folders Management

This is a [Laravel](https://laravel.com) project to manage folder stucture.

## Getting started

### Requirement to setup this project
  - PHP 7.3
  - Composer
  - Apache server
  - Mysql

### Launch the starter project

_(Assuming you've [installed Laravel](https://laravel.com/docs/5.5/installation))_

 clone this repository, and run bellow commont in your newly created directory:

```bash
- Clone the repository with git clone
- composer install
```

Next you need to make a copy of the `.env.example` file and rename it to `.env` inside your project root.

Run the following command to generate your app key:

```
php artisan key:generate
```
Run the following command to create table in database:

```
- php artisan migrate --seed - (it has some seeded data for your testing)
```
Run the following command to link storage to public:

```
- php artisan storage:link
```

Then start your server:

```
php artisan serve
```

Your Laravel starter project is now up and running!

## Screenshots 
![Laravel Folders/Files Front](https://quickadminpanel.com/blog/wp-content/uploads/2020/09/Screen-Shot-2020-09-15-at-5.10.21-PM.png)

  
