<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
//        $this->email->initialize($config);