# PHP dev task

Windsor Telecom wish to sell products to their customers. They will do this via an order system. There are two types of orders, free trial and contract. Each order will go
 through 4 core stages and there will be additional stages for each type.
- Created
- Approved
- Signed (contract only)
- Delivered
- Completed
- Expired (free trial only)

When a stage has been completed the following actions should happen:
- Created - email the customer with their requested order
- Approved - email the customer with a link to signing the contract (contract only)
- Signed - store the pdf on our server (this will be retrieve via an api call using the order ID)
- Delivered - email the sales team to follow up with the customer
- Completed - No action required
- Expired - email the customer to alert them the trial has expired, and to email the sales team to follow up with the customer (trial only)

You are not expected to code these actions, however you should showcase how these will be triggered with some placeholder code.

Using the Symfony project skeleton we have given, you are required to complete the following tasks:
- Create entities for your solution (feel free to add whatever fields you would like)
- Ability to transition between stages via API endpoint
- Showcase your code structure for how the actions will be triggered
- Any required database migrations
- Some data fixtures to help you while developing

Please feel free to add any packages to help you implement this project

## The minimum requirements for the application are:
- Write an implementation to handle the order stages in PHP7 and Symfony
- Explain your approach to solving the task
- Explain your assumptions and what other questions you would ask the user to ensure that you have all the information that you need to solve the task
- Include unit tests, with any placeholder documentation that someone might need to continue working on your solution

## Nice to see

Add something to the solution that you believe would enhance the system
 
We are not expecting a full solution and are just looking for an insight on how you might approach a specific task.

## Up and running with Docker

To get the project up and running for the first time run `make build`.
After this you can run `make up` to spin up the containers and `make bash` to run a bash command inside the `php-fpm` container.
If you would like to rebuild the project at anytime you can run `make build` again. 

Please note when setting up the project, if you encounter permission issues, ensure that your local user id and group id has been set correctly in `/docker/.env`
To find out your user and group id run `id` in you terminal for Mac and Linux. For Windsows run `id -u` for user id and `id -g` for group id  

You can also change the ports in the `docker/.env` file too. 
