<?php

namespace App\Traits;


trait GlobalSearch
{

    public function getSearchTitle($keyword){

        $org_keyword = $keyword;

        foreach ($keyword as &$value) {
            $value = '<strong>'.$value.'</strong>';
        }

        return str_ireplace($org_keyword, $keyword, $this->title);
    }


    public function getSearchContent($keyword){

        $org_keyword = $keyword;

        foreach ($keyword as &$value) {
            $value = '<strong>'.$value.'</strong>';
        }

        return str_ireplace($org_keyword, $keyword, $this->content);
    }


}