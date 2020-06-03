--
-- Data Base: `login`
--
CREATE DATABASE IF NOT EXISTS `login` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `login`;

-- --------------------------------------------------------

--
-- Table Structure: `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Table Structure: `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `pass` varchar(130) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` varchar(80) NOT NULL,
  `phone` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `last_session` datetime DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `token` varchar(40) NOT NULL,
  `token_password` varchar(100) DEFAULT NULL,
  `password_request` int(11) DEFAULT '0',
  `user_type` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

--
-- Table Index `user_type`
--
ALTER TABLE `user_type` ADD PRIMARY KEY (`id`);

--
-- Table Index `users`
--
ALTER TABLE `users` ADD PRIMARY KEY (`id`);

--
-- Table AUTO_INCREMENT: `user_type`
--
ALTER TABLE `user_type` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Table AUTO_INCREMENT: `users`
--
ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;