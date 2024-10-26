<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCredentials extends EditRecord
{
    protected static string $resource = UserResource::class;
    public static bool $isEditCredentials = true;

    protected static ?string $title = 'Editar Credenciales';

}
