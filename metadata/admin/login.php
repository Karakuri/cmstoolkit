<?php

return array(
    'view' => array(
        'path' => 'pages/admin/login.html',
    ),
    
    'snippets' => array(
        'login_form' => array(
            'preload' => 'login_form',
            'options' => array(
                'auth' => 'admin',
                'credentials' => 'default',
                'redirect_to' => 'admin',
            ),
        )
    )
);