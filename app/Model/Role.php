<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //1. 关联的数据表
    public $table = 'role';

    //2. 主键
    public $primaryKey = 'id';

    //3. 允许批量操作的字段
    public $guarded = [];//不允许操作哪些字段

    //4. 是否维护crated_at 和 updated_at字段
    public $timestamps = false;

    //添加动态属性，关联权限模型
    public function permission()
    {
        //所关联模型的命名空间App\Model\Permission
        //对应的关联表role_permission
        //关联表对应的当前模型key role_id
        //关联表对应的关联模型key permission_id

        //$role = Role::find($id);
        //获取当前角色拥有的权限$own_perms = $role->permission;
        return $this->belongsToMany('App\Model\Permission','role_permission','role_id','permission_id');
    }
}
