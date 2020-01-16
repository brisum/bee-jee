<?php

namespace App\Utils\Task;

class TaskPaginationService
{
    public function getPaginationLinks($pageCount, $page = 1, $sort = '', $order = '')
    {
        $paginationLinks = [];

        if (1 < $pageCount && 1 < $page) {
            $prevPage = $page - 1;
            $paginationLinks[] = [
                'text' => '<span aria-hidden="true">&laquo;</span>',
                'link' => 1 < $prevPage ? "/page/{$prevPage}/" : '/'
            ];
        }

        for ($p = 1; $p <= $pageCount; $p++) {
            $paginationLinks[] = [
                'text' => $p,
                'link' => 1 < $p ? "/page/{$p}/" : '/'
            ];
        }

        if (1 < $pageCount && $page < $pageCount) {
            $paginationLinks[] = [
                'text' => '<span aria-hidden="true">&raquo;</span>',
                'link' => "/page/" . ($page + 1) . "/",
            ];
        }

        return $paginationLinks;
    }
}
