DROP DATABASE IF EXISTS `learn-fargate`;

CREATE DATABASE IF NOT EXISTS `learn-fargate` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL ON `learn-fargate`.* to 'admin'@'%' IDENTIFIED BY 'dbfoijd2ioaoi32joj9sd';