FROM gitpod/workspace-mysql

USER gitpod

RUN sudo apt remove php -y && \
    brew install php
