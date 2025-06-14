<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'division_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    * division
    */
    public function division()
    {
        return $this->belongsTo(M_Divisions::class, 'division_id');
    }

    function itemHistories()
    {
        return $this->hasMany(M_Item_Histories::class, 'distributed_by');
    }

    function distributions()
    {
        return $this->hasMany(M_Distributions::class, 'distributed_by');
    }


    /**
     * auto generate UUID for the model
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->getKey())) {
                $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
}
