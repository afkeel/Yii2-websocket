<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "session".
 *
 * @property int $id
 * @property string $token
 * @property string $user_id
 * @property string|null $user_agent
 * @property string $created_at
 * @property string $closed_at
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'user_id'], 'required'],
            [['user_agent'], 'string'],
            [['created_at', 'closed_at'], 'safe'],
            [['token', 'user_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'user_id' => 'User ID',
            'user_agent' => 'User Agent',
            'created_at' => 'Created At',
            'closed_at' => 'Closed At',
        ];
    }
}
