/**
 * targeting
 */
    function getBoundary(ele){
        return $(ele).parentsUntil('.boundary').parent().first()
    }

    function getLinkerId(ele){
        return getBoundary(ele).attr('id');
    }

    function getForm(ele){
        return getBoundary(ele).find('form.live-form').first()
    }

    function getFormMessages(ele){
        return getForm(ele).find('div.form-messages').first()
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
        getPartial(data);
    })


/**
 *  auto-validate
 */
    $('.live-form input, .live-form textarea, .live-form select').live('change', function(){
        clearTarget();
        getFormMessages(this).addClass('target');
        var form = getForm(this)
        $.post('/catalogmanager/update-form/'+form.attr('id'), form.serializeArray(), function(html){
            $('.target').html(html)
            clearTarget()
        })
    })
    $('.live-form').live('submit', function(e){
        e.preventDefault();
    })


 /**
 * save a record
 */
    $('a.save-now').live('click', function(e){
        e.preventDefault();
        clearTarget();
        getBoundary(this).addClass('target');
        var form = getForm(this)
        $.post('/catalogmanager/update-record/'+form.attr('id'), form.serializeArray(), function(formHtml){
            $('.target').replaceWith(formHtml)
            clearTarget()
        })
    })


/**
 *  partial handling for new/existing records
 */
    $('.add-new').live("submit",function(e){
        e.preventDefault();
        targetListItems(this);
        newPartial($(this).serializeArray());
    })

    function doSort(){
        $('.list-items').sortable({
            opacity: 0.6,
            placeholder: 'sortable-placeholder',
            handle: '.sort-handle',
            axis: 'y',
            forcePlaceholderSize: true,
            update: function() {
                var data = {
                    order : $(this).sortable("toArray").toString(),
                }
                $.post(
                    "/catalogmanager/sort/" + $(this).attr('type') + '/' + $(this).attr('parent'),
                    data, function(res){
                        console.log(res);
                    }
                )
            }
        })
    }

    function newPartial(data){
        hideModal()
        $.post("/catalogmanager/new-partial", data, function(html){
            $('.target').append(html)
            initialCollapse('skip')
            $('.target').children().last().hide().addClass('appearing').slideDown(200, function(){
                $(this).removeClass('appearing', 200)
            })
            clearTarget()
            doSort()
        })
    }

    $('.remove-child').live("submit",function(e){
        alert('removing this!');
        e.preventDefault();
        targetListItems(this);
        var data = $(this).serializeArray();
        $.post('/catalogmanager/remove-child', data, function(response){
            if(response = true){
                getBoundary(this).addClass('removing').fadeOut(function(){
                   $(this).remove()
                });
            }
        });
    })


/**
 * make it easier on the eyes
 */

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
        var collapsing = $(headers).siblings('div.entity-content')
        if('expand' === action){
            $(collapsing).show()
            $(headers).find('i.icon-chevron-right').removeClass('icon-chevron-right').addClass('icon-chevron-down');
        }else{ //collapse
            $(collapsing).hide()
            $(headers).find('i.icon-chevron-down').removeClass('icon-chevron-down').addClass('icon-chevron-right');
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
