<?php

namespace App\Filament\Pages\Auth;

use App\Models\Role;
use Filament\Pages\Page;
use Filament\Pages\Auth\Register;
use Illuminate\Database\Eloquent\Model;

class RegisterStudent extends Register
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function handleRegistration(array $data): Model
    {
        $user = parent::handleRegistration($data);
        
        // Assign the 'student' role to the user
        $studentRole = Role::where('name', 'Student')->first();
        if ($studentRole) {
            $user->assignRole($studentRole);
        }

        return $user;
    }
}
