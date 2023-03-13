<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JVPMaklumatPenilaianMigrate extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_jvp_public';

    protected $table = 'penilaian';
}
