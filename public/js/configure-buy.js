function uomBuilders(form, validBuilders)
{
    this.productId = jQuery(form).find('input[name="product_id"]').val();

    getBuilders().find('input, select').change(function(){
        updateUoms();
    });

    function updateUoms() {
        //selectedUom = getSelected(uoms);
        //if (jQuery(selectedUom).length) {
        //    this.selected_uom = selectedUom.data('uom_string');
        //}

        builderPid = 0;
        ids = [];
        getBuilders().each(function(){
            id = getChoiceId(getSelected(this));
            if (id) { ids.push(id) } else { return false }
        });

        jQuery.each(validBuilders, function(i, builder) {
            if (builder.sort().join(',') == ids.sort().join(',')) {
                builderPid = i;
            }
        });
        showUoms(builderPid)
        //selectUom();
    }

    function getBuilders() {
        return jQuery(form).find('.option.builder');
    }

    function getChoiceId(element) {
        choiceId = jQuery(element).val();
        if (choiceId) { return choiceId; } else { return false; }
    }

    function getSelected(element) {
        var radio = jQuery(element).find('input[type="radio"]:checked');
        if (jQuery(radio).length) { return radio; }
        var select = jQuery(element).find('select option:selected');
        if (jQuery(select).length) { return select; }
        return false;
    }

    function showUoms(builderPid) {
        var data = {
            'product_id' : productId,
        }
        if (builderPid !== 0) {
            data.builder_product_id = builderPid;
        }
        jQuery.post('/partial/uoms', data, function(html) {
            jQuery('#uoms').html(html);
        });
    }
}
//this.selectUom = function(uomString)
//{
//    if (!this.selected_uom) {
//        return false;
//    }
//    uoms.find('input:enabled[data-uom_string="'+selected_uom+'"]').attr('checked', 'checked');
//    delete selected_uom
//}
