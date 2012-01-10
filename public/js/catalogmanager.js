function doSort(){
    $('.list-items').sortable({ 
        opacity: 0.6, 
        placeholder: 'sortable-placeholder', 
        handle: '.sort-handle', 
        axis: 'y', 
        update: function() {
            //var order = $(this).sortable("serialize") + '&action=updateRecordsListings' 
            //$.post("updateDB.php", order, function(theResponse){
            //    $("#contentRight").html(theResponse)
            //}) 															 
        }
    })
}   

function entitySearch(trigger){
    var entityClass = trigger.attr('entityClass')
    var title = 'Search for '+entityClass+': "'+trigger.val()+'"'
    $.get("/catalogmanager/entity-search?className="+entityClass+"&value="+trigger.val(), function(html) {
        populateModal(html, title)
        clearTarget()
        $(trigger).parentsUntil('.list-wrap').parent().children('.list-items').first().addClass('target')
        $('#modal-box').modal('show')
    })
}

function clearTarget(){
    $('.target').removeClass('target')
}

$('.modal-search-result').live('click', function(){
    $.get("/catalogmanager/live-partial?className="+$(this).attr('className')+"&entityId="+$(this).attr('entityId'), function(html) {
        $('#modal-box').modal('hide')
        $('.target').append(html)
        scrollLiveTarget()
        doSort()
    })
})

function scrollLiveTarget(){
    initialCollapse()
    $('.target').children().last().hide().addClass('imported').slideDown(200, function(){
        $(this).removeClass('imported', 200)
    })
    $('.target').parent().prev('.import-one').removeClass('hide') //display the stuff that goes with the imported
    $('.target').next('.remove').remove()
    clearTarget()
}

function populateModal(html, title){
    if(!title){ var title="popup" }
    $('.modal-header h3').text(title) 
    $('.modal-body').html(html)
}

function appendPartial(ele){
    clearTarget()
    $(ele).parentsUntil('.list-wrap').parent().children('.list-items').first().addClass('target')
    $(ele).parentsUntil('.list-wrap').parent().children('.hide').first().clone().removeClass('hide') // clone
          .appendTo($(ele).parentsUntil('.list-wrap').parent().children('.list-items').first())       // append it
    scrollLiveTarget()
    doSort()  
}   

function appendPartialAjax(ele){
    clearTarget()
    $(ele).parentsUntil('.list-wrap').parent().children('.list-items').first().addClass('target');
    $.get("/catalogmanager/live-partial?className=option", function(html) {
        $('#modal-box').modal('hide');
        $('.target').append(html);
        scrollLiveTarget();
        doSort();
    }); 
};

function liveFormChanged(trigger){
    var title = $(trigger).parents('.entity').first().children('.entity-header').find('.entity-title')
    if(!$(title).data('text')){
        $(title).data('text',$(title).text());
        $(title).html('*****'+$(title).text()+'*****').addClass('notice')
    }
}

function entityOptions(trigger){console.log('options')}

function collapse(trigger){
    $(trigger).toggleClass('ui-icon-triangle-1-s ui-icon-triangle-1-e').parent().parent().siblings().slideToggle()
}
function initialCollapse(){
    $('.initialCollapse').toggleClass('ui-icon-triangle-1-s ui-icon-triangle-1-e')
        .removeClass('initialCollapse').parent().parent().siblings().hide()
}

$(document).ready(function(){

    
    $('.live-form input, .live-form textarea, .live-form select').live('change', function(){ liveFormChanged(this); })
    $('.addButton').live('click', function(){ appendPartial(this) })
    $('.addButtonAjax').live('click', function(){ appendPartialAjax(this) })
    $('.collapser').live("click", function(){ collapse(this) })
    $('.entity-title').live("dblclick", function(){ 
        $(this).text($(this).data('text')).removeClass('notice');
        $(this).data('text', null);
    })
    
    $('.import-modal').live("change", function(){
        entitySearch($(this)) 
        $(this).val('')
    })
    
    $('.new-choice').live("change", function(){
        appendPartial(this, $(this).val())
        $(this).val('')
    })

    $('.entity-header').live({
        mouseenter:function(){$(this).children().find('.remover').removeClass('hide')},
        mouseleave:function(){$(this).children().find('.remover').addClass('hide')}
    })

    $('.entity-title').live('contextmenu', function(e){
        e.preventDefault();
        entityOptions(this);
        return false;
    });

    $('.remover').live("dblclick", function(){
        $(this).parent().parent().parent().addClass('deported').slideUp(function(){$(this).remove()})
        console.log('remove');
    })

    $('.import-one-modal').live("change", function(){
        entitySearch($(this)) 
        $(this).val('')
    })
    
    initialCollapse()
    doSort()
})   
