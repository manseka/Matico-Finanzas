<?php

namespace App\Filament\Resources\MovimientoResource\Pages;

use App\Filament\Resources\MovimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;


class CreateMovimiento extends CreateRecord
{
    protected static string $resource = MovimientoResource::class;



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
            ->title('Movimiento creado')
            ->body('El movimiento ha sido creada exitosamente.')
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
