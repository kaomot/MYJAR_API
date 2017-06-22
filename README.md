Readme
=====================

## Requirements
* PHP and Mysql

Setup
===================
Composer is needed to make use of the external library to validate the "phone"
* run php composer.phar install

Database Migration
===================
* run the sql command attached to create database

Run the API
====================
* To run the API, use PHP in-built server `php -S localhost:8080 -t /path/to/project/folder`


* Make a POST request to the endpoint `http://localhost:8080` with payload (postman is recommended)
```$json
{
        "firstname" : "Kayode",
    	"lastname": "Omotoye",
    	"email" : "kayodeoomotoye@gmail.com",
    	"phone" : "7448470319",
    	"address" : "Akadeemia Tee 7/2",
    	"Country" : "England",
    	"City" : "Manchester",
    	"gender": "M",
    	"DOB" : "3rd March",
    	"LoanType" : "LongTerm"
}
```

* To retrieve make GET request to the endpoint `http://localhost:8080`

* To search make GET request like this `http://localhost:8080?q=search_keyword`
