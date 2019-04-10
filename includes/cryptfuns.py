from Crypto.Cipher import AES
import base64
import os
import sys
import subprocess
import hashlib

# the block size for the cipher object; must be 16, 24, or 32 for AES
BLOCK_SIZE = 16

# the character used for padding--with a block cipher such as AES, the value
# you encrypt must be a multiple of BLOCK_SIZE in length.  This character is
# used to ensure that your value is always a multiple of BLOCK_SIZE
PADDING = '\0'

# one-liner to sufficiently pad the text to be encrypted
pad = lambda s: s + (BLOCK_SIZE - len(s) % BLOCK_SIZE) * PADDING

def crypt(text_to_encode):
    # one-liners to encrypt/encode and decrypt/decode a string
    # encrypt with AES, encode with base64
    EncodeAES = lambda c, s: base64.b64encode(c.encrypt(pad(s)))
    DecodeAES = lambda c, e: c.decrypt(base64.b64decode(e)).rstrip(PADDING)
    secret = "332SECRETabc1234"
    secret = hashlib.md5("bigbullets").hexdigest()
    iv = "HELLOWORLD123456"
    cipher=AES.new(key=secret,mode=AES.MODE_ECB,IV=iv) # CBC
    return EncodeAES(cipher, text_to_encode)

def popenr(cmd, host='pi@192.168.1.1'):
    return subprocess.Popen(('ssh -o "StrictHostKeyChecking no" %s "%s"' % (host, cmd)), shell=True, stdout=subprocess.PIPE)

def popen(cmd):
    return subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE)

def modemrefresh():
    p = popen("modemstat R")
    info = p.communicate()[0] # gets a string
    return info

if __name__ == '__main__':
    text = sys.argv[1]
    ctext = crypt(text)
    print "crypt '%s': '%s'" % (text, ctext)
    p = popen('php cryptfuns.php %s dec' % ctext)
    info = p.communicate()[0] # gets a string
    print "decrypted in php: '%s'" % info
    # print os.system('php cryptfuns.php %s dec' % ctext)
