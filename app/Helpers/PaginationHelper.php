<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class PaginationHelper
{
    public function handlePagination(Request $request, $maxPage)
    {
        $page = $request->query('page', 1);
        if ($page > $maxPage) {
            $page = $maxPage;
        }
        if ($page < 1) {
            $page = 1;
        }
        $request->query->set('page', $page);
        return $request;
    }

    public static function instance()
    {
        return new PaginationHelper();
    }
}
