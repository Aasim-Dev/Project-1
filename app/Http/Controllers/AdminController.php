<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\Website;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\WalletsExportMail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(){
        $categories = Category::all();
        $websites = Website::all();
        $orders = Order::all();
        $users = User::where('user_type', '!=', 'Admin')->get();
        return view('admin.dashboard', compact('categories', 'websites', 'orders', 'users'));
    }

    public function showTransaction(Request $request){
        $wallet = Wallet::select('wallets.*', 'users.name as name', 'users.user_type as user_type')
            ->join('users', 'users.id', '=', 'wallets.user_id')
            ->orderBy('wallets.id', 'DESC')
            ->get();
        //dd($wallet);
        foreach($wallet as $wal){
            $role = $wal->user_type;
        }
        return view('admin.transactions', compact('wallet', 'role'));
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
        $cate = Category::find(1);
        //dd($cate);   
        return view('admin.categories.list', compact('categories', 'cate'));
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
        $idExists = DB::table('websites')->where('id', $request->id)->exists();
        //dd($idExists);
            if ($idExists) {
                
                DB::table('websites')
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
                Website::create([
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
        $posts = Website::all();
        return view('admin.posts.index', compact('posts'));
    }

    public function showOrders(){
        $orders = Order::all();
        $new = Order::where('status', 'new')->count();
        $in_progress = Order::where('status', 'in_progress')->count();
        $completed = Order::where('status', 'complete')->count();
        $reject = Order::where('status', 'reject')->count();
        return view('admin.orders.list', compact('orders', 'new', 'in_progress', 'completed', 'reject'));
    }

    public function updateRequest(Request $request){
        $request->validate([
            'id'=> ['required', 'exists:orders,id'],
            'status' => ['required', 'string', 'in:approved,rejected']
        ]);
        $order = Order::findorFail($request->id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Order status updated successfully.']);
    }

     public function orderData(Request $request){
        $query = Order::query();
        $query = Order::select(
                'orders.*',
                'publisher.name as publisher_name',
                'advertiser.name as advertiser_name'
            )
            ->join('websites', 'websites.id', '=', 'orders.website_id')
            ->join('users as publisher', 'publisher.id', '=', 'websites.user_id') // Publisher
            ->join('users as advertiser', 'advertiser.id', '=', 'orders.advertiser_id') // Advertiser
            ->orderBy('orders.id', 'DESC')->get();
        $search = $request->search['value'];
        if(isset($search)){
            $query->where(function($q) use ($search){
                $q->where('host_url', 'like', "%{$search}%");
            });
        }
        //dd($query);
        if ($request->status) {
            $query->where('status', '=', $request->status);
        }

        return DataTables::of($query)
            ->editColumn('created_at', function($row){
                return $row->created_at;
            })
            ->editColumn('id', function($row){
                return '#' . $row->id;
            })
            ->editColumn('advertiser_name', function($row){
                return $row->advertiser_name;
            })
            ->editColumn('host_url', function($row){
                return '<a href="'. $row->website_url .'" target="_blank">' . $row->host_url . '</a>';
            })
            ->editColumn('publisher_name', function($row){
                return $row->publisher_name;
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
                return $row->tat;
            })
            ->addColumn('status', function($row){
                return $row->status;
            })
            ->addColumn('action', function($row){
                return '<button class="open-chat" data-order-id="'.$row->id.'" data-user-id="'.$row->publisher_id.'">Chat</button>';
            })
            ->rawColumns(['host_url', 'action'])
            ->make(true);
    }

    public function transactionTable(Request $request){
        $wallet = Wallet::select('wallets.*', 'users.name as name', 'users.user_type as user_type')
            ->join('users', 'users.id', '=', 'wallets.user_id')
            ->orderBy('wallets.id', 'DESC');
        //dd($wallet);
        //dd($request->role_filter);

        $search = $request->search['value'] ?? null;
        if(isset($search)){
            $wallet->where(function($w) use ($search){
                $w->where('users.name', 'like', "%{$search}%")
                  ->orWhere('wallets.order_type', 'like', "%{$search}%");  
            });
        }
        if($request->role_filter){
            $wallet->where('users.user_type', '=', $request->role_filter);
        }
        if ($request->type_filter) {
            $wallet->where('wallets.credit_debit', $request->type_filter);
        }
        if($request->id_filter){
            $wallet->where('wallets.order_type', '=', $request->id_filter);
        }
        if($request->status_filter){
            $wallet->where('wallets.payment_status', '=', $request->status_filter);
        }
        if ($request->from_date && $request->to_date) {
            $wallet->whereBetween('wallets.created_at', [$request->from_date, $request->to_date]);
        }


        return DataTables::of($wallet)
            ->editColumn('users.name', function($row){
                return $row->name;
            })
            ->editColumn('role', function($row){
                return $row->user_type;
            })
            ->editColumn('wallets.transaction_reference', function($row){
                return $row->transaction_reference;
            })
            ->editColumn('wallets.order_type', function($row){
                return $row->order_type;
            })
            ->editColumn('wallets.description', function($row){
                return $row->description;
            })
            ->editColumn('wallets.payment_type', function($row){
                return $row->payment_type;
            })
            ->editColumn('credit_debit', function($row){
                if($row->credit_debit == 'credit'){
                    return '<span style="color:green;">' . $row->credit_debit . '</span>';
                }else{
                    return '<span style="color:red;">' . $row->credit_debit . '</span>';
                }
            })
            ->editColumn('wallets.amount', function($row){
                return $row->amount;
            })
            ->editColumn('wallets.total', function($row){
                return $row->total;
            })
            ->rawColumns(['credit_debit'])
            ->make(true);
    }

    public function exportMail(Request $request){
        $wallets = Wallet::select('wallets.*', 'users.name as name', 'users.user_type as user_type', 'users.email as email')
            ->join('users', 'users.id', '=', 'wallets.user_id')
            ->where('wallets.created_at', '>=', Carbon::now()->subDay())
            ->orderBy('wallets.id', 'DESC')
            ->get();
        //dd(strtotime('-24 hours', strtotime(date('Y-m-d H-i'))));
        Mail::to('admin@gmail.com')->send(new WalletsExportMail($wallets));

        return back()->with('success', 'Wallet data has been emailed to admin.'); 
    }
}
