delete from `#__menu` where `link` = 'index.php?option=com_sfg' or `link` like 'index.php?option=com_sfg&%';

update `#__menu` set `client_id`=1 where `link` = 'index.php?option=com_sfg_installer';

update `#__extensions` set `protected`=0 where `element` = 'com_sfg_installer';

delete from `#__extensions` where `element` = 'sfg' or `element` = 'mod_sfg';

