
(function ($) {

    $.fn.jassets = function (options) {
        return Jbkcms.AssetManager.show($(this), options);
    };

}(jQuery));

Jbkcms.Assets = {
    init: function () {
        this.initEditableContent();
        this.initUploadButton();
        this.initFolderTree();
    },
    initEditableContent: function () {
        $('.edit-attribute').each(function () {
            $(this).on('focus', function () {
                before = $(this).html();
            }).on('blur', function () {
                if (before != $(this).html()) {
                    $(this).trigger('change');
                }
            });

            $(this).on('change', function () {
                $.post('/' + laikacms_prefix + '/assets/folder/update', {'id': $(this).attr('data-id'), 'attribute': $(this).attr('data-attribute'), 'value': $(this).html()}, function () {
                    console.log('updated')
                })
            });
        });
    },
    initUploadButton: function () {
        $('.btn-upload').dropzone({
            url: "/" + laikacms_prefix + "/assets/upload/" + Jbkcms.Assets.currentFolderId,
            paramName: "file",
            success: Jbkcms.Assets.handleUpload,
            'previewsContainer': '.upload-preview'
        })
    },
    handleUpload: function (result) {
        response = $.parseJSON(result.xhr.response)
        response = response.file;
        var html = '<div class="file-box"><div class="file"><a href="' + response.filepath + '/' + response.filename + '" target="_blank"><span class="corner"></span>';
        if (response.filetype == 1) {
            html += '<div class="image"><img src="' + response.filepath + '/' + response.filename + '" class="img-responsive" alt="image"></div>';
        } else if (response.filetype == 2) {
            html += '<div class="icon"><i class="fa fa-film"></i></div>';
        } else if (response.filetype == 3) {
            html += '<div class="icon"><i class="fa fa-file"></i></div>';
        }

        if (Jbkcms.AssetManager.viewMode === "embeded") {
            html += '<a data-id="' + response.id + '" class="file-select" data-src="' + response.filepath + '/' + response.filename + '">\n\
                        <div class="file-name">' + response.filename + '<i class="fa fa-plus"></i></div>\n\
                    </a>';
            
            
        } else {
            html += '<div class="file-name">' + response.filename + ' </div></a></div></div>';
        }

        $('.file-box-cnt').prepend(html);
         if (Jbkcms.AssetManager.viewMode === "embeded") {
             window.Jbkcms.AssetManager.initFileActions();
         }


    },
    
    initFolderTree: function(){
         if ($('#assets-folder-tree')) {
        $('#assets-folder-tree').nestable({
            group: 1,
            maxDepth: 100,
        })
        $('#assets-folder-tree .tree-item').each(function () {
            $(this).unbind('click');
            $(this).unbind('mouseover');
            $(this).on('click', function () {
                location.href = '/' + laikacms_prefix + '/assets/folder/' + $(this).attr('data-id') + '?view='+Jbkcms.AssetManager.viewMode;
            });
        });
        $('#assets-folder-tree').on('change', function () {
            $.post('/' + laikacms_prefix + '/assets/folder/updatetree', {'foldertree': $('#assets-folder-tree').nestable('serialize')}, function (response) {
            })
        });
    }
    }
    
   
}

Jbkcms.AssetManager = {
    show: function (el, options) {
        el.click(function () {
            Jbkcms.AssetManager.currentTrigger = el;
            Jbkcms.AssetManager.currentCallback = options.success;
            Jbkcms.AssetManager.loadModal();
        })

    },
    loadModal: function () {
        $.get('/' + laikacms_prefix + '/assets/manager', function (response) {
            $('#assetmanager-modal').remove();
            $('body').append(response);
            $('#assetmanager-modal').modal('show');

        })
    },
    callSelectHandler: function (el) {
        Jbkcms.AssetManager.currentCallback({'src': el.attr('data-src'), 'id': el.attr('data-id')}, Jbkcms.AssetManager.currentTrigger)
        $('#assetmanager-modal').modal('hide');
    },
    initFileActions: function () {
        console.log('initFileActions');
        $('.file-select').each(function () {
            $(this).unbind('click');
            $(this).click(function () {
                window.parent.Jbkcms.AssetManager.callSelectHandler($(this));
            })
        })
    }
}

$(document).ready(function () {
    Jbkcms.Assets.init();
})


