FROM gitpod/workspace-mysql

USER gitpod

RUN sudo add-apt-repository ppa:ondrej/php && \
    sudo apt-get update -y && \
    sudo apt-get install php8.0 libapache2-mod-php8.0 -y
