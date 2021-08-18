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

        $search = $searchClass::updateOrCreate(
            ['searchable_id' => $this->getKey(), 'searchable_type' => $this->getMorphClass()],
            ['title' => $title ?? $this->title, 'keywords' => $keywords]
        );

        return $search;

    }

    public function getSearchModel(): string
    {
        return config('searchable.search_model');
    }

}