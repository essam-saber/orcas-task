

### Installation

The application require php 7.4 or above.

Install the dependencies and devDependencies and start the server.

```sh
# pull project repository from github
$ https://github.com/essam-saber/orcas-task.git
# get inside the project path
$ cd orcas-task
# install project dependencies and the third party packages
$ composer install
# create database schema
$ php artisan migrate
# seed testing user in order to access the guarded endpoints 
$ php artisan db:seed
# run the application 
$ php artisan serve
```

### Login credentials

``` 
default email: test@test.com
default password: password
```

### Consume users endpoints
``` 
# In order to consume the users endpoint move to the root directory -
# execute the command below.
$ php artisan users:fetch
```

### Code implementation map
+ May you need to look at the ***FetchUsersCommand*** class in ***app/Console/Commands*** directory, which is invoking the service that is responsible for requesting the endpoints.
+ May you need to look at the ***UsersController*** class in ***app/Http/Controllers/Api/V1*** directoy, which is responsible for handling user search in addition to listing the all users (10) per request as mentioned in the task requirements.
+ May you need to look at the ***UserService*** class in ***app/Services*** directory, which is responsible for serving the operation that is related to the users.

>These are the main classes that you may need to look at directly. 