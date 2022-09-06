
<!-- select -->
<script src="{{ asset('bower_components/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>

<!-- currency -->
<script src="{{ asset('js/currency.js') }}"></script>
<!-- language -->
<script src="{{ asset('js/country.js') }}"></script>

<!-- jquery-validation -->
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('bower_components/admin-lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote();
  })
</script>

<script>
$(document).ready(function () {
  const descriptionValue = '{!! $term->description ?? '' !!}';
  if(descriptionValue !== '') {
    $('.note-editable p').html( descriptionValue );
    $('#description').html( descriptionValue );
  }

  const descriptionOldValue = '{!! old( 'description') !!}';
  if(descriptionOldValue !== '') {
    $('.note-editable p').html( descriptionOldValue );
    $('#description').html( descriptionOldValue );
  }
  
});
</script>
