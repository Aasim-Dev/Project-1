<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\Website;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function index(){
        $categories = Category::all();
        $websites = Website::all();
        $orders = Order::all();
        $users = User::where('user_type', '!=', 'Admin')->get();
        return view('admin.dashboard', compact('categories', 'websites', 'orders', 'users'));
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
            ->join('posts', 'posts.id', '=', 'orders.website_id')
            ->join('users as publisher', 'publisher.id', '=', 'posts.user_id') // Publisher
            ->join('users as advertiser', 'advertiser.id', '=', 'orders.advertiser_id') // Advertiser
            ->orderBy('orders.id', 'DESC');
        $search = $request->search['value'];
        if(isset($search)){
            $query->where(function($q) use ($search){
                $q->where('host_url', 'like', "%{$search}%");
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
}
