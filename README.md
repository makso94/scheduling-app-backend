# laravel
Laravel project in docker


1. run docker_console.sh script from host
  example:
    ./scripts/docker_console.sh
    
2. from the runned container run docker_serve.sh script with laravel directory as argument $1
  example:
    ./scripts/docker_serve.sh laravel

#############################################################################################
You can create another laravel project with the following command

example:
    composer create-project --prefer-dist laravel/laravel some_project_name


Then you can serve this project with following command:
    ./scripts/docker_serve.sh some_project_name


You can monitor mysql general log with the following command

tail -f mysql/general_log.log

