#!/bin/bash
# -----------------------------------------------------------------------------
# [Mario Maksimovic] Start Laravel application with php artisan serve in development mode
# -----------------------------------------------------------------------------

SUBJECT=4bcc6990-467d-4fe8-8b88-82d8eba62953

# --- Locks -------------------------------------------------------------------
LOCK_FILE=/tmp/$SUBJECT.lock
if [ -f "$LOCK_FILE" ]; then
    echo "$(basename $0)" " is already running"
    exit
fi

# if [ $1'x' == 'x' ]; then
#     echo "Please provide one argument -> the directory of the application you want to serve"
#     exit 1
# fi

trap "rm -f $LOCK_FILE" EXIT
touch $LOCK_FILE

# scripts
IMIN="$(cd "$(dirname "$0")" && pwd)"

# --- Body --------------------------------------------------------------------

# cd $1
cd laravel/

# Installing npm dependencies from lock file
npm install

# Installing dependencies from lock file (including require-dev)
composer install

# Running migrations
php artisan migrate

# Serving laravel app
php artisan serve --host 0.0.0.0

exit 0
