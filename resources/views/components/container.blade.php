<div>
    <x-form::form wire:submit.prevent="store">
        @foreach($fields as $field)
            @php($method = 'renderField' . ucfirst($field))
            @if (method_exists($this, $method))
                {!! $this->{$method}(Arr::get($row, $key), $row) !!}
            @else
                <x-form::input group-class="mb-3" type="text" wire:model="properties.{{$field}}" label="{{$field}}" />
            @endif
        @endforeach
        <x-form::button class="btn-primary" type="submit">{{ __('boileplate::ui:create')}}</x-form::button>
    </x-form::form>
</div>