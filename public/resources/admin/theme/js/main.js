
function deleteItem(el) {
    $('input.deleted-dates').val($('input.deleted-dates').val() + ',' + el.attr('data-id'))
    el.parent().parent().remove();
}


$('document').ready(function () {
    //$('.rte-text').wysihtml5({"size": 'sm', 'html': true});


    $('#add-date').click(function () {
        var row = $('.daterow-template').clone();

        $('table.date-table').append(row);
        var index = $('table.date-table tr').size() + 1;
        row.find('input').each(function () {
            $(this).val('')
            $(this).attr('name', $(this).attr('name').replace('%%ID%%', 'seminar[date][new-' + index))


        })
        row.removeClass('daterow-template');
        row.addClass('daterow');
        row.find('.date-delete').click(function () {
            deleteItem($(this));
        })
    })

    $('.date-delete').each(function () {
        $(this).click(function () {
            deleteItem($(this));
        })
    })
})

$('document').ready(function () {

    $('.navbar-minimalize').click(function () {
        if ($('body').hasClass('minibar')) {
            $('body').removeClass('minibar');
        } else {
            $('body').addClass('minibar');
        }
    })


    $('#btn-save').click(function () {
        $.post('/' + \KSPM\LCMS\_prefix + '/cms/content/create', $('#content-form').serialize(), function (response) {
            location.href = location.href;
        })
    })

    $('#content-form-modal').on('show.bs.modal', function (e) {
        $('.raw-edit').click(function () {
            var el = $(this).parent();
            el.find('.wysihtml5-sandbox').first().remove();
            $("body").removeClass("wysihtml5-supported");
            el.find("iframe.wysihtml5-sandbox, input[name='_wysihtml5_mode']").first().remove();
            el.find('.wysihtml5-toolbar').first().remove();
            el.find(".rte-text").first().css("display", "block");
            el.find(".rte-text").first().css("height", "90%");
        })
    })

    $('.btn-edit').each(function () {
        $(this).click(function () {
            $('#content-form-modal #key').val($(this).attr('data-key'));
            var content = $(this).parent().parent().find('td.value').attr('data-value');
            $('#content-form-modal #content-value').val(content);
            $('#content-form-modal').modal('show');
        })
    })

    $('.clear-cache').click(function () {
        $.get('/' + \KSPM\LCMS\_prefix + '/cms/clearcache', function () {
            Jbkcms.UI.sendNotification('Cache wurde gelöscht.');
        })
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });

    if ($('#page-structure')) {
        $('#page-structure').nestable({
            group: 1,
            maxDepth: 100,
        })
        $('.tree-item').each(function () {
            $(this).unbind('click');
            $(this).unbind('mouseover');
            $(this).on('click', function () {
                location.href = '/' + \KSPM\LCMS\_prefix + '/cms/page/' + $(this).attr('data-id') + '/edit';
            });
        });
        $('#page-structure').on('change', function () {
            $.post('/' + \KSPM\LCMS\_prefix + '/cms/page/updatetree', {'pagetree': $('#page-structure').nestable('serialize')}, function (response) {
            })
        });
    }

    $('.collapse').on('hide.bs.collapse', function () {
        var ci = $(this).parent().find('i.co-toggle');
        $(ci).removeClass('fa-minus').addClass('fa-plus');
    });

    $('.collapse').on('show.bs.collapse', function () {
        var ci = $(this).parent().find('i.co-toggle');
        $(ci).removeClass('fa-plus').addClass('fa-minus');
    });
})

var Jbkcms = {}

Jbkcms.UI = {
    sendNotification: function (message) {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        toastr.success(message);

    }
}

Jbkcms.User = {
    loadUserDetailModal: function (userid) {
        $.get('/' + \KSPM\LCMS\_prefix + '/user/form/' + userid, function (response) {
            $('#user-form-modal').remove();
            $('body').append(response);
            $('#user-form-modal').modal('show')
            $('#user-form-modal-save').unbind('click');
            $('#user-form-modal-save').click(function () {
                $.post('/' + \KSPM\LCMS\_prefix + '/user/form', $('#user-form').serialize(), function (response) {
                    $('#user-form-modal').modal('hide')
                    location.href = location.href;
                })
            })
        })
    }
}