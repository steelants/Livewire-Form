<div>
    @if (isset($options))
        <x-form::select
            :options="$options"
            group-class="mb-3"
            label="{{ $label }}"
            help="{{ $help }}"
            placeholder="{{ __('Select...') }}"
            wire:model.live="{{ $field }}"
        />
    @elseif(isset($type))
        @switch($type)
            @case('string')
                <x-form::input group-class="mb-3" label="{{ $label }}" help="{{ $help }}" wire:model="{{ $field }}" />
            @break

            @case('quill')
                <x-form::quill
                    :mentions="$mentions"
                    group-class="mb-3"
                    label="{{ $label }}"
                    help="{{ $help }}"
                    type="number"
                    wire:model="{{ $field }}"
                />
            @break

            @case('text')
                <x-form::textarea group-class="mb-3" label="{{ $label }}" wire:model="{{ $field }}" />
            @break

            @case('int')
                <x-form::input
                    group-class="mb-3"
                    label="{{ $label }}"
                    help="{{ $help }}"
                    type="number"
                    wire:model="{{ $field }}"
                />
            @break

            @case('checkbox')
                <x-form::checkbox
                    group-class="mb-3"
                    label="{{ $label }}"
                    help="{{ $help }}"
                    wire:model="{{ $field }}"
                />    
            @break

            @case('date')
                <x-form::input
                    group-class="mb-3"
                    label="{{ $label }}"
                    help="{{ $help }}"
                    type="date"
                    wire:model="{{ $field }}"
                />
            @break

            @case('datetime')
                <x-form::input
                    group-class="mb-3"
                    label="{{ $label }}"
                    help="{{ $help }}"
                    type="datetime-local"
                    wire:model="{{ $field }}"
                />
            @break

            @case('hashed')
                <x-form::input
                    group-class="mb-3"
                    label="{{ $label }}"
                    help="{{ $help }}"
                    type="password"
                    wire:model="{{ $field }}"
                />
                <x-form::input
                    group-class="mb-3"
                    label="{{ $label }} {{ __('again') }}"
                    help="{{ $help }}"
                    type="password"
                    wire:model="{{ $field . '_confirmation' }}"
                />
            @break

            @default
                <div class="mb-3">
                    <span>{{ __('Unsupported type: :type', ['type' => $type]) }}</span>
                </div>
        @endswitch
    @else
        <x-form::input
            group-class="mb-3"
            label="{{ $label }}"
            help="{{ $help }}"
            type="text"
            wire:model="{{ $field }}"
        />
    @endif
</div>
