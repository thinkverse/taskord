FROM gitpod/workspace-mysql

USER gitpod

RUN brew install php && \
    brew install composer && \
    brew install redis
