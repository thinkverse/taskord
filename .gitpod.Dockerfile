FROM gitpod/workspace-full

ENV COMPOSER_MEMORY_LIMIT -1

RUN sudo apt -y install software-properties-common

RUN sudo apt-get update \
 && sudo apt-get -y install mysql-server mysql-client graphviz \
 && sudo apt-get -y install php-fpm php-cli php-bz2 php-bcmath php-gmp php-imap \
 && sudo apt-get -y install php-redis

RUN sudo apt install -y php-dev libmcrypt-dev php-pear

RUN sudo add-apt-repository ppa:ondrej/php

RUN sudo apt-get update

RUN sudo apt-get install -y nodejs

RUN sudo apt-get update &&  \
    sudo apt-get -y install \
        php \
        php-cli \
        php-fpm \
        php-json \
        php-zip \
        php-gd \
        php-mbstring \
        php-curl \
        php-xml \
        php-pear \
        php-bcmath \
        php-mbstring \
        gcc \
        make \
        autoconf \
        libc-dev \
        pkg-config \
        php-mailparse && \
    sudo rm -rf /var/lib/apt/lists/*

RUN sudo apt-get update && \
    sudo apt-get install -y \
        ca-certificates \
        fonts-liberation \
        libappindicator3-1 \
        libasound2 \
        libatk-bridge2.0-0 \
        libatk1.0-0 \
        libc6 \
        libcairo2 \
        libcups2 \
        libdbus-1-3 \
        libexpat1 \
        libfontconfig1 \
        libgbm1 \
        libgcc1 \
        libglib2.0-0 \
        libgtk-3-0 \
        libnspr4 \
        libnss3 \
        libpango-1.0-0 \
        libpangocairo-1.0-0 \
        libstdc++6 \
        libx11-6 \
        libx11-xcb1 \
        libxcb1 \
        libxcomposite1 \
        libxcursor1 \
        libxdamage1 \
        libxext6 \
        libxfixes3 \
        libxi6 \
        libxrandr2 \
        libxrender1 \
        libxss1 \
        libxtst6 \
        lsb-release \
        wget \
        xdg-utils && \
    sudo rm -rf /var/lib/apt/lists/*

RUN sudo phpenmod mbstring

RUN sudo curl -s https://getcomposer.org/installer | php

RUN sudo mv composer.phar /usr/local/bin/composer
