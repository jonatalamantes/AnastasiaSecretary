<?php 

    /**
    * Clase para el AnastasiadbLog
    */
    Class AnastasiadbLog
    {
        private $id;
        private $uid;
        private $idSesiones;
        private $tipo;
        private $consulta;
        private $activo;
        private $fechaRegistro;

        /**
         * Constructor de la Clase
         */
        function __construct($id = "", $uid = "", $idSesiones = "", 
                            $tipo = "", $consulta = "", $activo = "", $fecha_registro = "") 
        {
            $this->id            = $id;
            $this->uid           = $uid;
            $this->idSesiones    = $idSesiones;
            $this->tipo          = $tipo;
            $this->consulta      = $consulta;
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
                $array["idSesiones"]     = $this->getIdSesiones();
                $array["tipo"]           = $this->getTipo();
                $array["consulta"]       = $this->getConsulta();
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
                
                if (array_key_exists("idSesiones", $array))
                {
                    $this->setIdSesiones($array["idSesiones"]);
                }
                else
                {
                    $this->setIdSesiones('');
                }
                
                if (array_key_exists("tipo", $array))
                {
                    $this->setTipo($array["tipo"]);
                }
                else
                {
                    $this->setTipo('');
                }
                
                if (array_key_exists("consulta", $array))
                {
                    $this->setConsulta($array["consulta"]);
                }
                else
                {
                    $this->setConsulta('');
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
         * @param  AnastasiadbLog $obj [Objeto con el que se comparara]
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
            
            if ($obj->getIdSesiones() != $this->getIdSesiones())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            if ($obj->getTipo() != $this->getTipo())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            if ($obj->getConsulta() != $this->getConsulta())
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
        
            $cad .= $this->getIdSesiones().' ';
            $cad .= $this->getTipo().' ';
            $cad .= $this->getConsulta().' ';
        
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
         * Gets the value of idSesiones
         */
        public function getIdSesiones()
        {
            return $this->idSesiones;
        }
        
        /**
         * Sets the value of idSesiones
         */
        public function setIdSesiones($idSesiones)
        {
            $this->idSesiones = $idSesiones;
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
         * Gets the value of consulta
         */
        public function getConsulta()
        {
            return $this->consulta;
        }
        
        /**
         * Sets the value of consulta
         */
        public function setConsulta($consulta)
        {
            $this->consulta = $consulta;
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
