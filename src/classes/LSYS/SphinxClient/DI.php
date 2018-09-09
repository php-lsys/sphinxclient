<?php
namespace LSYS\SphinxClient;
/**
 * @method \LSYS\SphinxClient sphinx_client($config=null)
 */
class DI extends \LSYS\DI{
    /**
     *
     * @var string default config
     */
    public static $config = 'sphinx.plain';
    /**
     * @return static
     */
    public static function get(){
        $di=parent::get();
        !isset($di->sphinx_client)&&$di->sphinx_client(new \LSYS\DI\ShareCallback(function($config=null){
            return $config?$config:self::$config;
        },function($config=null){
            $config=\LSYS\Config\DI::get()->config($config?$config:self::$config);
            return new \LSYS\SphinxClient($config);
        }));
        return $di;
    }
}