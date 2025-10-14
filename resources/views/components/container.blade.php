<div>
	<x-form::form wire:submit.prevent="store">
		@foreach ($this->fields as $field)
			@php($method = "renderField" . ucfirst(Str::camel(str_replace('.', '_', $field))))
			@if (method_exists($this, $method))
				{!! $this->{$method}() !!}
			@else
				{{-- {!! $this->field($field) !!} --}}
                <x-form-components::field
                    :field="'properties.'.$field"
                    :label="$this->labels[$field] ?? $field"
					:help="$this->helps[$field] ?? null"
                    :type="$this->types[$field] ?? null"
                    :options="$this->options[$field] ?? null"
                    :mentions="$this->mentions ?? null"
                />
			@endif
		@endforeach
		<x-form::button
			class="btn-primary"
			type="submit"
		>{{ (!empty($modelId) ? __("Update") : __("Create")) }}</x-form::button>
	</x-form::form>
</div>
