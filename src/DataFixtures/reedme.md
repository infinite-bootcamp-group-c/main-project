# commands

## 1. Runnable

- ### php bin/console doctrine:fixtures:load

## 2. --append

- ### By default the load command purges the database, removing all data from every table. To append your fixtures' data add the --append option.

## 3. drop and update

- ### If you want to drop the database and create it again, you can use the --purge-with-truncate option.

- ### php bin/console doctrine:schema:drop --force && php bin/console doctrine:schema:update --force

## 4. --help

## 5. recommended command

- ### php bin/console doctrine:schema:drop --force && php bin/console doctrine:schema:update --force && php bin/console doctrine:fixtures:load
