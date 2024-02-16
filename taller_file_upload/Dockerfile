FROM ubuntu:latest

LABEL maintainer="Club_ciberseguridad_FIUM"

ENV DEBIAN_FRONTEND noninteractive

RUN apt update && apt install -y net-tools \
        iputils-ping \
        curl \
        git \
        nano \
        apache2 \
        php \
        netcat \
        ncat 

ENTRYPOINT      chmod +x /tmp/script.sh && \
                ./tmp/script.sh && \
                apache2ctl -D FOREGROUND && \
                tail -f /dev/null
