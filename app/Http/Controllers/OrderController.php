<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Order;
use illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function orderData(Request $request){
        $user = Auth::user();
        $query = Order::where('advertiser_id', $user->id);
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
                return '<button class="open-chat" data-order-id="'.$row->id.'" data-user-id="'.$row->publisher_id.'">Chat</button>';
            })
            ->rawColumns(['host_url', 'action'])
            ->make(true);
    }

}
