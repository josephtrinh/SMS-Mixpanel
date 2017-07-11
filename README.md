## Overview

This is a basic webhook for Mixpanel to send out SMS via Nexmo. 


## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

    php composer.phar install

	OR

    sudo composer install


## Setup Database
   
    Run the mysql_setup.sql to create the database.


You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.


## To start Application

To run the application in development, you can also run this command. 

    php -S localhost:8080 -t public public/index.php
