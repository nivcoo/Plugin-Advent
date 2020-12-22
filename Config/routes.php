<?php
Router::connect('/admin/advent', array('controller' => 'advent', 'action' => 'index', 'plugin' => 'advent', 'admin' => true));
Router::connect('/admin/advent/config', array('controller' => 'advent', 'action' => 'config', 'plugin' => 'advent', 'admin' => true));

Router::connect('/advent/check/:id', array('controller' => 'advent', 'action' => 'check', 'plugin' => 'advent'));