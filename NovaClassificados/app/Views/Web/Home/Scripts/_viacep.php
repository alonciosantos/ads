<script>
    $(document).on('change', '[name=zipcode]', function() {

        let zipcode = $(this).val();


        if (zipcode.length === 9) {
            zipcode = zipcode.replace('-', '');

            // fazer o ajax request para buscar as situações e categorias

            var url = "https://viacep.com.br/ws/" + zipcode + "/json/";

            $.get(url, function(response) {

                $('#form-pay').find('input[name="street"]').val(response.logradouro);
                $('#form-pay').find('input[name="neighborhood"]').val(response.bairro);
                $('#form-pay').find('input[name="city"]').val(response.localidade);
                $('#form-pay').find('input[name="state"]').val(response.uf);

                $('#form-pay').find('span.error-text').text('');

            }, 'json').fail(function() {

                toastr.error("Zipcode not found.")
            });


        }

    });
</script>