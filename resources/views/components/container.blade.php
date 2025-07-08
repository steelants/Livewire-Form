<div>
	<x-form::form wire:submit.prevent="store">
		@foreach ($fields as $field)
			@php($method = "renderField" . ucfirst($field))
			@if (method_exists($this, $method))
				{!! $this->{$method}() !!}
			@else
				{!! $this->field($field) !!}
			@endif
		@endforeach
		<x-form::button
			class="btn-primary"
			type="submit"
		>{{ ($this->model->exists() ? __("boilerplate::ui.update") : __("boilerplate::ui.create")) }}</x-form::button>
	</x-form::form>
</div>
