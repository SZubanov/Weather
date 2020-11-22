$.fn.serializeCustomArray = function () {
    return this.map(function () {
        let elements = jQuery.prop(this, "elements");
        return elements ? jQuery.makeArray(elements) : this;
    }).filter(function () {
        let type = this.type;
        return this.name && this.value != '' && !jQuery(this).is(':disabled');
    }).map(function (index, element) {
        let rCRLF = /\r?\n/g;
        let type = this.type;

        let val = jQuery(this).val();
        if (val == null)
            return null;


        if (Array.isArray(val)) {
            return jQuery.map(val, function (val) {
                let option_name = jQuery(element).find('option:selected[value="' + val + '"]').text();
                return {type: type, option_name: option_name, name: element.name, value: val.replace(rCRLF, "\r\n")};
            });
        }

        let option_name = jQuery(element).find('option:selected').text();
        if (type == 'select-one')
            return {option_name: option_name, name: element.name, value: val.replace(rCRLF, "\r\n")};

        return {name: element.name, value: val.replace(rCRLF, "\r\n")};
    }).get();
};


$(document).ready(function () {
    $('table[data-type="datatable"]').each(function() {
        DatatableHelper.create($(this));
    });

    const SwallToast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
});


Main = {
    preloaderShow: function () {
        $('#preloader').toggleClass('d-none');
        $('#container-fluid').toggleClass('block-container')
    },
};

Model = {
    ajax_request: function (url, data = {}, method = 'GET', success = function(d){}, error = function(e){}) {
        $.ajax({
            type: method,
            url: url,
            cache: false,
            dataType: 'json',
            data: data,
            success: success,
            error: error
        });
    },

    update: function (form) {
        Main.preloaderShow();
        event.preventDefault();
        let data = $(form).serializeArray();
        let success = function (data) {
            Main.preloaderShow();
            if (data['action'] === 'reload_table') {
                dtListelements.ajax.reload(null, false);
            } else if (data['action'] === 'success') {
                toastr.success(data['success']);
            }
        }

        var error = function (data) {
            $.each(data.responseJSON.errors, function (index, error) {
                toastr.error(error[0]);
            });

            if (data.status && data.status === 403) {
                toastr.error('Недостаточно прав')
            }
        };

        Model.ajax_request(form.action, data, form.method, success, error)
    }
};

Weather = {
    get: function (url) {
        Main.preloaderShow();
        let data =  {_method: 'POST', _token: config.token};
        let success = function (data) {
            if (data['action'] === 'success') {
               DatatableHelper.reload('table');
            }
            Main.preloaderShow();

        }

        var error = function (data) {
                toastr.error(data.responseText);
                Main.preloaderShow();
         };

        Model.ajax_request(url, data, 'POST', success, error)
    }
}

