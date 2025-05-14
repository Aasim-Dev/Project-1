<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DB;

class AdvertiserController extends Controller
{
    //This above Logic is for the Advertiser dashboard
    public function index(){
        $user = Auth::user();

        return view('advertiser.dashboard');
    }

    public function show(){
        $user = Auth::user();
        $orders = Order::all();
        $wallet = Wallet::where('status', 'COMPLETED')->where('user_id', $user->id);
        if($wallet){
            $totalBalance = Wallet::where('user_id', $user->id)
            ->selectRaw("
                SUM(CASE WHEN credit_debit = 'credit' THEN amount ELSE 0 END) - 
                SUM(CASE WHEN credit_debit = 'debit' THEN amount ELSE 0 END) AS balance
            ")
            ->value('balance');
            $totalBalance = $totalBalance ?? 0;
        }
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
        return view('advertiser.orders.list', compact('orders', 'totalBalance'));
    }

    public function create(){
        $user = Auth::user();
        $carts = Cart::where('advertiser_id' , Auth::id())->get();
        $wallet = Wallet::where('status', 'COMPLETED')->where('user_id', $user->id);
        if($wallet){
            $totalBalance = Wallet::where('user_id', $user->id)
            ->selectRaw("
                SUM(CASE WHEN credit_debit = 'credit' THEN amount ELSE 0 END) - 
                SUM(CASE WHEN credit_debit = 'debit' THEN amount ELSE 0 END) AS balance
            ")
            ->value('balance');
            $totalBalance = $totalBalance ?? 0;
        }
        $cartItems = Cart::all();
        $cartIds = $carts->pluck('website_id')->toArray();
        $posts = Post::all(); // or use a filtered list if needed
        $prices = [];
        $total = 0;
        foreach ($cartItems as $item) {
            $type = $item->type;
            $wordCount = strtolower(trim($item->word_count));

            if (Str::contains($type, 'expert_writer')) {
                switch ($wordCount) {
                    case '500 words':
                        $total += ($item->guest_post_price + 20) * 1.3;
                        break;
                    case '1000 words':
                        $total += ($item->guest_post_price + 30) * 1.3;
                        break;
                    case '1500 words':
                        $total += ($item->guest_post_price + 35) * 1.3;
                        break;
                    case '2000 words':
                        $total += ($item->guest_post_price + 45) * 1.3;
                        break;
                    case '3000 words':
                        $total += ($item->guest_post_price + 65) * 1.3;
                        break;
                    case '100000':
                        $total += ($item->guest_post_price + 915) * 1.3;
                        break;
                    default:
                        $total += $item->guest_post_price * 1.3;
                }
            } elseif (Str::contains($type, 'provide_content')) {
                $total += $item->guest_post_price * 1.3;
            } elseif (Str::contains($type, 'link_insertion')) {
                $total += $item->linkinsertion_price * 1.3;
            } else {
                $total += $item->guest_post_price * 1.3; // fallback
            }
        }
        return view('advertiser.orders.create', compact('posts', 'carts', 'cartIds', 'prices', 'cartItems', 'total', 'totalBalance'));
    }

    public function showWebsite(){
        $user = Auth::user();
        $websites = Post::all();
        $wallet = Wallet::where('status', 'COMPLETED')->where('user_id', $user->id);
        if($wallet){
            $totalBalance = Wallet::where('user_id', $user->id)
            ->selectRaw("
                SUM(CASE WHEN credit_debit = 'credit' THEN amount ELSE 0 END) - 
                SUM(CASE WHEN credit_debit = 'debit' THEN amount ELSE 0 END) AS balance
            ")
            ->value('balance');
            $totalBalance = $totalBalance ?? 0;
        }
        return view('advertiser.website.list' ,compact('websites', 'totalBalance'));
    }

    protected function storeOrder(Request $request){
        //dd($request->all());
        $request->validate([
            'advertiser_id'=> ['exists:users,id'],
            'website_id' => ['exists:posts,id' ],         
        ]);
        $posts = Post::findOrFail($request->website_id);  // Assuming $id is the website_id
        $publisherId = $posts->user_id;
        $carts = Cart::where('website_id', $request->website_id)->first();
        $user = User::where('id', $carts->advertiser_id)->first();
        $price = ($carts->guest_post_price ?? $carts->linkinsertion_price) * 1.3;

        Order::create([
            'advertiser_id' => Auth::user()->id,
            'publisher_id' => $publisherId,
            'website_id' => $request->website_id,
            'host_url' => $carts->host_url,
            'da' => $carts->da,
            'tat' => $carts->tat,
            'semrush' => $carts->semrush,
            'price' => $price,
            'type' => $carts->type,
            'language' => $carts->language,
            'attachment' => $carts->attachment,
            'special_instruction' => $carts->special_instruction,
            'existing_post_url' => $carts->existing_post_url,
            'title_suggestion' => $carts->title_suggestion,
            'keywords' => $carts->keywords,
            'anchor_text' => $carts->anchor_text,
            'country' => $carts->country,
            'word_count' => $carts->word_count,
            'category' => $carts->category,
            'reference_link' => $carts->reference_link,
            'target_url' => $carts->target_url,
            'special_note' => $carts->special_note,
        ]);
        $carts->delete();
        $ord = Order::all();
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
        $user = Auth::user();
        $advertiserId = Auth::id();
        $websites = Post::all();
        $wallet = Wallet::where('status', 'COMPLETED')->where('user_id', $user->id);
        if($wallet){
            $totalBalance = Wallet::where('user_id', $user->id)
            ->selectRaw("
                SUM(CASE WHEN credit_debit = 'credit' THEN amount ELSE 0 END) - 
                SUM(CASE WHEN credit_debit = 'debit' THEN amount ELSE 0 END) AS balance
            ")
            ->value('balance');
            $totalBalance = $totalBalance ?? 0;
        }
        $cartItems = Cart::with('post')->where('advertiser_id', $advertiserId)->get();
        if($cartItems->isEmpty()){
            return view('advertiser.website.list', compact('websites', 'totalBalance'))->with('error', 'No Cart Items Found');
        }else{
            return view('advertiser.cart.items', compact('cartItems', 'totalBalance'));
        }
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
        //dd(auth()->user());
        $advertiserId = Auth::id();
        $websiteId = $request->website_id;
        $website = Post::where('id', $websiteId)->first();
        //dd($website->ahref_traffic);
        $cartItem = Cart::where('advertiser_id', $advertiserId)->where('website_id', $websiteId)->first();
        if($cartItem){
            $cartItem->delete();
            return response()->json(['status' => 'removed', 'message' => 'Website Removed']);
        }else{
            Cart::create([
                'advertiser_id' => $advertiserId,
                'website_id' => $websiteId,
                'host_url' => $website->host_url,
                'da' => $website->da,
                'tat' => $website->tat,
                'semrush' => $website->ahref_traffic,
                'guest_post_price' => $website->guest_post_price,
                'linkinsertion_price' => $website->linkinsertion_price,
                'status' => 'cart',

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

