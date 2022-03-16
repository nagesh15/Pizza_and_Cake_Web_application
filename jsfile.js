function checkCity() {
    const cities = ["udupi", "manipal"];

    var input = document.getElementById("city").value;
    var er =  document.getElementById("error");
    input = input.trim();
    var city=input.toLowerCase();
    if(city!=''){
        if(cities.includes(city)) {
            window.location.href = 'home.php';
        }else {
            er.innerHTML = "sorry we don't have a shop in " + city;
        }
    }

}

function decrementNum(qty) {
    var qt= document.getElementById(qty);

    if(qt.value <= 1) {
        qt.value = 1;
    }else {
        qt.value = parseInt(qt.value) - 1;
    }
}

function incrementNum(qty) {
    var qt= document.getElementById(qty);

    if(qt.value >= 5) {
        qt.value = 5;
    }else {
        qt.value = parseInt(qt.value) + 1;
    }
}

function manage_cart(pid,qt,type,prod_type) {
    if(type=='update' && prod_type=='cake'){
        var qty = jQuery("#"+pid+"qt").value;
    }else {
        var qty = document.getElementById(qt).value;
    }
    var qty = document.getElementById(qt).value;
    jQuery.ajax({
        url:'manage_cart.php', 
        type: 'post',
        data: 'pid='+pid+'&qty='+qty+'&type='+type+'&prod_type='+prod_type,
        success: function(result) {
            if(type=='update' || type=='remove') {
                window.location.href = 'cart.php';
            }

            jQuery('.cart-number').html(result);
        }
    });
}

function clickDel() {
    var otype = document.getElementById("otype").value;
    
    if(otype == "delivery") {
        window.location.href = '?oty=del';
    } else if (otype == "takeaway") {
        window.location.href = '?oty=take';
    }
}

function clickaddr() {
    console.log(document.getElementsByClassName("addre").value);
}