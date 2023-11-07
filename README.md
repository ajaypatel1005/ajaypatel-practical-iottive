steps

Install all the dependencies using composer
    composer install

Install all node module packages
npm install
npm run dev

Generate a new application key if required
    php artisan key:generate

Make sure you set the correct database connection information before running the migrations
    php artisan migrate
    php artisan serve

Run the database seeder and you're done
    php artisan db:seed