<?php 

    /**
    * Clase para el Log
    */
    Class Log
    {
        private $id;
        private $uid;
        private $sesionesUsuariosId;
        private $tipo;
        private $query;
        private $activo;
        private $fechaRegistro;

        /**
         * Constructor de la Clase
         */
        function __construct($id = "", $uid = "", $sesiones_usuarios_id = "", 
                            $tipo = "", $query = "", $activo = "", $fecha_registro = "") 
        {
            $this->id                  = $id;
            $this->uid                 = $uid;
            $this->sesionesUsuariosId  = $sesiones_usuarios_id;
            $this->tipo                = $tipo;
            $this->query               = $query;
            $this->activo              = $activo;
            $this->fechaRegistro       = $fecha_registro;
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
                $array["id"]                    = $this->getId();
                $array["uid"]                   = $this->getUid();
                $array["tsesiones_usuarios_id"] = $this->getSesionesUsuariosId();
                $array["tipo"]                  = $this->getTipo();
                $array["consulta"]              = $this->getQuery();
                $array["activo"]                = $this->getActivo();
                $array["fecha_registro"]        = $this->getFechaRegistro();
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
                $this->setId($array["id"]);
                $this->setUid($array["uid"]);
                $this->setSesionesUsuariosId($array["tsesiones_usuarios_id"]);
                $this->setTipo($array["tipo"]);
                $this->setQuery($array["consulta"]);
                $this->setActivo($array["activo"]);
                $this->setFechaRegistro($array["fecha_registro"]);
            }
        }
        
        /**
         * Calculo para saber que tan diferente es un objeto de otro
         * 
         * @param  Log $obj [Objeto con el que se comparara]
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
            
            if ($obj->getSesionesUsuariosId() != $this->getSesionesUsuariosId())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            if ($obj->getTipo() != $this->getTipo())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            if ($obj->getQuery() != $this->getQuery())
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
        
            $cad .= $this->getSesionesUsuariosId().' ';
            $cad .= $this->getTipo().' ';
            $cad .= $this->getQuery().' ';
        
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
         * Gets the value of sesionesUsuariosId
         */
        public function getSesionesUsuariosId()
        {
            return $this->sesionesUsuariosId;
        }
        
        /**
         * Sets the value of sesionesUsuariosId
         */
        public function setSesionesUsuariosId($sesionesUsuariosId)
        {
            $this->sesionesUsuariosId = $sesionesUsuariosId;
        }
        
        /**
         * Gets the value of tipo
         */
        public function getTipo()
        {
            return $this->tipo;
        }
        
        /**
         * Sets the value of tipo
         */
        public function setTipo($tipo)
        {
            $this->tipo = $tipo;
        }
        
        /**
         * Gets the value of query
         */
        public function getQuery()
        {
            return $this->query;
        }
        
        /**
         * Sets the value of query
         */
        public function setQuery($query)
        {
            $this->query = $query;
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
