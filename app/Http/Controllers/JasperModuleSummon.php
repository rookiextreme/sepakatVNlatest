<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

$carbon = new Carbon();
$carbon->setLocale('ms');

switch ($reportName) {
    case 'summon_letter':

        $module = [
            'summon' => 'summon'
        ];
        $breaks = array("<br />","<br>","<br/>");
        $params = [
            'asset_path' => public_path('my-assets'),
            'summon_id' => $request->summon_id,
            'ref_number' => $request->ref_number,
            'ref_date' => $request->ref_date,
            'address_to' =>  str_ireplace($breaks, "\r\n", $request->address_to),
            'quote' =>  str_ireplace($breaks, "\r\n", $request->quote),
            'signature' =>  str_ireplace($breaks, "\r\n", $request->signature),
            'copy_to' => str_ireplace($breaks, "\r\n", $request->copy_to)
        ];

        break;

}
