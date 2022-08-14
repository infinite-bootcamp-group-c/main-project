# Infinite Bootcamp Group C Main Project

## Setup

for running the project use the following command:

```
export UID=${UID}
export GID=${GID}
export USER_NAME=<your-git-user-name>
export EMAIL=<your-git-email>
```

## Running the project

* Builds the Docker images `make build`
* Start the docker hub in detached mode (no logs) `make up`
* Build and start the containers `make start`
* Stop the docker hub `make down`
* Show live logs `make logs`
* Connect to the PHP FPM container `make bash`

you can see all commands in the Makefile...