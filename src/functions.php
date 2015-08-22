<?php
if(!function_exists('tlsm_messages'))
{
    /**
     * Access point for session messages
     *
     * @param  string|null $message         Notify 
     * @return \Tarach\LSM\Message\Collection
     */
    function tlsm_messages($message = null)
    {
        // get session message collection
        $SMC = app(\Tarach\LSM\Message\Collection::IOC_ID);

        if(!is_null($message))
        {
            return $SMC->notify($message);
        }
        return $SMC;
    }
}