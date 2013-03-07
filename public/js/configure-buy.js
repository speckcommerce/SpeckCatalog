var builders = { 2:[1,3], 3: [2,3], 4:[1,4], 5:[2,4], 6:[5], 7:[6] }
var productOptions = { 2:$('#group_3'), 3:$('#group_3'), 4:'', 5:'', 6:'' ,7:'' }
var productUoms = { 2:'', 3:'', 4:$('#uoms_1'), 5:$('#uoms_1'), 6:$('#uoms_1'), 7:$('#uoms_1') }

var depths = { 1:[] }

function getBuilderChoiceIds(depth)
{
    var choices = [];
    $('#options').find('div.builder').each(function(){
        var selected = findCheckedRadio(this) || findSelectedOption(this);
        if (selected) {
            choices.push(selected.data('choice_id'));
        }
    })
    choices = removeOtherDepthChoices(depth, choices);
    depths[depth] = choices;

    return choices;
}

function removeOtherDepthChoices(depth, choices)
{
    for(i in depths) {
        if (i != depth) {
            choices = removeChoiceIds(choices, depths[i]);
        }
    }
    return choices;
}

function removeChoiceIds(choiceIds, remove)
{
    var ids = [];
    for(c in choiceIds) {
        var match = false;
        for(r in remove) {
            if(remove[r] === choiceIds[c]) {
                match = true;
            }
        }
        if (!match) ids.push(choiceIds[c]);
    }
    return ids;
}

function findCheckedRadio(el)
{
    var checked = false;
    $(el).find("input:radio:visible").each(function(){
        if($(this).attr('checked') && $(this).prop('value')) {
            checked = $(this);
        }
    })
    return checked;
}

function findSelectedOption(el)
{
    var option = false;
    $(el).find("select:visible").find('option').each(function(){
        if ($(this).attr('selected') && $(this).prop('value')) {
            option = $(this);
        }
    })
    return option;
}

function removeDepthsAbove(depth)
{
    $('.group').each(function(){
        if ($(this).data('depth') > depth) {
            $(this).remove();
        }
    })
    $('#uom_to_cart').html('');
}

function getBuilderProductIdForChoices(choices)
{
    var id = ''
    for (key in builders) {
        var csv1 = builders[key].sort().join(',');
        var csv2 = choices.sort().join(',');
        if (csv1 === csv2) {
            id = key;
        }
    }
    return id;
}

function checkRequired(form)
{
    var check = true
    var nogos = []
    $(form).find('.required:visible').each(function(){
        if (!findCheckedRadio(this) && !findSelectedOption(this)) {
            $(this).addClass('no_go');
            check = false;
            if (false) {
                nogos.push($(this).data('title')); // dont prepend crumbs to the name
            } else {
                var names = addBranchName(this, [], '.group');
                nogos.push(names.join(' > '));
            }
        }
    })
    if (false === check) {
        return nogos;
    }
    return check;
}

function addBranchName(el, names, selector)
{
    names.unshift($(el).data('title'));

    var selector = selector === '.option' ? '.group' : '.option';
    parent = getParent(el, selector);
    if (parent) {
        addBranchName(parent, names, selector);
    }

    return names;
}

function getParent(el, selector)
{
    parents = $(el).parents(selector);
    if (parents.length > 0) {
        return parents.first();
    }
}

function getProductUoms(productId)
{
    var url  = '/partial/uoms'
    var data = { 'product_id' : productId }

    $.post(url, data, function(html) {
        return html;
    }
}

function getOptions(productId, depth)
{
    var url  = '/partial/options'
    var data = { 'product_id' : productId, 'depth' : depth }

    $.post(url, data, function(html) {
        return html;
    }
}

$(document).ready(function(){

    $('form#configure_and_buy').find('.builder:visible').find('input, select').live('change', function(){
        var depth = $(this).parents('.group').first().data('depth') || 1;
        removeDepthsAbove(depth);
        choices = getBuilderChoiceIds(depth);
        if (choices) {
            var productId = getBuilderProductIdForChoices(choices);
            if (productId) {
                optionHtml = getOptions(productId, depth);
                uomHtml    = getProductUoms($productId);
                $('#options').append(optionHtml);
                $('#uom_to_cart').html(uomHtml);
            }
        }
    });

    $('form#configure_and_buy').find('input, select').live('change', function(){
        group  = getParent(this, '.group');
        option = getParent(this, '.option');

        $(group).removeClass('no_go');                //remove groups no-go coloring
        $(group).find('.group').addClass('hide');     //hide all child option groups
        $(option).find('.group').removeClass('hide'); //unhide option groups nested under the selection
    });

    $('form#configure_and_buy').live('submit', function(e) {
        var check = checkRequired(this);
        if (check !== true) {
            alert("Please Check:\n\n" + check.join("\n"));
            return false;
        }
    });

});


