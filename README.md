# Pocket Pay

## Brief

A simple system that transfers funds between users, using a microservices strategy.

The structure utilizes Docker as a container engine and divides services using Docker Compose files.

To execute transactions, the system employs a simple queue to ensure that if any issues arise during execution, the job will not be lost.

## Installation steps

```bash
## SSL Configuration
1º Go to folder /docker/pocket-pay/nginx/ssl/

2º Copy rootCA.pem to your desktop

3º Open you browser, and find certificate manager

4º Import the .pem file in trusted root certificate authority

5º Accept and done
```

## Configure required hosts
```bash
#######################################
# Windows example

## Edit hosts file
C:\Windows\System32\drivers\etc\hosts

## include registers bellow
127.0.0.1 pocketpay.com.br
127.0.0.1 pocketpay.localhost
127.0.0.1 pocketpay.manager.localhost
127.0.0.1 pocketpay.notifyer.localhost

#######################################
# Linux example

## Edit resolv.conf file
vim /etc/resolv.conf

## include registers bellow
127.0.0.1   pocketpay.com.br
127.0.0.1   pocketpay.localhost
127.0.0.1   pocketpay.manager.localhost
127.0.0.1   pocketpay.notifyer.localhost
```

```bash
## Up project
cd bin
./pocket-start.sh
```

## URL

```bash
https://pocketpay.com.br
```

## Software System diagram

<img src="doc/software-system.svg">

## Container diagram

<img src="doc/container.svg">

## Database diagram

<img src="doc/database.svg">


## Sequence Diagrams

### Transaction sequence

<img src="doc/pocket-manager-transaction-sequence.svg">

### Notification Sequence

<img src="doc/pocket-notifyer-sequence-diagram.svg">

