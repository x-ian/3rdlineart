# 3rdlineart

Sources for web application "3rd Line ART Expert Committee Malawi" to manage potential switching of patient from 2nd line to 3rd line Regimen.

## System environment

* Ubuntu 16.04.1 LTS
* Apache 2.4.18 with libapache2-mod-php7.0
* PHP 7.0.30 (7.2 not supported out of the box due to php7.0-mcrypt)
* MySQL 5.7.22

## Install

1 Copy/Extract/checkout the source code to /var/www/html/3rdlineart
1 Copy and adjust file includes/config.php.sample to includes/config.php
1 Create empty 3rdlineart MySQL database instance or restore from backup (use credentials from includes/config.php)
1 Add index.php to /var/www/html with <?php header('Location: https://www.3rdlineartmw.org/3rdlineart'); exit; ?>
1 Ensure that email account as configured in includes/config.php is functional
1 Create cronjob for automated, async email processing, e.g. with */10 * * * * cd /var/www/html/3rdlineart && /usr/bin/php send_emails.php > /dev/null
1 Create cronjob or manually invoke backup scripts, e.g. with 55 23 * * Sun cd /var/www/html/3rdlineart/scripts && ./backup.sh

## Development stuff

See picture / documents in folder documents/development
