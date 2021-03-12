# PixbayTestApp

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
