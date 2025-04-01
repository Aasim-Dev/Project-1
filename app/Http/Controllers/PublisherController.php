<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PublisherController extends Controller
{
    public function index(){
        
        return view('publisher.dashboard');
    }
    public function list(){
        //use below variable for declaration because if not declared here than the categories.list file will not be run.
        $posts = Post::all();
        $user = auth()->user();
        if($user->user_type == "Admin"){
            $posts = Post::all();
        }elseif($user->user_type == "Publisher"){
            $posts = Post::where('user_id', auth()->user()->id)->get();
        }else{
            abort(403, 'Unauthorized Access');
        }   
        return view('publisher.posts.list', compact('posts'));
    }
    protected function storePosts(Request $request){
            
        $request->validate([
            'website_url' => ['string', 'required', 'max:255', 'url'],
            'host_url'=> ['string', 'required', 'max:255'],
            'da' => ['integer', 'required', 'min:1', 'max:100'],
            'sample_post' => ['string', 'required', 'max:255'],
            'country' => ['string', 'required', 'min:4'],
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
                if(auth()->check()){
                    $user = optional(auth()->user())->email;
                    Post::create([
                        'website_url' => $request->website_url,
                        'host_url'=> $request->host_url,
                        'da' => $request->da,
                        'sample_post' => $request->sample_post,
                        'country' => $request->country,               
                        'normal' =>  $request->normal,   
                        'other' => $request->other,
                        'user_id' => auth()->user()->id,
                        
                    ]);
                }
            }
        
        return redirect()->route('posts.list')->with('success', 'Post added successfully.');

    }
}
