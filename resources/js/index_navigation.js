$('#btnSearch').ready(function () {
    var $buttonSubmit = $('#btnSearch')
    var $inputSearch = $('#inputSearch')
    var thisUrl = $('#pageConstant').data('url')
    var activePage = $('.page-item.active .page-link').html()
    var $buttonPageLinks = $('.page-link')

    $buttonSubmit.on('click', function () {
        var query = {}
        if (!_.isEmpty($inputSearch.val())) {
            query['q'] = $inputSearch.val()
        }

        location.href = thisUrl + '?' + generateUrl(query)
    })

    $buttonPageLinks.each(function (index) {
        $(this).on("click", function(event){
            event.preventDefault()
            var url = $(this).attr('href')
            var query = {}
            if (!_.isEmpty($inputSearch.val())) {
                query['q'] = $inputSearch.val()
            }

            location.href = url +'&'+ generateUrl(query)
        });
    })

    function generateUrl(params) {
        var ret = [];
        $.each(params, function(key, value) {
            ret.push(encodeURIComponent(key) + '=' + encodeURIComponent(value))
        });
        return ret.join('&');
    }

    $.ajax({
        url: thisUrl+'/3',
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        }
    })
    .done(function(response) {
        console.log(response.bank_accounts)
    })
    .fail(function( jqXHR, textStatus ) {
        alert( "Request failed: " + textStatus )
    });
})
