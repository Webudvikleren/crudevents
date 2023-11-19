<?php

namespace Webudvikleren\CrudEvents\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Webudvikleren\CrudEvents\Models\CrudEvent;

class AdminCrudEventController extends Controller
{
	protected string $baseroute = 'admin.crudevents.';
	protected array $breadcrumbs = [];

    public function create()
    {
		$this->breadcrumbs[] = [trans('crudevents::event.events'), route($this->baseroute . 'index')];
        return view('crudevents::admin.create')
				->with('baseroute', $this->baseroute)
				->with('breadcrumbs', $this->breadcrumbs);
    }

    public function delete(int $id)
    {
        $event = CrudEvent::findOrFail($id);
		if ($event->image !== null)
		{
			Storage::disk(config('crudevents.storage.disk'))->delete($event->image);
		}
        $event->delete();

        session()->flash('success', trans('crudevents::event.deleted') .'.');
        return redirect()->route($this->baseroute . 'index');
    }

    public function edit(int $id)
    {
        $this->breadcrumbs[] = [trans('crudevents::event.events'), route($this->baseroute . 'index')];
        $event = CrudEvent::findOrFail($id);
        return view('crudevents::admin.edit')
				->with('baseroute', $this->baseroute)
				->with('breadcrumbs', $this->breadcrumbs)
                ->with('event', $event);
    }

    public function index()
    {
        $events = CrudEvent::where('event_start', '>', Carbon::now())->orderBy('event_start')->get();
        return view('crudevents::admin.index')
				->with('baseroute', $this->baseroute)
				->with('breadcrumbs', $this->breadcrumbs)
                ->with('events', $events);
    }

	public function store(Request $request)
    {
		$validated = $request->validate([
			'name' => ['required', 'string'],
            'event_start' => ['required', 'date_format:Y-m-d\ H:i'],
            'event_end' => ['required', 'date_format:Y-m-d\ H:i', 'after:event_start'],
            'image' => ['image', 'max:2048'],
            'location' => ['string'],
            'public' => ['boolean'],
            'description' => ['nullable', 'string'],
            'text' => ['nullable', 'string'],
		], [
			// TODO: fix?
		]);

		DB::transaction(function () use ($validated, $request) {
			$event = CrudEvent::create([
				'name' => $validated['name'],
				'event_start' => $validated['event_start'],
				'event_end' => $validated['event_end'],
				'location' => $validated['location'],
				'public' => $validated['public'] ? true : false,
				'description' => $validated['description'],
				'text' => $validated['text'],
			]);

			if ($request->image !== null)
			{
				$path = config('crudevents.image.path');
				$filename = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
				Storage::disk(config('crudevents.storage.disk'))->putFileAs($path, $request->image, $filename);

				$event->image = $path . '/' . $filename;
				$event->save();
			}
		});

        session()->flash('success', trans('crudevents::event.created') . '.');
        return redirect()->route($this->baseroute . 'index');
    }

	public function update(int $id, Request $request)
    {
        $event = CrudEvent::findOrFail($id);
		$validated = $request->validate([
			'name' => ['required', 'string'],
            'event_start' => ['required', 'date_format:Y-m-d\ H:i'],
            'event_end' => ['required', 'date_format:Y-m-d\ H:i', 'after:event_start'],
            'image' => ['image', 'max:2048'],
            'location' => ['string'],
            'public' => ['boolean'],
            'description' => ['nullable', 'string'],
            'text' => ['nullable', 'string'],
		], [
			// TODO: fix?
		]);

		$event->update([
            'name' => $validated['name'],
            'event_start' => $validated['event_start'],
            'event_end' => $validated['event_end'],
            'location' => $validated['location'],
            'public' => $validated['public'] ?? false,
            'description' => $validated['description'],
            'text' => $validated['text'],
        ]);
		$event->save();

		if ($request->image !== null)
		{
			if ($event->image !== null)
			{
				Storage::delete($event->image);
			}

			$path = config('crudevents.image.path');
			$filename = Str::uuid() . '.' . $request->image->getClientOriginalExtension();
			Storage::disk(config('crudevents.storage.disk'))->putFileAs($path, $request->image, $filename);

			$event->image = $filename;
			$event->save();
		}

        session()->flash('success', trans('crudevents::event.updated') . '.');
        return redirect()->route($this->baseroute . 'index');
    }
}