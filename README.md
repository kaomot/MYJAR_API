Readme
=====================

## Requirements
* PHP and Mysql

Setup
===================
* php composer.phar install

Database Migration
===================
* 

Run the API App
====================
* To run the API, use PHP in-built server `php -S localhost:8080 -t /path/to/project/folder`


* Make a POST request to the endpoint `http://localhost:8080` with payload
```$json
{
    "name" : "Kayodee",
    "lastname": "Omotoyee",
    "email" : "abcd@xyz.com",
    "phone" : "7448470319"
}
```

* To retrieve make GET request to the endpoint `http://localhost:8080`

* To search make GET request like this `http://localhost:8080?q=search_keyword`