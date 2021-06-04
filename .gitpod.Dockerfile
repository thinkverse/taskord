FROM gitpod/workspace-mysql

USER gitpod

RUN sudo add-apt-repository ppa:ondrej/php && \
    sudo apt-get update && \
    sudo apt-get install -y php php-tidy php-bcmath php-curl php-xml php-mbstring php-intl php-redis php-mysql && \
    sudo apt-get clean && \
    sudo rm -rf /var/lib/apt/lists/*
