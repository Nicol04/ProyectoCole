<x-filament::page>
    <form wire:submit.prevent="create">
        {{ $this->form }}
        <x-filament::button type="submit" class="mt-4">
            Crear Sesión
        </x-filament::button>
    </form>
</x-filament::page>
