## Battle Microservice

This repository contains all the code related to the **Battle Microservice.** Feel free to use our tags to move to specific 
points while you are reading the **PHP Microservices** book.

### List of available tags

* Lumen Installation: lumen-installation

### List of available API endpoints

* GET /api/v1/battle -> BattleController@index : Gets all battles and supports filtering
* GET /api/v1/battle/{battleId} -> BattleController@get : Gets a battle by ID
* POST /api/v1/battle -> BattleController@create : Creates a new battle record
* PUT /api/v1/battle/{battleId} -> BattleController@update : Updates a battle record by ID
* DELETE /api/v1/battle/{battleId} -> BattleController@delete : Deletes a battle record by ID

### License

This example is open-sourced software licensed under the [BSD 3-Clause License](https://opensource.org/licenses/BSD-3-Clause)
