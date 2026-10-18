<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelRequest;
use App\Models\Label;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class LabelController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [new Middleware('auth', except: ['index'])];
    }

    public function index()
    {
        $labels = Label::orderBy('id')->get();

        return view('labels.index', compact('labels'));
    }

    public function create()
    {
        Gate::authorize('create', Label::class);

        return view('labels.create', ['label' => new Label()]);
    }

    public function store(LabelRequest $request)
    {
        Gate::authorize('create', Label::class);
        Label::create($request->validated());
        flash(__('labels.created'))->success();

        return redirect()->route('labels.index');
    }

    public function edit(Label $label)
    {
        Gate::authorize('update', $label);

        return view('labels.edit', compact('label'));
    }

    public function update(LabelRequest $request, Label $label)
    {
        Gate::authorize('update', $label);
        $label->update($request->validated());
        flash(__('labels.updated'))->success();

        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        Gate::authorize('delete', $label);

        if ($label->tasks()->exists()) {
            flash(__('labels.delete_failed'))->error();
        } else {
            $label->delete();
            flash(__('labels.deleted'))->success();
        }

        return redirect()->route('labels.index');
    }
}
