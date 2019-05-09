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
1 Create cronjob or manually invoke backup scripts, e.g. with 0 13 * * Sun cd /var/www/html/3rdlineart/scripts && ./backup.sh

## Backup

Via cronjob a backup to the local hard disk is done every day (currently folder /home/thirdline/3rdlineart-backup). This backup includes these archives:
* A MySQL dump of the database
* The folder with all uploaded lab results documents
* All currently uses PHP sources (should be the same as from github)

Additionally if an external hard drive is connected (currently configured is the external disk BENJA-WINDOWS with the filesystem NTFS in the /etc/fstab file), the GPG encrypted files are copied to that hard drive into the folder 3rdline-backup. The password for the encryption is the same as the MySQL password.

Once the backup is done, a mail is sent out.

## Dell PowerEdge server hardware

Currently the BIOS firmware version of the server seems to prevent a warm/soft reboot. During next bootup a memory initialization error blocks the startup. Maybe a firmware upgrade can prevent that as described here: https://www.dell.com/support/article/de/de/dedhs1/sln303868/system-hangs-during-warm-reboot-at-critical-memory-initialization-error-for-poweredge-t130-r230-r330-and-t330-servers?lang=en

## Development stuff

See picture / documents in folder documents/development
