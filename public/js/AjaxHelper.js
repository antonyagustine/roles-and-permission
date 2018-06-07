var AJAX = AJAX || {};
AJAX.AjaxHelper = {
    GETRequest: function (url, data, isAsync) {
        var responseData = {};
        $.ajax ({
            type: "GET",
            url: url,
            async: isAsync,
            data : data,
            //headers: '',
            success: function (response) {
                responseData = response;
            }
        });
        return responseData;
    },
    POSTRequest: function (url, postFields, isAsync) {
        var responseData = {};
        $.ajax({
            url: url,
            data: postFields,
            type: "POST",
            async: isAsync,
            success: function (dataval) {
                responseData = dataval;
            },
            error: function (response) {
                responseData = 111
            },
            failure: function (response) {
            }
        });
        return responseData;
    },
};
