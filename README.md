## About

This is a P.O.C. (proof of concept) of how to a do a basic Restful API with Laravel and respecting
as much as possible good practices and good use of design patterns.

## Architecture

The repository pattern is implemented so we can differenciate the Laravel Model - used 
to describe an entity - and the Repository - used to contains all the requests to get data 
(based on eloquent for the moment).

Laravel [Form Request](https://laravel.com/docs/9.x/validation#form-request-validation) 
and [Resources](https://laravel.com/docs/9.x/eloquent-resources#main-content) are used

For the security, [Laravel Sanctum](https://laravel.com/docs/9.x/sanctum)

[Spatie Query builder](https://github.com/spatie/laravel-query-builder) is installed so it can 
handle filters, sort, includes from an http request.

## Enhancement

QueryBuilder class to reduce the complexity of the queries and more easy to use.

Repository Interfaces to be agnostic on the way to get data (mysql, mongodb, elasticsearch, ...)

Managers if the Controllers get too fat and need more clarity.
