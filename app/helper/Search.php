<?php

namespace App\helper;

use App\Models\User;

class Search
{
    public static function SearchParams($data, $sort, $order)
    {
        $orderparams = '';
        if ($sort === 'asc') {
            $orderparams = 'orderBy';
        }
        if ($sort === 'desc') {
            $orderparams = 'orderByDesc';
        }
        if ($sort === '' and $order === '') {
            $search = User::where('name', 'like', "%{$data}%")
                ->orWhere('email', 'like', "%{$data}%")->get();
            return $search;
        } else {
            $search = User::where('name', 'like', "%{$data}%")
                ->orWhere('email', 'like', "%{$data}%")->$orderparams($order)->get();
            return $search;
        }

    }
}


