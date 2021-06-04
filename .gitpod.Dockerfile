FROM gitpod/workspace-mysql

USER gitpod

RUN sudo add-apt-repository ppa:ondrej/php && \
    sudo apt-get remove apache2 -y && \
    sudo apt-get update -y && \
    sudo apt-get install php8.0 -y
