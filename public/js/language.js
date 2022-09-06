$("#language").select2({
    templateResult: formatState,
   templateSelection: formatState
  });
 function formatState (state) {
  if (!state.id) { return state.text; }
  var text = state.element.outerHTML;
  text=text.substr(21,2);
  var $state = $(
   '<span ><i class="flag-icon flag-icon-' + text + '"> </i>  ' + state.text + '</span>'
  );
  return $state;
 }