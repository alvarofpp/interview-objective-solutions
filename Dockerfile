# Define the base image on which your image is
FROM php:7.4-cli-alpine

# Include and commit your project files
ADD ./ /zero

# Define the full path of the base command that will be executed
ENTRYPOINT ["/zero/gourmet-game"]
