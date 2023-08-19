@props(['disabled' => false])

<input maxlength="18" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
]) !!}>


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            if ($("#type").length) {

                $('#type').on('change', function() {

                    if ($('#type option:selected').text().trim() === 'PJ') {
                        $('#document').mask('00.000.000/0000-00', {
                            reverse: true
                        });
                    }

                    if ($('#type option:selected').text().trim() === 'PF') {
                        $('#document').mask('000.000.000-00', {
                            reverse: true
                        });
                    }
                });

                $('#type option:selected').change();
                return;
            }

            $("#document").mask("000.000.000-00", {
                onKeyPress: function(cpfcnpj, e, field, options) {
                    const masks = ["000.000.000-000", "00.000.000/0000-00"];
                    let mask = null;
                    if (cpfcnpj.length <= 14) {
                        mask = masks[0];
                    }
                    if (cpfcnpj.length > 14) {

                        mask = masks[1];
                    }

                    $("#document").mask(mask, options);
                }
            });
        });
    </script>
@endsection
