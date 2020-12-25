## User Microservice

This repository contains all the code related to the **User Microservice.** Feel free to use our tags to move to specific 
points while you are reading the **PHP Microservices** book.

### List of available tags

* Lumen Installation: lumen-installation

### List of available API endpoints

* GET /api/v1/user -> UserController@index : Gets all users and supports filtering
* GET /api/v1/user/{userId} -> UserController@get : Gets a user by ID
* POST /api/v1/user -> UserController@create : Creates a new user record
* PUT /api/v1/user/{userId} -> UserController@update : Updates a user record by ID
* DELETE /api/v1/user/{userId} -> UserController@delete : Deletes a user record by ID

### License

This example is open-sourced software licensed under the [BSD 3-Clause License](https://opensource.org/licenses/BSD-3-Clause)
