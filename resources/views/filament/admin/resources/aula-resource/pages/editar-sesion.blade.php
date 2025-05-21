<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-4" color="primary">
            Guardar Cambios
        </x-filament::button>
    </form>
</x-filament::page>
