function deleteItem(el) {
    $('input.deleted-dates').val($('input.deleted-dates').val() + ',' + el.attr('data-id'))
    el.parent().parent().remove();
}


$('document').ready(function () {
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

    if ($('.sidebar')) {
        $('.sidebar-handle').each(function () {
            $(this).click(function () {
                var sidebar = $(this).parent().parent().parent();
                sidebar.toggleClass('supress');
                if ($(this).find('i').hasClass('fa-angle-left')) {
                    $(this).find('i').removeClass('fa-angle-left').addClass('fa-angle-right');
                } else {
                    $(this).find('i').removeClass('fa-angle-right').addClass('fa-angle-left');
                }

                if (sidebar.hasClass('supress')) {
                    $('.wrapper-content').css('margin-left', parseInt($('.wrapper-content').css('margin-left')) - 160);
                } else {
                    $('.wrapper-content').css('margin-left', parseInt($('.wrapper-content').css('margin-left')) + 160);
                }

                if (sidebar.hasClass('sidebar-tree') && sidebar.hasClass('supress')) {
                    $('.sub-sidebar').css('left', parseInt($('.sub-sidebar').css('left')) - 160);
                } else if (sidebar.hasClass('sidebar-tree') && !sidebar.hasClass('supress')) {
                    $('.sub-sidebar').css('left', parseInt($('.sub-sidebar').css('left')) + 160);
                }
            })
        })
    }



    $('.navbar-minimalize').click(function () {
        $('body').toggleClass('minibar');
        if ($('body').hasClass('minibar')) {
            if ($('.sidebar-tree').hasClass('supress')) {
                $('.sub-sidebar').css('left', 120);
            } else if (!$('.sidebar-tree').hasClass('supress')) {
                $('.sub-sidebar').css('left', 280);
            }
        }else {
            if ($('.sidebar-tree').hasClass('supress')) {
                $('.sub-sidebar').css('left', 240);
            } else if (!$('.sidebar-tree').hasClass('supress')) {
                $('.sub-sidebar').css('left', 400);
            }
        }
    })
    $('#btn-save').click(function () {
        $.post('/' + laikacms_prefix + '/cms/content/create', $('#content-form').serialize(), function (response) {
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
        $.get('/' + laikacms_prefix + '/cms/clearcache', function () {
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
        $('#page-structure .tree-item').each(function () {
            console.log('foo');
            $(this).unbind('click');
            $(this).unbind('mouseover');
            $(this).on('click', function () {
                location.href = '/' + laikacms_prefix + '/cms/page/' + $(this).attr('data-id') + '/edit';
            });
        });
        $('#page-structure').on('change', function () {
            $.post('/' + laikacms_prefix + '/cms/page/updatetree', {'pagetree': $('#page-structure').nestable('serialize')}, function (response) {
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

var LCMS = {}

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
        $.get('/' + laikacms_prefix + '/user/form/' + userid, function (response) {
            $('#user-form-modal').remove();
            $('body').append(response);
            $('#user-form-modal').modal('show')
            $('#user-form-modal-save').unbind('click');
            $('#user-form-modal-save').click(function () {
                $.post('/' + laikacms_prefix + '/user/form', $('#user-form').serialize(), function (response) {
                    $('#user-form-modal').modal('hide')
                    location.href = location.href;
                })
            })
        })
    }
}