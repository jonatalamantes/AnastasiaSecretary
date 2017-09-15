<?php 

    /**
    * Clase para el AnastasiadbSesiones
    */
    Class AnastasiadbSesiones
    {
        private $id;
        private $uid;
        private $ip;
        private $host;
        private $ultimoAcceso;
        private $activo;
        private $fechaRegistro;

        /**
         * Constructor de la Clase
         */
        function __construct($id = "", $uid = "", $ip = "", 
                            $host = "", $ultimo_acceso = "", $activo = "", $fecha_registro = "") 
        {
            $this->id            = $id;
            $this->uid           = $uid;
            $this->ip            = $ip;
            $this->host          = $host;
            $this->ultimoAcceso  = $ultimo_acceso;
            $this->activo        = $activo;
            $this->fechaRegistro = $fecha_registro;
        }
        
        /**
         * Retorna un Array del Objeto
         * 
         * @return [array] [Array Asociativo Resultante]
         */
        public function toArray()
        {
            $array = array();
        
            if ($this !== null)
            {
                $array["id"]             = $this->getId();
                $array["uid"]            = $this->getUid();
                $array["ip"]             = $this->getIp();
                $array["host"]           = $this->getHost();
                $array["ultimo_acceso"]  = $this->getUltimoAcceso();
                $array["activo"]         = $this->getActivo();
                $array["fecha_registro"] = $this->getFechaRegistro();
            }
        
            return $array;
        }
        
        /**
         * Toma los datos de un Array para el Objeto
         * 
         * @param  array  $array [Array Entrante]
         */
        public function fromArray($array = array())
        {
            if (!empty($array))
            {
                if (array_key_exists("id", $array))
                {
                    $this->setId($array["id"]);
                }
                else
                {
                    $this->setId('');
                }
                
                if (array_key_exists("uid", $array))
                {
                    $this->setUid($array["uid"]);
                }
                else
                {
                    $this->setUid('');
                }
                
                if (array_key_exists("ip", $array))
                {
                    $this->setIp($array["ip"]);
                }
                else
                {
                    $this->setIp('');
                }
                
                if (array_key_exists("host", $array))
                {
                    $this->setHost($array["host"]);
                }
                else
                {
                    $this->setHost('');
                }
                
                if (array_key_exists("ultimo_acceso", $array))
                {
                    $this->setUltimoAcceso($array["ultimo_acceso"]);
                }
                else
                {
                    $this->setUltimoAcceso('');
                }
                
                if (array_key_exists("activo", $array))
                {
                    $this->setActivo($array["activo"]);
                }
                else
                {
                    $this->setActivo('');
                }
                
                if (array_key_exists("fecha_registro", $array))
                {
                    $this->setFechaRegistro($array["fecha_registro"]);
                }
                else
                {
                    $this->setFechaRegistro('');
                }
                
            }
        }
        
        /**
         * Calculo para saber que tan diferente es un objeto de otro
         * 
         * @param  AnastasiadbSesiones $obj [Objeto con el que se comparara]
         * @return [float]     [Disimilitud entre los dos objetos]
         */
        public function disimilitud($obj = null)
        {
            if ($obj === null)
            {
                return -1;
            }
        
            $disimilitud = 0;
            $numerador   = 0;
            $denominador = 0;
            
            if ($obj->getIp() != $this->getIp())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            if ($obj->getHost() != $this->getHost())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            if ($obj->getUltimoAcceso() != $this->getUltimoAcceso())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            $disimilitud = (float)($numerador/$denominador);
            return $disimilitud;
        }
        
        /**
         * Metodo toString
         */
        public function toString()
        {
            $cad = '';
        
            $cad .= $this->getIp().' ';
            $cad .= $this->getHost().' ';
            $cad .= $this->getUltimoAcceso().' ';
        
            return $cad;
        }
        
        /**
         * Gets the value of id
         */
        public function getId()
        {
            return $this->id;
        }
        
        /**
         * Sets the value of id
         */
        public function setId($id)
        {
            $this->id = $id;
        }
        
        /**
         * Gets the value of uid
         */
        public function getUid()
        {
            return $this->uid;
        }
        
        /**
         * Sets the value of uid
         */
        public function setUid($uid)
        {
            $this->uid = $uid;
        }
        
        /**
         * Gets the value of ip
         */
        public function getIp()
        {
            return $this->ip;
        }
        
        /**
         * Sets the value of ip
         */
        public function setIp($ip)
        {
            $this->ip = $ip;
        }
        
        /**
         * Gets the value of host
         */
        public function getHost()
        {
            return $this->host;
        }
        
        /**
         * Sets the value of host
         */
        public function setHost($host)
        {
            $this->host = $host;
        }
        
        /**
         * Gets the value of ultimoAcceso
         */
        public function getUltimoAcceso()
        {
            return $this->ultimoAcceso;
        }
        
        /**
         * Sets the value of ultimoAcceso
         */
        public function setUltimoAcceso($ultimoAcceso)
        {
            $this->ultimoAcceso = $ultimoAcceso;
        }
        
        /**
         * Gets the value of activo
         */
        public function getActivo()
        {
            return $this->activo;
        }
        
        /**
         * Sets the value of activo
         */
        public function setActivo($activo)
        {
            $this->activo = $activo;
        }
        
        /**
         * Gets the value of fechaRegistro
         */
        public function getFechaRegistro()
        {
            return $this->fechaRegistro;
        }
        
        /**
         * Sets the value of fechaRegistro
         */
        public function setFechaRegistro($fechaRegistro)
        {
            $this->fechaRegistro = $fechaRegistro;
        }
        
    }
?>
