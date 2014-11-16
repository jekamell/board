<?php

class m141116_214046_add_user_hash_confirm extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `user` ADD COLUMN `hash_confirm` VARCHAR(255) DEFAULT NULL AFTER `is_confirmed`;");
        return true;
	}

	public function down()
	{
		$this->execute("ALTER TABLE `user` DROP COLUMN `hash_confirm`");
	}
}
