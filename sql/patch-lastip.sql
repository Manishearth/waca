ALTER TABLE `acc_user` 
  ADD `user_lastip` VARCHAR( 15 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `user_lastactive`;