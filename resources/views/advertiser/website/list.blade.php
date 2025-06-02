@extends('layouts.advertiser')

@section('title', 'Website-List')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #f4f6f8;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        user-select: none;
    }
    html, body {
        height: 100%;
        overflow: hidden;
    }
    .custom-ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .custom-ul .row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; 
        margin-bottom: 10px;
    }

    .custom-ul li {
        white-space: nowrap;
    }

    .search-bar-container {
        display: flex;
        justify-content: flex-end;
        padding: 5px 10px 0;
        gap: 4px;
    }

    .search {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 250px;
    }

    .search-btn {
        padding: 1px 2px;
        background-color: #3498db;
        width: 55px;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .search-btn:hover {
        background-color: #2980b9;
    }

    .pagination-btn {
        display: flex;
        justify-content: flex-end;
        padding: 20px 0;
    }

    .pagination-btn ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 8px;
    }

    .pagination-btn li a {
        display: block;
        padding: 8px 12px;
        background-color: #ecf0f1;
        color: #2c3e50;
        text-decoration: none;
        border-radius: 6px;
        transition: background 0.3s ease;
    }

    .pagination-btn li a:hover {
        background-color: #d0d7de;
    }

    .right-side{
        display: flex;
        flex: 1 1 300px;
        max-width: 350px;
    }

    #marketplace-container {
        height: calc(100vh - 60px); /* Adjust 60px if there's a navbar */
        display: flex;
        gap: 20px;
        padding: 20px;
        background-color: #f9f9f9;
        overflow: hidden;
    }

    #marketplace-filters {
        flex: 1 1 300px;
        max-width: 250px;
        padding: 20px;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        animation: fadeInLeft 0.6s ease-in-out;
    }

    #marketplace-filters h1 {
        font-size: 22px;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .filter-group {
        margin-bottom: 18px;
        display: flex;
        flex-direction: column;
    }

    .filter-group label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #34495e;
    }

    .filter-group input,
    .filter-group select {
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: box-shadow 0.3s ease;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.3);
    }

    .filter-group select[multiple] {
        height: auto;
        min-height: 90px;
    }

    #applyFilters {
        padding: 10px 20px;
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    #applyFilters:hover {
        background: linear-gradient(135deg, #2980b9, #2471a3);
    }

    #marketplace-table {
        flex: 3 1 600px;
        overflow-x: auto;
        background: #ffffff;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        animation: fadeInRight 0.6s ease-in-out;
    }

    #myTable {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        border-radius: 8px;
        overflow: hidden;
    }

    #myTable th,
    #myTable td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    #myTable th {
        background: #ecf0f1;
        font-weight: 700;
        color: #2c3e50;
    }

    .add-to-cart {
        padding: 6px 12px;
        border-radius: 6px;
        background: #2ecc71;
        color: white;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .add-to-cart:hover {
        background: #27ae60;
    }

    .views {
        background: none;
        border: none;
        cursor: pointer;
        color: #2980b9;
        transition: transform 0.3s ease;
    }

    .views:hover {
        transform: scale(1.1);
    }

    .guide-modal {
        display: none;
        position: fixed;
        top: 20%;
        left: 30%;
        width: 40%;
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        animation: fadeIn 0.4s ease;
    }
    #marketplace-filters,
    #marketplace-table {
        height: 100%;
        overflow-y: auto;
    }

    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @media (max-width: 768px) {
        #marketplace-container {
            flex-direction: column;
        }

        #marketplace-filters,
        #marketplace-table {
            max-width: 100%;
        }
    }
    @media (max-width: 768px) {
        #marketplace-container {
            flex-direction: column;
            height: auto;
            overflow: auto;
        }

        #marketplace-filters,
        #marketplace-table {
            max-height: 400px;
        }
    }
</style>
@endsection

