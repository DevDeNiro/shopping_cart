
/**
 * This code block contains commands for managing the database and running the Symfony server.
 * 
 * - `php bin/console doctrine:database:create`: Creates the database.
 * - `php bin/console make:migration`: Generates a new migration based on the changes in the entities.
 * - `php bin/console doctrine:migrations:diff`: Generates a new migration if there are any changes in the entities.(optional)
 * - `php bin/console doctrine:migrations:migrate`: Executes any pending migrations to update the database schema.
 * - `php bin/console doctrine:fixtures:load`: Loads some products (dummy data) into the database.
 * - `Symfony server:start / php -S localhost:8000 -t public`: Starts the Symfony server on localhost:8000, serving the public directory.
 */


# API Endpoints

## Products

### GET /api/products
Get all products list.

**Parameters**: None

**Response**: An array of products.

---

### GET /api/products/{id}
Get product details for a specific id.

**Parameters**:
- `id` (path): The ID of the product.

**Response**: The details of the product.

---

## Cart

### POST /api/cart
Create a new cart and associate it with a session ID.

**Parameters**: None

**Response**: The ID of the created cart.

---

### GET /api/cart
Get the current state of the cart for the current session.

**Parameters**: None

**Response**: The current state of the cart.

---

### POST /api/cart/items
Add a product to the cart or increment the quantity of the product if it's already in the cart.

**Parameters**:
- `productId` (body): The ID of the product.
- `quantity` (body): The quantity of the product to add.

**Response**: The updated state of the cart.

---

### DELETE /api/cart/items/{id}
Remove a product from the cart.

**Parameters**:
- `id` (path): The ID of the cart item.

**Response**: The updated state of the cart.

---

### PUT /api/cart/items/{id}
Increase or decrease the quantity of a product in the cart.

**Parameters**:
- `id` (path): The ID of the cart item.
- `quantity` (body): The quantity to increase or decrease (use `+1` to increase and `-1` to decrease).

**Response**: The updated state of the cart.

---

### POST /api/cart/checkout
Checkout/save the cart.

**Parameters**:
- `cartId` (body): The ID of the cart.

**Response**: A message indicating that the cart has been checked out.