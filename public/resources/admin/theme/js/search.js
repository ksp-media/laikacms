Jbkcms.Search = {
    
    
    init: function(){
        $('#top-search').keyup(function(){
            Jbkcms.Search.request($('#top-search').val());
        })
    },
    
    setup: function(config){
        this.config = config;
    },
    
    request: function(val){
        if(this.config.route){
            $.get('/'+\KSPM\LCMS\_prefix+'/'+this.config.route + '?q=' + val, function(response){
                Jbkcms.Search.responseHandler(response)
            })
        }
    },
    
    responseHandler: function(result){
        $('#search-result').remove();
        $('#top-search').parent().append('<ul id="search-result"></ul>')
        $('ul#search-result').append(result).mouseleave(function(){$(this).fadeOut()}); 
        
    }
}

$(document).ready(function(){
    Jbkcms.Search.init();
})

