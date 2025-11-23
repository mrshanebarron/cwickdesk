<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens, LogsActivity, Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'sso_provider',
        'sso_id',
        'sso_data',
        'last_sso_sync',
        'extension',
        'cell',
        'direct',
        'building',
        'department',
        'area_of_responsibility',
        'is_admin',
        'is_agent',
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
            'sso_data' => 'array',
            'last_sso_sync' => 'datetime',
            'is_admin' => 'boolean',
            'is_agent' => 'boolean',
        ];
    }

    // Relationships
    public function requestedTickets()
    {
        return $this->hasMany(Ticket::class, 'requester_id');
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'assigned_to_id');
    }

    public function ticketComments()
    {
        return $this->hasMany(TicketComment::class);
    }

    public function kbArticles()
    {
        return $this->hasMany(KbArticle::class, 'author_id');
    }
}
