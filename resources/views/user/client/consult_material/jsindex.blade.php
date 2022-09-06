<!-- BEGIN PAGE VENDOR JS-->
<script src="{{ asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>

<!-- BEGIN PAGE LEVEL JS-->
<script src="{{ asset('app-assets/js/scripts/data-tables.js') }}"></script>
<!-- END PAGE LEVEL JS-->

<script>
    var providerListStr = "{!! $filter['providerfilters'] ?? '' !!}";
    var brandListStr = "{!! $filter['brandfilters'] ?? '' !!}";
    var skuListStr = "{!! $filter['skufilters'] ?? '' !!}";
    var partnoListStr = "{!! $filter['partnofilters'] ?? '' !!}";
    var keywordListStr = "{!! $filter['keywordfilters'] ?? '' !!}";
    var radiusListStr = "{!! $filter['radiusfilters'] ?? '' !!}";
    var providerList =[];
    var brandList =[];
    var skuList =[];
    var partnoList =[];
    var keywordList =[];
    var radiusList =[];

    var perpage = "{!! $filter['perpage'] ?? '' !!}";
    if(perpage == '')
    {
        $('#perpageSelect').val(10);
        $('#perpage').val(10);
    }
    else
    {
        $('#perpageSelect').val(perpage);
        $('#perpage').val(perpage);
    }

    $('#downloadList').click(function(){
        $('#keywordfilters1').val($('#keywordfilters').val());
        $('#providerfilters1').val($('#providerfilters').val());
        $('#brandfilters1').val($('#brandfilters').val());
        $('#skufilters1').val($('#skufilters').val());
        $('#partnofilters1').val($('#partnofilters').val());
        $('#radiusfilters1').val($('#radiusfilters').val());

        $('#downloadForm').submit();
    });

    $('#providerfilters').val(providerListStr);
    $('#brandfilters').val(brandListStr);
    $('#skufilters').val(skuListStr);
    $('#partnofilters').val(partnoListStr);
    $('#radiusfilters').val(radiusListStr);
    $('#keywordfilters').val(keywordListStr);

    if(providerListStr != '')
        providerList = providerListStr.split('|');
    if(brandListStr != '')
        brandList = brandListStr.split('|');
    if(skuListStr != '')
        skuList = skuListStr.split('|');    
    if(partnoListStr != '')
        partnoList = partnoListStr.split('|');
    if(keywordListStr != '')
        keywordList = keywordListStr.split('|');
    if(radiusListStr != '')
        radiusList = radiusListStr.split('|');

    //setInitialState for filter
    for(i in keywordList)
    {
        add_keywordfilterChip(keywordList[i]);
    }

    for(i in providerList)
    {
        add_providerfilterChip(providerList[i]);
    }

    for(i in brandList)
    {
        add_brandfilterChip(brandList[i]);
    }

    for(i in skuList)
    {
        add_skufilterChip(skuList[i]);
    }

    for(i in partnoList)
    {
        add_partnofilterChip(partnoList[i]);
    }
    
    for(i in radiusList)
    {
        add_radiusfilterChip(radiusList[i]);
    }

    /*------------------------------------------------*/

    var providers = {!! $providers !!};
    var providersData = {};

    for (var i = 0; i < providers.length; i++) {
        providersData[providers[i]] = null; 
    }

    $('#filter-provider').autocomplete({
        data: providersData,
        limit: 5,
    }).change(function() {
        var autodata = "";
        for (i in providers) {
            if (providers[i].toString().trim().toLowerCase() == this.value.toString().trim().toLowerCase()) {
                autodata = providers[i];
            }
        }
        this.value = autodata;
        if(autodata != "" && autodata != null)
        {
            add_providerList();
        }
    });

    var brands = {!! $brands !!};
    var brandsData = {};

    for (var i = 0; i < brands.length; i++) {
        brandsData[brands[i]] = null; 
    }

    $('#filter-brand').autocomplete({
        data: brandsData,
        limit: 5,
    }).change(function() {
        var autodata = "";
        for (i in brands) {
            if (brands[i].toString().trim().toLowerCase() == this.value.toString().trim().toLowerCase()) {
                autodata = brands[i];
            }
        }
        this.value = autodata;
        if(autodata != "" && autodata != null)
        {
            add_brandList();
        }
    });

    var skus = {!! $skus !!};
    var skusData = {};

    for (var i = 0; i < skus.length; i++) {
        skusData[skus[i]] = null; 
    }

    $('#filter-sku').autocomplete({
        data: skusData,
        limit: 5,
    }).change(function() {
        var autodata = "";
        for (i in skus) {
            if (skus[i].toString().trim().toLowerCase() == this.value.toString().trim().toLowerCase()) {
                autodata = skus[i];
            }
        }
        this.value = autodata;
        if(autodata != "" && autodata != null)
        {
            add_skuList();
        }
    });

    var partnos = {!! $partnos !!};
    var partnosData = {};

    for (var i = 0; i < partnos.length; i++) {
        partnosData[partnos[i]] = null; 
    }

    $('#filter-partno').autocomplete({
        data: partnosData,
        limit: 5,
    }).change(function() {
        var autodata = "";
        for (i in partnos) {
            if (partnos[i].toString().trim().toLowerCase() == this.value.toString().trim().toLowerCase()) {
                autodata = partnos[i];
            }
        }
        this.value = autodata;
        if(autodata != "" && autodata != null)
        {
            add_partnoList();
        }
    });

    $(document).ready(function () {
        $("body").on("keyup","#filter-provider",function(e){
            if(e.keyCode == 13)
            {
                add_providerList();
            }
        });

        $('body').on('change', '#perpageSelect', function(){
            $('#perpage').val($('#perpageSelect').val());
            $('#filterForm').submit();
        });

        $("body").on("mouseover","tr",function(e){
            $(this).children(':first').children('img').show();
        });

        $("body").on("mouseout","tr",function(e){
            $(this).children(':first').children('img').hide();
        });

        $("body").on("keyup","#filter-brand",function(e){
            if(e.keyCode == 13)
            {
                add_brandList();
            }
        });
        $("body").on("keyup","#filter-sku",function(e){
            if(e.keyCode == 13)
            {
                add_skuList();
            }
        });
        $("body").on("keyup","#filter-partno",function(e){
            if(e.keyCode == 13)
            {
                add_partnoList();
            }
        });
        $("body").on("keyup","#filter-keyword",function(e){
            if(e.keyCode == 13)
            {
                add_keywordList();
            }
        });
        $("body").on("change","#filter-radius",function(e){
            add_radiusList();
        });
    });

    function add_providerList()
    {
        if($('#filter-provider').val() != '' && $('#filter-provider').val() != null)
        {
            
            for(i in providerList)
            {
                if(providerList[i].trim() == $('#filter-provider').val().trim())
                {
                    return;
                }
            }

            providerList.push($('#filter-provider').val());
            var strTmp = providerList.join('|');
            $('#providerfilters').val(strTmp);
            $('#filterForm').submit();
        }
    }

    function add_providerfilterChip(str)
    {
        $('#filter-list').append(`<div class="provider-chip chip cyan z-depth-2 white-text"><i class="material-icons chip-prefix">groups</i>` + str
                            + `<i onclick="onClickChip(this, 'provider');" class="material-icons close">close</i>
                        </div>`);
    }

    function add_brandList()
    {
        if($('#filter-brand').val() != '' && $('#filter-brand').val() != null)
        {
            
            for(i in brandList)
            {
                if(brandList[i].trim() == $('#filter-brand').val().trim())
                {
                    return;
                }
            }

            brandList.push($('#filter-brand').val());
            var strTmp = brandList.join('|');
            $('#brandfilters').val(strTmp);
            $('#filterForm').submit();
        }
    }

    function add_brandfilterChip(str)
    {
        $('#filter-list').append(`<div class="brand-chip chip indigo z-depth-2 white-text"><i class="material-icons chip-prefix">branding_watermark</i>` + str
                            + `<i onclick="onClickChip(this, 'brand');" class="material-icons close">close</i>
                        </div>`);
    }

    function add_skuList()
    {
        if($('#filter-sku').val() != '' && $('#filter-sku').val() != null)
        {
            
            for(i in skuList)
            {
                if(skuList[i].trim() == $('#filter-sku').val().trim())
                {
                    return;
                }
            }

            skuList.push($('#filter-sku').val());
            var strTmp = skuList.join('|');
            $('#skufilters').val(strTmp);
            $('#filterForm').submit();
        }
    }

    function add_skufilterChip(str)
    {
        $('#filter-list').append(`<div class="sku-chip chip amber z-depth-2 white-text"><i class="material-icons chip-prefix">shop</i>` + str
                            + `<i onclick="onClickChip(this, 'sku');" class="material-icons close">close</i>
                        </div>`);
    }

    function add_partnoList()
    {
        if($('#filter-partno').val() != '' && $('#filter-partno').val() != null)
        {
            
            for(i in partnoList)
            {
                if(partnoList[i].trim() == $('#filter-partno').val().trim())
                {
                    return;
                }
            }

            partnoList.push($('#filter-partno').val());
            var strTmp = partnoList.join('|');
            $('#partnofilters').val(strTmp);
            $('#filterForm').submit();
        }
    }

    function add_partnofilterChip(str)
    {
        $('#filter-list').append(`<div class="partno-chip chip blue z-depth-2 white-text"><i class="material-icons chip-prefix">confirmation_number</i>` + str
                            + `<i onclick="onClickChip(this, 'partno');" class="material-icons close">close</i>
                        </div>`);
    }

    function add_keywordList()
    {
        if($('#filter-keyword').val() != '' && $('#filter-keyword').val() != null)
        {
            
            for(i in keywordList)
            {
                if(keywordList[i].trim() == $('#filter-keyword').val().trim())
                {
                    return;
                }
            }

            keywordList.push($('#filter-keyword').val());
            var strTmp = keywordList.join('|');
            $('#keywordfilters').val(strTmp);
            $('#filterForm').submit();
        }
    }

    function add_keywordfilterChip(str)
    {
        var list = str.split(' ');    
        var str1 = list.join(', ');
        $('#filter-list').append(`<div class="keyword-chip chip green z-depth-2 white-text"><i class="material-icons chip-prefix">search</i>` + str1
                            + `<i onclick="onClickChip(this, 'keyword');" class="material-icons close">close</i>
                        </div>`);
    }

    function add_radiusList()
    {
        if($('#filter-radius').val() != '' && $('#filter-radius').val() != null)
        {
            
            for(i in radiusList)
            {
                if(radiusList[i].trim() == $('#filter-radius').val().trim())
                {
                    return;
                }
            }

            radiusList.push($('#filter-radius').val());
            var strTmp = radiusList.join('|');
            $('#radiusfilters').val(strTmp);
            $('#filterForm').submit();
        }
    }

    function add_radiusfilterChip(str)
    {
        $('#filter-list').append(`<div class="radius-chip chip purple z-depth-2 white-text"><i class="material-icons chip-prefix">location_on</i>` + str
                            + `<i onclick="onClickChip(this, 'radius');" class="material-icons close">close</i>
                        </div>`);
    }

    function onClickChip(ele, type)
    {
        var strtmps = ele.parentNode.innerHTML.split('<i onclick');
        var strtmps1 = strtmps[0].split('</i>');
        var text = strtmps1[1];
        if(type == 'provider')
        {
            providerList.splice(providerList.indexOf(text), 1);
            var strTmp = providerList.join('|');
            console.log(text);
            $('#providerfilters').val(strTmp);
            $('#filterForm').submit();
        }

        if(type == 'brand')
        {
            brandList.splice(brandList.indexOf(text), 1);
            var strTmp = brandList.join('|');
            $('#brandfilters').val(strTmp);
            $('#filterForm').submit();
        }

        if(type == 'sku')
        {
            skuList.splice(skuList.indexOf(text), 1);
            var strTmp = skuList.join('|');
            $('#skufilters').val(strTmp);
            $('#filterForm').submit();
        }

        if(type == 'partno')
        {
            partnoList.splice(partnoList.indexOf(text), 1);
            var strTmp = partnoList.join('|');
            $('#partnofilters').val(strTmp);
            $('#filterForm').submit();
        }

        if(type == 'keyword')
        {
            var tmp1 = text.split(', ');
            var text1 = tmp1.join(' ');
            keywordList.splice(keywordList.indexOf(text1), 1);
            var strTmp = keywordList.join('|');
            $('#keywordfilters').val(strTmp);
            $('#filterForm').submit();
        }

        if(type == 'radius')
        {
            radiusList.splice(radiusList.indexOf(text), 1);
            
            var strTmp = radiusList.join('|');
            $('#radiusfilters').val(strTmp);
            $('#filterForm').submit();
        }
    }
</script>