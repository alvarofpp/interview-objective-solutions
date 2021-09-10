# Define the base image on which your image is
FROM php:7.4-cli-alpine

# Install composer
RUN echo "---> Installing Composer" && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    echo "---> Cleaning up" && \
    rm -rf /tmp/*

# Include and commit your project files
ADD ./ /zero

# Application directory
WORKDIR "/zero"

# Install dependencies
RUN composer install

# Define the full path of the base command that will be executed
ENTRYPOINT ["/zero/gourmet-game"]
