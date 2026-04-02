@push('js')
    <script>
        (function ($) {
            "use strict";

            $(document).ready(function () {
                $(document).on('click', '.modal-menu', function (e) {
                    e.preventDefault();
                    let selector = $('#dynamic-content');
                    let title = $(this).data('title');
                    let url = $(this).data('url'); // Get URL

                    if (title) {
                        $("#common-modal-title").text(title);
                    }

                    selector.html(''); // Clear content before loading
                    $('#modal-loader').show(); // Show loader (if you have one)

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'html',
                        success: function (data) {
                            selector.html(data);
                            $('#modal-loader').hide(); // Hide loader

                            // Initialize select2
                            $('.select2').select2({
                                dropdownParent: $('#common-modal')
                            });

                            // Initialize selectric
                            $('.selectric').selectric();

                            // Show modal after loading content
                            $('#common-modal').modal('show');
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log("AJAX Error: ", textStatus, errorThrown);
                            selector.html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                        }
                    });
                });
            });

        })(jQuery);
    </script>
@endpush
