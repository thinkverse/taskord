FROM gitpod/workspace-mysql

# Instal Requirements
RUN sudo add-apt-repository ppa:ondrej/php -y \
    && sudo apt update -y \
    && sudo apt install -y \
    && sudo apt-get purge apache2* -y \
    redis-server \
    php-8.0 \
    php-8.0-curl \
    php-8.0-common \
    php-8.0-cli \
    php-8.0-mysql \
    php-8.0-mbstring \
    php-8.0-xml \
    php-8.0-zip \
    php-8.0-redis \
    php-8.0-gd \
    php-8.0-bcmath \
    && sudo rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && HASH=`curl -sS https://composer.github.io/installer.sig` \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
