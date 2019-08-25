# CV - Georgi Sabev

Online portfolio

## Built With

* [Symfony](https://symfony.com/) - Used for back-end
* [Vue.js](https://vuejs.org/) - Used for creating the Single Page Application


### Installing

You need NPM installed 
```
cd vue
npm install
npm run serve
```

You need PHP and Composer installed

```
cd vue-server
composer install
```

Composer should navigate you through the process of connecting to your database, otherwise
the configurations are in ./vue-server/app/config/parameters.yml

After connecting to and starting your MySQL Server execute this code in ./vue-server/
```
php bin/console doctrine:schema:update --force
```
After this you should be good to go!
```
php bin/console server:run
```
Now navigate to
```
localhost:8080
```
And you should see the home page!


### Navigating through the website

There is Home Page, Blog section with listed all the Articles, Login and Register screen.
From Blog section you can choose an Article to read. Below every Article there is Comments section where every registered user can comment.
Only the Administrator of the website can add, edit and remove Articles and delete Comments.
