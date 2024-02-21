$(document).ready(function(){
    $('#search').keyup(function(){
        var query = $(this).val();
        if(query !== ''){
            $.ajax({
                url: 'search.php',
                method: 'POST',
                data: {query: query},
                success: function(data){
                    $('#search-results').html(data);
                }
            });
        } else {
            $('#search-results').html('');
        }
    });
});
