
</div>
<!-- END layout-wrapper -->


<!-- JAVASCRIPT -->
<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

<!-- jquery.vectormap map -->
<script src="{{asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js')}}"></script>

<script src="{{asset('/')}}assets/libs/dropzone/min/dropzone.min.js"></script>

{{--<script src="{{asset('assets/js/pages/dashboard.init.js')}}"></script>--}}

<!-- App js -->
<script src="{{asset('assets/js/app.js')}}"></script>
{{--<script src="{{asset('assets/js/select2.js')}}"></script>--}}


<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{--<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>--}}
{{--@livewireScripts--}}
{{--<script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.x/dist/livewire-sortable.js"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script>


    $(document).ready(function() {

        $(document).ready(function () {
            $('#categorySelect').trigger('change');
        });


        $('.js-example-basic-single').select2();
        $('.js-example-basic-multiple').select2();

        $('.group-checkbox').on('click', function() {

            // $(this).prop('checked', !$(this).prop('checked'));
            var groupBoolean =  $(this).prop('checked');
            var groupValue = $(this).data('group');

            $('input[type="checkbox"][data-group="' + groupValue + '"]').each(function() {

                if(groupBoolean){
                    $(this).prop('checked', true);
                }else{
                    $(this).prop('checked', false);
                }

            });

        });

        $('.radio_input').click(function (){

            var delete_route = $(this).data('delete');
            var edit_route = $(this).data('edit');
            var deleteForm = $('.delete_form');
            $('.edit_form').attr('href', edit_route);
            deleteForm.attr('action', delete_route);
            deleteForm.find('[type="submit"]').prop('disabled', false);

        });

        $('tbody tr').on('click', function () {
            // Find the radio input within this row and trigger its click event
            $(this).find('.radio_input').trigger('click');
        });

        // Attach a click event handler to the radio inputs to prevent propagation
        $('.radio_input').on('click', function (event) {
            event.stopPropagation();
        });



        $('#editor_az, #editor_en, #editor_ru, #editor1_az, #editor1_en, #editor1_ru').summernote({
            height: 100,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });



    });
</script>
</body>

</html>
