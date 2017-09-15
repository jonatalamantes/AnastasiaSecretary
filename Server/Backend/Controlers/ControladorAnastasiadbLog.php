<?php 

    require_once(__DIR__."/../Classes/AnastasiadbLog.php");
    require_once(__DIR__."/DatabaseManager.php");
    require_once(__DIR__."/WatashiEncrypt.php");
    require_once(__DIR__."/ControladorAnastasiadbSesiones.php");
    
    /**
     * Clase para Manipular Objetos del Tipo AnastasiadbLog
     */
    class ControladorAnastasiadbLog
    {
        /**
         * Recupera un objeto de tipo AnastasiadbLog
         */
        static function getSingle($keysValues = array())
        {
            if (!is_array($keysValues) || empty($keysValues))
            {
                return null;
            }
        
            $tableAnastasiadbLog  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_LOG');
        
            $query     = "SELECT $tableAnastasiadbLog.*
                          FROM $tableAnastasiadbLog
                          WHERE $tableAnastasiadbLog.activo='S'
                          AND ";
        
            foreach ($keysValues as $key => $value)
            {
                $query .= "$tableAnastasiadbLog.$key = '$value' AND ";
            }
            
            $query = substr($query, 0, strlen($query)-4);
            $query .= " ORDER BY $tableAnastasiadbLog.id DESC";

            $anastasiadblogA = null;
            
            $anastasiadblog_simple  = DatabaseManager::singleFetchAssoc($query);
            
            if ($anastasiadblog_simple !== null)
            {
                $anastasiadblogA = new AnastasiadbLog();
                $anastasiadblogA->fromArray($anastasiadblog_simple);
            }
        
            return $anastasiadblogA;
        }
        
        /**
         * Recupera un objeto de tipo AnastasiadbLog
         */
        static function getUltimo()
        {
            $tableAnastasiadbLog  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_LOG');
        
            $query     = "SELECT $tableAnastasiadbLog.*
                          FROM $tableAnastasiadbLog
                          ORDER BY $tableAnastasiadbLog.id DESC ";
        
            $anastasiadblog_simple  = DatabaseManager::singleFetchAssoc($query);
            $anastasiadblogA = null;
            
            if ($anastasiadblog_simple !== null)
            {
                $anastasiadblogA = new AnastasiadbLog();
                $anastasiadblogA->fromArray($anastasiadblog_simple);
            }
        
            return $anastasiadblogA;
        }
        
        /**
         * Obtiene todos los anastasiadblogs de la tabla de anastasiadblogs
         */
        static function getAll($order = 'id', $begin = 0, $cantidad = 10)
        {
            $tableAnastasiadbLog  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_LOG');
        
            $query     = "SELECT $tableAnastasiadbLog.*
                          FROM $tableAnastasiadbLog
                          WHERE $tableAnastasiadbLog.activo = 'S'
                          ORDER BY ";
        
            if ($order == 'idSesiones')
            {
                $query = $query . " $tableAnastasiadbLog.idSesiones";
            }
            else if ($order == 'tipo')
            {
                $query = $query . " $tableAnastasiadbLog.tipo";
            }
            else if ($order == 'consulta')
            {
                $query = $query . " $tableAnastasiadbLog.consulta";
            }
            else
            {
                $query = $query . " $tableAnastasiadbLog.id DESC";
            }
        
            if ($begin >= 0)
            {
                $query = $query. " LIMIT " . strval($begin * $cantidad) . ", " . strval($cantidad+1);
            }
        
            $arrayAnastasiadbLogs   = DatabaseManager::multiFetchAssoc($query);
            $anastasiadblog_simples = array();
        
            if ($arrayAnastasiadbLogs !== null)
            {
                $i = 0;
                foreach ($arrayAnastasiadbLogs as $anastasiadblog_simple) 
                {
                    if ($i == $cantidad && $begin >= 0)
                    {
                        continue;
                    }
        
                    $anastasiadblogA = new AnastasiadbLog();
                    $anastasiadblogA->fromArray($anastasiadblog_simple);
                    $anastasiadblog_simples[] = $anastasiadblogA;
                    $i++;
                }
        
                return $anastasiadblog_simples;
            }
            else
            {
                return null;
            }
        }
        
        /**
         * Inserta un elemento en la base de datos del tipo anastasiadblog
         */
        static function add($anastasiadblog = null)
        {
            if ($anastasiadblog === null)
            {
                return false;
            }

            $idSesiones = ControladorAnastasiadbSesiones::getSingle(array('ip' => $_SERVER["REMOTE_ADDR"]));

            if ($idSesiones == NULL)
            {
                $idSesiones = "NULL";
            }
            else
            {
                $idSesiones = $idSesiones->getId();
            }

            $uid            = WatashiEncrypt::uniqueKey();
            $tipo           = $anastasiadblog->getTipo();
            $consulta       = $anastasiadblog->getConsulta();
    
            $tableAnastasiadbLog  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_LOG');
    
            $query   = "INSERT INTO $tableAnastasiadbLog 
                        (uid, idSesiones, tipo, 
                        consulta)
                        VALUES
                        ('$uid', $idSesiones, '$tipo', 
                        '$consulta')";
    
            if (DatabaseManager::singleAffectedRow($query) === true)
            {
                return $uid;
            }
            else
            {
                return false;
            }
        }
        
        /**
         * Actualizar el Contenido de un objeto de tipo anastasiadblog
         */
        static function update($anastasiadblog = null)
        {
            if ($anastasiadblog === null)
            {
                return false;
            }
        
            $opciones = array('id' => $anastasiadblog->getId());
        
            $singleAnastasiadbLog = self::getSingle($opciones);
        
            if ($singleAnastasiadbLog->disimilitud($anastasiadblog) > 0)
            {
                $id             = $anastasiadblog->getId();
                $uid            = $anastasiadblog->getUid();
                $idSesiones     = $anastasiadblog->getIdSesiones();
                $tipo           = $anastasiadblog->getTipo();
                $consulta       = $anastasiadblog->getConsulta();
        
                $tableAnastasiadbLog  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_LOG');
        
                $opciones = array(
                    'idSesiones'     => $anastasiadblog->getIdSesiones(),
                    'tipo'           => $anastasiadblog->getTipo(),
                    'consulta'       => $anastasiadblog->getConsulta(),
                    'activo'         => 'S'
                );
        
                $singleAnastasiadbLog = self::getSingle($opciones);
        
                if ($singleAnastasiadbLog == null || $singleAnastasiadbLog->disimilitud($anastasiadblog) == 1)
                {
                    $tableAnastasiadbLog  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_LOG');
        
                    $query =   "UPDATE $tableAnastasiadbLog
                                SET uid            = '$uid',
                                    idSesiones     = '$idSesiones',
                                    tipo           = '$tipo',
                                    consulta       = '$consulta',
                                    activo         = 'S'
                                WHERE $tableAnastasiadbLog.id = '$id'";
        
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
         * Recupera varios objeto de tipo AnastasiadbLog
         */
        static function filter($keysValues = array(), $order = 'id', $begin = 0, $cantidad = 10, $exact = false)
        {
            if (!is_array($keysValues) || empty($keysValues))
            {
                return null;
            }
        
            $tableAnastasiadbLog  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_LOG');
        
            $query     = "SELECT $tableAnastasiadbLog.*
                          FROM $tableAnastasiadbLog
                          WHERE $tableAnastasiadbLog.activo = 'S' AND ";
        
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
            
            if ($order == 'idSesiones')
            {
                $query = $query . " $tableAnastasiadbLog.idSesiones";
            }
            else if ($order == 'tipo')
            {
                $query = $query . " $tableAnastasiadbLog.tipo";
            }
            else if ($order == 'consulta')
            {
                $query = $query . " $tableAnastasiadbLog.consulta";
            }
            else
            {
                $query = $query . " $tableAnastasiadbLog.id DESC";
            }
        
            if ($begin >= 0)
            {
                $query = $query. " LIMIT " . strval($begin * $cantidad) . ", " . strval($cantidad+1);
            }
        
            $arrayAnastasiadbLogs   = DatabaseManager::multiFetchAssoc($query);
            $anastasiadblog_simples = array();
        
            if ($arrayAnastasiadbLogs !== null)
            {
                $i = 0;
                foreach ($arrayAnastasiadbLogs as $anastasiadblog_simple) 
                {
                    if ($i == $cantidad && $begin >= 0)
                    {
                        continue;
                    }
        
                    $anastasiadblogA = new AnastasiadbLog();
                    $anastasiadblogA->fromArray($anastasiadblog_simple);
                    $anastasiadblog_simples[] = $anastasiadblogA;
                    $i++;
                }
        
                return $anastasiadblog_simples;
            }
            else
            {
                return null;
            }
        }
        
        /**
         * Elimina logicamente un AnastasiadbLog
         */
        static function remove($anastasiadblog = null)
        {
            if ($anastasiadblog === null)
            {
                return false;
            }
            else
            {
                $tableAnastasiadbLog  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_LOG');
                $id = $anastasiadblog->getId();
                
                $query = "UPDATE $tableAnastasiadbLog
                          SET activo = 'N' WHERE id = $id";
        
                return DatabaseManager::singleAffectedRow($query);
            }
        }
        /**
         * Obtiene los registros coincidentes de los anastasiadblogs de la tabla de anastasiadblogs
         */
        static function simpleSearch($string = '', $order = 'id', $begin = 0, $cantidad = 10)
        {
            $tableAnastasiadbLog  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_LOG');
        
            $query     = "SELECT $tableAnastasiadbLog.*
                          FROM $tableAnastasiadbLog
                          WHERE
                          (    $tableAnastasiadbLog.idSesiones LIKE '%$string%' OR 
                               $tableAnastasiadbLog.tipo LIKE '%$string%' OR 
                               $tableAnastasiadbLog.consulta LIKE '%$string%')
                          AND $tableAnastasiadbLog.activo = 'S'
                          ORDER BY ";
        
            if ($order == 'idSesiones')
            {
                $query = $query . " $tableAnastasiadbLog.idSesiones";
            }
            else if ($order == 'tipo')
            {
                $query = $query . " $tableAnastasiadbLog.tipo";
            }
            else if ($order == 'consulta')
            {
                $query = $query . " $tableAnastasiadbLog.consulta";
            }
            else
            {
                $query = $query . " $tableAnastasiadbLog.id DESC";
            }
        
            if ($begin >= 0)
            {
                $query = $query. " LIMIT " . strval($begin * $cantidad) . ", " . strval($cantidad+1);
            }
        
            $arrayAnastasiadbLogs   = DatabaseManager::multiFetchAssoc($query);
            $anastasiadblog_simples = array();
        
            if ($arrayAnastasiadbLogs !== null)
            {
                $i = 0;
                foreach ($arrayAnastasiadbLogs as $anastasiadblog_simple) 
                {
                    if ($i == $cantidad && $begin >= 0)
                    {
                        continue;
                    }
        
                    $anastasiadblogA = new AnastasiadbLog();
                    $anastasiadblogA->fromArray($anastasiadblog_simple);
                    $anastasiadblog_simples[] = $anastasiadblogA;
                    $i++;
                }
        
                return $anastasiadblog_simples;
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
            $tableAnastasiadbLog  = DatabaseManager::getNameTable('TABLE_ANASTASIADB_LOG');
        
            $query     = "SELECT $tableAnastasiadbLog.*
                          FROM $tableAnastasiadbLog
                          WHERE
                          (    $tableAnastasiadbLog.idSesiones LIKE '%$string%' OR 
                               $tableAnastasiadbLog.tipo LIKE '%$string%' OR 
                               $tableAnastasiadbLog.consulta LIKE '%$string%')
                          AND $tableAnastasiadbLog.activo = 'S'
                          LIMIT 50";
        
            $arrayAnastasiadbLogs   = DatabaseManager::multiFetchAssoc($query);
            $anastasiadblog_simples = array();
            $return         = array();
        
            if ($arrayAnastasiadbLogs !== null)
            {
                foreach ($arrayAnastasiadbLogs as $anastasiadblog_simple)
                {
                    $anastasiadblog = new AnastasiadbLog();
                    $anastasiadblog->fromArray($anastasiadblog_simple);
                    array_push($return, array('label' => $anastasiadblog->toString(),
                            'id' => $anastasiadblog->getId())
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
