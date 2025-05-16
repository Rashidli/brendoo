<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-rules|create-rules|edit-rules|delete-rules', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-rules', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-rules', ['only' => ['edit']]);
        $this->middleware('permission:delete-rules', ['only' => ['destroy']]);
    }

    public function generateUniqueSlug($title, $itemId = null)
    {
        $slug = Str::slug($title);

        if ($itemId) {
            $count = Rule::query()->whereNot('id', $itemId)->whereTranslation('title', $title)->count();
        } else {
            $count = Rule::query()->whereTranslation('title', $title)->count();
        }

        if ($count > 0) {
            $slug .= '-' . $count;
        }

        return $slug;
    }

    public function index()
    {
        $rules = Rule::paginate(10);

        return view('admin.rules.index', compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'en_title'       => 'required',
            'ru_title'       => 'required',
            'en_description' => 'required',
            'ru_description' => 'required',
        ]);

        Rule::create([
            'en' => [
                'title'       => $request->en_title,
                'description' => $request->en_description,
                'slug'        => $this->generateUniqueSlug($request->en_title),
            ],
            'ru' => [
                'title'       => $request->ru_title,
                'description' => $request->ru_description,
                'slug'        => $this->generateUniqueSlug($request->ru_title),
            ],
        ]);

        return redirect()->route('rules.index')->with('message', 'Rule added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rule $rule): void {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rule $rule)
    {
        return view('admin.rules.edit', compact('rule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rule $rule)
    {
        $request->validate([
            'en_title'       => 'required',
            'ru_title'       => 'required',
            'en_description' => 'required',
            'ru_description' => 'required',
        ]);

        $rule->update([
            'is_active' => $request->is_active,
            'en'        => [
                'title'       => $request->en_title,
                'description' => $request->en_description,
                'slug'        => $this->generateUniqueSlug($request->en_title),
            ],
            'ru' => [
                'title'       => $request->ru_title,
                'description' => $request->ru_description,
                'slug'        => $this->generateUniqueSlug($request->ru_title),
            ],
        ]);

        return redirect()->back()->with('message', 'Rule updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rule $rule)
    {
        $rule->delete();

        return redirect()->route('rules.index')->with('message', 'Rule deleted successfully');
    }
}
