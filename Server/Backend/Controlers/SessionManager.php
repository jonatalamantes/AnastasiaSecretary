<?php 
    
    if(session_id() == '' || !isset($_SESSION)) 
    { 
        session_start(); 
    }

    require_once("LanguageSupport.php");

    /**
    * Class for manipulate User Objects
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class SessionManager
    {
        /**
         * Get the last page $_SESSION
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return string   The past page
         */
        static function getLastPage()
        {

            if (isset($_SESSION) && array_key_exists("last_page", $_SESSION))
            {
                return $_SESSION["last_page"];
            }

            return "";

        }

        /**
         * Get the current page $_SESSION
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return string   The current page
         */
        static function getCurrentPage()
        {
            if (isset($_SESSION) && array_key_exists("curr_page", $_SESSION))
            {
                return $_SESSION["curr_page"];
            }

            return "";            
        }

        /**
         * Get the last query $_SESSION
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return string   The last query
         */
        static function getLastQuery()
        {
            if (isset($_SESSION) && array_key_exists("last_query", $_SESSION))
            {
                return $_SESSION["last_query"];
            }

            return "";          
        }

        /**
         * Change the last query on the database
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @return string   $newQuery   The new query
         */
        static function setLastQuery($newQuery = "")
        {
            if (isset($_SESSION) && array_key_exists("last_query", $_SESSION))
            {
                $_SESSION["last_query"] = $newQuery;
            }

            return "";          
        }

        /**
         * Validate the user in the actual page, if not user, move to index page
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  string    $type   The actual type
         */
        static function validateUserInPage($type = "", $json = FALSE)
        {
            require(__DIR__."/Geolocalizator.php");
            require(__DIR__."/ControladorSesionesUsuarios.php");

            /*$script  = json_encode(array('status'=>'INVALID_TOKEN'));
            $tiempoC = 1800; //media hora

            $clientToken = self::getCookierTk();

            if (!$json)
            {
                $script = "<script>window.location.href='login.php'</script>";
            }

            if ($type == "login")
            {                
                setcookie("_tk", "", time()-600);
                session_destroy();

                $ip = $_SERVER["REMOTE_ADDR"];

                $white = ControladorSesionesUsuarios::getSingle(array('ip' => $ip));

                if ($white == NULL)
                {
                    if (strpos($ip, "192.168") !== FALSE &&
                        strpos($ip, "10.15.5") !== FALSE &&
                        strpos($ip, "127.0.0") !== FALSE)
                    {
                        $loc = Geolocalizator::geolizalizarIP($ip);

                        if ($loc->region != "JAL")
                        {
                            echo "Hola Mundo";
                            die;
                        }
                    }
                }
            }
            else if ($type == "main")
            {
                if (array_key_exists("_tk", $_GET))
                {
                    if ($_GET["_tk"] == $_SESSION["_tk"])
                    {
                        setcookie("_tk", $_SESSION["_tk"], time()+$tiempoC);
                        echo "<script>window.location.href='principal.php'</script>";
                        die;
                    }
                    else
                    {
                        echo "<script>window.location.href='login.php'</script>";
                        die;
                    }
                }
                else
                {
                    if (array_key_exists("_tk", $_SESSION) &&
                        $clientToken == $_SESSION["_tk"])
                    {
                        setcookie("_tk", $_SESSION["_tk"], time()+$tiempoC);
                    }
                    else
                    {
                        echo $script;
                        die;
                    }
                }
            }
            else if (strtolower($type) == "operativo")
            {
                if (array_key_exists("_tk", $_SESSION) && 
                    $clientToken == $_SESSION["_tk"] && 
                    $_SESSION["tipo"] !== "")
                {
                    setcookie("_tk", $_SESSION["_tk"], time()+$tiempoC);
                }
                else
                {
                    echo $script;
                    die;
                }
            }
            else if (strtolower($type) == "admin")
            {
                if (array_key_exists("_tk", $_SESSION) &&
                    $clientToken == $_SESSION["_tk"] && 
                    strpos($_SESSION["tipo"], "ADMIN") !== FALSE)
                {
                    setcookie("_tk", $_SESSION["_tk"], time()+$tiempoC);
                }
                else
                {
                    echo $script;
                    die;
                }
            }
            else if (strtolower($type) == "superadmin")
            {
                if (array_key_exists("_tk", $_SESSION) &&
                    $clientToken == $_SESSION["_tk"] && 
                    strpos($_SESSION["tipo"], "SUPERADMIN") !== FALSE)
                {
                    setcookie("_tk", $_SESSION["_tk"], time()+$tiempoC);
                }
                else
                {
                    echo $script;
                    die;
                }
            }
            else
            {
                echo $script;
                die;            
            }

            if ($type !== "login")
            {
            	ControladorSesionesUsuarios::updateTime($_SESSION["_tk"]);

	            if (!array_key_exists("curr_page", $_SESSION) ||
                    $_SESSION["curr_page"] != $_SERVER['REQUEST_URI'])
	            {
	                $_SESSION["last_page"] = SessionManager::getCurrentPage();
	                $_SESSION["curr_page"] = $_SERVER['REQUEST_URI'];
	            }
            }*/
        }
    }

 ?>