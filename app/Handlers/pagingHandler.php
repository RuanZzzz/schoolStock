<?php

namespace App\Handlers;

class pagingHandler
{

    /*
     * 处理——总页数
     */
    public function getTotalPage($pageSize,$totalCount)
    {
        if ($totalCount > 0) {
            $totalPages = ceil($totalCount/$pageSize);
        } else {
            $totalPages = 0;
        }

        return $totalPages;
    }

    /*
     * 处理——限制页数
     */
    public function getLimitPage($page,$pageSize,$totalPages)
    {
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        if ($page < 1) {
            $page = 1;
        }
        if ($page >= 1) {
            $offset = ($page-1)*$pageSize;
        }else {
            $offset = 0;
        }

        return $offset;
    }

}
