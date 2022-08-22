<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $fillable = ['projectName', 'description', 'repositoryLastPush', 'repositoryCreatedAt', 'stars', 'URL', 'id'];
}
