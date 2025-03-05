<?php

namespace App\Models;

use App\Enum\UserRole;
use App\Exceptions\InvalidUserRoleException;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barbershop extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'ddd',
        'phone',
        'owner_id'
    ];
    protected $casts = [
        'ddd' => 'string',
        'phone' => 'string',
    ];
    public function setOwner(User $owner)
    {
        if ($owner->role !== UserRole::OWNER) {
            throw new InvalidUserRoleException('Erro, tipo de usuário inválido para serviço.');
        }
        $this->owner()->associate($owner);
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: fn($value) => ucwords(strtolower($value)),
        );
    }
    protected function address(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: fn($value) => ucwords(strtolower($value)),
        );
    }
    protected function phone(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: fn($value) => preg_replace('/[^0-9]/', '', $value),
        );
    }
    protected function ddd(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: fn($value) => preg_replace('/[^0-9]/', '', $value),
        );
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
