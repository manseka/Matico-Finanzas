<?php

namespace App\Filament\Resources\MovimientoResource\Pages;

use App\Filament\Resources\MovimientoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;


class EditMovimiento extends EditRecord
{
    protected static string $resource = MovimientoResource::class;

    protected function getSavedNotification(): ?Notification
    {
        return null;
    }


    // Cuando creamos una nueva categoria, se redirige a la pagina de categorias
    protected function afterSave()
    {
        Notification::make()
            ->title('Movimiento actualizado')
            ->body('El Movimiento ha sido actualizado exitosamente.')
            ->success()
            ->send();
    }




// Cuando eliminamos una categoria, se redirige a la pagina de categorias
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->successNotification(
                Notification::make()
                    ->title('Movimiento eliminado')
                    ->body('El Movimiento ha sido eliminado exitosamente.')
                    ->success()
            )
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
