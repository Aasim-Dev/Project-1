@extends('layouts.advertiser')

@section('title', 'Website-List')

@section('styles')
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
        -webkit-user-select: none;
        -moz-user-select: none;    
        -ms-user-select: none; 
    }

    /* Main Container */
    #marketplace-container {
        display: flex;
        gap: 20px;
        padding: 20px;
        flex-wrap: wrap;
        background-color: #f9f9f9;
        font-family: Arial, sans-serif;
    }

    /* Filters Section */
    #marketplace-filters {
        flex: 1 1 300px;
        max-width: 350px;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    #marketplace-filters h1 {
        font-size: 20px;
        margin-bottom: 15px;
        color: #333;
    }

    /* Individual filter group */
    .filter-group {
        margin-bottom: 15px;
        display: flex;
        flex-direction: column;
    }

    .filter-group label {
        font-weight: bold;
        margin-bottom: 5px;
        color: #555;
    }

    .filter-group input,
    .filter-group select {
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .filter-group select[multiple] {
        height: auto;
        min-height: 80px;
    }

    /* Apply Button */
    #applyFilters {
        padding: 10px 15px;
        background-color: #3498db;
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        margin-top: 10px;
        transition: background-color 0.2s ease;
    }

    #applyFilters:hover {
        background-color: #2980b9;
    }

    /* Table Section */
    #marketplace-table {
        flex: 3 1 600px;
        overflow-x: auto;
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* DataTable Styling */
    #myTable {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    #myTable th,
    #myTable td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    #myTable th {
        background-color: #f1f1f1;
        font-weight: bold;
        color: #444;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        #marketplace-container {
            flex-direction: column;
        }

        #marketplace-filters,
        #marketplace-table {
            max-width: 100%;
        }
    }

</style>
@endsection

@section('content')
        <div id="marketplace-container">
            <div id="marketplace-filters">
                <label for="Filters"><h1>Filters:</h1></label>
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
                <div class="filter-group" id="linktype">
                    <label for="linktype">Link Type:</label>
                    <input type="radio" name="link_type_filter" id="dofollow" value="dofollow">
                    <label for="dofollow" >Do Follow</label>
                    <input type="radio" name="link_type_filter" id="nofollow" value="nofollow">
                    <label for="nofollow">No follow</label>
                </div>
                <!-- <input type="date" id="dateFilter" placeholder="Created After">     -->
                <button id="applyFilters">Apply Filters</button>
            </div>
            <div id="marketplace-table">
                <div class="guide-modal" style="display: none; position: fixed; top: 20%; left: 30%; width: 40%; background: white; padding: 20px; border: 1px solid #ccc; z-index: 9999;">
                    <h1 style="color:green">Guidelines:</h1>
                    <h4 class="guide-content"></h4>
                </div>
                <table id="myTable">
                    <thead>
                        <tr>
                            <th>Website</th>
                            <th>DA</th>
                            <th>Traffic</th>
                            <th>Semrush</th>
                            <th>Country</th>
                            <th>Guest Post Price</th>
                            <th>LinkInsertion Price</th>
                            <th>Action</th>
                            <th><i class="fas fa-ellipsis-h"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($websites as $website)
                            <tr>
                                <td><a href="{{$website->website_url}}">{{ $website->host_url }}</a><br><small>Category: {{ $website->normal_category }}</small></td>
                                <td>{{ $website->da }}</td>
                                <td>{{ $website->ahref_traffic }}</td>
                                <td>{{ $website->semrush }}</td>
                                <td>{{ $website->country }}</td>
                                <td>{{ $website->guest_post_price }}</td>
                                <td>{{ $website->linkinsertion_price }}</td>
                                <td><button class="add-to-cart" data-id="{{$website->id}}">+Add</button></td>
                                <td >
                                   <button class="views"
                                    data-rating="{{ $website->dr ?? 'NA' }}"
                                    data-spam="{{ $website->spam_score ?? 'NA' }}"
                                    data-lang="{{ $website->language ?? 'English' }}"
                                    data-guidelines="{{ $website->guidelines ?? 'NA' }}"><i class="fas fa-chevron-down"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection

