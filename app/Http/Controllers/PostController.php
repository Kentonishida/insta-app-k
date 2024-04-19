<?php

namespace App\Http\Controllers;

# categories table is required
# posts table is required
use Illuminate\Support\Facades\Auth; //authentication
use Illuminate\Http\Request;
use App\Models\Post;     //posts table
use App\Models\Category; //categories table

class PostController extends Controller
{
    #Define properties and constructor
    private $post;
    private $category;

    # Constructor
    public function __construct(Post $post, Category $category){
        $this->post = $post;
        $this->category = $category;
    }

    public function create(){
        $all_categories = $this->category->all(); //retrieve all the categories
        #Same as: SELECT * FROM categories;
        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    # Note: ( Request $request ) holds the data coming form the form in the create post page
    public function store(Request $request){
        # 1. Validate the data first
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        # 2. Save our data into the database
        # Auth class is required
        $this->post->user_id            = Auth::user()->id; //the owner of the post
        $this->post->image              = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->description        = $request->description;
        $this->post->save();

        # 3. Get the categories of the post and save the category id into the PIVOT table (category_post)
        # $request->category = [1, 5]
        foreach ($request->category as $category_id) {
            $category_post[] = ['category_id' => $category_id];

            #$request->category = [1, 5]
            # $category_post[1, 5]


        }
        $this->post->categoryPost()->createMany($category_post);

        # 4. Go back homepage
        return redirect()->route('index');
    }

    # This will open show post page
    # The $id ---> is the specific id of the post that we want to see
    # We will received that ID coming the route later on
    public function show($id){
        $post = $this->post->findOrFail($id);
        #SAME AS: SELECT * FROM posts WHERE id = $id;

        return view('users.posts.show')->with('post', $post);
    }

    # This will open show post page
    # The $id ---> is the specific id of the post that we want to update
    # We will received that ID coming the route later on
    public function edit($id){
        #SAME AS: SELECT * FROM  posts WHERE id = $id;
        $post = $this->post->findOrFail($id); //2
        #$post['id' => 2, 'description' => 'I like to travel around different places', 'image' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAegA', 'user_id' => 2, ...];

        # If the AUTH user is not the owner of the post, redirect them to the homepage
        if (Auth::user()->id != $post->user->id) {
            return redirect()->route('index'); //hompepage
        }

        # get all the categories from the categories table
        $all_categories =  $this->category->all();
        # SAME AS: SELECT * FROM categories;
        # $all_categories['Travel', 'Food', 'Lifestyle', 'Technology', ...]

        # Get all the category IDs of this post, and save it in an array
        $selected_categories = [];
        #          2  ->   1,3,5        -->  1,3,5 (selected categories)
        foreach ($post->categoryPost as $category_post) {
            $selected_categories[] = $category_post->category_id;
            #$selected_categories[1]
            #$selected_categories[3]
            ##$selected_categories[5]
        }

        return view('users.posts.edit')
            ->with('post', $post)
            ->with('all_categories', $all_categories)
            ->with('selected_categories', $selected_categories);
    }

    # This will do the actual updating of data
    public function update(Request $request, $id){
        # 1. validate the data first
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        # 2. Update the post details
        $post   = $this->post->findOrFail($id); # Same as: SELECT * FROM posts WHERE id = $id
        $post->description = $request->description;

        # Check if there is new image uploaded
        if ($request->image) {
            $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        }
        $post->save();

        # 3. Delete all records from the category lists (category_post) related to this post
        $post->categoryPost()->delete();
        # Use the relationship Post::categoryPost() to select the records related to a post
        # SAME AS: DELETE FROM category_post WHERE post_id = $id


        # 4. Save the new categories into the category_post PIVOT table
        foreach ($request->category as $category_id) {
            $category_post[] = ['category_id' => $category_id];
        }
        $post->categoryPost()->createMany($category_post);

        # 5. Redirect the user to the show post (to confirm the update)
        return redirect()->route('post.show', $id);
    }

    # This method is going to delete/destroy a post
    public function destroy($id){
        $post = $this->post->findOrFail($id); #SAME AS: DELETE FROM posts WHERE id = $id
        $post->forceDelete();
        
        # got to homepage
        return redirect()->route('index');
    }
}
