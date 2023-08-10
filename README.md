# Pocket Pay

## Brief

A simple system that transfers funds between users, using a microservices strategy.

The structure utilizes Docker as a container engine and divides services using Docker Compose files.

To execute transactions, the system employs a simple queue to ensure that if any issues arise during execution, the job will not be lost.

## Software System diagram

<img src="doc/software-system.svg">

## Container diagram

<img src="doc/container.svg">

## Database diagram

<img src="doc/database.svg">
