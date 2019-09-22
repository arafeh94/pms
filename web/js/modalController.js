(window).modalController = {
    show: function (url) {
        let self = this;
        $.ajax({
            type: "html",
            url: url,
            success: function (data) {
                let modal = $('#modal-controller');
                let body = $('#modal-controller-body');
                body.empty();
                body.append(data);
                modal.modal('show');
                self._func().end();
            }
        });
    },
    _func: function () {
        function end() {
            $('#modal-controller-loading').hide();
            $('#modal-controller-body').show();
        }

        return {
            end: end
        }
    }
};