<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Population extends Model
{
    protected $table = 'population';

    protected $fillable = ['id', 'number', 'master', 'name', 'avatar', 'relation', 'old_name', 'id_number', 'sex', 'birthday', 'birth_place', 'place', 'type', 'community', 'nation', 'polity', 'education', 'marry', 'area', 'building', 'door', 'address', 'benefit', 'is_military', 'is_voter', 'occupation', 'health', 'phone', 'remarks', 'company', 'company_province', 'company_city', 'company_area', 'work_type', 'applay_time', 'apply_reason'];

}
