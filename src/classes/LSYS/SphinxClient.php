<?php
/**
 * lsys service
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS;
if (!class_exists('\SphinxClient')){
    require_once dirname(__FILE__).'/../../libs/sphinxapi.php';
}
class SphinxClient extends \SphinxClient{
    /**
     * @var Config
     */
    protected $_config;
    public function __construct(Config $config)
    {
        parent::__construct();
        $_config=$config->asArray()+array(
            'host'			=>	'localhost',
            'port'			=>	9312,
            'timeout'		=>	1,
            'query_time'	=>	1000,
        );
        $this->setServer($_config['host'],$_config['port']);
        $this->SetConnectTimeout ( $_config['timeout']);
        $this->SetMaxQueryTime($_config['query_time']);
        $this->SetArrayResult ( true );
        $this->_config=$config;
    }
    
    public function GetLastError():string{
        $message=parent::GetLastError();
        if (DIRECTORY_SEPARATOR === '\\'&&$this->_isGb2312($message)){
            if(PHP_SAPI!=='cli'||PHP_SAPI==='cli'&&version_compare(PHP_VERSION,'7.0.0',">=")){
                $message=iconv("gb2312", "utf-8",$message);//windows in china : cover string
            }
        }
        return (string)$message;
    }
    private function _isGb2312($str)
    {
        for($i=0; $i<strlen($str); $i++) {
            $v = ord( $str[$i] );
            if( $v > 127) {
                if( ($v >= 228) && ($v <= 233) )
                {
                    if(($i+2) >= (strlen($str)- 1)) return true;  // not enough characters
                    $v1 = ord( $str[$i+1] );
                    $v2 = ord( $str[$i+2] );
                    if( ($v1 >= 128) && ($v1 <=191) && ($v2 >=128) && ($v2 <= 191) ) // utf编码
                        return false;
                        else
                            return true;
                }
            }
        }
        return true;
    }
}