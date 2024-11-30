<form action="@if (isset($event)) {{ route($baseroute . 'edit', ['id' => $event->id]) }} @else {{ route($baseroute . 'create') }} @endif" enctype="multipart/form-data" method="post">
	@csrf

	<div class="row">
		<x-formcomponents::input id="name" :name="trans('crudevents::event.name')" :value="old('name', isset($event) ? $event->name : '')" />
		<x-formcomponents::input col="col-sm-6" id="event_start" :name="trans('crudevents::event.timestart')" :value="old('event_start', isset($event) ? date('Y-m-d H:i', strtotime($event->event_start)) : '')" />
		<x-formcomponents::input col="col-sm-6" id="event_end" :name="trans('crudevents::event.timeend')" :value="old('event_start', isset($event) ? date('Y-m-d H:i', strtotime($event->event_end)) : '')" />
		<x-formcomponents::image :name="isset($event) ? trans('crudevents::event.image.replace') : trans('crudevents::event.image')" />
		<x-formcomponents::input col="col-sm-6" id="location" :name="trans('crudevents::event.location')" :value="old('location', isset($event) ? $event->location : '')" />
		<x-formcomponents::checkbox :checked="isset($event) ? $event->public : false" col="col-sm-6 align-self-center" id="public" :name="trans('crudevents::event.public')" />
		<x-formcomponents::input id="description" :name="trans('crudevents::event.description')" :value="old('description', isset($event) ? $event->description : '')" />
		<x-formcomponents::text id="text" :name="trans('crudevents::event.text')" :value="old('text', isset($event) ? $event->text : '')" />
		<x-formcomponents::button onclick="summernoteSubmit();">
			@if (isset($event)) 
				{{ trans('crudevents::event.update') }}
			@else 
				{{ trans('crudevents::event.create') }}
			@endif
		</x-formcomponents::button>
	</div>
</form>