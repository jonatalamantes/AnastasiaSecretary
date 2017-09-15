<?php 

    require_once(__DIR__."/Backend/Controlers/ControladorAnastasiadbSesiones.php");
    require_once(__DIR__."/Third-Party/AESCipher.php");

    $aes = new AESCipher();

    if (array_key_exists("data", $_POST) && $_POST["data"] != "")
    {
        $jsonData = $aes->decrypt($_POST["data"]);
        $jsonData = json_decode($jsonData);

        if (!empty($jsonData))
        {
            if (property_exists($jsonData, "username") && 
                property_exists($jsonData, "password"))
            {
                if ($jsonData->username == "AnastasiaClient" &&
                    $jsonData->password == "AnastasiaIsLove")
                {
                    $obj = new AnastasiadbSesiones();
                    $obj->setIp($_SERVER["REMOTE_ADDR"]);
                    $obj->setHost(gethostbyaddr($_SERVER["REMOTE_ADDR"]));
                    $obj->setUltimoAcceso(date("y-m-d H:i:s"));

                    $uid = ControladorAnastasiadbSesiones::add($obj);

                    if ($uid == NULL)
                    {
                        echo $aes->encrypt("INVALID_CLIENT");
                    }
                    else
                    {
                        echo $aes->encrypt($uid);
                    }

                    die;
                }
            }
        }
    }

    echo $aes->encrypt("INVALID_CLIENT");

 ?>