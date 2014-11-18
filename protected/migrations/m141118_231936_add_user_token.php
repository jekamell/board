<?php

class m141118_231936_add_user_token extends CDbMigration
{
    public function up()
    {
        $transaction = $this->dbConnection->beginTransaction();
        try {
            $this->execute("ALTER TABLE `user` ADD COLUMN `token` VARCHAR(255) DEFAULT NULL AFTER `hash_confirm`;");
            $this->execute("ALTER TABLE `user` ADD INDEX `token` (`token`)");
        } catch (Exception $e) {
            echo $e->getMessage();
            $transaction->rollback();

            return false;
        }
        $transaction->commit();

        return true;
    }

    public function down()
    {
        $this->execute("ALTER TABLE `user` DROP COLUMN `token`");
    }
}