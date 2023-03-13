<?php

namespace App\Http\Controllers\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LogDAO
{

    public function sysLog(Request $request){

        // exception	737
        // log	429513
        // mail	122
        // model	424293
        // query	1773677
        // request	27153
        // view	66131

        $dropdown_list = ['exception','log','mail','model','query','request','view'];

        $limit = $request->limit ? $request->limit : 10;
        $type = $request->type ? $request->type : 'exception';
        $search_type = $request->search_type ? $request->search_type : 'user';
        $qSearch = '';

        if($request->search){
            switch ($search_type) {
                case 'user':
                    $qSearch = 'AND a.content LIKE \'%'.$request->search.'%\'';
                    break;
                
                default:
                    # code...
                    break;
            }
        }

        $sql = 'select a.*, b.* from telescope_entries a
        join telescope_entries_tags b on b.entry_uuid = a.uuid
        where type = \''.$type.'\' '.$qSearch.' ORDER BY created_at desc limit '.$limit;
        $list = DB::select($sql);
        return [
            'dropdown_list' => $dropdown_list,
            'limit' => $limit,
            'type' => $type,
            'list' => $list
        ];
        
    }

    public function sysLogDetail(Request $request){

        $uuid = $request->uuid;

        $sql = 'select a.content from telescope_entries a
        join telescope_entries_tags b on b.entry_uuid = a.uuid
        where a.uuid=\''.$uuid.'\'';
        $detail = DB::select($sql)[0];
        return [
            'detail' => $detail,
        ];
        
    }

}
