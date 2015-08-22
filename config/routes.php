<?php

Route::group(
    ['as'        => 'tlsm.',
     'prefix'    => 'session_message',
     'namespace' => 'Tarach\LSM\Controllers'],
    function()
    {
        Route::any('remove/{id}',  ['as'   => 'remove',
                                    'uses' => 'RemoveMessage@exec']);
    });