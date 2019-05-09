#!/bin/bash

SOURCE_DIR=/var/www/html/3rdlineart
TMP_DIR=/tmp/3rdlineart-backup
FILE_POSTFIX=`date +%Y%m%d`
BACKUP_DIR=~/3rdlineart-backup

MYSQL_USER=$(grep -oP "\\\$mysql_user.+?\"\K[^\"]+" $SOURCE_DIR/includes/config.php)
MYSQL_PASSWD=$(grep -oP "\\\$mysql_password.+?\"\K[^\"]+" $SOURCE_DIR/includes/config.php)
MYSQL_DATABASE=$(grep -oP "\\\$mysql_database.+?\"\K[^\"]+" $SOURCE_DIR/includes/config.php)

rm -rf $TMP_DIR
mkdir $TMP_DIR

# backup database
mysqldump -u $MYSQL_USER -p$MYSQL_PASSWD $MYSQL_DATABASE | gzip > $TMP_DIR/3rdlineart-`echo $FILE_POSTFIX`-db.sql.gz
gpg --passphrase $MYSQL_PASSWD -c --no-use-agent $TMP_DIR/3rdlineart-`echo $FILE_POSTFIX`-db.sql.gz

# backup current source code (despite it coming from github) 
cd $SOURCE_DIR
tar -czf $TMP_DIR/3rdlineart-`echo $FILE_POSTFIX`-source.tgz .
gpg --passphrase $MYSQL_PASSWD -c --no-use-agent $TMP_DIR/3rdlineart-`echo $FILE_POSTFIX`-source.tgz

# lab result attachments
cd $SOURCE_DIR/documents/results
tar czf $TMP_DIR/3rdlineart-`echo $FILE_POSTFIX`-lab-results.tgz .
gpg --passphrase $MYSQL_PASSWD -c --no-use-agent $TMP_DIR/3rdlineart-`echo $FILE_POSTFIX`-lab-results.tgz

# copy to external hard disk (assuming it is connected)
mkdir /media/BENJA-WINDOWS/3rdline-backup
cp $TMP_DIR/*.gpg /media/BENJA-WINDOWS/3rdline-backup

# move to backup dir
mv $TMP_DIR/* $BACKUP_DIR

# send mail notification
# dont create new mail subsystem, but piggyback on 3rd line P, MySQL mailing
#MSG_TO="christian.neumann@gmail.com"
MSG_TO="benjamin@pihmalawi.com"
MSG_FROM="3rdlinemw@gmail.com"
SUBJECT="3RD Line Expert Application backup "
BODY=$(echo "Local backup of 3rd line ART regimen to `echo $BACKUP_DIR` done" | base64)
SENT=0
DATE_SENT="$(date +%y-%m-%d)"
FORM_ID=0
mysql -u $MYSQL_USER -p$MYSQL_PASSWD $MYSQL_DATABASE <<EOF
INSERT INTO email_log
  (msg_to, msg_from, subject, body, sent, date_sent, form_id)
VALUES
  ("$MSG_TO", "$MSG_FROM", "$SUBJECT", "$BODY", "$SENT", "$DATE_SENT", "$FORM_ID");
EOF


