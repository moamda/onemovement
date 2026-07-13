<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_094634_userDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%user}}',
                           ["id", "username", "auth_key", "password_hash", "password_reset_token", "verification_token", "email", "status", "created_at", "updated_at", "code_name"],
                            [
    [
        'id' => 1,
        'username' => 'admin',
        'auth_key' => 'n_GGUXHrkFi15QSmxuHOoUaKK1MHi-zF',
        'password_hash' => '$2y$13$caSsOX2fdSuGsOpNU9CTDOztDbmFI7KxgWv57cfkqqSwQdZSn1j0G',
        'password_reset_token' => null,
        'verification_token' => 'QGOX-opdybE_Vb2SHze1VFmfBq5Xhq2F_1731224407',
        'email' => 'admin@gmail.com',
        'status' => 10,
        'created_at' => 1690278439,
        'updated_at' => 0,
        'code_name' => 'SUPER-ADMIN',
    ],
    [
        'id' => 7,
        'username' => 'super-admin',
        'auth_key' => 'uVwRMO79sKlhoZ0ZxT_zoQlprjToK3Ux',
        'password_hash' => '$2y$13$sbQKuQqB83/s.Qkxy1nmMuHmjEXmZ1q2Q0Hkxic/0uZT/xIzowiM6',
        'password_reset_token' => null,
        'verification_token' => 'MChfBuuH3nuarAF--xqtQW8W9FnDzsLU_1783865680',
        'email' => 'superadmin@gmail.com',
        'status' => 10,
        'created_at' => 1783865680,
        'updated_at' => 1783865680,
        'code_name' => '',
    ],
    [
        'id' => 8,
        'username' => 'emandoza',
        'auth_key' => 'qRwZL_i46mLVGCEWrcnodWaXu5m9AotG',
        'password_hash' => '$2y$13$QRByPrWOGmam8oTDZ/fBauQ06NnAJaSMseDl6N424XhlmmZwS3Ju2',
        'password_reset_token' => null,
        'verification_token' => '8lEeSXz6tLJFDNyFuRqo3el9m_Bg_qK-_1783867032',
        'email' => 'emandoza@gmail.com',
        'status' => 9,
        'created_at' => 1783867032,
        'updated_at' => 1783867032,
        'code_name' => '',
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%user}} CASCADE');
    }
}
