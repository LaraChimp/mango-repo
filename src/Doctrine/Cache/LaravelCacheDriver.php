<?php

namespace LaraChimp\MangoRepo\Doctrine\Cache;

use Doctrine\Common\Cache\CacheProvider;
use Illuminate\Contracts\Cache\Factory as LaravelCache;

class LaravelCacheDriver extends CacheProvider
{
    /**
     * The Laravel Cache instance.
     *
     * @var LaravelCache
     */
    protected $cache;

    /**
     * LaravelCacheDriver constructor.
     *
     * @param LaravelCache $cache
     */
    public function __construct(LaravelCache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        // We have no lifetime
        // so cache forever.
        if($lifeTime == 0) {
            $this->cache->forever($id, $data);
        } else {
            $this->cache->put($id, $data, $lifeTime);
        }

        return $this->doContains($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doFetch($id)
    {
        return $this->cache->get($id) ?: false;
    }

    /**
     * {@inheritdoc}
     */
    protected function doContains($id)
    {
        return $this->cache->has($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doDelete($id)
    {
        return $this->cache->forget($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doFlush()
    {
        return $this->cache->flush();
    }

    /**
     * {@inheritdoc}
     */
    protected function doGetStats()
    {
        return null;
    }
}
