Nuno Costa Test
===============

Extra Setup
------

> 

* run `make migrate` to set up database.
* run `make dummy-data` to populate the database with data needed to test the systen.


Assumptions
-----------
The system was built to be as flexibe as possible, new Order types can be added by inserting rows in the database as well as the allowed stages per Order Type.

Actions to be done when an order changes it's status can be performed by writting event listeners for the event `order.state.change` due to lack of time none was implemented, but the 
event is dispatched.

The system was build as a rest API and allows the following 3 actions

* `GET /orders` to list all orders in the system
* `POST /orders` to create a new order
* `PATCH /order/:id` to update an existing order

Ideally a Flow system could be implemented to ensure an Order moves through it's states in the correct order

Due to trying to keep the test under 2.5 hours not all system is unit tested, the complexity of mocking components like doctrine is high but some example unit tests feature suck mocks are present

Example requests
----------------
### List Orders
`curl --location --request GET 'http://localhost:9090/orders'`

### Create new order
`curl --location --request POST 'http://localhost:9090/orders' --header 'Content-Type: application/json' --data-raw '{ "client_id": 1, "type": "trial" }' `

### Update an order
`curl --location --request PATCH 'http://localhost:9090/order/1' --header 'Content-Type: application/json' --data-raw '{ "stage": "expired" }' `


