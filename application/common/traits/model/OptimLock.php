<?php
/**
 * Created by PhpStorm.
 * User: Websky
 * Date: 2018/12/31
 * Time: 23:55
 */

namespace app\common\traits\model;

use think\Exception;
use think\Model;

trait OptimLock
{
    protected function getOptimLockField()
    {
        return property_exists($this, 'optimLock') && isset($this->optimLock) ? $this->optimLock : 'version';
    }

    /**
     * 创建新的模型实例
     * @access public
     * @param  array    $data 数据
     * @param  bool     $isUpdate 是否为更新
     * @param  mixed    $where 更新条件
     * @return Model
     */
    public function newInstance($data = [], $isUpdate = false, $where = null)
    {
        // 缓存乐观锁
        $this->cacheLockVersion($data);

        return (new static($data))->isUpdate($isUpdate, $where);
    }

    /**
     * 写入之前检查数据
     * @access protected
     * @param  array   $data  数据
     * @param  array   $where 保存条件
     * @return bool
     */
    protected function checkBeforeSave($data, $where)
    {
        if (!empty($data)) {
            // 数据对象赋值
            foreach ($data as $key => $value) {
                $this->setAttr($key, $value, $data);
            }

            if (!empty($where)) {
                $this->isUpdate(true, $where);
            }
        }

        // 数据自动完成
        $this->autoCompleteData($this->auto);

        // 事件回调
        if (false === $this->trigger('before_write')) {
            return false;
        }

        if ($this->isExists()) {
            if (!$this->checkLockVersion()) {
                throw new Exception('record has update');
            }
        } else {
            $this->recordLockVersion();
        }

        return true;
    }

    /**
     * 缓存乐观锁
     * @access protected
     * @param  array $data 数据
     * @return void
     */
    protected function cacheLockVersion($data)
    {
        $optimLock = $this->getOptimLockField();
        $pk        = $this->getPk();

        if ($optimLock && isset($data[$optimLock]) && is_string($pk) && isset($data[$pk])) {
            $key = $this->getName() . '_' . $data[$pk] . '_lock_version';

            $_SESSION[$key] = $data[$optimLock];
        }
    }

    /**
     * 检查乐观锁
     * @access protected
     * @param  array $data 数据
     * @return bool
     */
    protected function checkLockVersion()
    {
        // 检查乐观锁
        $id = $this->getKey();

        if (empty($id)) {
            return true;
        }

        $key       = $this->getName() . '_' . $id . '_lock_version';
        $optimLock = $this->getOptimLockField();

        if ($optimLock && isset($_SESSION[$key])) {
            $lockVer        = $_SESSION[$key];
            $vo             = $this->field($optimLock)->find($id);
            $_SESSION[$key] = $lockVer;
            $currVer        = $vo[$optimLock];

            if (isset($currVer)) {
                if ($currVer > 0 && $lockVer != $currVer) {
                    // 记录已经更新
                    return false;
                }

                // 更新乐观锁
                $lockVer++;

                $data = $this->getData();

                if ($data[$optimLock] != $lockVer) {
                    $this->data($optimLock, $lockVer);
                }

                $_SESSION[$key] = $lockVer;
            }
        }

        return true;
    }
}