/**
 * targeting
 */
    function getBoundary(ele){ 
        return $(ele).parentsUntil('.boundary').parent().first() 
    }

    function getForm(ele){ 
        return getBoundary(ele).find('form').first() 
    }

    function targetListItems(trigger){
        clearTarget()
        $(trigger).parentsUntil('.list-wrap').parent().find('.list-items').first().addClass('target')
    }

    function targetTitle(ele){
        clearTarget()
        getBoundary(ele).find('.title').first().addClass('target')
    }

    function getCollapser(ele){
        return getBoundary(ele).find('div.collapser').first().children()
    }

    function getContent(ele){
        return getBoundary(ele).find('.entity-content').first()
    }

    function clearTarget(){ 
        $('.target').removeClass('target') 
    }


/**
 * modals 
 */
    function goModal(html, title){ 
        $('.modal-header h3').text(title) 
        $('.modal-body').html(html)
        $('#modal-box').modal('show')
    }

    function hideModal(){ 
        $('#modal-box').modal('hide') 
    }  


/**
 * searches
 */
    // search one class
    $('.import-search').live("submit", function(e){
        e.preventDefault();
        targetListItems(this); 
        $.post("/catalogmanager/search-class", $(this).serializeArray(), function(html) {
            goModal(html, 'Results')
        })  
    })
    
    // search many classes (catalog search)
    $('#catalog-search').live("submit", function(e){
        e.preventDefault()
        $.post("/catalogmanager/search-classes", $(this).serializeArray(), function(html) {
            goModal(html, 'Results')
        })
    })  

    $('.search-result').live("click", function(e){
        e.preventDefault();
        var data = $(this).parents('form.search-result-data').first().serializeArray();
        console.log(data);
        getPartial(data);
    })


/**
 *  auto-save
 */
    $('.live-form input, .live-form textarea, .live-form select').live('change', function(){
        targetTitle(this);
        var form = getForm(this)
        var parts = form.attr('id').split('-')
        $.post('/catalogmanager/update-record/'+parts[0]+'/'+parts[1], form.serializeArray(), function(title){
            $('.target').html('&nbsp; '+title)
        })    
    })
    $('.live-form').live('submit', function(e){
        e.preventDefault();
    })


/**
 *  partial handling for new/existing records
 */
    $('.add-partial').live("submit",function(e){
        e.preventDefault();
        targetListItems(this); 
        getPartial($(this).serializeArray());
    })

    function doSort(){
        $('.list-items').sortable({ 
            opacity: 0.6, 
            placeholder: 'sortable-placeholder', 
            handle: '.sort-handle', 
            axis: 'y',          
            forcePlaceholderSize: true,
            update: function() {
                var order = $(this).sortable('toArray').toString()//+ '&action=updateRecordsListings'      
                var segments = order.split(',');        
                console.log(segments);
                //$.post("updateDB.php", order, function(theResponse){
                //    $("#contentRight").html(theResponse)
                //}) 								 
            }
        })
    }       

    function getPartial(data){
        hideModal()
        $.post("/catalogmanager/fetch-partial", data, function(html){
            $('.target').append(html)
            if(data[1]['name'] === 'new_class_name' && data[1]['value']){
                initialCollapse('skip')
            }else{
                initialCollapse()
            }
            $('.target').children().last().hide().addClass('appearing').slideDown(200, function(){
                $(this).removeClass('appearing', 200)
            })
            clearTarget()
            doSort()  
        }) 
    }  

    $('.remover').live("dblclick", function(){
        var parts = getForm($(this)).attr('id').split('-')
        if($(this).attr('parentId')){
            var action = 'unlink'
        }else{
            var action = 'delete'
        }
        var data = {
            model:  parts[0],
            id:     parts[1],
            action: action,
        }
        $.post('/catalogmanager/remove', data)
        getBoundary(this).addClass('removing').fadeOut(function(){
            $(this).remove()
        })
    })  


/**
 * make it easier on the eyes  
 */
    $('.entity-header').live({
        mouseenter:function(){$(this).children('.remover').children().removeClass('hide')},
        mouseleave:function(){$(this).children('.remover').children().addClass('hide')}
    })

    $('.live-form').live({
        mouseenter:function(){$(this).css({opacity: 1.0})},
        mouseleave:function(){$(this).css({opacity: 0.7})},
    })

    $('.list-wrap').live({
        mouseenter:function(){$(this).children('.list-items-helper').animate({opacity: 1.0}, 100)},
        mouseleave:function(){$(this).children('.list-items-helper').animate({opacity: 0.2}, 100)},
    })

/**
 * collapse/expand stuff 
 */
    $('.expand-all').live('click', function(){
        collapseRecursively(this, 'expand')    
    })

    $('.collapse-all').live('click', function(){
        collapseRecursively(this)    
    }) 

    function collapseRecursively(ele, action){
        var headers = getBoundary(ele).children().find('.entity-header')
        var collapsing = $(headers).siblings('.entity-content')
        var collapsers = $(headers).find('.collapser')
        if('expand' === action){
            $(collapsing).show()
            var add = 'icon-arrow-up'
            var rem = 'icon-arrow-down'
            $(collapsers).removeClass(rem).addClass(add)
        }else{ //collapse
            $(collapsing).hide()
            var add = 'icon-arrow-up'
            var rem = 'icon-arrow-down'
            $(collapsers).removeClass(rem).addClass(add)
        }
    }

    $('.collapser').live("click", function(){
        getCollapser(this).toggleClass('icon-chevron-down icon-chevron-right')
        getContent(this).slideToggle(100)
    })

    function initialCollapse(skip){
        if(skip){
            //dont hide them, just remove the initialCollapse class (used for new partials)
            $('.initialCollapse').removeClass('initialCollapse')
        }else{
            $('.initialCollapse').toggleClass('icon-chevron-down icon-chevron-right')
                .removeClass('initialCollapse').parent().parent().siblings().hide()
        }
    }     

$(document).ready(function(){
    initialCollapse()
    doSort()
})
