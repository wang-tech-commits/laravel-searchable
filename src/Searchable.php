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

    public function search(): MorphOne
    {
        return $this->morphOne(\config('searchable.search_model'), 'searchable');
    }

    /**
     * Notes   : 创建或修改search模型
     * @Date   : 2021/8/17 14:27
     * @Author : Mr.wang
     * @param  string  $title
     * @param  string  $keywords
     * @return mixed
     */
    protected function searchForModel($title = '', $keywords = '')
    {
        $searchClass = $this->getSearchModel();

        $search = new $searchClass();

        $search->title            = $title ?? $this->title;
        $search->keywords         = $keywords;
        $search->searchable_id    = $this->getKey();
        $search->versionable_type = $this->getMorphClass();

        $search->save();

        return $search;

    }

    public function getSearchModel(): string
    {
        return config('searchable.search_model');
    }

}