DROP DATABASE IF EXISTS `learn-fargate`;
CREATE DATABASE IF NOT EXISTS `learn-fargate` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL ON `learn-fargate`.* to 'admin'@'%' IDENTIFIED BY 'dbfoijd2ioaoi32joj9sd';

DROP DATABASE IF EXISTS `learn-fargate-test`;
CREATE DATABASE IF NOT EXISTS `learn-fargate-test` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL ON `learn-fargate-test`.* to 'test'@'%' IDENTIFIED BY 'fd289gbng84kjndaa903';