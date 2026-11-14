# Crafty Charms – Online Shop

A Laravel e-commerce website for my small business, selling **imported items** and **handmade crafts** (resin art, pipe cleaner bouquets and more). Customers can browse, order, track their orders and review items. The admin manages products, orders and sales from a private dashboard.

## Features

### For visitors and customers
- Two shop sections: **Imported Items** and **Handcrafts**
- A dedicated page for every item with its description, price and photo
- **Top-selling items** shown on the home page
- **Customization button** that opens a Facebook message, so customers can request custom work
- Star rating and comment section on every item
- Order items directly from the website
- Register and log in as a normal user
- Personal **dashboard** showing your orders and your reviews
- Email notifications about your orders
- Cancel an order yourself, until it moves to the "Making" stage

### Order tracking
Orders move through four stages, updated by the admin:
1. Received and Confirmed
2. Making
3. Ready
4. Dispatched

### For the admin
- Separate admin login
- Dynamic product upload (name, category, description, price, cost, photo, units sold so far)
- The "units sold so far" figure is for the admin only and is never shown to visitors
- Order management and status updates
- Notifications for new orders, on the admin page and by email
- **Sales and profit page** for tracking revenue, cost and profit

## Tech stack
Laravel, PHP, MySQL, Blade, Tailwind CSS, JavaScript

## Getting started
1. Clone the repository
   `git clone https://github.com/AnikaRashid12/craftycharms.git`
2. Install dependencies
   `composer install` and `npm install`
3. Copy the environment file and generate a key
   `cp .env.example .env` then `php artisan key:generate`
4. Create a MySQL database and set the `DB_*` values in `.env`
5. Run migrations: `php artisan migrate`
6. Start the app: `php artisan serve` and `npm run dev`

## Status
In active development.

## Author
Anika Rashid – [github.com/AnikaRashid12](https://github.com/AnikaRashid12)