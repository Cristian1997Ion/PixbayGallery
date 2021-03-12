# PixbayTestApp

###################################################

PHP 7.3.27 |
NPM 6.14.11 |
Laravel Framework 8.31.0 |
VUE 2.6.12

###################################################

Steps:
- run: composer install
- run: npm install
- copy .env-example to .env and edit
- run: php artisan migrate
- run: php artisan storage:link
- run: php artisan serve
- run: npm run watch

#################################################
- Cache / Queue was tested via Redis Driver 
- Don't forget to run: php artisan queue:work redis

# How it works?

#################################################
- Home page loads firsts 21 photos from Pixbay with 'infinite scroll' (24h cached via searchTerm & page);
- Favourites page loads first 21 photos from DB with 'infinite scroll';
- Unregistered users can only view the homepage;
- Registered users can store photos, view them in Favourites page & delete them if needed;
- When an user stores a (favourite) photo, 2 copies (thumb/hd) are stored on the server + one row (containing paths to local copies and pixbay->photoId) gets inserted in db;
- If another users wants to store the same photo, only one row gets inserted in Photoables table (don't waste memory);
- The local copies are deleted when there's no user that uses them anymore;
