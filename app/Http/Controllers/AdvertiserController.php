<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use DB;

class AdvertiserController extends Controller
{
    //This above Logic is for the Advertiser dashboard
    public function index(){
        $user = Auth::user();

        return view('advertiser.dashboard');
    }

    public function show(){
        $orders = Order::all();
        $user = Auth::user();
        if($user->user_type == "Admin"){
            $orders = Order::all();
        }
        elseif($user->user_type == "Advertiser"){
            $orders = Order::where('advertiser_id', $user->id)->get();
        }
        else{
            abort(403, "Unauthorized Access");
            return redirect()->back();
        }
        return view('advertiser.orders.list', compact('orders'));
    }

    public function create(){
        $carts = Cart::where('advertiser_id' , Auth::id())->get();
        $cartIds = $carts->pluck('website_id')->toArray();
        $posts = Post::all(); // or use a filtered list if needed
        $prices = [];
        foreach($posts as $post){
            $prices[$post->id] = [
                'normal_gp' => $post->normal_gp * 1.3,
                'normal_li' => $post->normal_li * 1.3,
                'other_gp' => $post->other_gp * 1.3,
                'other_li' => $post->other_li * 1.3,
            ];
        }
        return view('advertiser.orders.create', compact('posts', 'carts', 'cartIds', 'prices'));
    }

    public function showWebsite(){
        $websites = Post::all(); 
        return view('advertiser.website.list' ,compact('websites'));
    }

    protected function storeOrder(Request $request){
        //dd($request->all());
        $request->validate([
            'advertiser_id'=> ['exists:users,id'],
            'website_id' => ['exists:posts,id' ],
            'purpose' => ['string', 'max:255'],
            'price' => ['numeric', 'min:0'],
            'status' => ['string', 'in:pending,approved,rejected,cancelled'],           
        ]);
        
        $posts = Post::findOrFail($request->website_id);  // Assuming $id is the website_id
        $publisherId = $posts->user_id;
        Order::create([
            'advertiser_id' => Auth::user()->id,
            'publisher_id' => $publisherId,
            'website_id' => $request->website_id,
            'purpose' => $request->purpose,
            'price' => $request->price,
            'status' => $request->status,
        ]);
        
        return redirect()->route('orders.list')->with('success', 'Order Created Successfully');
    }
    //Here the Advertiser Logic is ending.


    public function cartCount(){
        $advertiserId = Auth::id();
        $count = Cart::where('advertiser_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }

    //Here is the Start of the Cart logic 
    public function cartItems(){
        $advertiserId = Auth::id();
        $cartItems = Cart::with('post')->where('advertiser_id', $advertiserId)->get();
        return view('advertiser.cart.cartItems', compact('cartItems'));
    }

    public function cartStore(Request $request){
        $advertiserId = Auth::id();
        $websiteId = $request->website_id;
        $exists = Cart::where('advertiser_id', $advertiserId)->where('website_id', $websiteId)->first();
        if(!$exists){
            Cart::create([
                'advertiser_id' => $advertiserId,
                'website_id' => $websiteId,
                'status' => 1

            ]);
        }
        return response()->json(['status'=>'success', 'message' => 'Wbsite Added To Cart Successfully']);
    }

    public function getCartWebsites() {
        $cartIds = Cart::where('advertiser_id', Auth::id())->pluck('website_id')->toArray();
        return response()->json(['cart' => $cartIds]);
    }
    
    public function toggleCart(Request $request){
        $advertiserId = Auth::id();
        $websiteId = $request->website_id;

        $cartItem = Cart::where('advertiser_id', $advertiserId)->where('website_id', $websiteId)->first();
        if($cartItem){
            $cartItem->delete();
            return response()->json(['status' => 'removed', 'message' => 'Website Removed']);
        }else{
            Cart::create([
                'advertiser_id' => $advertiserId,
                'website_id' => $websiteId,
                'status' => 1

            ]);
            return response()->json(['status'=>'success', 'message' => 'Website Added To Cart Successfully']);
        }
    }
    public function cancelOrder(Request $request) {
        $request->validate([
            'id' => ['required', 'exists:orders,id'],
            'status' => ['required', 'string', 'in:cancelled']
        ]);
    
        $order = Order::findOrFail($request->id);
        $order->status = $request->status;
        $order->save();
        return response()->json(['message' => 'Order Cancelled Successfully']);
    }
}

