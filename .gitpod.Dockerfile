FROM gitpod/workspace-mysql

USER gitpod

RUN sudo apt remove apache2 -y && \
    brew install php
