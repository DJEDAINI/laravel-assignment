## Backend Assignment

## Task
You were given a sample [Laravel][laravel] project which implements sort of a personal wishlist
where user can add their wanted products with some basic information (price, link etc.) and
view the list.

#### Refactoring
The `ItemController` is messy. Please use your best judgement to improve the code. Your task
is to identify the imperfect areas and improve them whilst keeping the backwards compatibility.

#### New feature
Please modify the project to add statistics for the wishlist items. Statistics should include:

- total items count
- average price of an item
- the website with the highest total price of its items
- total price of items added this month

The statistics should be exposed using an API endpoint. **Moreover**, user should be able to
display the statistics using a CLI command.

Please also include a way for the command to display a single information from the statistics,
for example just the average price. You can add a command parameter/option to specify which
statistic should be displayed.

## Open questions
Please write your answers to following questions.

> **Please briefly explain your implementation of the new feature**  
>  
> _..._

> **For the refactoring, would you change something else if you had more time?**  
>  
> _..._

## Answers

> **Please briefly explain your implementation of the new feature**  
>  
> Answer: 

    the first thing i did was the code refactoring.

    these are the steps i have followed:
        1. Return a paginated list (10 items per page) of items either than the full list to avoid memory exception errors when the items list will be increased.
        2. Move requests validation process to a custom request classes that encapsulate their own validation and authorization logic.
        3. Create a standarized format of the APIs response and made available in all sub-controllers of ApiController.
        4. Make benefit of some of the built-in features in laravel [JsonResource, ResourceCollection] in order to specifiy the JSON format of the items.

    after that i have created new api endpoint `/items/statistics` to show some statistics of the items, these statistics are also provided in the console application using `php artisan items:statistics` command.

    these are the steps i have followed:
        1. Create new route with statistics controller method to return the required statistics.
        2. Add filter request paramter to show the statistics details based on it.
        3. Create new command using `php artisan make:command ItemsStatistics` to be used to display the statistics.
        4. Add an optional command option to filter the statistics details and show only single information, the filtering process with be done inside the controller method directly.
        5. Add some validation wihtin the command's handling logic.
        6. Show the result in table format.

> **For the refactoring, would you change something else if you had more time?**  
>  
> Answer: 

## Running the project
This project requires a database to run. For the server part, you can use `php artisan serve`
or whatever you're most comfortable with.

You can use the attached DB seeder to get data to work with.

#### Running tests
The attached test suite can be run using `php artisan test` command.

[laravel]: https://laravel.com/docs/8.x
