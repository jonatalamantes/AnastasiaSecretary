<?php 

    require_once(__DIR__."/../Classes/Log.php");
    require_once(__DIR__."/DatabaseManager.php");
    require_once(__DIR__."/WatashiEncrypt.php");
    
    /**
     * Clase para Manipular Objetos del Tipo Log
     */
    class ControladorLog
    {
        /**
         * Recupera un objeto de tipo Log
         */
        static function getSingle($keysValues = array())
        {
            if (!is_array($keysValues) || empty($keysValues))
            {
                return null;
            }
        
            $tableLog  = DatabaseManager::getNameTable('TABLE_LOG');
        
            $query     = "SELECT $tableLog.*
                          FROM $tableLog
                          WHERE ";
        
            foreach ($keysValues as $key => $value)
            {
                $query .= "$tableLog.$key = '$value' AND ";
            }
            
            $query = substr($query, 0, strlen($query)-4);
            $logA = null;
            
            $log_simple  = DatabaseManager::singleFetchAssoc($query);
            
            if ($log_simple !== null)
            {
                $logA = new Log();
                $logA->fromArray($log_simple);
            }
        
            return $logA;
        }
        
        /**
         * Recupera un objeto de tipo Log
         */
        static function getUltimo()
        {
            $tableLog  = DatabaseManager::getNameTable('TABLE_LOG');
        
            $query     = "SELECT $tableLog.*
                          FROM $tableLog
                          ORDER BY $tableLog.id DESC ";
        
            $log_simple  = DatabaseManager::singleFetchAssoc($query);
            $logA = null;
            
            if ($log_simple !== null)
            {
                $logA = new Log();
                $logA->fromArray($log_simple);
            }
        
            return $logA;
        }
        
        /**
         * Obtiene todos los logs de la tabla de logs
         */
        static function getAll($order = 'id', $begin = 0, $cantidad = 10)
        {
            $tableLog  = DatabaseManager::getNameTable('TABLE_LOG');
        
            $query     = "SELECT $tableLog.*
                          FROM $tableLog
                          WHERE $tableLog.activo = 'S'
                          ORDER BY ";
        
            if ($order == 'tsesionesUsuariosId')
            {
                $query = $query . " $tableLog.tsesiones_usuarios_id";
            }
            else if ($order == 'tipo')
            {
                $query = $query . " $tableLog.tipo";
            }
            else if ($order == 'consulta')
            {
                $query = $query . " $tableLog.query";
            }
            else
            {
                $query = $query . " $tableLog.id DESC";
            }
        
            if ($begin >= 0)
            {
                $query = $query. " LIMIT " . strval($begin * $cantidad) . ", " . strval($cantidad+1);
            }
        
            $arrayLogs   = DatabaseManager::multiFetchAssoc($query);
            $log_simples = array();
        
            if ($arrayLogs !== null)
            {
                $i = 0;
                foreach ($arrayLogs as $log_simple) 
                {
                    if ($i == $cantidad && $begin >= 0)
                    {
                        continue;
                    }
        
                    $logA = new Log();
                    $logA->fromArray($log_simple);
                    $log_simples[] = $logA;
                    $i++;
                }
        
                return $log_simples;
            }
            else
            {
                return null;
            }
        }
        
        /**
         * Inserta un elemento en la base de datos del tipo log
         */
        static function add($log = null)
        {
            if ($log === null)
            {
                return false;
            }

            $sesion = "NULL";

            if (array_key_exists("sesion_usuarios_id", $_SESSION))
            {
                $sesion = $_SESSION["sesion_usuarios_id"];
            }
        
            $opciones = array(
                'tsesiones_usuarios_id' => $sesion,
                'tipo'                  => $log->getTipo(),
                'consulta'              => $log->getQuery(),
                'activo'                => 'S'
            );
        
            $singleLog = self::getSingle($opciones);
        
            if ($singleLog == null || $singleLog->disimilitud($log) == 1)
            {
                $uid                   = WatashiEncrypt::uniqueKey();
                $sesiones_usuarios_id  = $sesion;
                $tipo                  = $log->getTipo();
                $query                 = $log->getQuery();
        
                $tableLog  = DatabaseManager::getNameTable('TABLE_LOG');
        
                $query   = "INSERT INTO $tableLog 
                            (uid, tsesiones_usuarios_id, tipo, 
                            consulta)
                            VALUES
                            ('$uid', $sesiones_usuarios_id, '$tipo', 
                            '$query')";
        
                if (DatabaseManager::singleAffectedRow($query) === true)
                {
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
         * Actualizar el Contenido de un objeto de tipo log
         */
        static function update($log = null)
        {
            if ($log === null)
            {
                return false;
            }
        
            $opciones = array('id' => $log->getId());
        
            $singleLog = self::getSingle($opciones);
        
            if ($singleLog->disimilitud($log) > 0)
            {
                $id                    = $log->getId();
                $uid                   = $log->getUid();
                $sesiones_usuarios_id  = $log->getSesionesUsuariosId();
                $tipo                  = $log->getTipo();
                $query                 = $log->getQuery();
        
                $tableLog  = DatabaseManager::getNameTable('TABLE_LOG');
        
                $opciones = array(
                    'tsesiones_usuarios_id' => $log->getSesionesUsuariosId(),
                    'tipo'                  => $log->getTipo(),
                    'consulta'              => $log->getQuery(),
                    'activo'                => 'S'
                );
        
                $singleLog = self::getSingle($opciones);
        
                if ($singleLog == null || $singleLog->disimilitud($log) == 1)
                {
                    $tableLog  = DatabaseManager::getNameTable('TABLE_LOG');
        
                    $query =   "UPDATE $tableLog
                                SET uid                   = '$uid',
                                    tsesiones_usuarios_id = '$sesiones_usuarios_id',
                                    tipo                  = '$tipo',
                                    consulta              = '$query',
                                    activo                = 'S'
                                WHERE $tableLog.id = '$id'";
        
                    if (DatabaseManager::singleAffectedRow($query) === true)
                    {
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
         * Recupera varios objeto de tipo Log
         */
        static function filter($keysValues = array(), $order = 'id', $begin = 0, $cantidad = 10, $exact = false)
        {
            if (!is_array($keysValues) || empty($keysValues))
            {
                return null;
            }
        
            $tableLog  = DatabaseManager::getNameTable('TABLE_LOG');
        
            $query     = "SELECT $tableLog.*
                          FROM $tableLog
                          WHERE $tableLog.activo = 'S' AND ";
        
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
            
            if ($order == 'tsesionesUsuariosId')
            {
                $query = $query . " $tableLog.tsesiones_usuarios_id";
            }
            else if ($order == 'tipo')
            {
                $query = $query . " $tableLog.tipo";
            }
            else if ($order == 'consulta')
            {
                $query = $query . " $tableLog.query";
            }
            else
            {
                $query = $query . " $tableLog.id DESC";
            }
        
            if ($begin >= 0)
            {
                $query = $query. " LIMIT " . strval($begin * $cantidad) . ", " . strval($cantidad+1);
            }
        
            $arrayLogs   = DatabaseManager::multiFetchAssoc($query);
            $log_simples = array();
        
            if ($arrayLogs !== null)
            {
                $i = 0;
                foreach ($arrayLogs as $log_simple) 
                {
                    if ($i == $cantidad && $begin >= 0)
                    {
                        continue;
                    }
        
                    $logA = new Log();
                    $logA->fromArray($log_simple);
                    $log_simples[] = $logA;
                    $i++;
                }
        
                return $log_simples;
            }
            else
            {
                return null;
            }
        }
        
        /**
         * Elimina logicamente un Log
         */
        static function remove($log = null)
        {
            if ($log === null)
            {
                return false;
            }
            else
            {
                $tableLog  = DatabaseManager::getNameTable('TABLE_LOG');
                $id = $log->getId();
                
                $query = "UPDATE $tableLog
                          SET activo = 'N' WHERE id = $id";
        
                return DatabaseManager::singleAffectedRow($query);
            }
        }
        /**
         * Obtiene los registros coincidentes de los logs de la tabla de logs
         */
        static function simpleSearch($string = '', $order = 'id', $begin = 0, $cantidad = 10)
        {
            $tableLog  = DatabaseManager::getNameTable('TABLE_LOG');
        
            $query     = "SELECT $tableLog.*
                          FROM $tableLog
                          WHERE
                          (    $tableLog.tsesiones_usuarios_id LIKE '%$string%' OR 
                               $tableLog.tipo LIKE '%$string%' OR 
                               $tableLog.query LIKE '%$string%')
                          AND $tableLog.activo = 'S'
                          ORDER BY ";
        
            if ($order == 'sesionesUsuariosId')
            {
                $query = $query . " $tableLog.sesiones_usuarios_id";
            }
            else if ($order == 'tipo')
            {
                $query = $query . " $tableLog.tipo";
            }
            else if ($order == 'consulta')
            {
                $query = $query . " $tableLog.query";
            }
            else
            {
                $query = $query . " $tableLog.id DESC";
            }
        
            if ($begin >= 0)
            {
                $query = $query. " LIMIT " . strval($begin * $cantidad) . ", " . strval($cantidad+1);
            }
        
            $arrayLogs   = DatabaseManager::multiFetchAssoc($query);
            $log_simples = array();
        
            if ($arrayLogs !== null)
            {
                $i = 0;
                foreach ($arrayLogs as $log_simple) 
                {
                    if ($i == $cantidad && $begin >= 0)
                    {
                        continue;
                    }
        
                    $logA = new Log();
                    $logA->fromArray($log_simple);
                    $log_simples[] = $logA;
                    $i++;
                }
        
                return $log_simples;
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
            $tableLog  = DatabaseManager::getNameTable('TABLE_LOG');
        
            $query     = "SELECT $tableLog.*
                          FROM $tableLog
                          WHERE
                          (    $tableLog.tsesiones_usuarios_id LIKE '%$string%' OR 
                               $tableLog.tipo LIKE '%$string%' OR 
                               $tableLog.query LIKE '%$string%')
                          AND $tableLog.activo = 'S'
                          LIMIT 50";
        
            $arrayLogs   = DatabaseManager::multiFetchAssoc($query);
            $log_simples = array();
            $return         = array();
        
            if ($arrayLogs !== null)
            {
                foreach ($arrayLogs as $log_simple)
                {
                    $log = new Log();
                    $log->fromArray($log_simple);
                    array_push($return, array('label' => $log->toString(),
                            'id' => $log->getId())
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
