FROM gitpod/workspace-mysql

USER gitpod

RUN sudo add-apt-repository ppa:ondrej/php && \
    sudo apt-get update && \
    sudo apt-get install -y php8.0  && \
    sudo rm -rf /var/lib/apt/lists/*
