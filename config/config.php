<?php

/**
 * This class contains the function to connect to the database 
 * 
 */
class AppConfig {
    /* CONECTION FUNCTIONS */
    public function connect( $dbname = FALSE, $server = "production" )
    {
        if( isset($_SERVER['SERVER_NAME']) )
        {
            if($_SERVER['SERVER_NAME'] != 'localhost')
            {
                if( isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == "dev-form.populetic.com" )
                {
                    /* DEVELOPMENT SERVER */
                    $servername = "127.0.0.1"; 
                    $username = "root";
                    $password = "p0pprdfr0nt";
                }
                else
                {        
                    $ip = shell_exec("/sbin/ifconfig  | grep 'inet '| grep -v '127.0.0.1' | cut -d: -f2 | awk '{ print $1}'");
                    $ip = str_replace(PHP_EOL, '', $ip);

                    if( $ip == "172.31.41.83" ) //IP DE DESARROLLO
                    {
                        /* DEVELOPMENT SERVER */
                        $servername = "127.0.0.1"; 
                        $username = "root";
                        $password = "p0pprdfr0nt";
                    }
                    else 
                    {
                        $username = "populetic";
                        $password = "p0pprdfr0nt";
                        
                        /* PRODUCTION SERVER */
                        switch( $server )
                        {
                            case "production":
                                $servername = "production-database.cjytdcwzxu1j.us-east-2.rds.amazonaws.com";          
                                break;
                            case "replica":
                                $servername = "populetic-datawarehouse.cjytdcwzxu1j.us-east-2.rds.amazonaws.com";
                                break;
                            default:
                                $servername = "production-database.cjytdcwzxu1j.us-east-2.rds.amazonaws.com";
                                break;
                        }
                    }
                }
            } 
            else 
            {
                /* LOCALHOST*/
                $servername = "127.0.0.1";
                $username   = "root";
                $password   = "";
            }
        } 
        else 
        {
            if (substr(php_uname(), 0, 7) == "Windows")
            {
                /* LOCALHOST*/
                $servername = "127.0.0.1";
                $username   = "root";
                $password   = "";
            }
            else
            {
                if( isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == "dev-form.populetic.com" )
                {
                    /* DEVELOPMENT SERVER */
                    $servername = "127.0.0.1"; 
                    $username = "root";
                    $password = "p0pprdfr0nt";
                }
                else
                {               
                    $ip = shell_exec("/sbin/ifconfig  | grep 'inet '| grep -v '127.0.0.1' | cut -d: -f2 | awk '{ print $1}'");
                    $ip = str_replace(PHP_EOL, '', $ip);

                    if( $ip == "172.31.41.83" ) //IP DE DESARROLLO
                    {
                        /* DEVELOPMENT SERVER */
                        $servername = "127.0.0.1"; 
                        $username = "root";
                        $password = "p0pprdfr0nt";
                    }   
                    else 
                    {
                        /* SERVER */
                        $username = "populetic";
                        $password = "p0pprdfr0nt";
                
                        switch( $server )
                        {
                            case "production":
                                $servername = "production-database.cjytdcwzxu1j.us-east-2.rds.amazonaws.com";          
                                break;
                            case "replica":
                                $servername = "populetic-datawarehouse.cjytdcwzxu1j.us-east-2.rds.amazonaws.com";
                                break;
                            default:
                                $servername = "production-database.cjytdcwzxu1j.us-east-2.rds.amazonaws.com";
                                break;
                        }
                    }
                }
            }
        }

        if( !isset($dbname) || $dbname === FALSE )
            $dbname = "populetic_form";

        //echo "servername: " . $servername . " - ";
        //echo "username: " . $username . " - ";
        //echo "password: " . $password . " - ";
        //echo "dbname: " . $dbname;
        //exit();

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if( $conn->connect_error ) 
        {
            die("Connection failed (".$servername.") : " . $conn->connect_error);
        }
        else
        {
            return $conn;
        }
    }



    /**
     * Class to close the connectiong with mysql
     */
    public function closeConnection($conn) {
        mysqli_close($conn);
    }
}
