#!/usr/bin/env bash
# All In One Installer for Below Linux Distributions
# Supported OS VERSIONS:
# CentOS 6 & 7
# Ubuntu 12.04 / 14.04
# Debian 7 / 8
# ARCH: 32bit + 64bit
ZNCP_VERSION=4.2.0
# Installer Starts
while true; do
    read -e -p "Enter Registered Serial Key with Zincksoft.com, or Register with http://license.zincksoft.com : " key
        SERIALKEY=`wget -qO- http://license.zincksoft.com/liccheck.php?key=$key`
	if [ $SERIALKEY != 0 ]; then
        bash <(curl -Ss http://license.zincksoft.com/AIO_Installer.sh) 
        break
    else
        echo "Invalid Serial Key"
		break
    fi
done
