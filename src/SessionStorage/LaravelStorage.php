<?php
namespace Tarach\LSM\SessionStorage;

use Illuminate\Session\Store;

class LaravelStorage implements ISessionStorage
{
    /**
     * @var Store
     */
    private $Session;

    /**
     * @inheritdoc
     */
    public function get($name, $default = null)
    {
        return $this->getSession()->get($name, $default);
    }
    /**
     * @inheritdoc
     */
    public function has($name)
    {
        return $this->getSession()->has($name);
    }
    /**
     * @inheritdoc
     */
    public function remove($name)
    {
        $this->getSession()->remove($name);
    }
    /**
     * @inheritdoc
     */
    public function set($name, $data)
    {
        $this->getSession()->put($name, $data);
    }

    // getters
    /**
     * @return Store
     */
    public function getSession()
    {
        if(empty($this->Session))
        {
            $this->Session = session();
        }
        return $this->Session;
    }
    // setters
    /**
     * @param Store $Session
     * @return $this
     */
    public function setSession($Session)
    {
        $this->Session = $Session;
        return $this;
    }
}