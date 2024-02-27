# livatek-task
Technical task for interview in Livatek.

## Test application
1. Install dependencies - `php composer.phar install`
2. Run server - `php composer.phar run-server`

In the [api_request](api_requests) folder you can find some HTTP request to test API

## Original task
Your task is to create a simple API in PHP which can (A) create Tasks, (B) display them and (C) delete them.

The field “deadline” should be null, if the “has_deadline” is false. Otherwise, it should be a date in whatever
format you decide. All other fields are required and must be non-empty when creating a new task using the
API. You are free to add further optional fields if you like.

Your API should be able to store and later display and delete these tasks. Data should be stored in a simple
file, so you do not need to spend time on setting up a database or similar. There will be no need for sorting
or other aggregating operations on the data.

You should spend no more than 2 hours on this task
