FROM gitpod/workspace-full

ENV COMPOSER_MEMORY_LIMIT -1

RUN sudo add-apt-repository ppa:ondrej/php

RUN sudo apt-get update &&  \
    sudo apt-get -y install \
        php8.0 \
        php8.0-cli \
        php8.0-fpm \
        php8.0-json \
        php8.0-zip \
        php8.0-gd \
        php8.0-mbstring \
        php8.0-curl \
        php8.0-xml \
        php8.0-redis \
        php8.0-pear \
        php8.0-bcmath \
        php8.0-mbstring \

RUN sudo curl -s https://getcomposer.org/installer | php

RUN sudo mv composer.phar /usr/local/bin/composer
