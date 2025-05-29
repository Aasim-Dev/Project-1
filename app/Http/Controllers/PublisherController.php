<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use App\Models\Message;


class PublisherController extends Controller
{   //for showing the dashboard
    public function index(){
        $user = Auth::user();
        $orders = Order::where('publisher_id', $user->id)->get();
        $wallets = Wallet::where('user_id', $user->id)->where('credit_debit', 'credit')->sum('amount');
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
        $websites = Website::where('user_id', $user->id)->count('id');
        return view('publisher.dashboard', compact('user', 'orders', 'wallets', 'websites', 'totalBalance'));
    }

    //for Showing Orders to the Publisher
    public function showOrders(Request $request){
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
        $orders = Order::where('publisher_id', $user->id)->get();
        $new = Order::where('status', 'new')->where('publisher_id', $user->id)->count();
        $in_progress = Order::where('status', 'in_progress')->where('publisher_id', $user->id)->count();
        $completed = Order::where('status', 'complete')->where('publisher_id', $user->id)->count();
        $reject = Order::where('status', 'reject')->where('publisher_id', $user->id)->count();
        $messages = Message::where('receiver_id', $user->id)->get();
        if($user){
            return view('publisher.order.list', compact('orders', 'messages', 'new', 'in_progress', 'completed', 'reject', 'totalBalance'));
        }
    }

    //for updating orderStatus
    public function updateRequest(Request $request){
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
            'id'=> ['required', 'exists:orders,id'],
            'status' => ['required', 'string', 'in:in_progress,reject']
        ]);
        $order = Order::findorFail($request->id);
        $order->status = $request->status;
        $order->save();

        if($request->status == 'in_progress'){
            $wallets = Wallet::where('user_id', $order->advertiser_id)->where('credit_debit', 'debit')->orderBy('id', 'DESC')->first();
            if($wallets){
                $wallets = Wallet::create([
                    'user_id' => $user->id,
                    'order_type' => 'ORDERPLACEMENT',
                    'description' => 'Order sells successfully',
                    'payment_status' => 'COMPLETED',
                    'credit_debit' => 'credit',
                    'amount' => $order->price,
                    'total' => $totalBalance + $order->price ,
                    'updated_at' => now(),
                ]);
                return response()->json(['message' => 'Payment completed successfully.']);
            } 
        }elseif($request->status == 'reject'){
            $wallet = Wallet::where('payment_status', 'COMPLETED')->where('user_id', $order->advertiser_id);
            if($wallet){
                $totalBalance = Wallet::where('user_id', $order->advertiser_id)
                ->selectRaw("
                    SUM(CASE WHEN credit_debit = 'credit' THEN amount ELSE 0 END) - 
                    SUM(CASE WHEN credit_debit = 'debit' THEN amount ELSE 0 END) AS balance
                ")
                ->value('balance');
                $totalBalance = $totalBalance ?? 0;
            }
            $wallets = Wallet::where('user_id', $order->advertiser_id)->where('credit_debit', 'debit')->orderBy('id', 'DESC')->first();
            if($wallets){
                $wallets = Wallet::create([
                    'user_id' => $order->advertiser_id,
                    'order_type' => 'refund',
                    'description' => 'refund place successfully',
                    'payment_status' => 'COMPLETED',
                    'credit_debit' => 'credit',
                    'amount' => $order->price,
                    'total' => $wallets->total + $order->price,
                    'updated_at' => now(),
                ]);
                return response()->json(['message' => 'Refund completed successfully.']);
            }
        }

        return response()->json(['message' => 'Order status updated successfully.']);
    }

    //for the create Websites page
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
        $user = Auth::user();
        $posts = Website::all();
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
        $user = auth()->user();
        if($user->user_type == "Admin"){
            $posts = Website::all();
        }elseif($user->user_type == "Publisher"){
            $posts = Website::/*with('category')->*/where('user_id', auth()->user()->id)->get();
        }else{
            abort(403, 'Unauthorized Access');
        }   
        return view('publisher.website.list', compact('posts', 'wallet', 'totalBalance'));
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
        $idExists = DB::table('websites')->where('id', $request->id)->exists();
        if ($idExists) {
                
                DB::table('websites')
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
                    $url = preg_replace("/^https?:\/\/(www\.)?/", "", $request->website_url);
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
                    Website::create([
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
        $post = Website::findOrFail($request->id);
        $post->delete();
    
        return response()->json(['success' => 'Category deleted successfully.']);
    }
    //I have created this function so that we can declare this variable into the blade file.
    public function showCategories(){
        $categories = Category::all();
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
        $normalCategories = Category::where('type', 'normal')->get();
        $otherCategories = Category::where('type', 'other')->get();

        return view('publisher.website.create', compact('categories', 'normalCategories', 'otherCategories', 'totalBalance'));
    }

    public function orderData(Request $request){
        $user = Auth::user();
        $query = Order::where('publisher_id', $user->id);
        $search = $request->search['value'];
        $search = strtolower($search);
        // $statusMap = [
        //     'new' => 1,
        //     'in_progress' => 2,
        // ];

        // if(array_key_exists($search, $statusMap)){
        //     $query->where('status', $statusMap[$search]);
        // }
        if(isset($search)){
            $query->where(function($q) use ($search){
                $q->where('host_url', 'like', "%{$search}%")
                ->orWhere('price', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
            });
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)
            ->editColumn('created_at', function($row){
                return $row->created_at;
            })
            ->editColumn('id', function($row){
                return '#' . $row->id;
            })
            ->editColumn('host_url', function($row){
                return '<a href="'. $row->website_url .'" target="_blank">' . $row->host_url . '</a>';
            })
            ->editColumn('price', function($row){
                return $row->price > 0 ? '$' . $row->price : '-';
            })
            ->editColumn('language', function($row){
                return $row->language;
            })
            ->editColumn('type', function($row){
                $type = (($row->type == 'provide_content') ? "Guest Post" :(($row->type == 'expert_writer') ? "Content and Guest Post" : (($row->type == 'link_insertion') ? "Link Insertion" : "Null")));
                return $type;
            })
            ->editColumn('tat', function($row){
                $tat = $row->tat;
                $days = intval($tat);
                $hours = $days * 24;
                return $hours . ' hours ';
            })
            ->editColumn('status', function($row){
                return $row->status;
            })
            ->addColumn('action', function($row){
                return '<button class="approve" data-id="' . $row->id . '">Approve</button> <button class="reject" data-id="' . $row->id . '">Reject</button>';
            })
            ->addColumn('chat', function($row){
                return '<button class="open-chat" data-order-id="'.$row->id.'" data-user-id="'.$row->publisher_id.'" data-sender-id="'.$row->advertiser_id.'">Chat</button>';
            })
            ->rawColumns(['host_url', 'action', 'chat'])
            ->make(true);
    }
}
