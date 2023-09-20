<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comics extends Model
{
    use HasFactory;
    protected $id_comic= [
        'id_comic' => 'integer'];
    protected $table='comics';
}
