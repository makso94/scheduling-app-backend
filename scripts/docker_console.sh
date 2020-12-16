#!/bin/bash
# -----------------------------------------------------------------------------
# [Mario Maksimovic] Build/Run docker container for this project
# -----------------------------------------------------------------------------

SUBJECT=f478fbd8-4ca7-4e5f-bab4-4dc12d57d3a4

# --- Locks -------------------------------------------------------------------
LOCK_FILE=/tmp/$SUBJECT.lock
if [ -f "$LOCK_FILE" ]; then
    echo "$(basename $0)" " is already running"
    exit
fi

trap "rm -f $LOCK_FILE" EXIT
touch $LOCK_FILE

# scripts
IMIN="$(cd "$(dirname "$0")" && pwd)"

# --- Body --------------------------------------------------------------------
SRC="$(dirname "$IMIN")"

docker network create lara-network || echo 'Network "lara-network" already created!'

# Update the base image
docker pull php:latest

# Start redis container
docker run --name redis -p 6379:6379 --network=lara-network -d redis:alpine

Enable KEY events notifications
docker exec -it redis /bin/sh -c "redis-cli config set notify-keyspace-events KEA"

# Start mysql db container
mkdir -p mysql

docker run --name lara-mysql --network=lara-network \
    --user $(id -u $USER):$(id -g $GROUP) \
    -v $SRC/mysql:/var/lib/mysql \
    -v $SRC/etc/mysql:/etc/mysql/conf.d \
    -e MYSQL_DATABASE=laravel \
    -e MYSQL_USER=laravel \
    -e MYSQL_PASSWORD=laravel123 \
    -e MYSQL_ROOT_PASSWORD=laravel123 \
    -p 3307:3306 \
    -d mysql:5.7.32


# Build project image
docker build --force-rm -t lara-server \
    --build-arg user=$USER --build-arg uid=$(id -u $USER) \
    --build-arg gid=$(id -g $GROUP) \
    -f docker/Dockerfile .
docker rmi $(docker images -f "dangling=true" -q)

# Start project container
docker run --rm -it --name=lara-server \
    -v $(pwd):/project -v /tmp:/tmp \
    --hostname lara-server --network=lara-network --dns=8.8.4.4 -p 8000:8000 \
    -e USR=$(id -u $USER) -e GRP=$(id -g $GROUP) lara-server tmux -L lara-server

#docker rm -f redis
docker rm -f lara-mysql
# docker rm -f lara-nginx

DANGLING=$(docker images -f "dangling=true" -q)
if [ "x""$DANGLING" != "x" ]; then
    docker rmi $DANGLING
fi

echo "Successfuly destroyed all linked containers"

exit 0
