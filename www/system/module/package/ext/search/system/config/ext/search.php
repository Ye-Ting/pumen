<?php
define('TABLE_SEARCH_INDEX',    $config->db->prefix . 'search_index');
define('TABLE_SEARCH_DICT',    $config->db->prefix . 'search_dict');

$config->rights->guest['search']['index'] = 'index';
