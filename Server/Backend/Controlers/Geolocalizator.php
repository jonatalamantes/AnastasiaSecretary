<?php 

    /**
    * Class for geolozalization of adress and places
    */
    class Geolocalizator
    {
        static function geolizalizarIP($ipRes = "")
        {
            $ip = $ipRes;

            if ($ip == "")
            {
                $ip = $_SERVER["REMOTE_ADDR"];
            }

            $res = @file_get_contents("http://ip-api.com/json/$ip");

            if ($res == FALSE)
            {
                return NULL;
            }
            else
            {
                $array = json_decode($res);
                return $array;
            }
        }

        static function addressToLatitude($addr2 = "")
        {
            if ($addr2 == "")
            {
                return NULL;
            }

            $addr = str_replace(" ", "+", $addr2);

            $page  = "https://maps.googleapis.com/maps/api/geocode/json?address=";
            $page .= $addr . "&key=AIzaSyC7Qr0ybUKhMUeFhxZiksLATWDB7JHzVBI";

            $res = @file_get_contents($page);

            if ($res == FALSE)
            {
                return NULL;
            }
            else
            {
                $array = json_decode($res);
                return $array;
            }
        }

        static function latitudeToAddress($x = "", $y = "")
        {
            if ($x == "" || $y == "")
            {
                return NULL;
            }

            $page  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=";
            $page .= $addr . "$x,$y&key=AIzaSyC7Qr0ybUKhMUeFhxZiksLATWDB7JHzVBI";

            $res = @file_get_contents($page);

            if ($res == FALSE)
            {
                return NULL;
            }
            else
            {
                $array = json_decode($res);
                return $array;
            }
        }

        static function test()
        {
            echo "<pre>";

            print_r(self::geolizalizarIP("201.144.35.210"));
            print_r(self::addressToLatitude("Alvaro Alcazar 1480, Guadalajara, Mexico"));
            print_r(self::latitudeToAddress("20.7015624", "-103.3376534"));

            echo "</pre>";
        }
    }

 ?>