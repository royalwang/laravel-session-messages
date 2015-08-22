<?php
if(!function_exists('session_message'))
{
    /**
     * Access point for session messages
     *
     * @param  string|null $message         Notify 
     * @return \Tarach\LSM\Message\Collection
     */
    function tlsm_session_message($message = null)
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