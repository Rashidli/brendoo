<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filter;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-options|create-options|edit-options|delete-options', ['only' => ['index','show']]);
        $this->middleware('permission:create-options', ['only' => ['create','store']]);
        $this->middleware('permission:edit-options', ['only' => ['edit']]);
        $this->middleware('permission:delete-options', ['only' => ['destroy']]);
    }

    public function index($filterId)
    {
        $filter = Filter::findOrFail($filterId);
        $options = $filter->options()->get();

        return view('admin.options.index', compact('filter', 'options'));
    }

    public function create($filterId)
    {
        $filter = Filter::findOrFail($filterId);
        return view('admin.options.create', compact('filter'));
    }

    public function store(Request $request, $filterId)
    {
        $filter = Filter::findOrFail($filterId);

        $request->validate([
            'en_title' => 'required',
            'ru_title' => 'required',
            'color_code' => 'nullable',
        ]);

        $filter->options()->create([
            'color_code' => $request->color_code,
            'en' => ['title' => $request->en_title],
            'ru' => ['title' => $request->ru_title]
        ]);

        return redirect()->route('filters.options.index', $filterId)->with('message', 'Option added successfully');
    }

    public function show($filterId, $optionId)
    {
        $filter = Filter::findOrFail($filterId);
        $option = $filter->options()->findOrFail($optionId);

        return view('admin.options.show', compact('filter', 'option'));
    }

    public function edit($filterId, $optionId)
    {
        $filter = Filter::findOrFail($filterId);
        $option = $filter->options()->findOrFail($optionId);

        return view('admin.options.edit', compact('filter', 'option'));
    }

    public function update(Request $request, $filterId, $optionId)
    {
        $filter = Filter::findOrFail($filterId);
        $option = $filter->options()->findOrFail($optionId);

        $request->validate([
            'en_title' => 'required',
            'ru_title' => 'required',
            'color_code' => 'nullable',
        ]);

        $option->update([
            'color_code' => $request->color_code,
            'en' => ['title' => $request->en_title],
            'ru' => ['title' => $request->ru_title]
        ]);

        return redirect()->route('filters.options.index', $filterId)->with('message', 'Option updated successfully');
    }

    public function destroy($filterId, $optionId)
    {
        $filter = Filter::findOrFail($filterId);
        $option = $filter->options()->findOrFail($optionId);

        $option->delete();

        return redirect()->route('filters.options.index', $filterId)->with('message', 'Option deleted successfully');
    }
}
