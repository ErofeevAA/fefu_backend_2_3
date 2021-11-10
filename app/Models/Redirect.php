<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string old_slug
 * @property string new_slug
*/

class Redirect extends Model
{
    use HasFactory;
}
