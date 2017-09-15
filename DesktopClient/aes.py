import base64
import hashlib
from Crypto.Cipher import AES

class AESCipher:
    def __init__(self, key, iv):
        self.key = hashlib.sha256(key.encode('utf-8')).hexdigest()[:32].encode("utf-8")
        self.iv = hashlib.sha256(iv.encode('utf-8')).hexdigest()[:16].encode("utf-8")

    __pad = lambda self,s: s + (AES.block_size - len(s) % AES.block_size) * chr(AES.block_size - len(s) % AES.block_size)
    __unpad = lambda self,s: s[0:-ord(s[-1])]

    def encrypt( self, raw ):
        raw = self.__pad(raw)
        cipher = AES.new(self.key, AES.MODE_CBC, self.iv)
        return base64.b64encode(cipher.encrypt(raw))

    def decrypt( self, enc ):
        enc = base64.b64decode(enc)
        cipher = AES.new(self.key, AES.MODE_CBC, self.iv)
        return self.__unpad(cipher.decrypt(enc).decode("utf-8"))
