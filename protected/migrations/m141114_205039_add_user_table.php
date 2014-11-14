<?php

class m141114_205039_add_user_table extends CDbMigration
{
	public function up()
	{
        $this->execute(
            "CREATE TABLE IF NOT EXISTS `user` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              `email` varchar(255) NOT NULL,
              `password` varchar(255) NOT NULL,
              `date_add` datetime NOT NULL,
              `date_update` datetime,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        return true;
	}

	public function down()
	{
        $this->execute("DROP TABLE IF EXISTS `user`;");
		return true;
	}
}
