<?php

namespace App\Livewire;

use App\Filament\Resources\TreatmentResource;
use App\Models\Patient;
use App\Models\Treatment;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;

class CreateTreatment extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public ?array $data = [];

    public Treatment $record;

    public function mount(): void
    {
        $this->form->fill($this->record->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Patient')
                    ->description('Patient Information')
                    ->schema([
                        Select::make('patient_id')
                            ->options(Patient::all()->pluck('name', 'id'))
                            ->required(),
                        Group::make()
                            ->schema([
                                TextInput::make('description')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('price')
                                    ->label('Treatment Price')
                                    ->numeric()
                                    ->prefix('$'),
                            ])->columns(),

                        Textarea::make('notes')
                            ->maxLength(65535)
                            ->columnSpanFull(),

                    ]),
            ])
            ->statePath('data');
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function () {
                try {
                    $record = Treatment::find(50);
                    $record->delete();
                    Notification::make()
                        ->success()
                        ->title('Successfully deleted custom record')
                        ->send();

                    $this->redirect(TreatmentResource::getUrl());
                }catch (\Throwable $exception){
                    Notification::make()
                        ->danger()
                        ->title($exception->getMessage())
                        ->send();
                }
            });
    }

    public function updateAction(): Action
    {
        return Action::make('Update')
            ->color('success')
            ->requiresConfirmation()
            ->modalIconColor('success')
            ->modalIcon('heroicon-o-check')
            ->action(function () {
                $this->record->update($this->form->getState());

                Notification::make()
                    ->success()
                    ->icon('heroicon-o-document-text')
                    ->title('Successfully updated custom record')
                    ->send();
            });
    }

    public function create(): void
    {
        dd($this->form->getState());
    }

    public function render()
    {
        return view('livewire.create-treatment');
    }
}
