<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Post;

class MarketplaceController extends Controller
{
    public function websiteData(){
        $query = Post::query();
        return DataTables::of($query)
            ->addColumn('created_at', function($row){
                return $row->created_at;
            })
            ->addColumn('host_url', function($row){
                return '<a href="'. $row->website_url .'" target="_blank">' . $row->host_url . '</a>';
            })
            ->addColumn('da', function($row){
                return $row->da;
            })
            ->addColumn('sample_post', function($row){
                return $row->sample_post;
            })
            ->addColumn('country', function($row){
                return $row->country;
            })
            ->addColumn('normal', function($row){
                return $row->normal;
            })
            ->addColumn('other', function($row){
                return $row->other;
            })
            ->addColumn('guest_post_price', function($row){
                return $row->guest_post_price > 0 ? "$" . $row->guest_post_price : "-";
            })
            ->addColumn('linkinsertion_price', function($row){
                return $row->linkinsertion_price > 0 ? "$" . $row->linkinsertion_price : "-";
            })
            ->addColumn('action', function($row){
                return '<button class="add-to-cart" data-id="'.$row->id.'">Add to Cart</button>';
            })
            ->rawColumns(['host_url', 'sample_post', 'action'])
            ->make(true);
    }
}
