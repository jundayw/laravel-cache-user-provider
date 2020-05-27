<?php

namespace Jundayw\LaravelCacheUserProvider;

use Illuminate\Auth\EloquentUserProvider;

class CacheUserProvider extends EloquentUserProvider
{
    public function getCacheUserName()
    {
        return 'cache_user_provider_' . sha1(static::class);
    }

    public function retrieveById($identifier)
    {
        if (!session()->has($this->getCacheUserName())) {
            $model = $this->createModel();

            $user = $this->newModelQuery($model)
                ->where($model->getAuthIdentifierName(), $identifier)
                ->first();

            session()->put($this->getCacheUserName(), $user);
        }

        return session()->get($this->getCacheUserName());
    }

    public function retrieveByToken($identifier, $token)
    {
        $retrievedModel = $this->retrieveById($identifier);

        if (!$retrievedModel) {
            return;
        }

        $rememberToken = $retrievedModel->getRememberToken();

        return $rememberToken && hash_equals($rememberToken, $token) ? $retrievedModel : null;
    }
}