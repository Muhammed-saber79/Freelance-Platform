<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    protected $rules = [
        'name' => [
            'required',
            'string',
            'min:3'
        ],
        'parent_id' => [
            'nullable',
            'exists:categories,id'
        ]
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::leftJoin('categories as parent', 'parent.id', '=', 'categories.parent_id')
            ->select(['categories.*', 'parent.name as parent'])
            ->paginate(5);

        return view('categories.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = new Category;
        $parents = Category::all()->pluck('name', 'id');

        return view('categories.create', compact('category', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());

        /**
         * This is the way before knowing 'Mass Assignment' concept.
         * 
         * $category = new Category;
         * $category->name = $clean['name'];
         * $category->parent_id = $clean['parent_id'];
         * $category->save();
         */
        
        Category::create( $request->all() );

        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {        
        $category = Category::leftJoin('categories as parent', 'parent.id', '=', 'categories.parent_id')
        ->where('categories.id', '=', $id)
        ->select(['categories.*', 'parent.name as parent'])
        ->get()->all()[0];

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        $parents = Category::all()->pluck('name', 'id');

        return view('categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $clean = $request->validate($this->rules());

        $category = Category::findOrFail($id);
        $category->name = $clean['name'];
        $category->parent_id = $clean['parent_id'];
        $category->save();

        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::destroy($id);
        return redirect()
            ->route('dashboard.categories.index')
            ->with('danger', 'Category deleted successfully.');
    }

    /**
     * Here is a custome Rule to validate category name.
     */
    public function rules () {
        $rules = $this->rules;
        $rules['name'][] = function ($attribute, $value, $fail) {
            $pattern = '/\bgod\b/i';
            if (preg_match($pattern, $value)) {
                $fail('You are not allawed to use this word "god"...!');
            }
        };

        return $rules;
    }
}
