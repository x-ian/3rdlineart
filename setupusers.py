#!/usr/bin/env python
import csv
import MySQLdb as mysql
import MySQLdb.cursors
from datetime import date, datetime
import hashlib
from Crypto.Cipher import AES
import base64
import crypt
import sys
import urllib
import requests

urlencode = urllib.quote_plus
# urlencode = urllib.urlencode
AES.key_size=128
# def urlencode(X):
#     return X

key = hashlib.md5("bigbullets").hexdigest()
salt = hashlib.md5("bigbullets").hexdigest()
print "key is '%s'" % key, len(key)
# the block size for the cipher object; must be 16, 24, or 32 for AES
BLOCK_SIZE = 16

# the character used for padding--with a block cipher such as AES, the value
# you encrypt must be a multiple of BLOCK_SIZE in length.  This character is
# used to ensure that your value is always a multiple of BLOCK_SIZE
PADDING = '\0'
# one-liner to sufficiently pad the text to be encrypted
pad = lambda s: s + (BLOCK_SIZE - len(s) % BLOCK_SIZE) * PADDING

def encrypt(text_to_encode, key="332SECRETabc1234"):
    # one-liners to encrypt/encode and decrypt/decode a string
    # encrypt with AES, encode with base64
    EncodeAES = lambda c, s: base64.b64encode(c.encrypt(pad(s)))
    DecodeAES = lambda c, e: c.decrypt(base64.b64decode(e)).rstrip(PADDING)
    secret = key
    iv = "HELLOWORLD123456"
    cipher=AES.new(key=secret,mode=AES.MODE_ECB,IV=iv)  # was CBC
    return EncodeAES(cipher, text_to_encode)

def pad_x(string):
    ls = len(string)
    print 'length of "%s" is' % string, ls
    if ls <= 16:
        string += ('\0'*(16-ls))
    elif ls <= 24:
        string += ('\0'*(24-ls))
    else:
        string += ('\0'*(32-ls))
    return string

pad = lambda s: s + (BLOCK_SIZE - len(s) % BLOCK_SIZE) * PADDING

def encrypt_x (string, key):
    crypt_object = AES.new(key=key,mode=AES.MODE_ECB)
    # print string, pad(string)
    return base64.b64encode(crypt_object.encrypt(pad(string)))

def decrypt_x (string, key):
    crypt_object=AES.new(key=key,mode=AES.MODE_ECB)
    decoded=base64.b64decode(base64.b64encode(string)) # your ecrypted and encoded text goes here
    return crypt_object.decrypt(decoded)

def hasword (string, salt):
    # string = encrypt_x(string, '$1$'+salt+'$')
    # return string
    return crypt.crypt(string, '$1$'+salt+'$')    

def db_exec(sql):
    db = mysql.connect(host='localhost', user='root', passwd='password',
                       db='3rdlineart8_db', cursorclass=MySQLdb.cursors.DictCursor)
    print db
    c = db.cursor()
    rows = None
    if sql:
        cmd = sql.split()[0].strip().upper()
        try:
            print 'sql is "%s", cmd is "%s"' % (sql, cmd)
            c.execute(sql)
            if cmd == 'SELECT':
                rows = c.fetchall()
                return rows
            else:
                print 'committing...'
                db.commit()
                return c, db
        except Exception, e:
            print 'Exception', str(e)
            pass
    
