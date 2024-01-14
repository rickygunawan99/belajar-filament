<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TreatmentResource\Pages;
use App\Filament\Resources\TreatmentResource\RelationManagers;
use App\Models\Treatment;
use Filament\Actions\StaticAction;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TreatmentResource extends Resource
{
    protected static ?string $model = Treatment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Patient')
                    ->description('Patient Information')
                    ->schema([
                        Forms\Components\Select::make('patient_id')
                            ->relationship('patient', 'name')
                            ->required(),
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('description')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('price')
                                    ->label('Treatment Price')
                                    ->numeric()
                                    ->prefix('$'),
                            ])->columns(),

                        Forms\Components\Textarea::make('notes')
                            ->maxLength(65535)
                            ->columnSpanFull(),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->limit(20),
                Tables\Columns\TextColumn::make('price')
                    ->money()
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
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                    Action::make('Notify')
                        ->color('info')
                        ->icon('heroicon-o-users')
                        ->action(function (array $data) {
                            Notification::make()
                                ->success()
                                ->title('OK')
                                ->send();
                        }),
                    Action::make('Custom')
                        ->color('secondary')
                        ->icon('heroicon-o-link')
                        ->url(fn(Treatment $treatment) => TreatmentResource::getUrl('custom', ['record' => $treatment])),
                    Action::make('Modal')
                        ->color('primary')
                        ->icon('heroicon-o-chat-bubble-bottom-center-text')
                        ->form([
                            Forms\Components\Toggle::make('is_visible')
                        ])
                        ->action(function () {
                            Notification::make()
                                ->title('Modal notification')
                                ->body('Success notify modal')
                                ->success()
                                ->send();
                        })
                        ->modalCancelActionLabel('Close')
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->searchPlaceholder('Search');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Treatment Info Detail')
                    ->schema([
                        TextEntry::make('patient.name')
                            ->label('Patient Name'),

                        TextEntry::make('description'),

                        TextEntry::make('price')
                            ->prefix('$'),

                        TextEntry::make('notes')
                            ->default('-'),
                    ])
            ])->columns(1);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTreatments::route('/'),
            'create' => Pages\CreateTreatment::route('/create'),
            'view' => Pages\ViewTreatment::route('/{record}'),
            'edit' => Pages\EditTreatment::route('/{record}/edit'),
            'custom' => Pages\CustomEditTreatment::route('/{record}/custom'),
        ];
    }
}
