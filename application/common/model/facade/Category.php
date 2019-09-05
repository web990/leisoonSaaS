<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.1
// +----------------------------------------------------------------
// | Copyright (c) 2018 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com> 201808301514
// +----------------------------------------------------------------

namespace app\common\model\facade;

use think\Facade;

/**
 * @see \app\admin\model\AdminCategory
 * @mixin \app\admin\model\AdminCategory
 *
 * @method static|null get(mixed $data, mixed $with = [], bool $cache = false, bool $failException = false) static 查找单条记录
 * @method mixed getError() static 获取错误信息
 * @method bool destroy(mixed $data) static 软删除记录（$data 主键列表 支持闭包查询条件）
 * @method static update(array $data = [], array $where = [], array|true $field = null) static 更新数据
 * @method static create(array $data = [], array|true $field = null, bool $replace = false) static 写入数据
 * @method bool delete() static 删除当前的记录
 * @method bool save(array $data = [], array $where = [], string $sequence = null) static  保存当前数据对象
 * @method Collection saveAll(array $dataSet, boolean $replace = true) static 保存多个数据到当前数据对象
 * @method bool setDec(string $field, integer $step = 1, integer $lazyTime = 0) static 字段值(延迟)减少
 * @method bool setInc(string $field, integer $step = 1, integer $lazyTime = 0) static  字段值(延迟)增长
 * @method $this force(bool $force = true) static  更新是否强制写入数据 而不做比较
 * @method bool isForce() static   判断force
 * @method $this replace(bool $replace = true) static   新增数据是否使用Replace
 * @method void exists(bool $exists) static   设置数据是否存在
 * @method bool isExists() static   判断数据是否存在数据库
 * @method Collection|array|\PDOStatement|string select(array|string|Query|\Closure $data = null) static 查找记录
 * @method array|null|\PDOStatement|string|Model find(array|string|Query|\Closure $data = null) static 查找单条记录
 * @method \think\Paginator paginate(int|array $listRows = null, int|bool $simple = false, array $config = []) static 分页查询
 */
class Category extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'app\admin\model\AdminCategory';
    }
}