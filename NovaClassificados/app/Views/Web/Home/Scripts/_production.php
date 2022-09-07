<script type='text/javascript'>
    var s = document.createElement('script');
    s.type = 'text/javascript';
    var v = parseInt(Math.random() * 1000000);
    s.src = 'https://api.gerencianet.com.br/v1/cdn/12d57fc3400c205d9d4262c73cdf98ae/' + v;
    s.async = false;
    s.id = '12d57fc3400c205d9d4262c73cdf98ae';
    if (!document.getElementById('12d57fc3400c205d9d4262c73cdf98ae')) {
        document.getElementsByTagName('head')[0].appendChild(s);
    };
    $gn = {
        validForm: true,
        processed: false,
        done: {},
        ready: function(fn) {
            $gn.done = fn;
        }
    };
</script>