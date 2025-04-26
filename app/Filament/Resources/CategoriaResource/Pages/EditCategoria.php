<?php

namespace App\Filament\Resources\CategoriaResource\Pages;

use App\Filament\Resources\CategoriaResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCategoria extends EditRecord
{
    protected static string $resource = CategoriaResource::class;

    protected function getSavedNotification(): ?Notification
    {
        return null;
    }

    // Cuando creamos una nueva categoria, se redirige a la pagina de categorias
    protected function afterSave()
    {
        Notification::make()
            ->title('Categoria actualizada')
            ->body('La categoria ha sido actualizada exitosamente.')
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
                    ->title('Categoria eliminada')
                    ->body('La categoria ha sido eliminada exitosamente.')
                    ->success()
            )
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
