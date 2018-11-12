<?php

use common\models\UserMaster;
use common\models\UserProfile;
use sbs\components\DbMigration;

class m000000_000001_user extends DbMigration
{
    public function safeUp()
    {
        $this->createTable('{{%user_master}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'email_confirm' => $this->string(32)->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(UserMaster::STATUS_NOT_ACTIVE),
            'create_date' => $this->dateTime()->notNull(),
            'update_date' => $this->dateTime()->notNull(),
            'last_visit' => $this->dateTime(),
        ], $this->getOptions());

        $this->createTable('{{%user_profile}}', [
            'user_id' => $this->primaryKey(),
            'name' => $this->string(),
            'phone' => $this->string(),
            'DOB' => $this->date(),
            'gender' => $this->smallInteger(UserProfile::GENDER_THING),
            'subscribe' => $this->smallInteger(1)->defaultValue(UserProfile::SUBSCRIBE_ACTIVE),
            'info' => $this->text(),
        ], $this->getOptions());
        $this->addForeignKey(
            'fk_user_profile', '{{%user_profile}}', 'user_id', '{{%user_master}}', 'id', 'cascade', 'no action'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%user_profile}}');
        $this->dropTable('{{%user_master}}');
    }
}
