<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
    private $category;
    private $post;

    public function __construct(Category $category, Post $post){
        $this->category = $category;
        $this->post = $post;
    }

    public function index(){

        $all_categories = $this->category->orderBy('created_at', 'desc')->paginate(10);

        $uncategorized_count = 0;
        $all_posts = $this->post->all(); //SELECT * FROM posts;
        foreach ($all_posts as $post) {
            if ($post->categoryPost->count() == 0) {
                $uncategorized_count++; //increment this property for every post that do not have category
            }
        }

        return view('admin.categories.index')
            ->with('all_categories', $all_categories)
            ->with('uncategorized_count', $uncategorized_count);
    }

    # Note
    # 1. You have to convert the text into lowercase, and the first letter should be capitalize
    # 2. Save it into the categories table

    public function store(Request $request){
        # Validate the data first
        $request->validate([
            'name' => 'required|min:1|max:50|unique:categories,name'
        ]);

        $this->category->name = ucfirst(strtolower($request->name)); //SPORT --> sport -->Sport
        $this->category->save(); //SAME AS: INSERT INTO categories(`name`) VALUES('$request->name');

        return redirect()->back();
    }

    # Activity 04/17/2024
    # 1. Create the update method
    # 2. Add the validation and the codes
    # 3. Create the route
    # 4. Use the route
    public function update(Request $request, $id){
        $request->validate([
            'new_name' => 'required|min:1|max:50|unique:categories,name'
        ]);

        $category = $this->category->findOrFail($id);
        $category->name = ucfirst(strtolower($request->new_name));
        $category->save();

        return redirect()->back();
    }

    public function destroy($id){
        $this->category->destroy($id);
        return redirect()->back();
    }
}
