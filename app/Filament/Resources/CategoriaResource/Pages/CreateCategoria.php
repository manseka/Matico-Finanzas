<?php

namespace App\Filament\Resources\CategoriaResource\Pages;

use App\Filament\Resources\CategoriaResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoria extends CreateRecord
{
    protected static string $resource = CategoriaResource::class;

    // Redirect to the index page after creating a record
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function afterCreate()
    {
        Notification::make()
            ->title('Categoria creada')
            ->body('La categoria ha sido creada exitosamente.')
            ->success()
            ->send();

       // $this->redirect($this->getResource()::getUrl('index'));
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
            ->label('Registrar')
            ->color('success')
            ->icon('heroicon-o-check'),

            //$this->getCreateAnotherFormAction()
            //->label('Guardar y Crear otra categoria')

            $this->getCancelFormAction()
            ->label('Cancelar')


        ];
    }

}
