<?php

namespace App\Filament\Resources\TreatmentResource\Pages;

use App\Filament\Resources\TreatmentResource;
use App\Models\Patient;
use App\Models\Treatment;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

class CustomEditTreatment extends Page implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    protected static string $resource = TreatmentResource::class;

    protected static string $view = 'filament.resources.treatment-resource.pages.custom-edit-treatment';

    public ?array $data = [];

    public Treatment $record;

    public function mount(): void
    {

    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('patient_id')
                    ->options(Patient::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload(),
                TextInput::make('description'),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('$'),
            ])
            ->statePath('data');
    }

    public function getFormActions(): array
    {
        return [
            Action::make('Save')
                ->requiresConfirmation()
                ->action('save')
        ];
    }

    public function create(): void
    {
        Action::make('Save')
            ->requiresConfirmation()
            ->action(function (array $arguments) {
            });
    }


    public function save(): void
    {
//        dd($this->form->getState());
        Notification::make()
            ->warning()
            ->title('Success')
            ->send();
    }
}
