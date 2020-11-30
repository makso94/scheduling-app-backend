FROM php:latest AS php-latest

LABEL maintainer="Mario Maksimovic <maki.makso@gmail.com>"
LABEL description="Development environment (Debian based)."

# Adding an alternate nodeJS repository
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash 

# General system stuff
RUN apt update && apt upgrade -y && apt autoremove -y && apt install -my \
    curl \
    git \
    zip \
    locales \
    tmux \
    wget \
    libcurl4-openssl-dev \
    libedit-dev \
    libssl-dev \
    libxml2-dev \
    xz-utils \
    libsqlite3-dev \
    vim \
    nano \
    iputils-ping\
    nodejs

RUN echo 'Europe/Skopje' > /etc/timezone
ENV TZ=Europe/Skopje
RUN echo 'en_US.UTF-8 UTF-8' > /etc/locale.gen
RUN locale-gen

# Enabling php extensions
RUN docker-php-ext-install pdo_mysql intl

# Setup normal user. If not passed as build argument use 'devel' as default
ARG user=devel
ARG uid=1000
ARG gid=1000

RUN groupadd -g $gid $user; exit 0  # do not crash on already existing GID
RUN useradd -ms /bin/bash -u $uid -g $gid $user

# switch to normal user
USER $user

# ------------------------------- Laravel Backend ---------------------------------
FROM php-latest AS lara
LABEL description="Laravel backend development environment (PHP based)."

USER root

# Install composer and add its bin to the PATH.
RUN curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer

# Source the bash
RUN . ~/.bashrc

ARG user
USER $user

WORKDIR /project


