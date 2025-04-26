<?php

namespace App\Filament\Resources;


use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Categoria;
use App\Models\Movimiento;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MovimientoResource\Pages;
use App\Filament\Resources\MovimientoResource\RelationManagers;
use App\Filament\Resources\RawsJs;
use Filament\Forms\Components\RawJs;
use Filament\Support\RawJs as SupportRawJs;
use Illuminate\Support\Facades\Log;



class MovimientoResource extends Resource
{
    protected static ?string $model = Movimiento::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Tipos de Movimiento')
                    ->description('LLene los campos requeridos')
                    ->schema([
                        forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->required()
                        ->label('Usuarios'),
                    Forms\Components\Select::make('categoria_id')
                    ->required()
                    ->options(
                        \App\Models\Categoria::all()->pluck('nombre', 'id')
                    ),
                    Forms\Components\Select::make('tipo')
                        ->options([
                            'ingreso' => 'Ingreso',
                            'gasto' => 'Gasto',
                        ])
                        ->required(),

                        Forms\Components\TextInput::make('monto')
                        ->label('Monto')
                        ->required()
                        ->numeric()
                        ->step(0.01)
                        ->prefix('$')
                        ->mask(SupportRawJs ::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric(),


                    Forms\Components\RichEditor::make('descripcion')
                        ->label('Descripción')
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('foto')
                      ->label('Foto')
                        ->image()
                        ->disk('public')
                        ->directory('movimientos')
                        ->default(null),
                    Forms\Components\DatePicker::make('fecha')
                        ->required(),

                        ])


                            ->columns(2)
                            ->columnSpan(2),

            ]);




    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                Tables\Columns\TextColumn::make('user_id')

                ->sortable()
                ->label('Num')
                ->rowIndex(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuarios')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('categoria.nombre')
                    ->numeric()
                    ->label('Categoria')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->sortable()
                    ->label('Tipo de Movimiento'),
                Tables\Columns\TextColumn::make('monto')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => '$ '.number_format($state, 2, ',', '.'))
                    ->label('Monto'),
                Tables\Columns\TextColumn::make('descripcion')
                    ->limit(30)
                    ->sortable()
                    ->html()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')

                    ->width(100)
                    ->height(100)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('tipo')
                    ->label('Tipo de Movimiento')
                    ->multiple()
                    ->options([
                        'ingreso' => 'Ingreso',
                        'gasto' => 'Gasto',
                    ])
                    ->placeholder('Seleccionar Tipo de Movimiento'),
                Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Usuarios')
                    ->multiple()
                    ->placeholder('Seleccionar Usuarios'),
                Tables\Filters\SelectFilter::make('categoria_id')
                    ->relationship('categoria', 'nombre')
                    ->label('Categorias')
                    ->multiple()
                    ->placeholder('Seleccionar Categorias'),

            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->button()
                    ->icon('heroicon-o-pencil')
                    ->color('success'),
                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar')
                    ->button()
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                  ->successNotification(
                    Notification::make()
                        ->title('Movimiento Eliminado')
                        ->body('El movimiento ha sido eliminado correctamente.')
                        ->success()
                  ),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovimientos::route('/'),
            'create' => Pages\CreateMovimiento::route('/create'),
            'edit' => Pages\EditMovimiento::route('/{record}/edit'),
        ];
    }
}
