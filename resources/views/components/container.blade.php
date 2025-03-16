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
						wire:model.live="properties.{{ $field }}"
					/>
				@elseif(isset($types[$field]))
					@switch($types[$field])
						@case("string")
							<x-form::input
								group-class="mb-3"
								label="{{ $labels[$field] ?? $field }}"
								wire:model="properties.{{ $field }}"
							/>
						@break

						@case("quill")
							<x-form::quill
								group-class="mb-3"
								label="{{ $labels[$field] ?? $field }}"
								type="number"
								:mentions="$this->mentions"
								wire:model="properties.{{ $field }}"
							/>
						@break

						@case("text")
							<x-form::textarea
								group-class="mb-3"
								label="{{ $labels[$field] ?? $field }}"
								wire:model="properties.{{ $field }}"
							/>
						@break

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

						@case("hashed")
							<x-form::input
								group-class="mb-3"
								label="{{ $labels[$field] ?? $field }}"
								type="password"
								wire:model="properties.{{ $field }}"
							/>
							<x-form::input
								group-class="mb-3"
								label="{{ ($labels[$field . '_confirmation'] ?? $field . ' ' . __('livewire-form::ui.confirmation')) }}"
								type="password"
								wire:model="properties.{{ $field . '_confirmation' }}"
							/>
						@break

						@default
							<div class="mb-3">
								<span>Unsupported type: {{ $types[$field] }}</span>
							</div>
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
		>{{ ($this->model->exists() ? __("boilerplate::ui.update") : __("boilerplate::ui.create")) }}</x-form::button>
	</x-form::form>
</div>
