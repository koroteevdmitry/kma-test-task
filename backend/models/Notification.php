<?php
namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property string $text
 * @property int $status
 * @property int $integrator
 * @property string $created_at
 * @property string $send_at

 *
 */
class Notification extends ActiveRecord
{
    public const INTEGRATOR_TELEGRAM = 1;
    public const INTEGRATOR_EMAIL = 2;

    public const STATUS_WAITING = 1;
    public const STATUS_SEND = 2;
    public const STATUS_ERROR = 3;

    private CONST INTEGRATOR_LIST = [
        self::INTEGRATOR_TELEGRAM => 'Telegram',
        self::INTEGRATOR_EMAIL => 'Email',
    ];

    private CONST STATUS_LIST = [
        self::STATUS_WAITING => 'Waiting',
        self::STATUS_SEND => 'Send',
        self::STATUS_ERROR => 'Error',
    ];

    public static function tableName(): string
    {
        return 'notification';
    }

    public function rules(): array
    {
        return [
            [['text', 'status', 'integrator'], 'required'],
            [['text'], 'string'],
            [['status', 'integrator'], 'integer'],
            [['created_at', 'send_at'], 'safe'],
            [['status'], 'in', 'range' => array_keys(self::STATUS_LIST)],
            [['integrator'], 'in', 'range' => array_keys(self::INTEGRATOR_LIST)],
        ];
    }

    /**
     * @return string[]
     */
    public static function getIntegratorList(): array
    {
      return self::INTEGRATOR_LIST;
    }

    /**
     * @param int $status
     * @return string
     */
    public static function getStatus(int $status): string
    {
        return self::STATUS_LIST[$status];
    }

    /**
     * @param int $integrator
     * @return string
     */
    public static function getIntegrator(int $integrator): string
    {
        return self::INTEGRATOR_LIST[$integrator];
    }
}