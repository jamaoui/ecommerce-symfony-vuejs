# Demo
![image](https://github.com/user-attachments/assets/538aef38-315f-4643-b302-0e2334d2234e)
# Requirements
PHP, NodeJs, git, composer, Mysql
# Technologies
Vuejs 3 + Symfony 7 + Symfony ux (vuejs)
# Documentation
Once the project has been cloned, run composer install and npm/yarn install to install the packages used.
Then create the database using doctrine:migrations:migrate. If this doesn't work, modify the .env file so that you have a connection to your local database.
Then run a migration to retrieve the fakestoreapi data and persist it in the local database using the following command: php bin/console doctrine:fixtures:load

The application retrieves data from fakestoreapi and persists it in the local database, after which the data is retrieved and sent via symfony ux to vuejs (first load).
In the case of search, the data is retrieved in ASYNC.

After that, everything should work as expected :) 
