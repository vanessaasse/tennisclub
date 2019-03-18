TennisClub
========

"TennisClub" is a Symfony project created between November 2018 and March 2019.
It's a website of a tennis association. 


**REQUIREMENTS**

- PHP 7.1 or higher,
- and the usual Symfony application requirements.


**INSTALLATION**

1. Go to your localhost file and launch XAMP, WAMP ou MAMP
2. Execute this command to clone the project: `$ git clone https://github.com/vanessaasse/tennisclub.git`
3. Go to "TennisClub" file: `$ cd tennisclub`
4. Get dependancies with Composer: `$ composer install` (windows) or `$ composer.phar install` (Mac)
5. Create the database: `$ php bin/console doctrine:database:create`
7. Update database : `$ php bin/console doctrine:migrations:migrate`
8. Run the project : `$ php bin/console server:run`

