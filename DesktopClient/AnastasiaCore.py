import ssl
import httplib
import urllib
import json
from aes import AESCipher

ssl._create_default_https_context = ssl._create_unverified_context

class AnastasiaCore():

    def printDebug(self, msj):
        if (self._debug):
            print msj

    def getAes(self):
        return self._aes

    def getConection(self):
        return self._conection

    def getToken(self):
        return self._token

    def getEvents(self):
        return self._events

    def __init__(self):
        self._aes = AESCipher('RinTohsaka<3', 'Anastasia<3')
        self._conection = httplib.HTTPSConnection("10.15.50.95")
        self._token = ""
        self._events = []
        self._debug = True;
        
    def loginServer(self):
        jsonData = {'username': "AnastasiaClient", 'password': "AnastasiaIsLove"}
        self._token = self.makeRequest("/AnastasiaSecretary/Server/getToken.php", jsonData)
        self.printDebug("El token recibido es: " + self._token)

    def syncEvents(self):
        jsonData = {'token': self._token}
        lastEvent = json.loads(self.makeRequest("/AnastasiaSecretary/Server/syncEvent.php", jsonData))

        if (len(self._events) != 0 and (lastEvent == None or len(lastEvent) != 0)):
            if (lastEvent["id"] != self._events[-1]["id"]):
                self.printDebug("Diferente ultimo evento >:v")
                self.pullEvents()
            else:
                self.printDebug("Mismo Eventos :D")
        else:
            self.printDebug("Actualizare todo :v")
            self.pullEvents()

    def pullEvents(self):
        jsonData = {'token': self._token}
        self._events = json.loads(self.makeRequest("/AnastasiaSecretary/Server/pullEvents.php", jsonData))
        self.printDebug("Eventos actualizados")

    def insertEvent(self, eventJson):
        myJson = eventJson
        myJson["token"] = self._token
        if (self.makeRequest("/AnastasiaSecretary/Server/insertEvent.php", jsonData) != ""):
            self.printDebug("Evento creado")
            self.pullEvents()
        else:
            self.printDebug("Evento sin crear")

    def updateEvent(self, eventJson):
        myJson = eventJson
        myJson["token"] = self._token
        res = self.makeRequest("/AnastasiaSecretary/Server/updateEvent.php", jsonData)

        if (res == ""):
            self.printDebug("El evento no se modifico")
        else:
            self.printDebug("El evento se modifico")

        self.pullEvents()

    def makeRequest(self, page, jsonData):
        headers = {"Content-type": "application/x-www-form-urlencoded", "Accept": "text/plain"}
        params = urllib.urlencode({'data': self._aes.encrypt(json.dumps(jsonData))})

        self._conection.request("POST", page, params, headers)
        response = self._conection.getresponse()
        #print response.status, response.reason

        data = response.read()
        #self.printDebug(data)
        data2 = self._aes.decrypt(data)
        #self.printDebug(data2)
        return data2


c = AnastasiaCore()
c.loginServer()
c.pullEvents()
c.syncEvents()
#print c.getEvents()

jsonData = {"descripcion": "otro evento", "fecha_activacion": "2017-09-14 19:57:22", 'estado': "creado"}
c.insertEvent(jsonData)

jsonData = {"id": 2, "descripcion": "otro evento culero", "fecha_activacion": "2017-09-14 19:59:23", 'estado': "creado"}
c.updateEvent(jsonData)
