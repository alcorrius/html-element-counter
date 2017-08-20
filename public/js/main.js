function init(){
    $("#countButton").click(function(e) {
        var url = $('#url').val();
        var element = $('#element').val();

        if(url && element) {
            console.log('fuck');
            $.ajax({
                url: 'counter/count',
                type: 'GET',
                data: {
                    url: url,
                    element: element
                },
                contentType: 'application/json; charset=utf-8',
                success: function (response) {
                    var json = JSON.parse(response);

                    $('#result div').first().remove();
                    var div = document.createElement("DIV");
                    var urlDiv = document.createElement("DIV");
                    var url = document.createTextNode("URL " + json.url + " Fetched on " + json.date + ", took " + json.response_time + "s.");
                    urlDiv.appendChild(url);
                    div.appendChild(urlDiv);

                    var elementDiv = document.createElement("DIV");
                    var element = document.createTextNode("Element <" + json.element + "> appeared " + json.count + " times in page.");
                    elementDiv.appendChild(element);
                    div.appendChild(elementDiv);

                    document.getElementById("result").appendChild(div);
                },
                error: function () {
                    console.log('counting error');
                }
            });
        }
    });
}
