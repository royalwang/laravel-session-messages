<?php
namespace Tarach\LSM;

trait TConfigAccess
{
    /**
     * @var Config
     */
    private $Config;
    /**
     * @return Config
     */
    public function getConfig()
    {
        if(!$this->Config)
        {
            $this->Config = app(Config::IOC_ID);
        }
        return $this->Config;
    }
    /**
     * @param Config $C
     * @return $this
     */
    public function setConfig(Config $C)
    {
        $this->Config = $C;
        return $this;
    }
}