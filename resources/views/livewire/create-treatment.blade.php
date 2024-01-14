<div>
    <div class="pb-6">
        {{ $this->form }}
    </div>

    {{ $this->updateAction }}
    {{ $this->deleteAction }}

    <x-filament-actions::modals />
</div>
