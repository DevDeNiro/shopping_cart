php bin/console doctrine:database:create

php bin/console make:migration  

php bin/console doctrine:fixtures:load   

php bin/console doctrine:migrations:diff 

php bin/console doctrine:migrations:migrate

Symfony server:start / php -S localhost:8000 -t public

GET /api/products: Get all products list

GET /api/products/{id} Get product details for specific id

POST /api/cart: Create a new cart and associate it with a session ID.

GET /api/cart: Get the current state of the cart for the current session.

POST /api/cart/items: Add a product to the cart or increment the quantity of the product if it's already in the cart.

DELETE /api/cart/items/{id}: Remove a product from the cart.

PUT /api/cart/items/{id}: Increase or decrease the quantity of a product in the cart.

POST /api/cart/checkout: Checkout/save the cart.