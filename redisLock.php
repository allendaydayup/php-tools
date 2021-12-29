<?php
class RedisLock
{
    protected static $_genLockLogLockKey = "#gen##lock##log##lock#";
    static $_genLockLogLockValue = "#gen##lock##log##lock^^expire#value#";


    const REDIS_LOCK_DEFAULT_EXPIRE_TIME = 4200;

    public static function getGenLockLogLockKey($valueSign)
    {
        return self::$_genLockLogLockKey.$valueSign;
    }

    public static function getGenLockLogLockValue($valueSign)
    {
        return self::$_genLockLogLockValue.self::REDIS_LOCK_DEFAULT_EXPIRE_TIME."#".$valueSign;
    }

    /**
     * 加锁
     * @param $valueSign
     * @return string
     */
    public static function addLock($valueSign)
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $queueUniqueKey = self::getGenLockLogLockKey($valueSign);
        $queueUniqueValue = self::getGenLockLogLockValue($valueSign);
        $bolRes = $redis->set($queueUniqueKey, $queueUniqueValue, ['nx', 'ex' => self::REDIS_LOCK_DEFAULT_EXPIRE_TIME]);
        return $bolRes ? $queueUniqueValue : $bolRes;
    }

    /**
     * 解锁
     * @param $intLockId
     * @return bool
     */
    public static function releaseLock($intLockId, $valueSign)
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $queueUniqueKey = self::getGenLockLogLockKey($valueSign);
        $redis->watch($queueUniqueKey);
        if ($intLockId == $redis->get($queueUniqueKey))
        {
            $redis->del($queueUniqueKey);
            return true;
        }
        $redis->unwatch();
        return false;
    }
}