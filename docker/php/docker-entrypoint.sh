#!/bin/bash

if [[ "php-fpm" == ${1} ]] ; then
    DIRECTORIES=(var/cache var/log)

    # name of web user
    USER="www-data"

    # get owner of first directory
    OWNER=$(stat -c "%u" ${DIRECTORIES[0]})

    # fix rights on directories
    sudo setfacl -R  -m u:${USER}:rwX -m u:${OWNER}:rwX ${DIRECTORIES[@]}
    sudo setfacl -dR -m u:${USER}:rwX -m u:${OWNER}:rwX ${DIRECTORIES[@]}
elif [[ ! -z ${TARGET_UID} ]] ; then
    TARGET_USER=$(getent passwd "${TARGET_UID}" | cut -d: -f1)
    if [[ -z ${TARGET_USER} ]] ; then
        sudo useradd --uid "${TARGET_UID}" --shell /bin/bash target-user
        TARGET_USER=target-user
    fi

    HOME_DIR=$(getent passwd "${TARGET_UID}" | cut -d: -f6)
fi

# run input command
sudo HOME="${HOME_DIR:-/root}" --user="${TARGET_USER:-root}" -- $@
