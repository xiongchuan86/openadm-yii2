<?php

namespace app\modules\user\models;

use Yii;
use yii\db\ActiveRecord;
use yii\rbac\Item;
/**
 * This is the model class for table "tbl_role".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $create_time
 * @property string  $update_time
 * @property integer $can_admin
 *
 * @property User[]  $users
 */
class Role extends ActiveRecord
{
    /**
     * @var int Admin user role
     */
    const ROLE_ADMIN = 1;

    /**
     * @var int Default user role
     */
    const ROLE_USER = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%AuthItem}}";
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            //            [['create_time', 'update_time'], 'safe'],
            [['type'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'        => Yii::t('user', 'Name'),
            'created_at' => Yii::t('user', 'Create Time'),
            'updated_at' => Yii::t('user', 'Update Time'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class'      => 'yii\behaviors\TimestampBehavior',
                'value'      => function () { return time(); },
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ],
        ];
    }


    /**
     * Check permission
     *
     * @param string $permission
     * @return bool
     */
    public function checkPermission($permission)
    {
        $roleAttribute = "can_{$permission}";
        return $this->$roleAttribute ? true : false;
    }

    /**
     * Get list of roles for creating dropdowns
     *
     * @return array
     */
    public static function dropdown()
    {
        // get and cache data
        static $dropdown;
        if ($dropdown === null) {

            // get all records from database and generate
            $models = static::find()->where(["type"=>Item::TYPE_ROLE])->all();
			
            foreach ($models as $model) {
                $dropdown[$model->name] = $model->name;
            }
        }

        return $dropdown;
    }
}