<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $query = Translation::query();

        if ($request->name) {
            $query->whereHas('translation', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->name . '%');
            });
        }

        $translations = $query->get();
        return view('admin.translations.index', compact('translations'));
    }


    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.translations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
            'key'=>'required|unique:translations',
        ]);


        Translation::create([
            'key' => $request->key,
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('translations.index')->with('message','Translation added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Translation $translation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Translation $translation)
    {

        return view('admin.translations.edit', compact('translation'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Translation $translation)
    {

        $request->validate([
            'en_title'=>'required',
            'ru_title'=>'required',
        ]);

        $translation->update( [
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);

        return redirect()->back()->with('message','Translation updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Translation $translation)
    {
        $translation->delete();

        return redirect()->route('translations.index')->with('message', 'Translation deleted successfully');
    }

    public function importTranslations()
    {
        $langs = ['ru', 'en']; // İstədiyin dillər
        $allTranslations = [];

        foreach ($langs as $lang) {
            $path = resource_path("lang");
            $data = json_decode(File::get("{$path}/$lang.json"), true);
            $flat = $this->flattenArray($data);

            foreach ($flat as $key => $value) {
                $allTranslations[$key][$lang] = is_array($value) ? json_encode($value) : $value;
            }
        }

        foreach ($allTranslations as $key => $translations) {
            // Mövcud key varsa onu götür, yoxdursa insert et
            $existing = DB::table('translations')->where('key', $key)->first();

            if ($existing) {
                $translationId = $existing->id;
            } else {
                $translationId = DB::table('translations')->insertGetId([
                    'key' => $key,
                ]);
            }

            // Mövcud title varsa yenilə, yoxdursa əlavə et
            foreach ($translations as $locale => $title) {
                DB::table('translation_translations')->updateOrInsert(
                    [
                        'translation_id' => $translationId,
                        'locale' => $locale,
                    ],
                    [
                        'title' => $title,
                    ]
                );
            }
        }

        return 'All translations imported.';
    }


    private function flattenArray(array $array, $prefix = ''): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $fullKey = $prefix ? "{$prefix}.{$key}" : $key;

            if (is_array($value)) {
                $result += $this->flattenArray($value, $fullKey);
            } else {
                $result[$fullKey] = $value;
            }
        }

        return $result;
    }


}
