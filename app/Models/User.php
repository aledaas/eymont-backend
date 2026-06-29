<?php

namespace App\Models;

use App\Modules\Assessment\Domain\Models\UserAnswer;
use App\Modules\IAM\Domain\Models\StudentProfile;
use App\Modules\Learning\Domain\Models\LearningSession;
use App\Modules\Learning\Domain\Models\UserProgress;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

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
            'admin' => $this->hasAnyRole([
                'super_admin',
                'admin',
                'teacher',
            ]),

            'student' => $this->hasRole('student'),

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

    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    public function learningSessions(): HasMany
    {
        return $this->hasMany(LearningSession::class);
    }
}
