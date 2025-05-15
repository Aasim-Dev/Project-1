<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Message;


class PublisherController extends Controller
{   //for showing the dashboard
    public function index(){
        $user = Auth::user();
        $orders = Order::where('publisher_id', $user->id)->get();
        $wallets = Wallet::where('user_id', $user->id)->where('credit_debit', 'credit')->sum('amount');
        $websites = Post::where('user_id', $user->id)->count('id');
        return view('publisher.dashboard', compact('user', 'orders', 'wallets', 'websites'));
    }

    //for Showing Orders to the Publisher
    public function showOrders(Request $request){
        $user = Auth::user();
        $orders = Order::where('publisher_id', $user->id)->get();
        $messages = Message::where('receiver_id', $user->id)->get();
        if($user){
            return view('publisher.order.list', compact('orders', 'messages'));
        }
    }

    //for updating orderStatus
    public function updateRequest(Request $request){
        $request->validate([
            'id'=> ['required', 'exists:orders,id'],
            'status' => ['required', 'string', 'in:in_progress,rejected']
        ]);
        $order = Order::findorFail($request->id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Order status updated successfully.']);
    }

    //for the create posts page
    public function create(){
        $categories = Category::all();
        $normalCategories = Category::where('type', 'normal')->get();
        $otherCategories = Category::where('type', 'other')->get();

        return view('publisher.website.create', compact('categories', 'normalCategories', 'otherCategories'));
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
        return view('publisher.website.list', compact('posts'));
    }
    //For updating and storing post to the table 
    protected function storePosts(Request $request){
        
        // $request->validate([
        //     'website_url' => ['string', 'required', 'max:255', 'url'],
        //     //'host_url'=> ['string', 'required', 'max:255'],
        //     'da' => ['integer', 'required', 'min:1', 'max:100'],
        //     'sample_post' => ['string', 'required', 'max:255'],
        //     'ahref_traffic' => ['integer'],
        //     'TaT' => ['required', 'string', 'in:1 day,2 days,3 days,4 days,5 days,6 days,7 days,8 days,9 days,10 days,11 days,12 days,13 days,14 days,15 days'],
        //     'country' => ['string', 'required', 'min:4']
        // ]);
        
        
        //dd($request->all());
        //dd($request->catenormal);
        $idExists = DB::table('posts')->where('id', $request->id)->exists();
        if ($idExists) {
                
                DB::table('posts')
                    ->where('id', $request->id)
                    ->update([
                        /*This is for database*/'website_url' => $request->website_url, /*This is for form*/  
                        'host_url'=> $request->host_url,
                        'da' => $request->da,
                        'sample_post' => $request->sample_post,
                        'country' => $request->country,               
                        'type' => $request->catenormal || $request->othercate,
                        'guest_post_price' => $request->normalGpPrice || $request->otherGpPrice,
                        'linkinsertion_price' =>$request->normalLiPrice || $request->otherLiPrice,
                        'updated_at' => now(), 
                    ]);
            } else { 
                if(auth()->check()){
                    $user = optional(auth()->user())->email;
                    $url = $request->website_url;
                    $url = parse_url($request->website_url);
                    //dd($request->catenormal);
                    $cate = '';
                    if($request->catenormal){
                        $cate = 'normal';
                    }
                    if($request->othercate){
                        $cate = 'other';
                    }
                    //dd($cate);
                    $val1 = $request->normalGpPrice ?? $request->otherGpPrice;
                    $val2 = $request->normalLiPrice ?? $request->otherLiPrice;
                    //dd($val2, $val1);
                    Post::create([
                        'website_url' => $request->website_url,                   
                        'host_url' => $url['host'] ?? null, 
                        'da' => $request->da,
                        'sample_post' => $request->sample_post,
                        'ahref_traffic' => $request->ahref_traffic,
                        'tat' => $request->TaT,
                        'country' => $request->country,               
                        'normal' => $cate,
                        'other' => $cate,
                        'guest_post_price' => $val1,
                        'linkinsertion_price' => $val2,
                        'user_id' => auth()->user()->id,
                        
                    ]);
                }
            }
        
        return redirect()->route('website.list')->with('success', 'Post added successfully.');

    }

    public function destroy(Request $request)
    {
        $post = Post::findOrFail($request->id);
        $post->delete();
    
        return response()->json(['success' => 'Category deleted successfully.']);
    }
    //I have created this function so that we can declare this variable into the blade file.
    public function showCategories(){
        $categories = Category::all();
        $normalCategories = Category::where('type', 'normal')->get();
        $otherCategories = Category::where('type', 'other')->get();

        return view('publisher.website.create', compact('categories', 'normalCategories', 'otherCategories'));
    }
}
