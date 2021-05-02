# Fruit Listing
This sample exercise is used to demonstrate the following stacks:
**Laravel Jetstream - InertiaJs** for the front-end, **Laravel** for the back-end, **MySQL** for the database, and **Docker** containers that serve as the infrastructure

# Requirements
You need to have **Docker** installed on your local machine. This code base was tested using Docker v18.06 under Linux OS. Although it is not tested under Windows and Mac OS, usually it would still work.

# Instruction
To run the code:
1. Unzip the file locally

2. Open your terminal / command prompt (in linux), navigate to the project's root directory, and run the following docker command
`docker-compose up -d`. This docker command will instantiate 2 separate containers: app (for the laravel application) and database (mysql). The initial bootup process will take quite a fair bit of time as docker will do all of the jobs of initializing these items: **composer installation for laravel**, **npm installation for VueJs (Laravel Jetstream - Innertia)**, and **database tables and the necessary data**.

You can verify whether docker initialization has been completed or not by visiting the url of the laravel application which is set to: **http://localhost:8080**. If a "page cannot be loaded" error message shows up then that means the initialization process is still in progress.

There is a console application set up to be run every hour to fetch the data from https://dev.shepherd.appoly.io/fruit.json and this cron job needs to be set up manually. To do so, follow these steps:

1. Access into the **app** docker container by typing in the following command: `docker exec -it app sh`

2. Once you are inside the container, cd to the root directory of the application which is located in **/app** directory

3. In the root directory of the application, run this laravel artisan command for executing cron job in foreground: `php artisan schedule:work`
