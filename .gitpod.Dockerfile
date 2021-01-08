FROM gitpod/workspace-mysql

RUN sudo apt update \
    && sudo apt install redis-server -y \