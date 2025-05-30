<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Http;
use App\Models\Website;

class MarketplaceController extends Controller
{

    public function fetchMarketplaceData(Request $request){
        $search = $request->search;
        $min_da = $request->min_da_filter;
        $max_da = $request->max_da_filter;
        $min_price = $request->min_price_filter;
        $max_price = $request->max_price_filter;
        $min_dr = $request->min_dr;
        $max_dr =$request->max_dr;
        $category = $request->input('category_filter', []);
        $country = $request->country_filter;
        $min_ahref = $request->min_ahref_filter;
        $max_ahref = $request->max_ahref_filter;
        $min_semrush = $request->min_semrush_filter;
        $max_semrush = $request->max_reuqest_filter;
        $minAuthority = $request->min_authority_filter;
        $maxAuthority = $request->max_authority_filter;
        $tat = $request->tat_filter;
        $marketplaceFilter = $request->marketplaceFilter;
        $language = $request->input('language_filter', []);
        $sortColumn = $request->input('sort_column', 'da'); 
        $sortOrder = $request->input('sort_order', 'desc');
        $link_type_filter = $request->link_type_filter;
        $query = Website::query();
        $api_category = is_array($category) ? implode(',', $category) : $category;
        //dd($category);
        if(is_array($language)){
            $language = implode(',', $language);
        }  
        if(!empty($min_da)){
            $query->where('da', '>=', $min_da);
        }
        if(!empty($max_da)){
            $query->where('da', '<=', $max_da);
        }
        if(!empty($min_price)){
            $query->where('guest_post_price', '>=', $min_price);
        }
        if(!empty($max_price)){
            $query->where('guest_post_price', '<=', $max_price);
        }
        if(!empty($category)){
            $query->where('normal_category', $category);
        }
        if(!empty($min_dr)){
            $query->where('dr', '>=', $min_dr);
        }
        if(!empty($max_dr)){
            $query->where('dr', '<=', $max_dr);
        }
        if(!empty($country)){
            $query->where('country', '=', $country);
        }
        if(!empty($min_ahref)){
            $query->where('ahref', '>=', $min_ahref);
        }
        if(!empty($max_ahref)){
            $query->where('ahref', '<=', $max_ahref);
        }
        if(!empty($min_semrush)){
            $query->where('semrush', '>=', $min_semrush);
        }
        if(!empty($max_semrush)){
            $query->where('semrush', '<=', $max_semrush);
        }
        if(!empty($tat)){
            $query->where('tat', $tat);
        }
        if(!empty($language)){
            $query->where('language', $language);
        }
        $start = $request->get('page', 1);
        $offset = $request->get('offset');
        $page = $start;
        $length = 25;
        $response = Http::withToken('B2tr8yxCoeN2sIASSfZq3bhdM4rpEP')->post('https://lp-latest.elsnerdev.com/api/fetch-inventory', [
            'page_no' => $page,
            'marketplaceType' => $marketplaceFilter,
            'per_page' => $length,
            'search' => $search,
            'min_da_filter' => $min_da,
            'max_da_filter' => $max_da,
            'category_filter' => $api_category,
            'min_price_filter' => $min_price,
            'max_price_filter' => $max_price,
            'country_filter' => $country,
            'language_filter' => $language,
            'min_ahref_filter' => $min_ahref,
            'max_ahref_filter' => $max_ahref,
            'min_semrush_filter' => $min_semrush,
            'max_semrush_filter' => $max_semrush,
            'min_dr' => $min_dr,
            'max-dr' => $max_dr,
            'tat_filter' => $tat,
            'sort_by' => $sortColumn,
            'sort_direction' => $sortOrder,
            'min_authority_filter' => $minAuthority,
            'max_authority_filter' => $maxAuthority,
            'link_type_filter' => $link_type_filter,
        ]);
    
        $data = $response->json();
        $items = $data['data']['items'] ?? [];
        $totalRecords = $data['data']['total_records'] ?? count($items);
        $totalPages = ceil($totalRecords / $length );
        $websites = $query->get();
        return response()->json(['status' => 'success', 'data' => $websites, 'items'=> $items, 'totalRecords' => $totalRecords, 'totalPages' => $totalPages]);
    }
}
