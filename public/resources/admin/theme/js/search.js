LCMS.Search = {
    
    
    init: function(){
        $('#top-search').keyup(function(){
            LCMS.Search.request($('#top-search').val());
        })
    },
    
    setup: function(config){
        this.config = config;
    },
    
    request: function(val){
        $.get('/'+ laikacms_prefix+'/search/ajax?q=' + val, function(response){
            LCMS.Search.responseHandler(response)
        })
    },
    
    responseHandler: function(result){
        $('#search-result').remove();
        $('#top-search').parent().append('<ul id="search-result"></ul>')
        $('ul#search-result').append(result).mouseleave(function(){$(this).fadeOut()}); 
    }
}

$(document).ready(function(){
    LCMS.Search.init();
})

