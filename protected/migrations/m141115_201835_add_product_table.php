<?php

class m141115_201835_add_product_table extends CDbMigration
{
	public function up()
	{
        $this->execute(
            "CREATE TABLE IF NOT EXISTS `product` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `title` varchar(255) NOT NULL,
              `price` decimal(12, 2 ) NOT NULL,
              `is_deleted` tinyint(1) default 0,
              `user_id` int(11) UNSIGNED NOT NULL,
              `date_add` datetime NOT NULL,
              `date_update` datetime DEFAULT NULL,
              PRIMARY KEY (`id`),
              FOREIGN KEY (`user_id`) REFERENCES user(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        return true;
	}

	public function down()
	{
		$this->execute("DROP TABLE IF EXISTS `product`");

		return true;
	}
}
