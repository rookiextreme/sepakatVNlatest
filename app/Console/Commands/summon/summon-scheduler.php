<?php

use App\Models\RefSetting;

$setting = RefSetting::where('ref_setting.code', "01")
->join('ref_setting_sub', 'ref_setting_sub.setting_id', '=', 'ref_setting.id')
->select('ref_setting_sub.code', 'ref_setting_sub.function_for')
->where('ref_setting_sub.status', '=', 1)
->first();

if($setting && $setting->function_for == 'scheduler'){
    if($setting->code == '01'){
        $schedule->command('daily:infoSummon')->daily();
    } else if($setting->code == '02'){
        $schedule->command('weekly:infoSummon')->weekly();
    } else if($setting->code == '03'){
        $schedule->command('montly:infoSummon')->monthly();
    } else if($setting->code == '04'){
        $schedule->command('minute:infoSummon')->everyMinute();
    }
};