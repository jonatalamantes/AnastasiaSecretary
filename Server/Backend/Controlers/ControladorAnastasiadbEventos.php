<?php 

    require_once(__DIR__."/../Classes/AnastasiadbEventos.php");
    require_once(__DIR__."/DatabaseManager.php");
    require_once(__DIR__."/WatashiEncrypt.php");
    require_once(__DIR__."/ControladorAnastasiadbLog.php");
    
    /**
     * Clase para Manipular Objetos del Tipo AnastasiadbEventos
     */
    class ControladorAnastasiadbEventos
    {
        /**
         * Recupera un objeto de tipo AnastasiadbEventos
         */
        static function getSingle($keysValues = array())
        {
            if (!is_array($keysValues) || empty($keysValues))
            {
                return null;
            }
        
            $tableAnastasiadbEventos  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_EVENTOS');
        
            $query     = "SELECT $tableAnastasiadbEventos.*
                          FROM $tableAnastasiadbEventos
                          WHERE $tableAnastasiadbEventos.activo='S'
                          AND ";
        
            foreach ($keysValues as $key => $value)
            {
                $query .= "$tableAnastasiadbEventos.$key = '$value' AND ";
            }
            
            $query = substr($query, 0, strlen($query)-4);
            $query .= " ORDER BY $tableAnastasiadbEventos.id DESC";

            $anastasiadbeventosA = null;
            
            $anastasiadbeventos_simple  = DatabaseManager::singleFetchAssoc($query);
            
            if ($anastasiadbeventos_simple !== null)
            {
                $anastasiadbeventosA = new AnastasiadbEventos();
                $anastasiadbeventosA->fromArray($anastasiadbeventos_simple);
            }
        
            return $anastasiadbeventosA;
        }
        
        /**
         * Recupera un objeto de tipo AnastasiadbEventos
         */
        static function getUltimo()
        {
            $tableAnastasiadbEventos  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_EVENTOS');
        
            $query     = "SELECT $tableAnastasiadbEventos.*
                          FROM $tableAnastasiadbEventos
                          ORDER BY $tableAnastasiadbEventos.id DESC ";
        
            $anastasiadbeventos_simple  = DatabaseManager::singleFetchAssoc($query);
            $anastasiadbeventosA = null;
            
            if ($anastasiadbeventos_simple !== null)
            {
                $anastasiadbeventosA = new AnastasiadbEventos();
                $anastasiadbeventosA->fromArray($anastasiadbeventos_simple);
            }
        
            return $anastasiadbeventosA;
        }
        
        /**
         * Obtiene todos los anastasiadbeventoss de la tabla de anastasiadbeventoss
         */
        static function getAll($order = 'id', $begin = 0, $cantidad = 10)
        {
            $tableAnastasiadbEventos  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_EVENTOS');
        
            $query     = "SELECT $tableAnastasiadbEventos.*
                          FROM $tableAnastasiadbEventos
                          WHERE $tableAnastasiadbEventos.activo = 'S'
                          ORDER BY ";
        
            if ($order == 'minutosDuracion')
            {
                $query = $query . " $tableAnastasiadbEventos.minutos_duracion";
            }
            else if ($order == 'descripcion')
            {
                $query = $query . " $tableAnastasiadbEventos.descripcion";
            }
            else if ($order == 'fechaActivacion')
            {
                $query = $query . " $tableAnastasiadbEventos.fecha_activacion";
            }
            else if ($order == 'estado')
            {
                $query = $query . " $tableAnastasiadbEventos.estado";
            }
            else if ($order == 'tipoAlerta')
            {
                $query = $query . " $tableAnastasiadbEventos.tipo_alerta";
            }
            else if ($order == 'referencia')
            {
                $query = $query . " $tableAnastasiadbEventos.referencia";
            }
            else if ($order == 'mensaje')
            {
                $query = $query . " $tableAnastasiadbEventos.mensaje";
            }
            else if ($order == 'idEventoPrevio')
            {
                $query = $query . " $tableAnastasiadbEventos.idEventoPrevio";
            }
            else if ($order == 'idEventoAnterior')
            {
                $query = $query . " $tableAnastasiadbEventos.idEventoAnterior";
            }
            else
            {
                $query = $query . " $tableAnastasiadbEventos.id DESC";
            }
        
            if ($begin >= 0)
            {
                $query = $query. " LIMIT " . strval($begin * $cantidad) . ", " . strval($cantidad+1);
            }
        
            $arrayAnastasiadbEventoss   = DatabaseManager::multiFetchAssoc($query);
            $anastasiadbeventos_simples = array();
        
            if ($arrayAnastasiadbEventoss !== null)
            {
                $i = 0;
                foreach ($arrayAnastasiadbEventoss as $anastasiadbeventos_simple) 
                {
                    if ($i == $cantidad && $begin >= 0)
                    {
                        continue;
                    }
        
                    $anastasiadbeventosA = new AnastasiadbEventos();
                    $anastasiadbeventosA->fromArray($anastasiadbeventos_simple);
                    $anastasiadbeventos_simples[] = $anastasiadbeventosA;
                    $i++;
                }
        
                return $anastasiadbeventos_simples;
            }
            else
            {
                return null;
            }
        }
        
        /**
         * Inserta un elemento en la base de datos del tipo anastasiadbeventos
         */
        static function add($anastasiadbeventos = null)
        {
            if ($anastasiadbeventos === null)
            {
                return false;
            }
        
            $opciones = array(
                'minutos_duracion' => $anastasiadbeventos->getMinutosDuracion(),
                'descripcion'      => $anastasiadbeventos->getDescripcion(),
                'fecha_activacion' => $anastasiadbeventos->getFechaActivacion(),
                'estado'           => $anastasiadbeventos->getEstado(),
                'tipo_alerta'      => $anastasiadbeventos->getTipoAlerta(),
                'referencia'       => $anastasiadbeventos->getReferencia(),
                'mensaje'          => $anastasiadbeventos->getMensaje(),
                'idEventoPrevio'   => $anastasiadbeventos->getIdEventoPrevio(),
                'idEventoAnterior' => $anastasiadbeventos->getIdEventoAnterior(),
                'activo'           => 'S'
            );
        
            $singleAnastasiadbEventos = self::getSingle($opciones);
        
            if ($singleAnastasiadbEventos == null || $singleAnastasiadbEventos->disimilitud($anastasiadbeventos) == 1)
            {
                $uid              = WatashiEncrypt::uniqueKey();
                $minutos_duracion = $anastasiadbeventos->getMinutosDuracion();
                $descripcion      = $anastasiadbeventos->getDescripcion();
                $fecha_activacion = $anastasiadbeventos->getFechaActivacion();
                $estado           = $anastasiadbeventos->getEstado();
                $tipo_alerta      = $anastasiadbeventos->getTipoAlerta();
                $referencia       = $anastasiadbeventos->getReferencia();
                $mensaje          = $anastasiadbeventos->getMensaje();
                $idEventoPrevio   = $anastasiadbeventos->getIdEventoPrevio();
                $idEventoAnterior = $anastasiadbeventos->getIdEventoAnterior();
        
                $tableAnastasiadbEventos  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_EVENTOS');
        
                $query   = "INSERT INTO $tableAnastasiadbEventos 
                            (uid, minutos_duracion, descripcion, 
                            fecha_activacion, estado, tipo_alerta, 
                            referencia, mensaje, idEventoPrevio, 
                            idEventoAnterior)
                            VALUES
                            ('$uid', '$minutos_duracion', '$descripcion', 
                            '$fecha_activacion', '$estado', '$tipo_alerta', 
                            '$referencia', '$mensaje', '$idEventoPrevio', 
                            '$idEventoAnterior')";
        
                if (DatabaseManager::singleAffectedRow($query) === true)
                {
                    $log = new AnastasiadbLog();
                    $log->setConsulta(addslashes($query));
                    $log->setTipo('A');
                    
                    ControladorAnastasiadbLog::add($log);
                    return $uid;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        
        /**
         * Actualizar el Contenido de un objeto de tipo anastasiadbeventos
         */
        static function update($anastasiadbeventos = null)
        {
            if ($anastasiadbeventos === null)
            {
                return false;
            }
        
            $opciones = array('id' => $anastasiadbeventos->getId());
        
            $singleAnastasiadbEventos = self::getSingle($opciones);
        
            if ($singleAnastasiadbEventos == NULL || $singleAnastasiadbEventos->disimilitud($anastasiadbeventos) > 0)
            {
                $id               = $anastasiadbeventos->getId();
                $uid              = $anastasiadbeventos->getUid();
                $minutos_duracion = $anastasiadbeventos->getMinutosDuracion();
                $descripcion      = $anastasiadbeventos->getDescripcion();
                $fecha_activacion = $anastasiadbeventos->getFechaActivacion();
                $estado           = $anastasiadbeventos->getEstado();
                $tipo_alerta      = $anastasiadbeventos->getTipoAlerta();
                $referencia       = $anastasiadbeventos->getReferencia();
                $mensaje          = $anastasiadbeventos->getMensaje();
                $idEventoPrevio   = $anastasiadbeventos->getIdEventoPrevio();
                $idEventoAnterior = $anastasiadbeventos->getIdEventoAnterior();
        
                $tableAnastasiadbEventos  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_EVENTOS');
        
                $opciones = array(
                    'minutos_duracion' => $anastasiadbeventos->getMinutosDuracion(),
                    'descripcion'      => $anastasiadbeventos->getDescripcion(),
                    'fecha_activacion' => $anastasiadbeventos->getFechaActivacion(),
                    'estado'           => $anastasiadbeventos->getEstado(),
                    'tipo_alerta'      => $anastasiadbeventos->getTipoAlerta(),
                    'referencia'       => $anastasiadbeventos->getReferencia(),
                    'mensaje'          => $anastasiadbeventos->getMensaje(),
                    'idEventoPrevio'   => $anastasiadbeventos->getIdEventoPrevio(),
                    'idEventoAnterior' => $anastasiadbeventos->getIdEventoAnterior(),
                    'activo'           => 'S'
                );

                $singleAnastasiadbEventos = self::getSingle($opciones);

                if ($singleAnastasiadbEventos == null || $singleAnastasiadbEventos->disimilitud($anastasiadbeventos) == 1)
                {
                    $tableAnastasiadbEventos  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_EVENTOS');
        
                    $query =   "UPDATE $tableAnastasiadbEventos
                                SET minutos_duracion = '$minutos_duracion',
                                    descripcion      = '$descripcion',
                                    fecha_activacion = '$fecha_activacion',
                                    estado           = '$estado',
                                    tipo_alerta      = '$tipo_alerta',
                                    referencia       = '$referencia',
                                    mensaje          = '$mensaje',
                                    idEventoPrevio   = '$idEventoPrevio',
                                    idEventoAnterior = '$idEventoAnterior',
                                    activo           = 'S'
                                WHERE $tableAnastasiadbEventos.id = '$id'";

                    if (DatabaseManager::singleAffectedRow($query) === true)
                    {
                        $log = new AnastasiadbLog();
                        $log->setConsulta(addslashes($query));
                        $log->setTipo('M');
                        
                        ControladorAnastasiadbLog::add($log);
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        
        /**
         * Recupera varios objeto de tipo AnastasiadbEventos
         */
        static function filter($keysValues = array(), $order = 'id', $begin = 0, $cantidad = 10, $exact = false)
        {
            if (!is_array($keysValues) || empty($keysValues))
            {
                return null;
            }
        
            $tableAnastasiadbEventos  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_EVENTOS');
        
            $query     = "SELECT $tableAnastasiadbEventos.*
                          FROM $tableAnastasiadbEventos
                          WHERE $tableAnastasiadbEventos.activo = 'S' AND ";
        
            foreach ($keysValues as $key => $value)
            {
                if ($exact)
                {
                    $query .= "$key = '$value' AND ";
                }
                else
                {
                    $query .= "$key LIKE '%$value%' AND ";
                }
            }
            
            $query = substr($query, 0, strlen($query)-4);
            
            $query = $query . " ORDER BY ";
            
            if ($order == 'minutosDuracion')
            {
                $query = $query . " $tableAnastasiadbEventos.minutos_duracion";
            }
            else if ($order == 'descripcion')
            {
                $query = $query . " $tableAnastasiadbEventos.descripcion";
            }
            else if ($order == 'fechaActivacion')
            {
                $query = $query . " $tableAnastasiadbEventos.fecha_activacion";
            }
            else if ($order == 'estado')
            {
                $query = $query . " $tableAnastasiadbEventos.estado";
            }
            else if ($order == 'tipoAlerta')
            {
                $query = $query . " $tableAnastasiadbEventos.tipo_alerta";
            }
            else if ($order == 'referencia')
            {
                $query = $query . " $tableAnastasiadbEventos.referencia";
            }
            else if ($order == 'mensaje')
            {
                $query = $query . " $tableAnastasiadbEventos.mensaje";
            }
            else if ($order == 'idEventoPrevio')
            {
                $query = $query . " $tableAnastasiadbEventos.idEventoPrevio";
            }
            else if ($order == 'idEventoAnterior')
            {
                $query = $query . " $tableAnastasiadbEventos.idEventoAnterior";
            }
            else
            {
                $query = $query . " $tableAnastasiadbEventos.id DESC";
            }
        
            if ($begin >= 0)
            {
                $query = $query. " LIMIT " . strval($begin * $cantidad) . ", " . strval($cantidad+1);
            }
        
            $arrayAnastasiadbEventoss   = DatabaseManager::multiFetchAssoc($query);
            return json_encode($arrayAnastasiadbEventoss);
        }
        
        /**
         * Elimina logicamente un AnastasiadbEventos
         */
        static function remove($anastasiadbeventos = null)
        {
            if ($anastasiadbeventos === null)
            {
                return false;
            }
            else
            {
                $tableAnastasiadbEventos  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_EVENTOS');
                $id = $anastasiadbeventos->getId();
                
                $query = "UPDATE $tableAnastasiadbEventos
                          SET activo = 'N' WHERE id = $id";
        
                $log = new AnastasiadbLog();
                $log->setConsulta(addslashes($query));
                $log->setTipo('E');
        
                ControladorAnastasiadbLog::add($log);
                return DatabaseManager::singleAffectedRow($query);
            }
        }
        /**
         * Obtiene los registros coincidentes de los anastasiadbeventoss de la tabla de anastasiadbeventoss
         */
        static function simpleSearch($string = '', $order = 'id', $begin = 0, $cantidad = 10)
        {
            $tableAnastasiadbEventos  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_EVENTOS');
        
            $query     = "SELECT $tableAnastasiadbEventos.*
                          FROM $tableAnastasiadbEventos
                          WHERE
                          (    $tableAnastasiadbEventos.minutos_duracion LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.descripcion LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.fecha_activacion LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.estado LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.tipo_alerta LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.referencia LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.mensaje LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.idEventoPrevio LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.idEventoAnterior LIKE '%$string%')
                          AND $tableAnastasiadbEventos.activo = 'S'
                          ORDER BY ";
        
            if ($order == 'minutosDuracion')
            {
                $query = $query . " $tableAnastasiadbEventos.minutos_duracion";
            }
            else if ($order == 'descripcion')
            {
                $query = $query . " $tableAnastasiadbEventos.descripcion";
            }
            else if ($order == 'fechaActivacion')
            {
                $query = $query . " $tableAnastasiadbEventos.fecha_activacion";
            }
            else if ($order == 'estado')
            {
                $query = $query . " $tableAnastasiadbEventos.estado";
            }
            else if ($order == 'tipoAlerta')
            {
                $query = $query . " $tableAnastasiadbEventos.tipo_alerta";
            }
            else if ($order == 'referencia')
            {
                $query = $query . " $tableAnastasiadbEventos.referencia";
            }
            else if ($order == 'mensaje')
            {
                $query = $query . " $tableAnastasiadbEventos.mensaje";
            }
            else if ($order == 'idEventoPrevio')
            {
                $query = $query . " $tableAnastasiadbEventos.idEventoPrevio";
            }
            else if ($order == 'idEventoAnterior')
            {
                $query = $query . " $tableAnastasiadbEventos.idEventoAnterior";
            }
            else
            {
                $query = $query . " $tableAnastasiadbEventos.id DESC";
            }
        
            if ($begin >= 0)
            {
                $query = $query. " LIMIT " . strval($begin * $cantidad) . ", " . strval($cantidad+1);
            }
        
            $arrayAnastasiadbEventoss   = DatabaseManager::multiFetchAssoc($query);
            $anastasiadbeventos_simples = array();
        
            if ($arrayAnastasiadbEventoss !== null)
            {
                $i = 0;
                foreach ($arrayAnastasiadbEventoss as $anastasiadbeventos_simple) 
                {
                    if ($i == $cantidad && $begin >= 0)
                    {
                        continue;
                    }
        
                    $anastasiadbeventosA = new AnastasiadbEventos();
                    $anastasiadbeventosA->fromArray($anastasiadbeventos_simple);
                    $anastasiadbeventos_simples[] = $anastasiadbeventosA;
                    $i++;
                }
        
                return $anastasiadbeventos_simples;
            }
            else
            {
                return null;
            }
        }
        
        /**
         * Obtiene los registros para un autocompletado
         */
        static function getAutocompletado($string = '')
        {
            $tableAnastasiadbEventos  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_EVENTOS');
        
            $query     = "SELECT $tableAnastasiadbEventos.*
                          FROM $tableAnastasiadbEventos
                          WHERE
                          (    $tableAnastasiadbEventos.minutos_duracion LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.descripcion LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.fecha_activacion LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.estado LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.tipo_alerta LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.referencia LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.mensaje LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.idEventoPrevio LIKE '%$string%' OR 
                               $tableAnastasiadbEventos.idEventoAnterior LIKE '%$string%')
                          AND $tableAnastasiadbEventos.activo = 'S'
                          LIMIT 50";
        
            $arrayAnastasiadbEventoss   = DatabaseManager::multiFetchAssoc($query);
            $anastasiadbeventos_simples = array();
            $return         = array();
        
            if ($arrayAnastasiadbEventoss !== null)
            {
                foreach ($arrayAnastasiadbEventoss as $anastasiadbeventos_simple)
                {
                    $anastasiadbeventos = new AnastasiadbEventos();
                    $anastasiadbeventos->fromArray($anastasiadbeventos_simple);
                    array_push($return, array('label' => $anastasiadbeventos->toString(),
                            'id' => $anastasiadbeventos->getId())
                    );
                }
        
                return json_encode($return);
            }
            else
            {
                return null;
            }
        }
    }
?>
