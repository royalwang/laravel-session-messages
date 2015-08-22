<?php
namespace Tarach\LSM\Controllers;

class RemoveMessage extends AController
{
    public function exec($id)
    {
        $Message = new \Tarach\LSM\Message\Message($id);
        
        if($Message->exists())
        {
            $Message->remove();
        }
        return '';
    }
}
