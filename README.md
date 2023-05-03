# Online Printing with Gcash (E-wallet) Payment System

## Description

####  Online Printing System is an online queueing of printing shop which allow customers to upload their documents to be printed and it automatically calculates the amount to pay by the customer based on per document's page prices. Customer can make a payment online via G-cash (E-wallet), also system will notify customers if their documents are ready to pickup.

#### Business Owner (Admin) can manage their printing shops, queues and transactions. In order for business owner to start their shop operation, Super admin should approve their application. The project was built with Laravel (backend) and Vuejs (frontend) frameworks.

# Getting Started

## Installation

#### Clone the repository

```
git clone https://github.com/cur1ousFranz/laravue-printsystem.git
```
#### Navigate to Laravel main directory

```
cd laravue-printsystem
```
#### Install required dependencies

```
composer install
```

#### Copy the example env file and make the required configuration changes in the .env file

```
cp .env.example .env
```

#### Generate a new application key

```
php artisan key:generate
```

#### Run the database migrations (Set the database connection in .env before migrating)

```
php artisan migrate
```

#### Start laravel local development server.

```
php artisan serve
```

#### You may now access the Laravel server at http://127.0.0.1:8000


## Next is running the local development of Vuejs frontend.

#### *Open New Terminal:* Navigate to Vuejs directory inside the Laravel main directory

```
cd vue
```

#### Install required dependencies

```
npm install
```

### Start local development server.

```
npm run dev
```

#### You can now access the server at http://localhost:5173 that communicates in Laravel backend at server http://127.0.0.1:8000


## Features

* Customer Registration, Business Owner Registration (CRUD).
* SMS Verification (API).
* Display all shops available in customer (CRUD).
* Customer recieve notification when queue is complete, Business Owner can recieve notification once application is approved.
* Customer can submit a reviews to shop when the queue has been completed.
* Display all the customer's reviews to selected shops.
* Add, Edit Shop printing prices for different sizes of documents (CRUD).
* Online Payment with G-cash E-wallet (API).
* Read, Update Queues of customers (CRUD).
* Business Owner can read shop reports, Admin can read all shops reports (CRUD).