@section('content')
        <div id="marketplace-container">
            <div id="marketplace-filters">
                <label for="Filters"><h1>Filters:</h1></label>
                <div class="mb-3" id="marketplacetype">
                    <label class="form-label d-block">Marketplace Type:</label>
                    
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="normal">Normal</label>
                        <input class="form-check-input" type="radio" name="marketplace_type_filter" id="normal" value="0" checked>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="marketplace_type_filter" id="forbidden" value="1">
                        <label class="form-check-label" for="forbidden">Forbidden</label>
                    </div>
                </div>
                <div name="da" id="da" class="filter-group">
                    <label for="da">DA Filter:</label>
                    <input type="number" id="daFilterMin" placeholder="Min DA">
                    <input type="number" id="daFilterMax" placeholder="Max DA">
                </div>
                <div name="categories" id="categories" class="filter-group">
                    <label for="categories">Categories:</label>
                    <select id="categoryFilter" name="category_filter[]" class="categoryFilter" multiple>
                        <option value="Health & Wellness">Health & Fitness</option>
                        <option value="Technology">Technology</option>
                        <option value="Agriculture">Agriculture</option>
                        <option value="Arts & Entertainment">Arts & Entertainment</option>
                        <option value="Beauty">Beauty</option>
                        <option value="Blogging">Blogging</option>
                        <option value="Business">Business</option>
                        <option value="Career & Employment">Career & Employment</option>
                        <option value="Ecommerce">Ecommerce</option>
                        <option value="Web Development">Web Development</option>
                    </select>
                </div>
                <div class="filter-group" id="country" >
                    <label for="country">Country:</label>
                    <select class="countryFilter" name="country_filter[]" id="countryFilter" multiple>
                        <option value="United States">United States</option>
                        <option value="India">India</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Canada">Canada</option>
                    </select>
                </div>
                <div class="filter-group" id="language">
                    <label for="language">Language:</label>
                    <select name="language_filter[]" id="languageFilter" class="languageFilter" multiple>
                        <option value="English">English</option>
                        <option value="Czech">Czech</option>
                        <option value="Dutch">Dutch</option>
                        <option value="Gujarati">Gujarati</option>
                    </select>
                </div>
                <div class="filter-group" id="price">
                    <label for="price">Price:</label>
                    <input type="number" id="priceFilterMin" placeholder="Min Price">
                    <input type="number" id="priceFilterMax" placeholder="Max Price">
                </div>
                <div name="ahref" id="ahref" class="filter-group">
                    <label for="ahref">Ahref:</label>
                    <input type="number" id="ahrefFilterMin" placeholder="Min Ahref">
                    <input type="number" id="ahrefFilterMax" placeholder="Max Ahref">
                </div>
                <div class="filter-group" id="semrush">
                    <label for="semrush">Semrush:</label>
                    <input type="number" id="semrushFilterMin" placeholder="Min Semrush">
                    <input type="number" id="semrushFilterMax" placeholder="Max Semrush">
                </div>
                <div class="filter-group" id="domainrating">
                    <label for="domainrate">Domain Rating:</label>
                    <input type="number" id="minDr" placeholder="Min DR">
                    <input type="number" id="maxDr" placeholder="Max DR">
                </div>
                <div class="filter-group" id="authorityscore">
                    <label for="authscore">Authority score:</label>
                    <input type="number" id="min_authority_filter" placeholder="Min Authority">
                    <input type="number" id="max_authority_filter" placeholder="Max Authority">
                </div>
                <div class="filter-group" id="tat">
                    <label for="tat">Tat:</label>
                    <select name="tat_filter[]" id="tatFilter" class="tatFilter">
                        <option value="">Select Tat</option>
                        <option value="1 day">1 day</option>
                        <option value="2 days">2 days</option>
                        <option value="3 days">3 days</option>
                        <option value="4 days">4 days</option>
                        <option value="5 days">5 days</option>
                        <option value="6 days">6 days</option>
                        <option value="7 days">7 days</option>
                        <option value="8 days">8 days</option>
                        <option value="9 days">9 days</option>
                        <option value="10 days">10 days</option>
                        <option value="11 days">11 days</option>
                        <option value="12 days">12 days</option>
                        <option value="13 days">13 days</option>
                        <option value="14 days">14 days</option>
                        <option value="15 days">15 days</option>
                        <option value="30 days">30 days</option>
                        <option value="60 days">60 days</option>
                    </select>
                </div>
                <div name="spam" id="spam" class="filter-group">
                    <label for="spam">Spam Filter:</label>
                    <input type="number" id="spamFilterMin" placeholder="Min spam Score">
                    <input type="number" id="spamFilterMax" placeholder="Max Spam Score">
                </div>
                <div name="trust" id="trust" class="filter-group">
                    <label for="trust">Trust FLow Filter:</label>
                    <input type="number" id="trustFilterMin" placeholder="Min Trust Flow">
                    <input type="number" id="trustFilterMax" placeholder="Max Trust Flow">
                </div>
                <div name="citation" id="citation" class="filter-group">
                    <label for="citation">Spam Filter:</label>
                    <input type="number" id="citationFilterMin" placeholder="Min Citation Flow">
                    <input type="number" id="citationFilterMax" placeholder="Max Citation Flow">
                </div>
                <div class="filter-group" id="linktype">
                    <label for="linktype">Link Type:</label>
                    <input type="radio" name="link_type_filter" id="dofollow" value="dofollow">
                    <label for="dofollow" >Do Follow</label>
                    <input type="radio" name="link_type_filter" id="nofollow" value="nofollow">
                    <label for="nofollow">No follow</label>
                </div>
                <button id="applyFilters">Apply Filters</button>
            </div>
            <div id="marketplace-table">
                <div class="search-bar-container">
                    <input type="text" class="search" id="search" name="search" placeholder="Search Your Website">
                    <input type="submit" class="search-btn" value="Submit">
                </div>
                <div class="guide-modal" style="display: none; position: fixed; top: 20%; left: 30%; width: 40%; background: white; padding: 20px; border: 1px solid #ccc; z-index: 9999;">
                    <h1 style="color:green">Guidelines:</h1>
                    <h4 class="guide-content"></h4>
                </div>
                <table id="myTable" class="table">
                    <thead class="table-light">
                        <tr>
                            <th class="sort" data-column="website" data-order="asc">Website</th>
                            <th class="sort" data-column="da" data-order="asc">DA</th>
                            <th class="sort" data-column="ahref" data-order="asc">Traffic</th>
                            <th class="sort" data-column="semrush" data-order="asc">Semrush</th>
                            <th class="sort" data-column="tat" data-order="asc">TAT</th>
                            <th class="sort" data-column="backlink" data-order="asc">Backlinks</th>
                            <th class="sort" data-column="guest_post_price" data-order="asc">Guest Post Price</th>
                            <th class="sort" data-column="linkinsertion_price" data-order="asc">LinkInsertion Price</th>
                            <th>Action</th>
                            <th><button class="open-every"><i class="fas fa-ellipsis-h"></i></button></th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                
                            </tr>
                            <tr class="details-row" style="display:none">
                                
                            </tr>
                    </tbody>
                </table>
                <div class="pagination-btn">
                    <ul>
                        <li><a class="page-btn" name="previous" id="previous" data-previous="0">Previous</a></li>
                        <li><a class="page-btn" name="next" id="next" data-next="1">Next</a></li>
                    </ul>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
    <script src ="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src ="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let page = 1;
        let offset = 0;
        $(document).ready(function () {
            // Set CSRF Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            fetchWebsites();
            $('#myTable').on('click', '.views', function () {
                let $currentRow = $(this).closest('tr');
                let $detailsRow = $currentRow.next('.details-row');

                $detailsRow.toggle();
            });
            $('.views').each(function () {
                $(this).trigger('click');
            });
            $(document).on('click', '.open-every', function(){
                $('.views').trigger('click');
            });
            $(document).on('click', '.sort', function(e) {

                let column = $(this).data('column');
                let order = $(this).data('order');
                order = order === 'desc' ? 'asc' : 'desc';
                $(this).data('order', order);

                fetchWebsites(column, order);
            });
            $(document).on('keypress keydown click', '.search-btn', function(){
                var search = $('#search').val();
                fetchWebsites();
            });
            $('#next').on('click', function(){
                var previous = $('#previous').attr('data-previous');
                var next = $('#next').attr('data-next');
                previous = parseInt(next);
                next = parseInt(next) + 1;
                offset = previous;
                page = next;
                $('#previous').attr('data-previous', previous);
                $('#next').attr('data-next', next);
                fetchWebsites();
                // $("html, body").animate({
                //     scrollTop: 0
                // }, "slow");
            });
            $('#previous').on('click', function(){
                var previous = $('#previous').attr('data-previous');
                if (previous == 0) {
                    $('#previous_page').addClass('disabled');
                    return false;
                }
                var next = $('#next').attr('data-next');
                next = previous;
                previous = parseInt(previous) - 1;
                next = parseInt(next);
                $('#previous').attr('data-previous', previous);
                $('#next').attr('data-next', next);
                page = next;
                offset = previous;
                fetchWebsites();
                // $("html, body").animate({
                //     scrollTop: 0
                // }, "slow");
            });
            $('input[name="marketplace_type_filter"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#applyFilters').trigger('click');
                }
            });        
            function fetchWebsites(column, order){
                var search = $('#search').val();
                var min_da_filter = $('#daFilterMin').val();  
                var max_da_filter = $('#daFilterMax').val();  
                var category_filter = $('#categoryFilter').val();  
                var min_price_filter = $('#priceFilterMin').val();  
                var max_price_filter = $('#priceFilterMax').val();
                var country_filter = $('#countryFilter').val();
                var min_ahref_filter = $('#ahrefFilterMin').val();
                var max_ahref_filter = $('#ahrefFilterMax').val();
                var min_semrush_filter = $("#semrushFilterMin").val();
                var max_semrush_filter = $("#semrushFilterMax").val();
                var tat_filter = $('#tatFilter').val(); 
                var language_filter = $('#languageFilter').val();
                var min_dr = $('#minDr').val();
                var max_dr = $('#maxDr').val();
                var min_authority_filter = $('#min_authority_filter').val();
                var max_authority_filter = $('#max_authority_filter').val();
                var link_type_filter = $('input[name="link_type_filter"]:checked').val();
                var marketplaceFilter = $('input[name="marketplace_type_filter"]:checked').val();
                var minSpamScore = $('#spamFilterMin').val();
                var maxSpamScore = $('#spamFilterMax').val();
                var minTrustFlow = $('#trustFilterMin').val();
                var maxTrustFlow = $('#trustFilterMax').val();
                var minCitationFlow = $('#citationFilterMin').val();
                var maxCitationFlow = $('#citationFilterMax').val();
                
                $.ajax({
                    url: "{{route('marketplace')}}",
                    type: "GET",
                    data: {
                        offset: offset,
                        search: search,
                        page: page,
                        sort_column: column,
                        sort_order: order,
                        min_da_filter: min_da_filter,
                        max_da_filter: max_da_filter,
                        category_filter: category_filter,
                        min_price_filter: min_price_filter,
                        max_price_filter: max_price_filter,
                        country_filter: country_filter,
                        min_ahref_filter: min_ahref_filter, 
                        max_ahref_filter: max_ahref_filter,
                        min_semrush_filter: min_semrush_filter,
                        max_semrush_filter: max_semrush_filter,
                        tat_filter: tat_filter,
                        language_filter: language_filter,
                        min_dr: min_dr,
                        max_dr: max_dr,
                        min_authority_filter: min_authority_filter,
                        max_authority_filter: max_authority_filter,
                        link_type_filter: link_type_filter,
                        marketplaceFilter: marketplaceFilter,
                        min_spam_score: minSpamScore,
                        max_spam_score: maxSpamScore,
                        min_citation_flow: minCitationFlow,
                        max_citation_flow: maxCitationFlow,
                        min_trust_flow: minTrustFlow,
                        max_trust_flow: maxTrustFlow,
                    },
                    success: function(response){
                        if(response.status === 'success'){
                            renderTable(response.items);
                        } else {
                            $('#myTable tbody').html('<tr><td colspan="10" class="text-center">No data found</td></tr>');
                        }
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                    },
                });
            }
            function renderTable(items) {
                var marketplaceFilter = $('input[name="marketplace_type_filter"]:checked').val();
                let tableBody = '';
                if(marketplaceFilter == 0){
                    items.forEach(item => {
                        tableBody += `
                        <tr>             
                            <td><a href="${item.website_url}">${item.host_url}</a><br><small>Category: ${item.category}</small></td>
                            <td>${item.da}</td>
                            <td>${(item.ahref > 100) ? item.ahref : '<100'}</td>
                            <td>${(item.semrush > 100) ? item.semrush : '<100'}</td>
                            <td>${item.tat}</td>
                            <td>${item.backlink_type}</td>
                            <td>${item.guest_post_price > 0 ? '$' + item.guest_post_price : item.forbidden_category_guest_post_price > 0 ? '$' + item.forbidden_category_guest_post_price : '-' }</td>
                            <td>
                                ${item.linkinsertion_price > 0 ? '$' + item.linkinsertion_price : item.forbidden_category_linkinsertion_price > 0 ? '$' + item.forbidden_category_linkinsertion_price : '-' }
                            </td>
                            <td><button class="add-to-cart" data-id="${item.id}" data-website="${item.website_id}" data-host="${item.host_url}" data-da="${item.da}" data-tat="${item.tat}"
                            data-ahref="${item.ahref}" data-semrush="${item.semrush}" data-guest="${item.guest_post_price}" data-link="${item.linkinsertion_price}">+Add</button></td>
                            <td><button class="views"><i class="fas fa-chevron-down"></i></button></td>
                        </tr>
                        <tr class="details-row" style="display:none">
                            <td colspan="10">
                                <div class="p-3 bg-white border rounded shadow-sm">
                                    <div class="container-fluid px-0">
                                        <div class="row mb-2">
                                            <div class="col-md-3"><strong>Domain Rating:</strong> ${item.domain_rating ?? 'NA'}</div>
                                            <div class="col-md-3"><strong>Authority:</strong> ${item.authority_score ?? 'NA'}</div>
                                            <div class="col-md-3"><strong>Spam Score:</strong> ${(item.spam_score > 0) ? item.spam_score + '%' : 'NA'}</div>
                                            <div class="col-md-3"><strong>Total Keywords:</strong> ${(item.article_count > 0) ? item.article_count : 'NA'}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3"><strong>Language:</strong> ${item.language ?? 'NA'}</div>
                                            <div class="col-md-3"><strong>Link Validity:</strong> ${item.domain_life_validity ?? 'NA'}</div>
                                            <div class="col-md-3"><strong>Trust FLow:</strong> ${item.trust_flow ?? 'NA'}</div>
                                            <div class="col-md-3"><strong>Citation Flow:</strong> ${item.citation_flow ?? 'NA'}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <button class="btn btn-sm btn-outline-primary guide-btn" data-guide="${item.guidelines}">
                                                    Guidelines
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </td>
                        </tr>`;   
                    });
                }else if(marketplaceFilter == 1){
                    items.forEach(item => {
                        tableBody += `
                        <tr>             
                            <td><a href="${item.website_url}">${item.host_url}</a><br><small>Category: ${item.category}</small></td>
                            <td>${item.da}</td>
                            <td>${(item.ahref > 100) ? item.ahref : '<100'}</td>
                            <td>${(item.semrush > 100) ? item.semrush : '<100'}</td>
                            <td>${item.tat}</td>
                            <td>${item.backlink_type}</td>
                            <td>${item.forbidden_category_guest_post_price > 0 ? '$' + item.forbidden_category_guest_post_price : '-' }</td>
                            <td>
                                ${item.forbidden_category_linkinsertion_price > 0 ? '$' + item.forbidden_category_linkinsertion_price : '-' }
                            </td>
                            <td><button class="add-to-cart" data-id="${item.id}" data-website="${item.website_id}" data-host="${item.host_url}" data-da="${item.da}" data-tat="${item.tat}"
                            data-ahref="${item.ahref}" data-semrush="${item.semrush}" data-guest="${item.guest_post_price}" data-link="${item.linkinsertion_price}">+Add</button></td>
                            <td><button class="views"><i class="fas fa-chevron-down"></i></button></td>
                        </tr>
                        <tr class="details-row" style="display:none">
                            <td colspan="10">
                                <div class="p-3 bg-white border rounded shadow-sm">
                                    <div class="container-fluid px-0">
                                        <div class="row mb-2">
                                            <div class="col-md-3"><strong>Domain Rating:</strong> ${item.domain_rating ?? 'NA'}</div>
                                            <div class="col-md-3"><strong>Authority:</strong> ${item.authority_score ?? 'NA'}</div>
                                            <div class="col-md-3"><strong>Spam Score:</strong> ${(item.spam_score > 0) ? item.spam_score + '%' : 'NA'}</div>
                                            <div class="col-md-3"><strong>Total Keywords:</strong> ${(item.article_count > 0) ? item.article_count : 'NA'}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3"><strong>Language:</strong> ${item.language ?? 'NA'}</div>
                                            <div class="col-md-3"><strong>Link Validity:</strong> ${item.domain_life_validity ?? 'NA'}</div>
                                            <div class="col-md-3"><strong>Trust FLow:</strong> ${item.trust_flow ?? 'NA'}</div>
                                            <div class="col-md-3"><strong>Citation Flow:</strong> ${item.citation_flow ?? 'NA'}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <button class="btn btn-sm btn-outline-primary guide-btn" data-guide="${item.guidelines}">
                                                    Guidelines
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </td>
                        </tr>`;   
                    });
                }
                $('#myTable tbody').html(tableBody);
                $('.views').each(function () {
                    $(this).trigger('click');
                });
                $(document).on('click', '.open-every', function(){
                    $('.views').trigger('click');
                });
                $.get('{{ route("website.cart") }}', function (response) {
                    const cartItems = response.cart.map(id => id.toString());

                    $('.add-to-cart').each(function () {
                        const websiteId = $(this).data('id').toString();

                        if (cartItems.includes(websiteId)) {
                            $(this).text("Remove").css("background-color", "#e74c3c");
                        }
                    });

                    updateCartCount();
                });
                $(document).on('click', '.add-to-cart', function () {
                    const button = $(this);
                    const websiteId = button.data('id').toString();
                    var website_id = button.data('website');
                    var hostUrl = button.data('host');
                    var da = button.data('da');
                    var tat = button.data('tat');
                    var semrush = button.data('semrush');
                    var gp_price = button.data('guest');
                    var li_price = button.data('link'); 
                    //alert('add');
                    $.ajax({
                        url: "{{route('cart.toggle')}}",
                        type: "POST",
                        data: {
                            website_id: website_id,
                            host_url: hostUrl,
                            da: da,
                            tat: tat,
                            semrush: semrush,
                            guest_post_price: gp_price,
                            linkinsertion_price: li_price,
                            _token: '{{csrf_token()}}',
                        },
                        success: function(response){
                            if (response.status === 'success') {
                                button.text("Remove").css("background-color", "#e74c3c");
                            } else if (response.status === 'removed') {
                                button.text("+Add").css("background-color", "#2ecc71");
                            }
                            updateCartCount(); // Update the count on toggle
                        },
                    });
                });
            }
            $(document).on('click', '.guide-btn', function(){
                var id = $(this).data('id');
                var guide = $(this).data('guide');
                $('.guide-content').html(guide);
                $('.guide-modal').fadeIn();
                $('.guide-modal').fadeOut(8000);
            });

            $(".categoryFilter, .countryFilter, .languageFilter").select2({
                placeholder: function() {
                    // Set dynamic placeholder based on element class
                    if($(this).hasClass("categoryFilter")) return "Select categories";
                    if($(this).hasClass("countryFilter")) return "Select country";
                    if($(this).hasClass("languageFilter")) return "Select Language";
                },
                allowClear: true,
                closeOnSelect: false
            });

            $(".categoryFilter").on("change", function() {
                table.ajax.reload(); 
            });

            $('#search').unbind().bind('keyup', function(e) {
                if (e.key === 'Enter') {
                    $('.search-btn').trigger('click');
                }
            });
            $('#applyFilters').on('click', function() {
                $('#previous').attr('data-previous', 0);
                $('#next').attr('data-next', 1);
                page = 1;
                fetchWebsites();
            });
                $.get('{{ route("website.cart") }}', function (response) {
                    const cartItems = response.cart.map(id => id.toString());

                    $('.add-to-cart').each(function () {
                        const websiteId = $(this).data('id').toString();

                        if (cartItems.includes(websiteId)) {
                            $(this).text("Remove").css("background-color", "#e74c3c");
                        }
                    });

                    updateCartCount();
                });

                // $(document).on('click', '.add-to-cart', function () {
                //     const button = $(this);
                //     const websiteId = button.data('id').toString();
                //     var website_id = button.data('website');
                //     var hostUrl = button.data('host');
                //     var da = button.data('da');
                //     var tat = button.data('tat');
                //     var semrush = button.data('semrush');
                //     var gp_price = button.data('guest');
                //     var li_price = button.data('link'); 
                //     //alert('add');
                //     $.ajax({
                //         url: "{{route('cart.toggle')}}",
                //         type: "POST",
                //         data: {
                //             website_id: website_id,
                //             host_url: hostUrl,
                //             da: da,
                //             tat: tat,
                //             semrush: semrush,
                //             guest_post_price: gp_price,
                //             linkinsertion_price: li_price,
                //             _token: '{{csrf_token()}}',
                //         },
                //         success: function(response){
                //             if (response.status === 'success') {
                //                 button.text("Remove").css("background-color", "#e74c3c");
                //             } else if (response.status === 'removed') {
                //                 button.text("+Add").css("background-color", "#2ecc71");
                //             }
                //             updateCartCount(); // Update the count on toggle
                //         },
                //     });
                // });

            // STEP 3: Count updater function
            function updateCartCount() {
                $.ajax({
                    url: "{{route('cart.count')}}",
                    type: "GET",
                    success: function(response){
                         $('#cart-count').text(response.count);
                    },
                });
            }
        });

    </script>
@endsection