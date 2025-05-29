<?php

namespace App\Http\Controllers;
use App\Models\Website;
use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use App\Services\GoogleSheetServices;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use DB;
use \Cache;
use App\Models\UrlChecker;

class AdvertiserController extends Controller
{
    //This above Logic is for the Advertiser dashboard
    public function index(){
        $user = Auth::user();
        $orders = Order::where('advertiser_id', $user->id)->get();
        $wallet = Wallet::where('payment_status', 'COMPLETED')->where('user_id', $user->id);
        if($wallet){
            $totalBalance = Wallet::where('user_id', $user->id)
            ->selectRaw("
                SUM(CASE WHEN credit_debit = 'credit' THEN amount ELSE 0 END) - 
                SUM(CASE WHEN credit_debit = 'debit' THEN amount ELSE 0 END) AS balance
            ")
            ->value('balance');
            $totalBalance = $totalBalance ?? 0;
        }

        return view('advertiser.dashboard', compact('user', 'wallet', 'orders', 'totalBalance'));
    }

    public function apiPage(){
        $user = Auth::user();
        $wallet = Wallet::where('payment_status', 'COMPLETED')->where('user_id', $user->id);
        if($wallet){
            $totalBalance = Wallet::where('user_id', $user->id)
            ->selectRaw("
                SUM(CASE WHEN credit_debit = 'credit' THEN amount ELSE 0 END) - 
                SUM(CASE WHEN credit_debit = 'debit' THEN amount ELSE 0 END) AS balance
            ")
            ->value('balance');
            $totalBalance = $totalBalance ?? 0;
        }
        $token = null;
        if($totalBalance > 0 && $totalBalance != null){
            if(!$user->openapi_token){
                User::where('id', $user->id)->update([
                    'openapi_token' => Str::random(32),
                ]); 
            }
            $token = $user->openapi_token;            
        }elseif($totalBalance == 0 || $totalBalance == null){
            if($user->openapi_token){
                User::where('id', $user->id)->update([
                    'openapi_token' => null,
                ]);
            }
            $token = $user->openapi_token;
        }
        return view('advertiser.api.apipage', compact('user', 'totalBalance', 'token'));
    }

    public function show(){
        $user = Auth::user();
        $orders = Order::all();
        $wallet = Wallet::where('payment_status', 'COMPLETED')->where('user_id', $user->id);
        $new = Order::where('advertiser_id', $user->id)->where('status', 'new')->count();
        $in_progress = Order::where('advertiser_id', $user->id)->where('status', 'in_progress')->count();
        $completed = Order::where('advertiser_id', $user->id)->where('status', 'complete')->count();
        $reject = Order::where('advertiser_id', $user->id)->where('status', 'reject')->count();
        if($wallet){
            $totalBalance = Wallet::where('user_id', $user->id)
            ->selectRaw("
                SUM(CASE WHEN credit_debit = 'credit' THEN amount ELSE 0 END) - 
                SUM(CASE WHEN credit_debit = 'debit' THEN amount ELSE 0 END) AS balance
            ")
            ->value('balance');
            $totalBalance = $totalBalance ?? 0;
        }
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
        return view('advertiser.orders.list', compact('orders', 'totalBalance', 'new', 'in_progress', 'completed', 'reject'));
    }

    public function create(){
        $user = Auth::user();
        $carts = Cart::where('advertiser_id' , Auth::id())->get();
        $wallet = Wallet::where('payment_status', 'COMPLETED')->where('user_id', $user->id);
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
        $websites = Website::all(); // or use a filtered list if needed
        $prices = [];
        $total = 0;
        foreach ($carts as $item) {
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
        return view('advertiser.orders.create', compact('websites', 'carts', 'cartIds', 'prices', 'cartItems', 'total', 'totalBalance'));
    }

    public function showWebsite(){
        $user = Auth::user();
        $websites = Website::all();
        $wallet = Wallet::where('payment_status', 'COMPLETED')->where('user_id', $user->id);
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
        $user = Auth::user();
        $wallet = Wallet::where('payment_status', 'COMPLETED')->where('user_id', $user->id);
        if($wallet){
            $totalBalance = Wallet::where('user_id', $user->id)
            ->selectRaw("
                SUM(CASE WHEN credit_debit = 'credit' THEN amount ELSE 0 END) - 
                SUM(CASE WHEN credit_debit = 'debit' THEN amount ELSE 0 END) AS balance
            ")
            ->value('balance');
            $totalBalance = $totalBalance ?? 0;
        }
        $request->validate([
            'advertiser_id'=> ['exists:users,id'],
            'website_id' => ['exists:websites,id' ],         
        ]);
        $total = $request->price;
        //dd($total);
        if($totalBalance < $total){
            return response()->json(['success' => false, 'message' => 'Insufficient balance.'], 403);
        }
        $websites = Website::findOrFail($request->website_id);  // Assuming $id is the website_id
        $publisherId = $websites->user_id;
        $carts = Cart::where('website_id', $request->website_id)->first();
        $user = User::where('id', $carts->advertiser_id)->first();
        $price = ($carts->guest_post_price ?? $carts->linkinsertion_price) * 1.3;

        $orders = Order::create([
            'advertiser_id' => Auth::user()->id,
            'publisher_id' => $publisherId,
            'website_id' => $request->website_id,
            'host_url' => $carts->host_url,
            'da' => $carts->da,
            'tat' => $carts->tat,
            'semrush' => $carts->semrush,
            'price' => $total,
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

        if($orders){
            return response()->json(['success']);
        }

        $sheet = new GoogleSheetServices();
        $sheet->saveDataToSheet([[
            $user->name, 
            $publisherId,
            $request->website_id,
            $carts->host_url,
            $carts->da,
            $carts->tat,
            $carts->semrush,
            $total,
            $carts->type,
            $carts->language,
            $carts->attachment,
            $carts->special_instruction,
            $carts->existing_post_url,
            $carts->title_suggestion,
            $carts->keywords,
            $carts->anchor_text,
            $carts->country,
            $carts->word_count,
            $carts->category,
            $carts->reference_link,
            $carts->target_url,
            $carts->special_note,
            now()->toDateTimeString(),
        ]]);
        //dd($sheet);
        $carts->delete();
        $totalBalance -= $total;
        Wallet::create([
            'user_id' => $user->id,
            'order_type' => 'ORDERPLACEMENT',
            'description' => 'Order placed successfully',
            'payment_status' => 'COMPLETED',
            'credit_debit' => 'debit',
            'amount' => $total,
            'total' => $totalBalance,
            'updated_at' => now(),
        ]);
        $ord = Order::all();
        return view('advertiser.orders.list');
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
        $websites = Website::all();
        $wallet = Wallet::where('payment_status', 'COMPLETED')->where('user_id', $user->id);
        if($wallet){
            $totalBalance = Wallet::where('user_id', $user->id)
            ->selectRaw("
                SUM(CASE WHEN credit_debit = 'credit' THEN amount ELSE 0 END) - 
                SUM(CASE WHEN credit_debit = 'debit' THEN amount ELSE 0 END) AS balance
            ")
            ->value('balance');
            $totalBalance = $totalBalance ?? 0;
        }
        $cartItems = Cart::with('website')->where('advertiser_id', $advertiserId)->get();
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
        $website = Website::where('id', $websiteId)->first();
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

    public function getPrice(Request $request){
        $url = preg_replace("/^https?:\/\/(www\.)?/", "", $request->priceUpdate);
        //dd($url);
        $url1 = $request->priceUpdate;
        $user = Auth::user();
        $website = Website::where('host_url', $url)->first();
        if(!$website){
            return response()->json(['error' => 'Website not found', 'status' => 'error']);
        }
        if($website){
            return response()->json([
                'status' => 'success',
                'guest_post_price' => $website->guest_post_price,
                'linkinsertion_price' => $website->linkinsertion_price,
            ]);
        }
    }

    public function urlCheck(){
        $user = Auth::user();
        $wallet = Wallet::where('payment_status', 'COMPLETED')->where('user_id', $user->id);
        if($wallet){
            $totalBalance = Wallet::where('user_id', $user->id)
            ->selectRaw("
                SUM(CASE WHEN credit_debit = 'credit' THEN amount ELSE 0 END) - 
                SUM(CASE WHEN credit_debit = 'debit' THEN amount ELSE 0 END) AS balance
            ")
            ->value('balance');
            $totalBalance = $totalBalance ?? 0;
        }
        $checkers = UrlChecker::where('user_id', $user->id)->get();
        return view('advertiser.urlChecker', compact('totalBalance', 'checkers'));
    }

    public function urlCheckSave(Request $request){
        $user = Auth::user();
        //dd($request->urls);
        $urls = $request->urls;
        $batchId = Str::random(5);
        foreach($urls as $url){
            $check = UrlChecker::create([
                'user_id' => $user->id,
                'url' => $url,
                'batch_id' => $batchId,
            ]);
        }
        return response()->json(['status' => 'success']);
    }

    
}

