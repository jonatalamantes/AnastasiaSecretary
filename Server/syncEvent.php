<?php 

    require_once(__DIR__."/Backend/Controlers/ControladorAnastasiadbSesiones.php");
    require_once(__DIR__."/Backend/Controlers/ControladorAnastasiadbEventos.php");
    require_once(__DIR__."/Third-Party/AESCipher.php");

    $aes = new AESCipher();

    if (array_key_exists("data", $_POST) && $_POST["data"] != "")
    {
        $jsonData = $aes->decrypt($_POST["data"]);
        $jsonData = json_decode($jsonData);

        if (!empty($jsonData))
        {
            if (property_exists($jsonData, "token"))
            {
                $s  = ControladorAnastasiadbSesiones::getSingle(array("ip" => $_SERVER["REMOTE_ADDR"]));

                $f1 = date_create($s->getUltimoAcceso());
                $f2 = date_create(date("Y-m-d H:i:s"));

                $intervalo = date_diff($f2, $f1);
                $intervalo = $intervalo->format("%i:%s");
                
                if ($intervalo <= "06:00")
                {
                    echo $aes->encrypt("SESSION_TIMEOUT");
                    die;                    
                }
                else
                {
                    $s->setUltimoAcceso(date("Y-m-d H:i:s"));
                    ControladorAnastasiadbSesiones::update($s);

                    $event = ControladorAnastasiadbEventos::getSingle(array('estado' => 'creado'));

                    if ($event == NULL)
                    {
                        $event = json_encode(NULL);
                    }
                    else
                    {
                        $event = json_encode($event->toArray());
                    }

                    echo $aes->encrypt($event);
                    die;
                }
            }
        }
    }

    echo $aes->encrypt("INVALID_CLIENT");

 ?>