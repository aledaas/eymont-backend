<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

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

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            // Backoffice principal
            'admin' => $this->hasAnyRole([
                'super_admin',
                'admin',
                'teacher',
            ]),
            // Experiencia de aprendizaje
            'student' => $this->hasRole('student'),
            // Futuros paneles
            'analytics' => $this->hasAnyRole([
                'super_admin',
                'admin',
                'researcher',
            ]),
            'reviewer' => $this->hasAnyRole([
                'super_admin',
                'admin',
                'content_reviewer',
            ]),
            default => false,
        };
    }
}
