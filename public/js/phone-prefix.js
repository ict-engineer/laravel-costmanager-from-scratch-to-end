$("#countrycodeSel").select2({
    templateResult: formatState,
   templateSelection: formatState,
   dropdownAutoWidth : true
}).change(function () {
    var text = $('#countrycodeSel').select2('data')[0].element.outerHTML;
    text=text.substr(26,2);
    text = text.toLowerCase();   
    $('#select2-countrycodeSel-container').html('<span ><i class="flag-icon flag-icon-' + text + '"> </i> +' +$(this).val() + '</span>'); 
    // change select2 span to the selected value
}).trigger('change');


 $("#countrycodeSel1").select2({
    templateResult: formatState,
   templateSelection: formatState,
   dropdownAutoWidth : true
}).change(function () {
    var text = $('#countrycodeSel1').select2('data')[0].element.outerHTML;
    text=text.substr(26,2);
    text = text.toLowerCase();   
    $('#select2-countrycodeSel1-container').html('<span ><i class="flag-icon flag-icon-' + text + '"> </i> +' +$(this).val() + '</span>'); 
    // change select2 span to the selected value
}).trigger('change');


function formatState (state) {
    if (!state.id) { return state.text; }
    var text = state.element.outerHTML;
    text=text.substr(26,2);
    text = text.toLowerCase();    
    var $state = $(
     '<span ><i class="flag-icon flag-icon-' + text + '"> </i>  ' + state.text + '</span>'
    );
    return $state;
   }