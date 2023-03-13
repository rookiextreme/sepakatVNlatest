<?php

use App\Models\RefSetting;

$setting = RefSetting::where('ref_setting.code', "03")
->join('ref_setting_sub', 'ref_setting_sub.setting_id', '=', 'ref_setting.id')
->select('ref_setting_sub.code', 'ref_setting_sub.function_for')
->where('ref_setting_sub.status', '=', 1)
->first();

if($setting && $setting->function_for == 'scheduler'){
    $schedule->command('daily:infoMaintenanceService')->daily();
};