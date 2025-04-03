<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;


class PublisherController extends Controller
{   //for showing the dashboard
    public function index(){
        
        return view('publisher.dashboard');
    }
    //for the create posts page
    public function create(){
        return view('publisher.posts.create');
    }
    //for getting the category type from the category table
    public function getCategoriesByType(Request $request){
        $type = $request->input('type');
        if (!$request->has('type')) {
            return response()->json(['error' => 'No category type provided'], 400);
        }    
        $categories = Category::where('type', $request->type)->get();
        // dd($categories);
        return response()->json($categories);
    }
    //for showing what are the post available and I have uploaded
    public function list(){
        //use below variable for declaration because if not declared here than the categories.list file will not be run.
        $posts = Post::all();
        $user = auth()->user();
        if($user->user_type == "Admin"){
            $posts = Post::all();
        }elseif($user->user_type == "Publisher"){
            $posts = Post::/*with('category')->*/where('user_id', auth()->user()->id)->get();
        }else{
            abort(403, 'Unauthorized Access');
        }   
        return view('publisher.posts.list', compact('posts'));
    }
    //For updating and storing post to the table 
    protected function storePosts(Request $request){
            
        $request->validate([
            'website_url' => ['string', 'required', 'max:255', 'url'],
            //'host_url'=> ['string', 'required', 'max:255'],
            'da' => ['integer', 'required', 'min:1', 'max:100'],
            'sample_post' => ['string', 'required', 'max:255'],
            'country' => ['string', 'required', 'min:4']
        ]);
    
        //dd($request->all());
        $idExists = DB::table('posts')->where('id', $request->id)->exists();
        //dd($idExists);
            if ($idExists) {
                
                DB::table('posts')
                    ->where('id', $request->id)
                    ->update([
                        /*This is for database*/'website_url' => $request->website_url, /*This is for form*/  
                        'host_url'=> $request->host_url,
                        'da' => $request->da,
                        'sample_post' => $request->sample_post,
                        'country' => $request->country,               
                        'normal_gp' =>  $request->normal_gp,   
                        'normal_li' => $request->normal_li,
                        'other_gp' =>  $request->other_gp,   
                        'other_li' => $request->other_li,
                        'updated_at' => now(), 
                    ]);
            } else { 
                if(auth()->check()){
                    $user = optional(auth()->user())->email;
                    $url = $request->website_url;
                    $url = parse_url($request->website_url);

                    Post::create([
                        'website_url' => $request->website_url,                   
                        'host_url' => $url['host'] ?? null, 
                        'da' => $request->da,
                        'sample_post' => $request->sample_post,
                        'country' => $request->country,               
                        'normal_gp' =>  $request->normalGpPrice,
                        'normal_li' => $request->normalLiPrice,
                        'other_gp' =>  $request->otherGpPrice, 
                        'other_li' => $request->otherLiPrice,
                        'user_id' => auth()->user()->id,
                        
                    ]);
                }
            }
        
        return redirect()->route('posts.list')->with('success', 'Post added successfully.');

    }

    public function destroy(Request $request)
    {
        $category = Post::findOrFail($request->id);
        $category->delete();
    
        return response()->json(['success' => 'Category deleted successfully.']);
    }
    //I have created this function so that we can declare this variable into the blade file.
    public function showCategories(){
        $categories = Category::all();
        $normalCategories = Category::where('type', 'normal')->get();
        $otherCategories = Category::where('type', 'other')->get();

        return view('publisher.posts.create', compact('categories', 'normalCategories', 'otherCategories'));
    }
}
