PizzaAPI
=======================

## Setup
- Clone source code
- Install packages : `composer install` (Required to install `composer` as global)
- Prepare config files: `composer run-script prepare-project`
- Update `/.env` with server environment configurations like database connection, App URL, Timezone...
- Init project: `composer run-script init-project`
    - this will run database migration (Required DB config in `/.env`)
    - and run the seeder for dummy data
        - default admin is `admin@example.com` with password `123456` (same password with other admins)
        - default user is `user@example.com` with password `123456`(same password with other users)
    - and run packages setup for OAuth server
- Setup write permission on :
    - storage/*
    - bootstrap/cache/
- Done.

## PizzaAPI - Document

Example: http://pizza.dev/doc.html

## Manager Pizzas and Pizza Options
- Login to admin panel and create some pizzas

## Manager Orders
- Login to admin panel to view orders and update status(Place Order, Pay Success, Shipment, Order Complete)

## Road map
- Payment API
- Update quantity

## Demo
![alt text](https://i.gyazo.com/7caa6e8b06ff7793b3b8267e74ead33e.png)
![alt text](https://i.gyazo.com/65ed5beb2b227e44c21ac80cecb63b13.png)
![alt text](https://i.gyazo.com/1e2e0c40d88c61e9dc72da539ecc822c.png)

