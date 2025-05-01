<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SearchService
{

    public function getData($request,$table){

        $query = DB::table($table)->where('deleted_at',  NULL);
        $limit = $request->input('limit', 10);
        $is_active = $request->input('is_active');
        $date = $request->input('date');
        $text = $request->input('text');

        if($is_active != null){
            $query->where('is_active', $is_active);
        }
        if($date){
            $query->whereDate('created_at', '=', $date);
        }


        if ($text) {

            $query->where(function ($query) use ($text, $table) {
                $columns = Schema::getColumnListing($table);

                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', '%' . $text . '%');
                }
            });


        }

        $count = count($query->get());
        $data = $query->orderBy('id', 'desc')->paginate($limit)->withQueryString();

        return ['items' => $data, 'count' => $count];


    }
}
