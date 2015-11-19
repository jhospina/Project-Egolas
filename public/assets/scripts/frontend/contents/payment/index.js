var quantity_max = 365;

$(document).ready(function () {
    $("#quantity-days-up").click(function () {
        var value = parseInt($("#quantity-days").html());
        $("#quantity-days").html(value + 1);
        calculateContributions(true);
    });

    $("#quantity-days-down").click(function () {
        var value = parseInt($("#quantity-days").html());
        $("#quantity-days").html(value - 1);
        calculateContributions(true);
    });

    $("#quantity-mount-up").click(function () {
        var value = parseFloat($("#quantity-mount").html());
        $("#quantity-mount").html(setMount(value + 1));
        calculateContributions(false);
    });

    $("#quantity-mount-down").click(function () {
        var value = parseFloat($("#quantity-mount").html());
        $("#quantity-mount").html(setMount(value - 1));
        calculateContributions(false);
    });
});


function calculateContributions(who) {
    var quantity = parseInt($("#quantity-days").html());
    var mount = parseFloat($("#quantity-mount").html());
    var num = 0;
    if (who) {
        //MONTO

        if (quantity < quantity_min) {
            quantity = quantity_min
            $("#quantity-days").html(quantity_min);
        }
        //Maximo
        if (quantity > quantity_max) {
            quantity = quantity_max;
            $("#quantity-days").html(quantity_max);
        }


        num = setMount(quantity * parseFloat(price_per_day));


        if (parseFloat(num) < parseFloat(setMount(quantity_min * price_per_day)))
            num = setMount(quantity_min * price_per_day);
        $("#quantity-mount").html(num);
    } else {
        //DIAS
        num = parseInt(mount / parseFloat(price_per_day));
        if (num < quantity_min)
            num = quantity_min;
        if (num > quantity_max)
            num = quantity_max;
        $("#quantity-days").html(num);

        mount = parseFloat($("#quantity-mount").html());
        quantity = parseInt($("#quantity-days").html());
        $("#quantity-mount").html(setMount(quantity * parseFloat(price_per_day)));
    }


    $("#result .mount").html($("#quantity-mount").html());
    $("#result .days").html($("#quantity-days").html());
    $("#mount").val($("#quantity-mount").html());
    $("#quantity").val($("#quantity-days").html());

}


function setMount(num) {
    return new Number(num).toFixed(2);
}