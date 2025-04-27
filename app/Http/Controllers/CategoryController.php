<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }

    public function create(){
        $all_categories = $this->category->paginate(10);

        return view('projects.category-create')
                ->with('all_categories', $all_categories);
    }

    public function store(Request $request){
        // $request->validate([
        //     'category'    => 'required|min:1|max:50|unique:categories,name'
        // ]);

        $this->category->name = $request->category;
        $this->category->save();

        return redirect()->back();
    }

    public function update(Request $request,$id){
        // $request->validate([
        //     'category'    => 'required|min:1|max:50|unique:categories,name'
        // ]);

        $category = $this->category->findOrFail($id);
        $category->name = $request->category;
        $category->save();

        return redirect()->back();
    }

    public function destroy($id){
        $this->category->destroy($id);

        return redirect()->back();
    }
}
