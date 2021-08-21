$('#change').change(function(e) {
    var id = $(this).val();
    if(id==0){
        var url ='../fee';
    } else {
    var url ="../student/"+id;
    }
    window.location.replace(url);
    
});
$('#subchange').change(function(e) {
    var id = $(this).val();
    if(id==0){
        var url ='../subfee';
    } else {
    var url ="../sub/"+id;
    }
    window.location.replace(url);
    
});