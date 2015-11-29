#!/bin/bash
set -e

SPECKPHP_IMAGE="speckcommerce/php:7.0"

if [ "$USER" != "vagrant" ] || [ ! -d "/vagrant" ]; then
    echo "Restricted to vagrant to avoid accidental damage to local environment"
    exit 1
fi

# docker 1.9 is not in main repo yet
sudo dnf install -y docker --enablerepo=updates-testing
sudo systemctl enable docker.service
sudo systemctl start docker.service

sudo dnf install -y git

# composer image is built locally to ensure it uses correct php image
sudo docker build -t speckcommerce/composer - << DOCKERFILE
FROM ${SPECKPHP_IMAGE}
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

WORKDIR /app
CMD ["-"]
ENTRYPOINT ["composer", "--ansi"]
DOCKERFILE
# does not work as expected as of now, @see https://github.com/docker/docker/issues/17907
# volume is deleted on docker run --rm atm
sudo docker volume create --name=composer-cache

sudo bash -c "cat > /usr/local/bin/d-composer" << EOL
#!/bin/bash
sudo docker run --rm -v composer-cache:/root/.composer/cache -v "\$(pwd)":/app \
    speckcommerce/composer "\$@"
EOL
sudo chmod +x /usr/local/bin/d-composer

sudo bash -c "cat > /usr/local/bin/d-php" << EOL
#!/bin/bash
sudo docker run --rm -v "\$(pwd)":/app -t\$([ -t 0 ] && echo i) -w=/app ${SPECKPHP_IMAGE} "\$@"
EOL
sudo chmod +x /usr/local/bin/d-php

echo 'd-composer update' > ~/.bash_history
echo 'd-php vendor/bin/phpcbf' >> ~/.bash_history
echo 'd-php vendor/bin/phpcs' >> ~/.bash_history
echo 'd-php vendor/bin/phpunit' >> ~/.bash_history

