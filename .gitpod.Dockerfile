FROM gitpod/workspace-full

ENV COMPOSER_MEMORY_LIMIT -1

RUN sudo add-apt-repository ppa:ondrej/php

RUN sudo apt-get update &&  \
    sudo apt-get -y install \
        php-8.0 \
        php-8.0-cli \
        php-8.0-fpm \
        php-8.0-json \
        php-8.0-zip \
        php-8.0-gd \
        php-8.0-mbstring \
        php-8.0-curl \
        php-8.0-xml \
        php-8.0-redis \
        php-8.0-pear \
        php-8.0-bcmath \
        php-8.0-mbstring \

RUN sudo curl -s https://getcomposer.org/installer | php

RUN sudo mv composer.phar /usr/local/bin/composer
