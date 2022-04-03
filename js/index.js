// Referencia de JQuery
var CardToppings = $('#card-toppings');

//Simulating a response json server
var ToppingList = 
{
    "Toppings":[
        {"name":"Pepperoni", "cost": 1, "img": "Pepperoni.jpg"},
        {"name":"Ham", "cost": 2, "img": "Ham.jpg"},
        {"name":"Italian sausage", "cost": 1, "img": "ItalianSausage.jpg"},
        {"name":"Bacon", "cost": 3, "img": "Bacon.jpg"},
        {"name":"Mushrooms", "cost": 2, "img": "Mushrooms.jpg"},
        {"name":"Black olives", "cost": 3, "img": "BlackOlives.jpg"},
        {"name":"Pineapple", "cost": 1, "img": "Pineapple.jpg"}
    ]
};

$( document ).ready(function() {
    getToppings();
    renderCardToppings(ToppingList);
});

function addDefinedTopping(topping){
    $.ajax({
        url: 'index.php?action=addTopping',
        data: {
            topping
        },
        success: function(result) {
            try {
                json = jQuery.parseJSON(result);
                console.log(json);
            } catch (e) {
                showError("Invalid JSON returned from server: " + result);
                return;
            }
            if (json["success"] === 0) {
                showError(json["errormsg"]);
            } else {
                $("#topping").val("");
                getToppings();
            }
        },
        error: function() {
            showError('Error Reaching index.php');
        }
    });
}

function addTopping() {
    $.ajax({
        url: 'index.php?action=addTopping',
        data: {
            topping: $("#topping").val()
        },
        success: function(result) {
            try {
                json = jQuery.parseJSON(result);
                console.log(json);
            } catch (e) {
                showError("Invalid JSON returned from server: " + result);
                return;
            }
            if (json["success"] === 0) {
                showError(json["errormsg"]);
            } else {
                $("#topping").val("");
                getToppings();
            }
        },
        error: function() {
            showError('Error Reaching index.php');
        }
    });
}

function getToppings() {
    $.ajax({
        url: 'index.php?action=getToppings',
        dataType:"JSON",
        success: function(json) {

            if (json["success"] === "0") {
                showError(json["errormsg"]);
            } else {
                console.log(json.toppings.length)
                if (json.toppings.length > 0) {
                    $("#listToppings").empty();
                    $.each(json.toppings, function(key, value) {
                        $("#listToppings").append(`<li class='list-group-item d-flex justify-content-between align-items-center'><span>` + value + `</span><button type='button' onClick='deleteTopping(`+key+`); reduceCost("`+value+`");' class='btn btn-danger'>Delete it</button></li>`);
                    });
                    $('p.hasToppings').show();
                    $('p.isEmpty').hide();
                    renderCountToppings(json.toppings.length);
                } else {
                    $("#listToppings").empty();
                    $('p.hasToppings').hide();
                    $('p.isEmpty').show();
                    renderCountToppings(0);
                }
            }
        },
        error: function(data) {
            console.log(data);
            showError('Error Reaching Server');
        }
    });
}

function deleteTopping(toppingId){
    console.log(toppingId);

    $.ajax({
        url: 'index.php?action=deleteTopping&toppingId='+toppingId,
        dataType: 'JSON',
        success: function(result) {

            if(result.success === 0){
                showError(result.message);
            }else{
                getToppings();
            }
        },
        error: function(xhr) {
            console.log(xhr);
            showError('Error Reaching Server');
        }

    });

}


/*
function updateCost(costToppings) {
    $.ajax({
        url: 'index.php?action=updateCost',
        data: {
            costTopping: costToppings
        },
        success: function(result) {
            try {
                json = jQuery.parseJSON(result);
                console.log(json);
            } catch (e) {
                showError("Invalid JSON returned from server: " + result);
                return;
            }
            if (json["success"] === 0) {
                showError(json["errormsg"]);
            } else {
                //getToppings();
            }
        },
        error: function() {
            showError('Error Reaching index.php');
        }
    });
}


function getCost() {
    console.log('h')
    $.ajax({
        url: 'index.php?action=getCost',
        dataType:"JSON",
        success: function(json) {
            console.log(json);

            if (json["success"] === "0") {
                showError(json["errormsg"]);
            } else {
                console.log(json.costTopping.length)
                if (json.toppings.length > 0) {

                } else {
                    updateToppingsCost(json.costTopping.costTopping)

                }
            }
        },
        error: function(data) {
            console.log(data);
            showError('Error Reaching Server');
        }
    });
}
*/
function renderCountToppings(length){
    $("#LengthToppings").empty();
    $("#LengthToppings").append(length);
}

function showError(message) {
    alert("ERROR: " + message);
}

function renderCardToppings(ToppingList){
    var html = '';

    for(var i=0; i < ToppingList.Toppings.length; i++) {

        html+=`<div class="col mb-5 animate__animated animate__fadeIn">`;
        html+=`	<div class="card h-100">`;
        html+=`		<img class="card-img-top" width="450" height="200" src="img/`+ToppingList.Toppings[i].img+`" alt="..." />`;
        html+=`		<div class="card-body p-4">`;
        html+=`			<div class="text-center">`;
        html+=`				<h5 class="fw-bolder">`+ToppingList.Toppings[i].name+`</h5>`;
        html+=`				$`+ToppingList.Toppings[i].cost+``;
        html+=`			</div>`;
        html+=`		</div>`;
        html+=`		<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">`;
        html+=`			<div class="text-center"><button type="button" onclick="addDefinedTopping('`+ToppingList.Toppings[i].name+`'); increaseCosts(`+ToppingList.Toppings[i].cost+`);" class="btn btn-warning">Add it!</button></div>`;
        html+=`		</div>`;
        html+=`	</div>`;
        html+=`</div>`;
    }

    CardToppings.html(html);
}

function increaseCosts(num){
    var lastCost = parseInt($('#ToppingsCost').text());
    NewCost = lastCost + num;
    updateToppingsCost(NewCost);
    updateTotalCost(NewCost);
}

function reduceCost(toppingName){
    toppingCost = null;

    for(var i=0; i < ToppingList.Toppings.length; i++) {
        if(ToppingList.Toppings[i].name == toppingName){
            console.log(ToppingList.Toppings[i]);
            toppingCost = ToppingList.Toppings[i].cost;
        }
    }

    if (toppingCost != null) {
        var lastCost = parseInt($('#ToppingsCost').text());
        NewCost = lastCost - toppingCost;
        updateToppingsCost(NewCost);
        updateTotalCost(NewCost);
    }

}



function updateToppingsCost(NewCost){
    NewCost = (Math.round(NewCost * 100) / 100).toFixed(2);
    $("#ToppingsCost").empty();
    $("#ToppingsCost").append(NewCost);
}


function updateTotalCost(NewCost){
    var total = 24.99;
    newTotalCost = total + NewCost;
    newTotalCost = (Math.round(newTotalCost * 100) / 100).toFixed(2);
    $("#TotalCost").empty();
    $("#TotalCost").append(newTotalCost);
}