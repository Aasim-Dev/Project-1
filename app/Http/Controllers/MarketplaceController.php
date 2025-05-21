<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Website;

class MarketplaceController extends Controller
{
    public function websiteData(Request $request){
        $query = Website::query();
        $search = $request->search['value'];
        if(isset($search)){
            $query->where(function($q) use ($search){
                $q->where('host_url', 'like', "%{$search}%");
            });
        }
        if ($request->min_da_filter) {
            $query->where('da', '>=', $request->min_da_filter);
        }

        if ($request->max_da_filter) {
            $query->where('da', '<=', $request->max_da_filter);
        }

        if ($request->min_price_filter) {
            $query->where('guest_post_price', '>=', $request->min_price_filter);
        }

        if ($request->max_price_filter) {
            $query->where('guest_post_price', '<=', $request->max_price_filter);
        }

        if ($request->category_filter && is_array($request->category_filter)) {
            $query->whereIn('normal_category', $request->category_filter);
        }

        if ($request->country_filter && is_array($request->country_filter)) {
            $query->whereIn('country', $request->country_filter);
        }

        if ($request->min_ahref_filter) {
            $query->where('ahref', '>=', $request->min_ahref_filter);
        }

        if ($request->max_ahref_filter) {
            $query->where('ahref', '<=', $request->max_ahref_filter);
        }

        if ($request->min_semrush_filter) {
            $query->where('semrush', '>=', $request->min_semrush_filter);
        }

        if ($request->max_semrush_filter) {
            $query->where('semrush', '<=', $request->max_semrush_filter);
        }

        if ($request->tat_filter) {
            $query->where('tat', $request->tat_filter);
        }

        if ($request->language_filter && is_array($request->language_filter)) {
            $query->whereIn('language', $request->language_filter);
        }

        if ($request->min_dr) {
            $query->where('domain_rating', '>=', $request->min_dr);
        }

        if ($request->max_dr) {
            $query->where('domain_rating', '<=', $request->max_dr);
        }

        if ($request->min_authority_filter) {
            $query->where('authority_score', '>=', $request->min_authority_filter);
        }

        if ($request->max_authority_filter) {
            $query->where('authority_score', '<=', $request->max_authority_filter);
        }

        if ($request->link_type_filter) {
            $query->where('link_type', $request->link_type_filter);
        }
        
        return $query;
    }
}
