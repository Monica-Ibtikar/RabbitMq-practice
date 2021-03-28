FROM php:7.4.0-fpm

RUN apt-get update && apt-get install -y \
        wget \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
#        libpng12-dev \
        libbz2-dev \
        libtidy-dev \
        libicu-dev \
        libmagickwand-dev --no-install-recommends \
        libmagickcore-dev \
        openssh-client \
        imagemagick \
        libpng-dev \
	libzip-dev \
        git \
        zip \
        libmcrypt-dev\
#    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install json \
    && docker-php-ext-install intl \
    && docker-php-ext-install bz2 \
    && docker-php-ext-install gettext \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install tidy \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pdo \
    && docker-php-ext-install exif \
    && docker-php-ext-install xmlrpc \
#    && docker-php-ext-install pcntl \
#    && Docker-php-ext-install shmop \
#    && docker-php-ext-install sysvmsg \
#    && docker-php-ext-install wddx \
#    && docker-php-ext-install sysvsem \
#    && docker-php-ext-install sysvshm \
#    && docker-php-ext-install xsl \
#    && docker-php-ext-install igbinary \
#    && docker-php-ext-install imap \
    && docker-php-ext-install soap \
    && docker-php-ext-install sockets \
#    && docker-php-ext-install mhash\
#    && docker-php-ext-install mcrypt \
#    && docker-php-ext-install mysql \
    && docker-php-ext-install zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN printf "\n" | pecl install -f mcrypt-1.0.1 && \
docker-php-ext-enable mcrypt

RUN printf "\n" | pecl install grpc && \
	docker-php-ext-enable grpc

RUN pecl install inotify \
    && docker-php-ext-enable inotify

RUN apt-get update && apt-get install -y libc-client-dev libkrb5-dev && rm -r /var/lib/apt/lists/*
#RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
 #   && docker-php-ext-install imap

RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache


RUN pecl install redis \
    && pecl install imagick \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable redis \
    && docker-php-ext-enable imagick \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

#RUN pecl install mcrypt && docker-php-ext-enable mcrypt

#RUN echo "deb http://ftp.uk.debian.org/debian jessie-backports main" >> /etc/apt/sources.list \
#    && apt-get update -yqq && apt-get install ffmpeg -yqq \
#    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
COPY ./composer.sh /tmp/
RUN sh /tmp/composer.sh

##########################
#add User

ARG user_name
ARG app_name
ARG user_id
ARG group_id

RUN useradd -m ${user_name} && \
    usermod -u $user_id $user_name && \
    groupmod -g $group_id $user_name && \
    chown -R ${user_id}:${group_id} /home/${user_name}/

#########################
WORKDIR /home/${user_name}/${app_name}/
USER ${user_name}


