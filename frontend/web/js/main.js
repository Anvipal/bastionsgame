/**
 * Created by Alexan on 02.06.2015.
 */
(function () {
    $(document).ready(function () {
        $.fn.serializeObject = function () {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function () {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };
        $('.popup-wrapper').on('click', function (e) {
            $('.popup').hide();
        });
    });
})();