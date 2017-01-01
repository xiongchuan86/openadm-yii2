<?php
/**
 * 重写 getAssignments 启动缓存
 */
namespace app\common\components;

use yii\db\Query;
use yii\rbac\DbManager;
use yii\rbac\Assignment;

class RbacCacheDbManager extends DbManager
{
    protected $assignments4Users = [];

    public function getAssignments($userId)
    {

        if (empty($userId)) {
            return [];
        }
        if(isset($this->assignments4Users[$userId]) && !empty($this->assignments4Users[$userId]))
            return $this->assignments4Users[$userId];

        $query = (new Query)
            ->from($this->assignmentTable)
            ->where(['user_id' => (string) $userId]);

        $this->assignments4Users[$userId] = [];
        $assignments = [];
        foreach ($query->all($this->db) as $row) {
            $assignments[$row['item_name']] = new Assignment([
                'userId' => $row['user_id'],
                'roleName' => $row['item_name'],
                'createdAt' => $row['created_at'],
            ]);
        }
        $this->assignments4Users[$userId] = $assignments;
        return $assignments;
    }


}