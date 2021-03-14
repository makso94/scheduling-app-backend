# Appointment Scheduling, Server App (Backend)
This project is writen in Laravel 8.12

In order to run this project, follow the following steps:

0. To run this project you need to have installed [Docker engine](https://www.docker.com/) on your local machine.

    Docker installation tutorial for Ubuntu distros
    * https://docs.docker.com/engine/install/ubuntu/
    * https://docs.docker.com/engine/install/linux-postinstall/

1. Clone github project

2. From your local machine run docker_console.sh script
  
      **The script MUST be runned from project root directory**

    ```
      ./scripts/docker_console.sh
    ```
3. In the running container run docker_serve.sh script in order to serve the project
      
      **The script MUST be runned from project root directory**
    ```
      ./scripts/docker_serve.sh
    ```

----------

## MySQL General LOG
You can monitor MySQL general log with the following command
```
  tail -f mysql/general_log.log
```

> Note: This project is made for the purpose of graduate thesis.
