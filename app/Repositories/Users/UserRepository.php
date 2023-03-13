<?php

namespace App\Repositories\Users;

use App\Models\RefStatus;
use App\Models\User;

class UserRepository
{
    public function tindakan($data)
    {
        $user = User::find($data['id']);

        if($data['action'] == 'approve'){

            $status = $user->status()->create([
                'status' => true
            ]);

            $refStatusCode = "06";
            $refStatus = RefStatus::where('code', '=', $refStatusCode)->first();
            $user->detail()->update([
                'ref_status_id' =>  $refStatus->id
            ]);

        }else{

            $status = $user->status()->create([
                'status' => false
            ]);

        }
    }
}