def setupusers(key, usersfn, which='clinician'):
    today = date.today()
    date_created = today.strftime("%d/%m/%Y")
    print date_created
    
    with open(usersfn, 'rb') as csvfile:
        spamreader = csv.DictReader(csvfile, delimiter=',', quotechar='|')
        # print spamreader.fieldnames
        userno = 0
        for row in spamreader:
            fullname = row['NAME']
            # email = 'jeffgelbard@gmail.com'
            email = row['EMAIL']
            print 'email was: '+row['EMAIL']
            try:
                role = int(row['ROLE'])
            except:
                role = 0
            if which == 'reviewer':
                (isClinician, isSecretary) = (role == 2) and (1,1) or ((role == 1) and (1, 0) or (0, 0))
            if which == 'clinician':
                isReviewer = 1;
            try:
                art_linic = row['DISTRICT']
            except:
                art_clinic = ''
            try:
                phone = row['MOBILE']
            except:
                phone = ''
                
            fns = fullname.split()
            fname = fns[0]
            lname = ' '.join(fns[1:])
            lname2 = ''.join(fns[1:])
            username = fname[0].lower()+lname2.lower()  # default username is first initial + lname(s)
            password = '123456'

            '''
            enc_password = hasword(password, salt)            
            cap_which = which.capitalize()
            print 'key is', key
            cap_which = cap_which+'\0'*(16-len(cap_which))
            enc_role = encrypt(cap_which, key)
            print 'role is', cap_which, 'enc role is', enc_role, 'len', len(enc_role)
            print encrypt(username, key), enc_password, encrypt(cap_which, key), date_created
            enc_role += '\0'*(len(enc_role) % 16)
            print 'decrypted', decrypt(enc_role, key)
            sql_insert = "INSERT INTO users (username,password,role,date_created) VALUES ('%s', '%s', '%s', '%s')" % (encrypt(username, key), enc_password, encrypt(cap_which, key), date_created)
            # print '>>>', sql_insert
            c, db = db_exec(sql_insert)
            user_id = c.lastrowid
            print 'last insert', user_id
            # rows = db_exec('SELECT LAST_INSERT_ID()')
            # print 'Insert id is', rows[0]
            
            if which == 'clinician':
                insert_clinician = "INSERT INTO clinician(user_id, art_clinic, name, fname, lname, email, phone, isReviewer) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', %s)" % (user_id, art_clinic, fullname, fname, lname, email, phone, isReviewer)
            if which == 'reviewer':
                insert_clinician = "INSERT INTO reviewer(user_id, fname, lname, email, phone, isClinician, isSecretary) VALUES ('%s', '%s', '%s', '%s', '%s', %s, %s)" % (user_id, fname, lname, email, phone, isClinician, isSecretary)
            db_exec(insert_clinician)
'''

            json = { 'register_clinician':'1', 'logoutafter':'1', 'backdoor':'3rdl!nEg3n0typ3mw','firstname':fname, 'lastname':lname, 'username':username, 'art_clinic':'','email':email, 'phone':phone, 'reviewer':'on', 'password':password, 'confirm_pswd':password }

            if 1:
                response = requests.post('https://www.3rdlineartmw.org/3rdlineart8/admin/dash.php',
                                         data=json, verify=False)
            else:
                response = requests.post('http://localhost/3rdlineart8/admin/dash.php',
                                         data=json)
            # response = requests.post('https://www.3rdlineartmw.org/3rdlineart8/admin/includes/insert_clinician.php',
            #                          json=json)
            print response
            # print response.text
            
            userno += 1
            if userno == 1:
                break
        #   email_newuser(username, enc_password, fullname, email, cap_which, key)
        #   break
    print "Registered %s users !" % userno
            
def phpmailer(to, subject, body):
    today = date.today()
    date_sent = today # today.strftime("%d/%m/%Y")
    
    insert_email = """INSERT INTO email_log
    (msg_from, msg_to, subject, body, date_sent)
    VALUES (
    '3rdlineartmalawi@gmail.com', '%s', '%s', '%s', '%s')""" % (to, subject, base64.b64encode(body), date_sent)
    db_exec(insert_email)

serveraddr = 'localhost'
rooturl = 'http://'+serveraddr+'/3rdlineart8/'

def email_newuser(username, password, fullname, email, role, key):
    subject = "New Member"
    message = '''<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>New User Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
    <p>Welcome '''+fullname+'''!</p>
    <p>You have been registered as a '''+role+''' user in the 3<sup>rd</sup> Line ART Expert Committee Malawi. Follow the link to complete your registration:</p>
    <a href="'''+rooturl+'''/new_user_account.php?x='''+urlencode(encrypt(username, key))+'&y='+urlencode(encrypt(role, key))+'&z='+password+'''">Click Here</a>

    <p>&nbsp;</p>
    <p>Regards</p>
    <p>Admin</p>
    </body>
    </html>
    '''
    print message
    retval = phpmailer(email, subject, message)
    # echo 'phpmailer returned: '+retval

if __name__ == '__main__':
    '''
    x = encrypt_x('Clinician', key)
    print x
    
    # print 'password_hash:', hasword('123456', salt)
    # print pad_x('$1$%s$' % key), len(pad_x('$1$%s$' % key))
    # print encrypt_x('123456', pad_x('$1$%s$' % key))
    # print urlencode('vC3zlc0Pxo+3JTQXxJU/Xw==')
    
    print 'key is', key, len(key)
    salt = '$1$%s$' % key
    crypt_object=AES.new(key=key,mode=AES.MODE_ECB)
    padded_user = pad('Clinician')
    crypt_object=AES.new(key=salt,mode=AES.MODE_ECB)
    padded_user = pad('123456')
    encrypted = crypt_object.encrypt(padded_user)
    print 'encrypted Clinician is',  base64.b64encode(encrypted), len(base64.b64encode(encrypted))
    
    decoded=base64.b64decode(base64.b64encode(encrypted)) # your ecrypted and encoded text goes here
    decrypted=crypt_object.decrypt(decoded)
    print 'original', decrypted
    sys.exit()
    '''

    # fn = './3rdLineArtClinicians2.csv'
    # fn = './3rdlineArtReviewers.csv'
    fn = './3rdLineArt Participants list.csv'
    setupusers(key, fn, 'clinician')
    # print '>>>', crypt.crypt('bytewarp', '$1$'+salt+'$')
