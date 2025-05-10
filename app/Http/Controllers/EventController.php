<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('status', 'active')->orderBy('event_date')->paginate(10);

        return Inertia::render('Events/Index', [
            'events' => $events,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Events/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate();
        $event = Event::create([
            'user_id' => auth()->id(),
            ...$validate,
        ]);

        return redirect()->route('events.show', $event)->with('Success', 'Event created successfully!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event->load(['user', 'registrations.user']);
        $isRegistered = auth()->check() ? $event->registrations()->where('user_id', auth()->id())->exists() : false;

        return Inertia::render('Events/Show', [
            'event' => $event,
            'isRegistered' => $isRegistered,
            'registationsCount' => $event->confirmedRegistrationsCount(),
            'isAtCapacity' => $event->isAtCapacity(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update', $event);

        return Inertia::render('Events/Edit', [
            'event'=> $event,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update', $event);

        $validate = $request->validated();
        $event->update($validated);

        return redirect()->route('events.show', $event)->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
