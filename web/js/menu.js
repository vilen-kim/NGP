var page_id = 0;

function getAnchors(id) {
    $.ajax({
        url: '/menu/get-anchors',
        type: 'POST',
        data: {id},
        success: function (data) {
            $.each(data, function (index, value) {
                $("#anchor").append("<option value='" + value + "'>" + value + "</option>");
            });
        }
    });
};


$("#menuSave").on('click', function () {
    var arr = [];
    var menuPos = 1;
    var subMenuPos = 1;
    $("div.col-sm-8 > ul.ui-sortable a[data-id]").each(function () {
        var id = $(this).attr('data-id');
        var subMenu = $(this).parents('ul.subMenu');
        if (subMenu.length) {
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
        success: function (data) {
            console.log(data);
        }
    });
    return false;
});


$("#emptyPage").on("click", function () {
    if ($(this).prop("checked")) {
        $("#autoPage_id").attr("disabled", true);
        $("#page_id").val("0");
    } else {
        $("#autoPage_id").attr("disabled", false);
        $("#page_id").val(page_id);
    }
    console.log($("#page_id").val());
});


$("ul.subMenu > div").on("click", function () {
    var id = $(this).children("span").data("id");
    console.log(id);
});


// Получение подменю
$(".menuHeader").on('click', function (e) {
    var id = $(this).attr('id');
    $.ajax({
        url: '/site/get-submenu',
        type: 'POST',
        data: {id},
        success: function (result) {
            $("#subMenu").html(result);
        }
    });
    return false;
});