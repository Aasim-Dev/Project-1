<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){

        
        //dd($categories); //used for debuging because it was not fething it properly.
        return view('admin.dashboard');
    }
    protected function storeCategory(Request $request){
            
            $request->validate([
                'name' => ['required', 'min:4', 'max:255', 'string'],
                'tag' => ['required', 'max:255', 'string'],
                'description' => ['required', 'string', 'max:255'],
            ]);
        
            //dd($request->all());
            $idExists = DB::table('categories')->where('id', $request->id)->exists();
            //dd($idExists);
            if ($idExists) {
                
                DB::table('categories')
                    ->where('id', $request->id)
                    ->update([
                        'name' => $request->name,
                        'description' => $request->description,
                        'tag' => $request->tag,
                        'type' => $request->type,
                        'updated_at' => now(), 
                    ]);
            } else {
                Category::create([  
                    'name' => $request->name,
                    'description' => $request->description,
                    'tag' => $request->tag,
                    'type' => $request->type,
                ]);
            }
        
        return redirect()->route('categories.list')->with('success', 'Category added successfully.');
   
    }

    public function destroy(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->delete();
    
        return response()->json(['success' => 'Category deleted successfully.']);
    }

    public function list(){
        //use below variable for declaration because if not declared here than the categories.list file will not be run.
        $categories = Category::all();   
        return view('admin.categories.list', compact('categories'));
    }

    protected function posts(Request $request){
            
        $request->validate([
            'website_url' => ['string', 'required', 'max:255'],
            'host_url'=> ['string', 'required', 'max:255'],
            'da' => ['integer', 'required', 'min:1', 'max:100'],
            'sample_post' => ['string', 'required', 'max:255'],
            'country' => ['string', 'required'],
            'normal' => ['string'],
            'other' => ['string'],
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
                        'normal' =>  $request->normal,   
                        'other' => $request->other,
                        'updated_at' => now(), 
                    ]);
            } else {
                Post::create([
                    'website_url' => $request->website_url,
                    'host_url'=> $request->host_url,
                    'da' => $request->da,
                    'sample_post' => $request->sample_post,
                    'country' => $request->country,               
                    'normal' =>  $request->normal,   
                    'other' => $request->other,
                ]);
            }
        
        return redirect()->route('publisher.dashboard')->with('success', 'Post added successfully.');

    }

    public function post(){
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    public function showOrders(){
        $orders = Order::all();
        return view('admin.orders.list', compact('orders'));
    }

}
