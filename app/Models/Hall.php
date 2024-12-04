<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;
     protected $table = 'halls';
     protected $primaryKey = 'id';
     public $timestamps = true;
 
     // Define fillable columns
     protected $fillable = [
         'hall_name',
         'hall_address',
         'phone_number',
         'normal_seat_row',
         'normal_seat_column',
         'premium_seat_row',
         'premium_seat_column',
         'premium_seat_price',
         'normal_seat_price',
         'location_id',
     ];
}
