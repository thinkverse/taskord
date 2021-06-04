FROM gitpod/workspace-mysql

USER gitpod

RUN sudo add-apt-repository ppa:ondrej/php && \
    sudo apt-get remove php -y && \
    sudo apt-get update -y && \
    sudo apt-get install php8.0 -y  && \
    sudo rm -rf /var/lib/apt/lists/*
