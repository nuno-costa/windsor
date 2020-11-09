Nuno Costa Test
===============

TL; DR
------

> configure `MAILER_DSN` and `EMAIL_FROM` in `docker-compose.yml` or you wont be able to send emails _(run `make restart` after changing if your containers are running)_

* run `make` for a list of available targets.
* run `make setup` to build docker containers, install dependencies, compile sass and start the containers.
* run `make tests` to run phpstan and unit tests.
* run `make stop` or `make start` to stop/start the server (http://localhost:8089/).
* http://localhost:8089/page.html for Web Page Layout test and http://localhost:8089/form.php for the php test


Assumptions
-----------
This test can be executed on any system that supports any recent version of `docker` and `docker-compose`.

I'm assuming this test will be viewed on a Unix type of system, like `Linux` or `OSX` as such all the utilitarian scripts are based on that assumption but the
tests and application can be executed on any environment that supports php 7.3+

As a rule I try to make live easier for everyone so I've bundled a few `make targets` to make it easier for everyone as most tasks are automated and anyone can "hit the ground running" quickly.


Folder Structure
----------------
Below you will find a list of the most important directories:

| Folder            | Description                                                                                                                  |
|-------------------|------------------------------------------------------------------------------------------------------------------------------|
|`/`                | contains docker and make files                                                                                               |
|`/src`             | base folder, this folder is mounted into docker                                                                              |
|`/data`            | initial sql script to create db schema  _Note: there is no persistency, db will be reset everytime the container is started_ |
|`/src/assets/sass` | sass source files                                                                                                            |
|`/src/public`      | doc root                                                                                                                     |
|`/src/tests`       | tests Folder                                                                                                                 |


Exercise 1 - Web Page Layout
============================

How to run it
-------------
1. Run `make setup` _(if not already)_
2. Point your browser to http://localhost:8089/page.html

Considerations
--------------
The image layout reference provided is too small, that makes it very hard to properly set spacings and font sizes.

It was only after zooming the image that I understood that the background was not a solid color

The color scheme was loosly based on Kamma website, as such the Logo, fav icon and font used are the same as on the website



Exercise 2 - Referal Form
=========================

How to run it
-------------
1. Configure `MAILER_DSN` and `EMAIL_FROM` in `docker-compose.yml` or you wont be able to send emails _(run `make restart` after changing if your containers are running)_
2. Run `make setup` _(if not already)_
3. Point your browser to http://localhost:8089/form.php

Design decisions
----------------
No information was given regarding the use of frameworks, so I opted for not using any framework.

For the backend no framework was used apart from a few components to ease out with PSR-7 and emitting responses

Composer is used to provide autoloading and to install dependencies.

I've tried to keep this exercise as simple as possible while maintaining a viable and extensible object oriented architecture.

This test sports a simple MVC framework, implementing requests, routing, controllers and Dependency Injection.

PHP is at its core a templating language, so it's used to render template files into html _(for emails and views)_

Validation is done using HTML5 attributes and, of course, as well in the backend

__To prevent spam only allow 1 email to be sent__ when trying to send an email to a previously registered recipient the system will tell you
that the recipeint was emailed already


Tests
-----
For convenience Unit Tests can be executed by running `make tests` from the command line.

If not making use of make targets, then running `docker-compose run --rm php vendor/bin/phpunit tests/unit/` from the project root should do the trick.

Due to the lack of time not all classes are tested, I had to choose and tested only the ones that are not easy to assert via exploratory testing.