$(document).ready(function() {
    menuHandle();
    searchData();
    chechForCheckAll();
    saveActions();
    editActions();
    closeModel();
    deleteAction();

    $(document).on('ifUnchecked', '.permission', function () {
        var cls = $(this).attr('class').split(' ').pop();
        $('input[data-child-class="'+cls+'"]').parent().removeClass('checked');
    });

    $(document).on('ifChecked', '.permission', function () {
        var obj = $(this);
        setTimeout(function () {
            checkCheckAll(obj);
        }, 100 ); 
    });

    $(document).on('change', '#rap_modules', function () {
        SaveRAP();
        var data = { 'module_id' : $(this).val(), role_id : roll_id };
        actions = AJAX.AjaxHelper.POSTRequest(get_action_url, data, false);
        $('#action').html(actions);
        setTimeout(function () {
            chechForCheckAll();
        }, 100);
    });

    ifChecked('.check-all');
    ifUnchecked('.check-all');

    $(document).on('submit', '#roles-and-permission', function(e) {
        e.preventDefault();
        SaveRAP();
        reloadPageWithMessage(store_trans, false)
    });

    $(document).on('ifChecked', '#select_all', function(e, parameters) {
        $("#rap_modules > option").prop("selected", "selected");
        $("#rap_modules").trigger("change");
    });

    $(document).on('ifUnchecked', '#select_all', function(e, parameters) {
        $("#rap_modules").val(null).trigger("change");
    });

});

/**
 * [ifChecked]
 * @param  {[str]} cls
 * @return {[void]}*/
 
function ifChecked(cls) {
    $(document).on('ifChecked', cls, function(e, parameters) {
        var cls = $(this).attr('data-child-class');
        $('input.'+cls).iCheck('check');
    });
}

/**
 * [ifUnchecked]
 * @param  {[str]} cls
 * @return {[void]}
 */
function ifUnchecked(cls) {
    $(document).on('ifUnchecked', cls, function(e, parameters) {
        var cls = $(this).attr('data-child-class');
        $('input.'+cls).iCheck('uncheck');
    });
}

/**
 * [SaveRAP]
 */
function SaveRAP() {
    var data = { role_id : roll_id }
    $(".permission").each(function () {
        if ($(this).parent().hasClass("checked"))
        data[$(this).attr("name")] = 1;
        else 
        data[$(this).attr("name")] = 0;
    });
    AJAX.AjaxHelper.POSTRequest(save_RAP_url, data, false);
}

/**
 * [chechForCheckAll]
 * @return {[void]}
 */
function chechForCheckAll() {
    $(".check-all").each(function () {
        checkCheckAll($("." + $(this).attr("data-child-class")));
    });
}

/**
 * [checkCheckAll]
 * @param  {[obj]} obj
 * @return {[void]}
 */
function checkCheckAll(obj) {
    var cls = $(obj).attr('class').split(' ').pop();
    var status = true;
    $("." + cls).each( function () {
        if (!$(this).parent().hasClass("checked"))
        status = false;
    });
    if (status) 
    $('input[data-child-class="'+cls+'"]').parent().addClass('checked');
}

/**
 * [menuHandle]
 * @return {[void]}
 */
function menuHandle() {
    $('ul.nav li.dropdown').hover(function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(100);
    }, function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(100);
    });

    $('.dropdown-menu a').click(function() {
        $('.dropdown-menu li').each(function(i) {
            $(this).removeClass('active')
        });
        
        $(this).parent().addClass('active')
    });

    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
}

/**
 * [searchData]
 * @return {[void]}
 */
function searchData() {
    var search = '';
    $(document).on('keyup', '#search', function(e) {
        if (e.keyCode == 13) {
            if ($('#search').val()) 
            search = $('#search').val();
            window.location.href = search_role_url+'/'+search;
        }
    });
}

/**
 * [saveActions]
 * @return {[void]}
 */
function saveActions() {
    $(document).on('click', '#save-actions', function (e) {
        e.preventDefault();
        var data = $('#rap-actions-form').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        AJAX.AjaxHelper.POSTRequest(save_action_url, data, false);
        $('#action-fields').modal('hide');
        assignDataForFields('', module_id, '');
        reloadPageWithMessage(store_trans, true)
    })
}

/**
 * [editActions]
 * @return {[void]}
 */
function editActions() {
    $(document).on('click', '#edit-action', function () {
        var data = { 'id': $(this).attr('data-id'), 'module_id': module_id };
        action = AJAX.AjaxHelper.GETRequest(edit_action_url, data, false);
        $('#action-fields').modal('show');
        assignDataForFields(action[0].id, action[0].module_id, action[0].action)
        
    });
}

/**
 * [deleteAction]
 * @return {[void]}
 */
function deleteAction() {
    $(document).on('click', '#delete-action', function() {
        if(confirm('Do you want to delete.?')) {
            var data = { 'id': $(this).attr('data-id')};
            AJAX.AjaxHelper.GETRequest(delete_action_url, data, false);
            reloadPageWithMessage(destroy_trans)
        }
    });
}

/**
 * [reloadPageWithMessage]
 * @param  {[str]}  msg
 * @param  {Boolean} reload
 * @return {[void]}
 */
function reloadPageWithMessage(msg, reload) {
    $('#alert-msg').removeAttr('style');
    $('div.alert-success').text(msg);
    $('div.alert').not('.alert-important').delay(3000).fadeOut(500);

    if (reload) {
        setTimeout(function() {
            location.reload();
        }, 700);    
    }
}

/**
 * [assignDataForFields]
 * @param  {Boolean || int} id
 * @param  {[int]}  module_id
 * @param  {Boolean || str} action
 * @return {[void]}
 */
function assignDataForFields(id, module_id, action) {
    $('#id').val(id);
    $('#module_id').val(module_id);
    $('#action').val(action);
}

/**
 * [closeModel]
 * @return {[void]}
 */
function closeModel() {
    $(document).on('click', '.close-model', function() {
        assignDataForFields('', module_id, '');
    })
}