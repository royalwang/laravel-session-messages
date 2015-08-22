<?php
namespace Tarach\LSM\Controllers;

class RemoveMessage extends AController
{
    public function exec($id)
    {
        $Message = new \Tarach\LSM\Message\Message($id, tlsm_session_message());
        
        if($Message->exists())
        {
            $Message->remove();
        }
        return '';
    }
}
