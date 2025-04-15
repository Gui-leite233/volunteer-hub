<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('user')->paginate(10);

        return Inertia::render('Events/index', [
            'events' => $events
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
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'date' => 'required|date',
            'capacity' => 'required|integer|min:1',
            'category' => 'required|string|max:255',
        ]);

        $event = Auth::user()->events()->create($validate);

        return redirect()-route('events.show', $event)->with('sucesso', 'Evento Criado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event->load('user');
        
        return Inertia::render('Events/Show', [
            'event' => $event
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update', $event);

        return Inertia::render('Events/edit', [
            'event' =>$event
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update', $event);

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'date' => 'required|date',
            'capacity' => 'required|integer|min:1',
            'category' => 'required|string|max:255',
        ]);


        $event->update($validate);

        return redirect()->route('events.show', $event)->with('sucesso', 'Evento atualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', $event);

        $event->delete();


        return redirect()->route('events.index')->with('sucesso', 'Evento deletado');
    }
}
