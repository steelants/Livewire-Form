<div>
    @if (isset($options))
        <x-form::select
            :options="$options"
            group-class="mb-3"
            label="{{ $label }}"
            placeholder="{{ __('Vyberte') }}..."
            wire:model.live="properties.{{ $field }}"
        />
    @elseif(isset($type))
        @switch($type)
            @case('string')
                <x-form::input group-class="mb-3" label="{{ $label }}" wire:model="properties.{{ $field }}" />
            @break

            @case('quill')
                <x-form::quill
                    :mentions="$this->mentions"
                    group-class="mb-3"
                    label="{{ $label }}"
                    type="number"
                    wire:model="properties.{{ $field }}"
                />
            @break

            @case('text')
                <x-form::textarea group-class="mb-3" label="{{ $label }}" wire:model="properties.{{ $field }}" />
            @break

            @case('int')
                <x-form::input
                    group-class="mb-3"
                    label="{{ $label }}"
                    type="number"
                    wire:model="properties.{{ $field }}"
                />
            @break

            @case('date')
                <x-form::input
                    group-class="mb-3"
                    label="{{ $label }}"
                    type="date"
                    wire:model="properties.{{ $field }}"
                />
            @break

            @case('datetime')
                <x-form::input
                    group-class="mb-3"
                    label="{{ $label }}"
                    type="datetime-local"
                    wire:model="properties.{{ $field }}"
                />
            @break

            @case('hashed')
                <x-form::input
                    group-class="mb-3"
                    label="{{ $label }}"
                    type="password"
                    wire:model="properties.{{ $field }}"
                />
                <x-form::input
                    group-class="mb-3"
                    label="{{ __('livewire-form::ui.confirmation') }}"
                    type="password"
                    wire:model="properties.{{ $field . '_confirmation' }}"
                />
            @break

            @default
                <div class="mb-3">
                    <span>Unsupported type: {{ $type }}</span>
                </div>
        @endswitch
    @else
        <x-form::input
            group-class="mb-3"
            label="{{ $label }}"
            type="text"
            wire:model="properties.{{ $field }}"
        />
    @endif
</div>
