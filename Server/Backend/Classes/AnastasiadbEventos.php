<?php 

    /**
    * Clase para el AnastasiadbEventos
    */
    Class AnastasiadbEventos
    {
        private $id;
        private $uid;
        private $minutosDuracion;
        private $descripcion;
        private $fechaActivacion;
        private $estado;
        private $tipoAlerta;
        private $referencia;
        private $mensaje;
        private $idEventoPrevio;
        private $idEventoAnterior;
        private $fechaRegistro;
        private $activo;

        /**
         * Constructor de la Clase
         */
        function __construct($id = "", $uid = "", $minutos_duracion = "", 
                            $descripcion = "", $fecha_activacion = "", $estado = "", 
                            $tipo_alerta = "", $referencia = "", $mensaje = "", 
                            $idEventoPrevio = "", $idEventoAnterior = "", $fecha_registro = "", $activo = "") 
        {
            $this->id               = $id;
            $this->uid              = $uid;
            $this->minutosDuracion  = $minutos_duracion;
            $this->descripcion      = $descripcion;
            $this->fechaActivacion  = $fecha_activacion;
            $this->estado           = $estado;
            $this->tipoAlerta       = $tipo_alerta;
            $this->referencia       = $referencia;
            $this->mensaje          = $mensaje;
            $this->idEventoPrevio   = $idEventoPrevio;
            $this->idEventoAnterior = $idEventoAnterior;
            $this->fechaRegistro    = $fecha_registro;
            $this->activo           = $activo;
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
                $array["id"]               = $this->getId();
                $array["uid"]              = $this->getUid();
                $array["minutos_duracion"] = $this->getMinutosDuracion();
                $array["descripcion"]      = $this->getDescripcion();
                $array["fecha_activacion"] = $this->getFechaActivacion();
                $array["estado"]           = $this->getEstado();
                $array["tipo_alerta"]      = $this->getTipoAlerta();
                $array["referencia"]       = $this->getReferencia();
                $array["mensaje"]          = $this->getMensaje();
                $array["idEventoPrevio"]   = $this->getIdEventoPrevio();
                $array["idEventoAnterior"] = $this->getIdEventoAnterior();
                $array["fecha_registro"]   = $this->getFechaRegistro();
                $array["activo"]           = $this->getActivo();
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
                
                if (array_key_exists("minutos_duracion", $array))
                {
                    $this->setMinutosDuracion($array["minutos_duracion"]);
                }
                else
                {
                    $this->setMinutosDuracion('');
                }
                
                if (array_key_exists("descripcion", $array))
                {
                    $this->setDescripcion($array["descripcion"]);
                }
                else
                {
                    $this->setDescripcion('');
                }
                
                if (array_key_exists("fecha_activacion", $array))
                {
                    $this->setFechaActivacion($array["fecha_activacion"]);
                }
                else
                {
                    $this->setFechaActivacion('');
                }
                
                if (array_key_exists("estado", $array))
                {
                    $this->setEstado($array["estado"]);
                }
                else
                {
                    $this->setEstado('');
                }
                
                if (array_key_exists("tipo_alerta", $array))
                {
                    $this->setTipoAlerta($array["tipo_alerta"]);
                }
                else
                {
                    $this->setTipoAlerta('');
                }
                
                if (array_key_exists("referencia", $array))
                {
                    $this->setReferencia($array["referencia"]);
                }
                else
                {
                    $this->setReferencia('');
                }
                
                if (array_key_exists("mensaje", $array))
                {
                    $this->setMensaje($array["mensaje"]);
                }
                else
                {
                    $this->setMensaje('');
                }
                
                if (array_key_exists("idEventoPrevio", $array))
                {
                    $this->setIdEventoPrevio($array["idEventoPrevio"]);
                }
                else
                {
                    $this->setIdEventoPrevio('');
                }
                
                if (array_key_exists("idEventoAnterior", $array))
                {
                    $this->setIdEventoAnterior($array["idEventoAnterior"]);
                }
                else
                {
                    $this->setIdEventoAnterior('');
                }
                
                if (array_key_exists("fecha_registro", $array))
                {
                    $this->setFechaRegistro($array["fecha_registro"]);
                }
                else
                {
                    $this->setFechaRegistro('');
                }
                
                if (array_key_exists("activo", $array))
                {
                    $this->setActivo($array["activo"]);
                }
                else
                {
                    $this->setActivo('');
                }
                
            }
        }
        
        /**
         * Calculo para saber que tan diferente es un objeto de otro
         * 
         * @param  AnastasiadbEventos $obj [Objeto con el que se comparara]
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
            
            if ($obj->getMinutosDuracion() != $this->getMinutosDuracion())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            if ($obj->getDescripcion() != $this->getDescripcion())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            if ($obj->getFechaActivacion() != $this->getFechaActivacion())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            if ($obj->getEstado() != $this->getEstado())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            if ($obj->getTipoAlerta() != $this->getTipoAlerta())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            if ($obj->getReferencia() != $this->getReferencia())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            if ($obj->getMensaje() != $this->getMensaje())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            if ($obj->getIdEventoPrevio() != $this->getIdEventoPrevio())
            {
                $numerador += 1;
            }
        
            $denominador += 1;
        
            if ($obj->getIdEventoAnterior() != $this->getIdEventoAnterior())
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
        
            $cad .= $this->getMinutosDuracion().' ';
            $cad .= $this->getDescripcion().' ';
            $cad .= $this->getFechaActivacion().' ';
            $cad .= $this->getEstado().' ';
            $cad .= $this->getTipoAlerta().' ';
            $cad .= $this->getReferencia().' ';
            $cad .= $this->getMensaje().' ';
            $cad .= $this->getIdEventoPrevio().' ';
            $cad .= $this->getIdEventoAnterior().' ';
        
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
         * Gets the value of minutosDuracion
         */
        public function getMinutosDuracion()
        {
            return $this->minutosDuracion;
        }
        
        /**
         * Sets the value of minutosDuracion
         */
        public function setMinutosDuracion($minutosDuracion)
        {
            $this->minutosDuracion = $minutosDuracion;
        }
        
        /**
         * Gets the value of descripcion
         */
        public function getDescripcion()
        {
            return $this->descripcion;
        }
        
        /**
         * Sets the value of descripcion
         */
        public function setDescripcion($descripcion)
        {
            $this->descripcion = $descripcion;
        }
        
        /**
         * Gets the value of fechaActivacion
         */
        public function getFechaActivacion()
        {
            return $this->fechaActivacion;
        }
        
        /**
         * Sets the value of fechaActivacion
         */
        public function setFechaActivacion($fechaActivacion)
        {
            $this->fechaActivacion = $fechaActivacion;
        }
        
        /**
         * Gets the value of estado
         */
        public function getEstado()
        {
            return $this->estado;
        }
        
        /**
         * Sets the value of estado
         */
        public function setEstado($estado)
        {
            $this->estado = $estado;
        }
        
        /**
         * Gets the value of tipoAlerta
         */
        public function getTipoAlerta()
        {
            return $this->tipoAlerta;
        }
        
        /**
         * Sets the value of tipoAlerta
         */
        public function setTipoAlerta($tipoAlerta)
        {
            $this->tipoAlerta = $tipoAlerta;
        }
        
        /**
         * Gets the value of referencia
         */
        public function getReferencia()
        {
            return $this->referencia;
        }
        
        /**
         * Sets the value of referencia
         */
        public function setReferencia($referencia)
        {
            $this->referencia = $referencia;
        }
        
        /**
         * Gets the value of mensaje
         */
        public function getMensaje()
        {
            return $this->mensaje;
        }
        
        /**
         * Sets the value of mensaje
         */
        public function setMensaje($mensaje)
        {
            $this->mensaje = $mensaje;
        }
        
        /**
         * Gets the value of idEventoPrevio
         */
        public function getIdEventoPrevio()
        {
            return $this->idEventoPrevio;
        }
        
        /**
         * Sets the value of idEventoPrevio
         */
        public function setIdEventoPrevio($idEventoPrevio)
        {
            $this->idEventoPrevio = $idEventoPrevio;
        }
        
        /**
         * Gets the value of idEventoAnterior
         */
        public function getIdEventoAnterior()
        {
            return $this->idEventoAnterior;
        }
        
        /**
         * Sets the value of idEventoAnterior
         */
        public function setIdEventoAnterior($idEventoAnterior)
        {
            $this->idEventoAnterior = $idEventoAnterior;
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
        
    }
?>
