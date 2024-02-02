<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BrandCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($user) {


                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'user_name' => $user->user_name,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ];
            }),
            'payload' => [
                'pagination' => $this->paginationInfo($this->resource)
            ],

        ];
    }

    private function paginationInfo($users)
    {
        $currentPage = $users->currentPage();
        $lastPage = $users->lastPage();

        $links = [
            [
                'url' => $users->previousPageUrl(),
                'label' => '&laquo; Previous',
                'active' => $currentPage > 1,
                'page' => $currentPage - 1,
            ],
        ];

        for ($page = 1; $page <= $lastPage; $page++) {
            $links[] = [
                'url' => $users->url($page),
                'label' => $page,
                'active' => $page == $currentPage,
                'page' => $page,
            ];
        }

        $links[] = [
            'url' => $users->nextPageUrl(),
            'label' => 'Next &raquo;',
            'active' => $currentPage < $lastPage,
            'page' => $currentPage + 1,
        ];

        return [
            'page' => $currentPage,
            'first_page_url' => $users->url(1),
            'from' => $users->firstItem(),
            'last_page' => $lastPage,
            'links' => $links,
            'next_page_url' => $users->nextPageUrl(),
            'items_per_page' => $users->perPage(),
            'prev_page_url' => $users->previousPageUrl(),
            'to' => $users->lastItem(),
            'total' => $users->total(),
        ];
    }
}
