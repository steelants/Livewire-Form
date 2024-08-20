<div>
	<x-form::form wire:submit.prevent="store">
		@foreach ($fields as $field)
			@php($method = "renderField" . ucfirst($field))
			@if (method_exists($this, $method))
				{!! $this->{$method}(Arr::get($row, $key), $row) !!}
			@else
				@if (isset($options[$field]))
					<x-form::select
						:options="$options[$field]"
						group-class="mb-3"
						label="{{ $labels[$field] ?? $field }}"
						placeholder="Vyberte"
						wire:model="properties.{{ $field }}"
					/>
				@elseif(isset($types[$field]))
					@switch($types[$field])
						@case("int")
							<x-form::input
								group-class="mb-3"
								label="{{ $labels[$field] ?? $field }}"
								type="number"
								wire:model="properties.{{ $field }}"
							/>
						@break

						@case("date")
							<x-form::input
								group-class="mb-3"
								label="{{ $labels[$field] ?? $field }}"
								type="date"
								wire:model="properties.{{ $field }}"
							/>
						@break

						@case("datetime")
							<x-form::input
								group-class="mb-3"
								label="{{ $labels[$field] ?? $field }}"
								type="datetime-local"
								wire:model="properties.{{ $field }}"
							/>
						@break

						@default
					@endswitch
				@else
					<x-form::input
						group-class="mb-3"
						label="{{ $labels[$field] ?? $field }}"
						type="text"
						wire:model="properties.{{ $field }}"
					/>
				@endif
			@endif
		@endforeach
		<x-form::button
			class="btn-primary"
			type="submit"
		>{{ __("boileplate::ui:create") }}</x-form::button>
	</x-form::form>
</div>
