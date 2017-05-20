/**
 * Created by ALA on 08-05-2017.
 */


//----------------------
//---show hide Departure Date Div
//-------------------------------------------
//-------------------------------------------

$("#show").click(function(){

    $("#departureDate").toggle();

    if ($("#departureDate").is(":visible"))
        $('#plus').removeClass().addClass('fa fa-minus');
    else
        $('#plus').removeClass().addClass('fa fa-plus');

});

$("#showSlot").click(function(){

    $("#slot2zone").show();

});