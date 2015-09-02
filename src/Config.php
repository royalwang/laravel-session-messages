<?php
namespace Tarach\LSM;

class Config
{
    /**
     * Inversion of control container id
     */
    const IOC_ID = 'tlsm_config';
    /**
     * @see getPrefix()
     * @var string
     */
    private $prefix;
    
    // getters
    /**
     * Returns session variable prefix that all variables 
     * stored in session by this package should be prepended with
     * 
     * @return string
     */
    public function getPrefix()
    {
        if(!$this->prefix)
        {
            $this->prefix = config('tlsm.session_var_prefix', 'tlsm_message_');
        }
        return $this->prefix;
    }
    
    // setters
    /**
     * @see getPrefix()
     * @param string $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }
}