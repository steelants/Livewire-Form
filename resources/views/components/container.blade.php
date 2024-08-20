<div>
    <x-form::form wire:submit.prevent="store">
        @foreach($fields as $field)
            @php($method = 'renderField' . ucfirst($field))
            @if (method_exists($this, $method))
                {!! $this->{$method}(Arr::get($row, $key), $row) !!}
            @else
            @dump($types)
            @if(isset($types[$field]))
                @switch($types[$field])
                    @case('int')
                    <x-form::input group-class="mb-3" type="number" wire:model="properties.{{$field}}" label="{{$field}}" />
                    @break
                    
                    @case('date')
                    <x-form::input group-class="mb-3" type="date" wire:model="properties.{{$field}}" label="{{$field}}" />
                    @break

                    @case('datetime')
                    <x-form::input group-class="mb-3" type="datetime-local" wire:model="properties.{{$field}}" label="{{$field}}" />
                    @break
                    
                    @default
                    
                @endswitch
            @else
                <x-form::input group-class="mb-3" type="text" wire:model="properties.{{$field}}" label="{{$field}}" />
            @endif
            @endif
            @dump($properties[$field])
        @endforeach
        @dump($properties)

        <x-form::button class="btn-primary" type="submit">{{ __('boileplate::ui:create')}}</x-form::button>
    </x-form::form>
</div>