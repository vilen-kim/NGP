function getAnchors(id){
    $.ajax({
        url: '/menu/get-anchors',
        type: 'POST',
        data: {id},
        success: function(data){
            $.each(data, function(index, value){
                $("#anchor").append("<option value='" + value + "'>" + value + "</option>");
            });
        }
    });
};



$("#menuSave").on('click', function(){
    var arr = [];
    var menuPos = 1;
    var subMenuPos = 1;
    $("div.col-md-6 > ul.ui-sortable span[data-id]").each(function(){
        var id = $(this).attr('data-id');
        var subMenu = $(this).parents('ul.subMenu');
        if (subMenu.length){
            var parentID = subMenu.parents('h4').children().attr('data-id');
            arr.push(id + ';' + parentID + ';' + subMenuPos);
            subMenuPos++;
        } else {
            arr.push(id + ';' + 0 + ';' + menuPos);
            menuPos++;
            subMenuPos = 1;
        }
    });
    $.ajax({
        url: '/menu/save',
        type: 'POST',
        data: {arr},
        success: function(data){
            console.log(data);
        }
    });
    return false;
});