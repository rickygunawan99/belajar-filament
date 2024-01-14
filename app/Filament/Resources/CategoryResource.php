<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $navigationParentItem = 'Products';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->autocomplete(false)
                                    ->required()
                                    ->placeholder('Lorem ipsum'),

                                Toggle::make('visibility')
                                    ->helperText('Show or hide visibility status')
                                    ->inline(false)
                                    ->default(true)
                            ]),
                    ])->columns(2),

                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Placeholder::make('created_at')
                                    ->label('Created at')
                                    ->content(fn(Category $record): ?string => $record->created_at?->diffForHumans()),

                                Placeholder::make('updated_at')
                                    ->label('Updated at')
                                    ->content(fn(Category $record): ?string => $record->updated_at?->diffForHumans()),
                            ])->hidden(fn (?Category $record) => $record === null),
                    ])->columns()
                ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('visibility')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->label('Created Date')
                    ->toggleable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ])->tooltip('actions')
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
