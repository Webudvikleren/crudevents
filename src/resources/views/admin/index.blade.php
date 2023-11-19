@extends('layout.app')

@section('content')
<h1>{{ trans('crudevents::event.events') }}</h1>
<x-crudevents::status />
<a class="btn btn-light" href="{{ route($baseroute . 'create') }}">
	<x-iconcomponents::plus-circle class="me-1" color="green" />
	{{ trans('crudevents::event.create') }}
</a>

<table class="mt-2 table table-hover table-list">
	<thead>
		<td>{{ trans('crudevents::event.name') }}</td>
		<td>{{ trans('crudevents::event.timestart') }}</td>
		<td>{{ trans('crudevents::event.timeend') }}</td>
		<td class="text-center" colspan="3">{{ trans('crudevents::event.actions') }}</td>
	</thead>
	@forelse ($events as $event)
		<tr>
			<td>{{ $event->name }}</td>
			<td>{{ $event->event_start }}</td>
			<td>{{ $event->event_end }}</td>
			<td class="text-center">
				<a class="me-4" href="{{ route(config('crudevents.route'), ['id' => $event->id]) }}" title="{{ trans('crudevents::event.show') }}">
					<x-iconcomponents::search color="green" />
				</a>
			</td>
			<td class="text-center">
				<a class="me-4" href="{{ route($baseroute . 'edit', ['id' => $event->id]) }}" title="{{ trans('crudevents::event.edit') }}">
					<x-iconcomponents::pencil-square />
				</a>
			</td>
			<td class="text-center">
				<a href="{{ route($baseroute . 'delete', ['id' => $event->id]) }}" onclick="return confirm('{{ trans('crudevents::event.delete.confirm') }}')" title="{{ trans('crudevents::event.delete') }}">
					<x-iconcomponents::trash color="red" />
				</a>
			</td>
		</tr>
	@empty
		<tr>
			<td class="text-center" colspan="7">{{ trans('crudevents::event.noevents') }}</td>
		</tr>
	@endforelse
</table>
@endsection