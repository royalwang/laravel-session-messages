<?php
namespace Tarach\LSM\SessionStorage;

trait TStorageAccess
{
    /**
     * The session writer.
     *
     * @var ISessionStorage
     */
    private $SessionStorage;
    
    /**
     * @return ISessionStorage
     */
    public function getSessionStorage()
    {
        if(empty($this->SessionStorage))
        {
            $this->SessionStorage = app(ISessionStorage::IOC_ID);
        }
        return $this->SessionStorage;
    }
    /**
     * @param ISessionStorage $SessionStorage
     * @return $this
     */
    public function setSessionStorage(ISessionStorage $SessionStorage)
    {
        $this->SessionStorage = $SessionStorage;
        return $this;
    }
}
