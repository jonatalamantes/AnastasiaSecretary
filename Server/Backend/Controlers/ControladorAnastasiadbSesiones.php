<?php 

    require_once(__DIR__."/../Classes/AnastasiadbSesiones.php");
    require_once(__DIR__."/DatabaseManager.php");
    require_once(__DIR__."/WatashiEncrypt.php");
    require_once(__DIR__."/ControladorAnastasiadbLog.php");
    
    /**
     * Clase para Manipular Objetos del Tipo AnastasiadbSesiones
     */
    class ControladorAnastasiadbSesiones
    {
        /**
         * Recupera un objeto de tipo AnastasiadbSesiones
         */
        static function getSingle($keysValues = array())
        {
            if (!is_array($keysValues) || empty($keysValues))
            {
                return null;
            }
        
            $tableAnastasiadbSesiones  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_SESIONES');
        
            $query     = "SELECT $tableAnastasiadbSesiones.*
                          FROM $tableAnastasiadbSesiones
                          WHERE $tableAnastasiadbSesiones.activo='S'
                          AND ";
        
            foreach ($keysValues as $key => $value)
            {
                $query .= "$tableAnastasiadbSesiones.$key = '$value' AND ";
            }
            
            $query = substr($query, 0, strlen($query)-4);
            $query .= " ORDER BY $tableAnastasiadbSesiones.id DESC";
            
            $anastasiadbsesionesA = null;
            
            $anastasiadbsesiones_simple  = DatabaseManager::singleFetchAssoc($query);
            
            if ($anastasiadbsesiones_simple !== null)
            {
                $anastasiadbsesionesA = new AnastasiadbSesiones();
                $anastasiadbsesionesA->fromArray($anastasiadbsesiones_simple);
            }
        
            return $anastasiadbsesionesA;
        }
        
        /**
         * Recupera un objeto de tipo AnastasiadbSesiones
         */
        static function getUltimo()
        {
            $tableAnastasiadbSesiones  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_SESIONES');
        
            $query     = "SELECT $tableAnastasiadbSesiones.*
                          FROM $tableAnastasiadbSesiones
                          ORDER BY $tableAnastasiadbSesiones.id DESC ";
        
            $anastasiadbsesiones_simple  = DatabaseManager::singleFetchAssoc($query);
            $anastasiadbsesionesA = null;
            
            if ($anastasiadbsesiones_simple !== null)
            {
                $anastasiadbsesionesA = new AnastasiadbSesiones();
                $anastasiadbsesionesA->fromArray($anastasiadbsesiones_simple);
            }
        
            return $anastasiadbsesionesA;
        }
        
        /**
         * Obtiene todos los anastasiadbsesioness de la tabla de anastasiadbsesioness
         */
        static function getAll($order = 'id', $begin = 0, $cantidad = 10)
        {
            $tableAnastasiadbSesiones  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_SESIONES');
        
            $query     = "SELECT $tableAnastasiadbSesiones.*
                          FROM $tableAnastasiadbSesiones
                          WHERE $tableAnastasiadbSesiones.activo = 'S'
                          ORDER BY ";
        
            if ($order == 'ip')
            {
                $query = $query . " $tableAnastasiadbSesiones.ip";
            }
            else if ($order == 'host')
            {
                $query = $query . " $tableAnastasiadbSesiones.host";
            }
            else if ($order == 'ultimoAcceso')
            {
                $query = $query . " $tableAnastasiadbSesiones.ultimo_acceso";
            }
            else
            {
                $query = $query . " $tableAnastasiadbSesiones.id DESC";
            }
        
            if ($begin >= 0)
            {
                $query = $query. " LIMIT " . strval($begin * $cantidad) . ", " . strval($cantidad+1);
            }
        
            $arrayAnastasiadbSesioness   = DatabaseManager::multiFetchAssoc($query);
            $anastasiadbsesiones_simples = array();
        
            if ($arrayAnastasiadbSesioness !== null)
            {
                $i = 0;
                foreach ($arrayAnastasiadbSesioness as $anastasiadbsesiones_simple) 
                {
                    if ($i == $cantidad && $begin >= 0)
                    {
                        continue;
                    }
        
                    $anastasiadbsesionesA = new AnastasiadbSesiones();
                    $anastasiadbsesionesA->fromArray($anastasiadbsesiones_simple);
                    $anastasiadbsesiones_simples[] = $anastasiadbsesionesA;
                    $i++;
                }
        
                return $anastasiadbsesiones_simples;
            }
            else
            {
                return null;
            }
        }
        
        /**
         * Inserta un elemento en la base de datos del tipo anastasiadbsesiones
         */
        static function add($anastasiadbsesiones = null)
        {
            if ($anastasiadbsesiones === null)
            {
                return false;
            }
        
            $opciones = array(
                'ip'             => $anastasiadbsesiones->getIp(),
                'host'           => $anastasiadbsesiones->getHost(),
                'ultimo_acceso'  => $anastasiadbsesiones->getUltimoAcceso(),
                'activo'         => 'S'
            );
        
            $singleAnastasiadbSesiones = self::getSingle($opciones);
        
            if ($singleAnastasiadbSesiones == null || $singleAnastasiadbSesiones->disimilitud($anastasiadbsesiones) == 1)
            {
                $uid            = WatashiEncrypt::uniqueKey();
                $ip             = $anastasiadbsesiones->getIp();
                $host           = $anastasiadbsesiones->getHost();
                $ultimo_acceso  = $anastasiadbsesiones->getUltimoAcceso();
        
                $tableAnastasiadbSesiones  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_SESIONES');
        
                $query   = "INSERT INTO $tableAnastasiadbSesiones 
                            (uid, ip, host, 
                            ultimo_acceso)
                            VALUES
                            ('$uid', '$ip', '$host', 
                            '$ultimo_acceso')";
        
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
         * Actualizar el Contenido de un objeto de tipo anastasiadbsesiones
         */
        static function update($anastasiadbsesiones = null)
        {
            if ($anastasiadbsesiones === null)
            {
                return false;
            }
        
            $opciones = array('id' => $anastasiadbsesiones->getId());
        
            $singleAnastasiadbSesiones = self::getSingle($opciones);
        
            if ($singleAnastasiadbSesiones->disimilitud($anastasiadbsesiones) > 0)
            {
                $id             = $anastasiadbsesiones->getId();
                $uid            = $anastasiadbsesiones->getUid();
                $ip             = $anastasiadbsesiones->getIp();
                $host           = $anastasiadbsesiones->getHost();
                $ultimo_acceso  = $anastasiadbsesiones->getUltimoAcceso();
        
                $tableAnastasiadbSesiones  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_SESIONES');
        
                $opciones = array(
                    'ip'             => $anastasiadbsesiones->getIp(),
                    'host'           => $anastasiadbsesiones->getHost(),
                    'ultimo_acceso'  => $anastasiadbsesiones->getUltimoAcceso(),
                    'activo'         => 'S'
                );
        
                $singleAnastasiadbSesiones = self::getSingle($opciones);
        
                if ($singleAnastasiadbSesiones == null || $singleAnastasiadbSesiones->disimilitud($anastasiadbsesiones) == 1)
                {
                    $tableAnastasiadbSesiones  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_SESIONES');
        
                    $query =   "UPDATE $tableAnastasiadbSesiones
                                SET uid            = '$uid',
                                    ip             = '$ip',
                                    host           = '$host',
                                    ultimo_acceso  = '$ultimo_acceso',
                                    activo         = 'S'
                                WHERE $tableAnastasiadbSesiones.id = '$id'";
        
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
         * Recupera varios objeto de tipo AnastasiadbSesiones
         */
        static function filter($keysValues = array(), $order = 'id', $begin = 0, $cantidad = 10, $exact = false)
        {
            if (!is_array($keysValues) || empty($keysValues))
            {
                return null;
            }
        
            $tableAnastasiadbSesiones  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_SESIONES');
        
            $query     = "SELECT $tableAnastasiadbSesiones.*
                          FROM $tableAnastasiadbSesiones
                          WHERE $tableAnastasiadbSesiones.activo = 'S' AND ";
        
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
            
            if ($order == 'ip')
            {
                $query = $query . " $tableAnastasiadbSesiones.ip";
            }
            else if ($order == 'host')
            {
                $query = $query . " $tableAnastasiadbSesiones.host";
            }
            else if ($order == 'ultimoAcceso')
            {
                $query = $query . " $tableAnastasiadbSesiones.ultimo_acceso";
            }
            else
            {
                $query = $query . " $tableAnastasiadbSesiones.id DESC";
            }
        
            if ($begin >= 0)
            {
                $query = $query. " LIMIT " . strval($begin * $cantidad) . ", " . strval($cantidad+1);
            }
        
            $arrayAnastasiadbSesioness   = DatabaseManager::multiFetchAssoc($query);
            $anastasiadbsesiones_simples = array();
        
            if ($arrayAnastasiadbSesioness !== null)
            {
                $i = 0;
                foreach ($arrayAnastasiadbSesioness as $anastasiadbsesiones_simple) 
                {
                    if ($i == $cantidad && $begin >= 0)
                    {
                        continue;
                    }
        
                    $anastasiadbsesionesA = new AnastasiadbSesiones();
                    $anastasiadbsesionesA->fromArray($anastasiadbsesiones_simple);
                    $anastasiadbsesiones_simples[] = $anastasiadbsesionesA;
                    $i++;
                }
        
                return $anastasiadbsesiones_simples;
            }
            else
            {
                return null;
            }
        }
        
        /**
         * Elimina logicamente un AnastasiadbSesiones
         */
        static function remove($anastasiadbsesiones = null)
        {
            if ($anastasiadbsesiones === null)
            {
                return false;
            }
            else
            {
                $tableAnastasiadbSesiones  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_SESIONES');
                $id = $anastasiadbsesiones->getId();
                
                $query = "UPDATE $tableAnastasiadbSesiones
                          SET activo = 'N' WHERE id = $id";
        
                $log = new AnastasiadbLog();
                $log->setConsulta(addslashes($query));
                $log->setTipo('E');
        
                ControladorAnastasiadbLog::add($log);
                return DatabaseManager::singleAffectedRow($query);
            }
        }
        /**
         * Obtiene los registros coincidentes de los anastasiadbsesioness de la tabla de anastasiadbsesioness
         */
        static function simpleSearch($string = '', $order = 'id', $begin = 0, $cantidad = 10)
        {
            $tableAnastasiadbSesiones  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_SESIONES');
        
            $query     = "SELECT $tableAnastasiadbSesiones.*
                          FROM $tableAnastasiadbSesiones
                          WHERE
                          (    $tableAnastasiadbSesiones.ip LIKE '%$string%' OR 
                               $tableAnastasiadbSesiones.host LIKE '%$string%' OR 
                               $tableAnastasiadbSesiones.ultimo_acceso LIKE '%$string%')
                          AND $tableAnastasiadbSesiones.activo = 'S'
                          ORDER BY ";
        
            if ($order == 'ip')
            {
                $query = $query . " $tableAnastasiadbSesiones.ip";
            }
            else if ($order == 'host')
            {
                $query = $query . " $tableAnastasiadbSesiones.host";
            }
            else if ($order == 'ultimoAcceso')
            {
                $query = $query . " $tableAnastasiadbSesiones.ultimo_acceso";
            }
            else
            {
                $query = $query . " $tableAnastasiadbSesiones.id DESC";
            }
        
            if ($begin >= 0)
            {
                $query = $query. " LIMIT " . strval($begin * $cantidad) . ", " . strval($cantidad+1);
            }
        
            $arrayAnastasiadbSesioness   = DatabaseManager::multiFetchAssoc($query);
            $anastasiadbsesiones_simples = array();
        
            if ($arrayAnastasiadbSesioness !== null)
            {
                $i = 0;
                foreach ($arrayAnastasiadbSesioness as $anastasiadbsesiones_simple) 
                {
                    if ($i == $cantidad && $begin >= 0)
                    {
                        continue;
                    }
        
                    $anastasiadbsesionesA = new AnastasiadbSesiones();
                    $anastasiadbsesionesA->fromArray($anastasiadbsesiones_simple);
                    $anastasiadbsesiones_simples[] = $anastasiadbsesionesA;
                    $i++;
                }
        
                return $anastasiadbsesiones_simples;
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
            $tableAnastasiadbSesiones  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_SESIONES');
        
            $query     = "SELECT $tableAnastasiadbSesiones.*
                          FROM $tableAnastasiadbSesiones
                          WHERE
                          (    $tableAnastasiadbSesiones.ip LIKE '%$string%' OR 
                               $tableAnastasiadbSesiones.host LIKE '%$string%' OR 
                               $tableAnastasiadbSesiones.ultimo_acceso LIKE '%$string%')
                          AND $tableAnastasiadbSesiones.activo = 'S'
                          LIMIT 50";
        
            $arrayAnastasiadbSesioness   = DatabaseManager::multiFetchAssoc($query);
            $anastasiadbsesiones_simples = array();
            $return         = array();
        
            if ($arrayAnastasiadbSesioness !== null)
            {
                foreach ($arrayAnastasiadbSesioness as $anastasiadbsesiones_simple)
                {
                    $anastasiadbsesiones = new AnastasiadbSesiones();
                    $anastasiadbsesiones->fromArray($anastasiadbsesiones_simple);
                    array_push($return, array('label' => $anastasiadbsesiones->toString(),
                            'id' => $anastasiadbsesiones->getId())
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
