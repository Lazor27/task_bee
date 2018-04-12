<?php

Config::set('site_name','TASKS');
Config::set(
    'routes', array (
        'default'   => '',
        'admin'     => 'admin_',
        'user'      => 'user_'
        )
);

Config::set('default_router'    ,'default');
Config::set('default_controller','tasks');
Config::set('default_action'    ,'start');


Config::set('db.host'    ,'localhost');
Config::set('db.user'    ,'root');
Config::set('db.password','');
Config::set('db.name'    ,'test');


Config::set('salt', 'eriu35356y23yiuio3445');
