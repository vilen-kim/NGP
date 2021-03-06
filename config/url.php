<?php

return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',
        'show' => 'site/show',
        'login' => 'auth/login',
        'logout' => 'auth/logout',
        'register' => 'auth/register',
        'activate' => 'auth/activate',
        'forgotPassword' => 'auth/forgot-pass',
        'newPassword' => 'auth/new-password',
    ],
];
