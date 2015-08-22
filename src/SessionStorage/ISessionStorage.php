<?php 
namespace Tarach\LSM\SessionStorage;

interface ISessionStorage
{
    /**
     * Inversion of control container id
     */
    const IOC_ID = 'tlsm_session_storage';
    
    /**
     * Returns an attribute.
     * 
     * @param   string    $name     The attribute name
     * @param   mixed     $default  Default value to be returned
     * @return mixed
     */
    public function get($name, $default = null);
    /**
     * Checks if an attribute is defined.
     * 
     * @param   string    $name     The attribute name
     * @return bool
     */
    public function has($name);
    /**
     * Removes attribute with the given name.
     * 
     * @param string $name
     * @return mixed
     */
    public function remove($name);
    /**
     * Set data to session store
     *
     * @param string            $name   The attribute name
     * @param array|string|int  $data   Data to store
     */
    public function set($name, $data);
} 