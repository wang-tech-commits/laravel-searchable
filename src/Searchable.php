<?php

namespace MrwangTc\Searchable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Searchable
{

    public static function bootSearchable()
    {
        static::deleted(
            function (Model $model) {
                $model->search()->forceDelete();
            }
        );
    }

    /**
     * Notes   : 创建或修改search模型
     * @Date   : 2021/8/17 11:12
     * @Author : Mr.wang
     * @param $model
     * @param $keywords
     * @return mixed
     */
    protected static function createSearchForModel($model, $keywords)
    {
        $searchClass = $model->getSearchModel();

        $search = new $searchClass();

        $search->title            = $model->title;
        $search->keywords         = $keywords;
        $search->searchable_id    = $model->getKey();
        $search->versionable_type = $model->getMorphClass();

        $search->save();

        return $search;

    }

    public function search(): MorphOne
    {
        return $this->morphOne(\config('searchable.search_model'), 'searchable');
    }

    public function getSearchModel(): string
    {
        return config('searchable.search_model');
    }

}