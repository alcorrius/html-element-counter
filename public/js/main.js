function init(){

    function setMessage(message) {
        $('#result div').first().remove();
        var div = document.createElement("DIV");
        var urlDiv = document.createElement("DIV");
        var text = document.createTextNode(message);
        urlDiv.appendChild(text);
        div.appendChild(urlDiv);
        document.getElementById("result").appendChild(div);
    }

    $("#url").keyup(function(event){
        if(event.keyCode == 13){
            $("#element").focus();
        }
    });

    $("#element").keyup(function(event){
        if(event.keyCode == 13){
            $("#countButton").click();
        }
    });

    $("#countButton").click(function(e) {
        var url = $('#url').val();
        var element = $('#element').val();

        if(url && element) {
            setMessage('Loading...');

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

                    if(json.success == false) {
                        setMessage(json.message);
                        return false;
                    }

                    $('#result div').first().remove();
                    var div = document.createElement("DIV");
                    var urlDiv = document.createElement("DIV");
                    var url = document.createTextNode("URL " + json.url_name + " Fetched on " + json.date + ", took " + json.response_time + "s.");
                    urlDiv.appendChild(url);
                    div.appendChild(urlDiv);

                    var elementDiv = document.createElement("DIV");
                    var element = document.createTextNode("Element <" + json.element_name + "> appeared " + json.count + " times in page.");
                    elementDiv.appendChild(element);
                    div.appendChild(elementDiv);

                    var statisticDiv = document.createElement("DIV");
                    var stat = document.createElement('p');
                    stat.innerHTML = "<strong>General Statistics:</strong>";
                    var stat1 = document.createElement('p');
                    stat1.innerHTML = json.statistic.totalUrl + " different URLs from " + json.domain + " have been fetched";
                    var stat2 = document.createElement('p');
                    stat2.innerHTML = "Average fetch time from " + json.domain + " during the last 24 hours hours is " + json.statistic.avgTime + "s";
                    var stat3 = document.createElement('p');
                    stat3.innerHTML = "There was a total of " + json.statistic.totalElement + " &#60;" + json.element_name +"&#62;" + " elements from " + json.domain;
                    var stat4 = document.createElement('p');
                    stat4.innerHTML = "Total of " + json.statistic.totalElementById + " &#60;" + json.element_name +"&#62;" + " elements counted in all requests ever made.";
                    statisticDiv.appendChild(stat);
                    statisticDiv.appendChild(stat1);
                    statisticDiv.appendChild(stat2);
                    statisticDiv.appendChild(stat3);
                    statisticDiv.appendChild(stat4);
                    div.appendChild(statisticDiv);

                    document.getElementById("result").appendChild(div);
                },
                error: function () {
                    setMessage('Error');
                }
            });
        } else {
            setMessage('Insert both URL and ELEMENT');
        }
    });
}
