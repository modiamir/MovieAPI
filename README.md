# Movie API
![PHPUnit](https://github.com/modiamir/MovieAPI/actions/workflows/phpunit.yml/badge.svg)
![PHPCS](https://github.com/modiamir/MovieAPI/actions/workflows/phpcs.yml/badge.svg)

This repository is my take-home project for interview process at ### company.

### !!! THIS README IS NOT COMPLETED.
### !!! IF YOU ARE GOING TO REVIEW THIS ASSIGNMENT PLEASE WAIT ONE MORE DAY, I WILL UPDATE THIS TOMORROW

## Requirements
Before setting up the project you need to make sure these tools are installed on your environment:
 - Docker
 - Docker Compose
 - Make

## Getting Started
To set up the project run below commands:
```shell
make setup
make migrate
```

## Running Tests
Run below command to run tests:
```shell
make test
```

## Architecture

### System level point of view
The application is an API with two set of users:
 - Anonymous users: can only register to the system and then log
 - Authenticated users: users after logging in can create movies and 
![](./docs/Context.png)