@section('scripts')
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            // Set CSRF Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $('#myTable').DataTable({
                
                paging: true,
                lengthMenu: [25, 50],
                pageLength: 25,
                
                drawCallback: function () {
                    $('.views').on('click', function () {
                        toggleRow($(this)); 
                    });

                    // $('.views').each(function () {
                    //     toggleRow($(this));
                    // });
                }
            });
            $(document).on('click', '.guide-btn', function(){
                var guide = $(this).data('guide');
                $('.guide-content').html(guide);
                $('.guide-modal').fadeIn();
                $('.guide-modal').fadeOut(8000);
            });

            // 🔄 Shared row toggle function
            function toggleRow($button) {
                const tr = $button.closest('tr');
                const row = $('#myTable').DataTable().row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                } else {
                    const html = `
                        <div class="p-3 bg-white border rounded shadow-sm">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><strong>Domain Rating:</strong> ${$button.data('rating')}</li>
                                <li class="mb-2"><strong>Spam Score:</strong> ${$button.data('spam')}</li>
                                <li class="mb-2"><strong>Language:</strong> ${$button.data('lang')}</li>
                                <li><strong><button class="guide-btn" data-guide="${$button.data('guidelines')}">Guidelines</button></strong></li>
                            </ul>
                        </div>
                    `;
                    row.child(html).show();
                }
            }
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

            $('#myTable_filter input').unbind().bind('keyup', function(e) {
                if (e.key === 'Enter') {
                    $('#myTable').DataTable().search(this.value).draw();
                }
            });
            $('#applyFilters').on('click', function() {
                let table = $('#myTable').DataTable();
                let minDA = parseInt($('#daFilterMin').val()) || 0;
                let maxDA = parseInt($('#daFilterMax').val()) || 100;
                let selectedCategories = $('#categoryFilter').val();
                let minPrice = parseFloat($('#priceFilterMin').val()) || 0;
                let maxPrice = parseFloat($('#priceFilterMax').val()) || 10000;
                let selectedCountry = $('#countryFilter').val();
                let minAhref = parseInt($('#ahrefFilterMin').val()) || 0;
                let maxAhref = parseInt($('#ahrefFilterMax').val()) || 10000000000;
                let minSemrush = parseInt($('#semrushFilterMin').val()) || 0;
                let maxSemrush = parseInt($('#semrushFilterMax').val()) || 10000000000;
                let selectedTAT = $('#tatFilter').val();
                let selectedLanguage = $('#languageFilter').val();
                let minDR = parseInt($('#minDr').val()) || 0;
                let maxDR = parseInt($('#maxDr').val()) || 100;
                let minAuthority = parseInt($('#min_authority_filter').val()) || 0;
                let maxAuthority = parseInt($('#max_authority_filter').val()) || 100;
                let selectedLinkType = $('input[name="link_type_filter"]:checked').val();

                table.rows().every(function () {
                    let row = this.node();
                    $(row).show(); 
                });

                table.rows().every(function () {
                    let data = this.data(); 
                    let da = parseInt(data[1]);
                    let authority = parseInt(data[1]); 
                    let country = data[4];
                    let category = $(this.node()).find('small').text().replace('Category: ', '');

                    let daValid = da >= minDA && da <= maxDA;
                    let categoryValid = selectedCategories.length === 0 || selectedCategories.includes(category);
                    let countryValid = selectedCountry.length === 0 || selectedCountry.includes(country);

                    if (!(daValid && categoryValid && countryValid)) {
                        $(this.node()).hide(); 
                    }

                });
                table.draw();
                $('.views').on('click', function () {
                    toggleRow($(this)); 
                });
            });

            // STEP 1: Load cart item IDs and update buttons
            $.get('{{ route("website.cart") }}', function (response) {
                const cartItems = response.cart.map(id => id.toString());

                $('.add-to-cart').each(function () {
                    const websiteId = $(this).data('id').toString();

                    if (cartItems.includes(websiteId)) {
                        $(this).text("Remove from Cart").css("background-color", "#e74c3c");
                    }
                });

                updateCartCount(); // Set the count on page load
            });

            // STEP 2: Handle Add/Remove click
            $(document).on('click', '.add-to-cart', function () {
                const button = $(this);
                const websiteId = button.data('id').toString();
                //alert('add');
                $.ajax({
                    url: "{{route('cart.toggle')}}",
                    type: "POST",
                    data: {
                        website_id: websiteId,
                        _token: '{{csrf_token()}}',
                    },
                    success: function(response){
                        if (response.status === 'success') {
                            button.text("Remove from Cart").css("background-color", "#e74c3c");
                        } else if (response.status === 'removed') {
                            button.text("Add to Cart").css("background-color", "#2ecc71");
                        }
                        updateCartCount(); // Update the count on toggle
                    },
                });
            });

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