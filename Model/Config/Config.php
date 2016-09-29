<?php

namespace Model\Config;

Class Config
{

    private $config;

    public function __construct( )
    {
        // config is an array
        $this->config = array( "ServerName" => "localhost" , "Password" => "" , "UserName" => "root" , "Port" =>"3360" , "DBName" => "OdnoosUsers");


    }

    public function getConfig()
    {
        // return config array
        return $this->config;
    }

}