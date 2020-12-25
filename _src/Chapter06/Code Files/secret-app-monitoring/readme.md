## Secret Microservice

This repository contains all the code related to the **Secret Microservice.** Feel free to use our tags to move to specific 
points while you are reading the **PHP Microservices** book.

### List of available tags

* Lumen Installation: lumen-installation

### List of available API endpoints

* GET /api/v1/secret -> SecretController@index : Gets all secrets and supports filtering
* GET /api/v1/secret/{secretId} -> SecretController@get : Gets a secret by ID
* POST /api/v1/secret -> SecretController@create : Creates a new secret record
* PUT /api/v1/secret/{secretId} -> SecretController@update : Updates a secret record by ID
* DELETE /api/v1/secret/{secretId} -> SecretController@delete : Deletes a secret record by ID

### License

This example is open-sourced software licensed under the [BSD 3-Clause License](https://opensource.org/licenses/BSD-3-Clause)
