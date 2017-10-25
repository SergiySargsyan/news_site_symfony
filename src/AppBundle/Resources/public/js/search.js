$(document).ready(function () {
    $('#search-form').keyup(function(key) {
        if (this.value.length >= 1 || this.value == '') {
            var mydata = this.value;
            $.ajax({
                // url: '{{ path('test') }}', //twig
                method: 'GET',
                data: {data: mydata},
                success: function (m) {
                    var arr = [];
                    var tex = '';
                    for( var i = 0; i<m.length; i++){
                        arr.push((JSON.parse(m[i])));
                        var url = '{{ path("news_by_tag", {"name": "article"}) }}';
                        url = url.replace("article", arr[i].name)
                        console.log(url);
                        tex = tex + "<a class='list-group-item'  href=\"" + url + '"'+">"+arr[i].name+"</a>";
                    }
                    console.log(arr[0].name);
                    $(".search_result").html(tex).fadeIn();
                }
            })
        }
    })
})