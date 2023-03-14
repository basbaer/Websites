var table_food = "Food";
var col_mealId = "mealId";
var col_meal = "meal";
var col_eatenAt = "eatenat";
var col_amount = "amount";
var col_unit = "unit";


var meals = new Array();
var tableInfo = new Array();


function getTable() {
    $.ajax({
        url: 'rest.php',
        data: {
            action: 'getTable'
        },
        type: 'post',
        success: function (output) {
            buildTable(output);

        }

    })
}

function buildTable(json) {
    var table = document.getElementById("mealTable");
    tableInfo = JSON.parse(json);

    Object.entries(tableInfo).forEach((entry) => {
        const [id, mealInfo] = entry;
        var row = table.insertRow();
        var i = 0;
        Object.entries(mealInfo).forEach((infos) => {
            const [key, value] = infos;

            //Add the meal name to the meals Array
            if (key == col_meal) {
                meals[id] = value;
            }


            var cell = row.insertCell(i);
            if (i == 0) {
                cell.outerHTML = "<th scope='row'>".concat(value, "</th>");
            } else {
                cell.innerHTML = value;
            }
            i++;
        });

    });
    buildMealSelector();
};

function buildMealSelector() {
    //remove all options
    var select = document.getElementById('selectMeal');

    while (select.options.length > 0) {
        select.remove(0);
    }

    for (let i = 0; i < meals.length; i++){
         //add option to the selector
         var value = meals[i].concat(":").concat(i);
         var option = new Option(meals[i], value);

         select.add(option);
    }

    updateUnit(0);
};




function updateUnit(mealId) {
    //make query
    //note: ajax function does not work with 0 as action value
    action = 'getUnits'.concat(mealId);
    
    $.ajax({
        url: 'rest.php',
        data: {
            action: action
        },
        type: 'post',
        success: function (output) {
            createUnitSelector(output);

        }
    });

    function createUnitSelector(output) {
        
        //remove all options
        var select = document.getElementById('unit');

        while (select.options.length > 0) {
            select.remove(0);
        }


        //output will be all the different units seprated by comma
        units = output.split(";");
        units.forEach(createSelectorOption);

        function createSelectorOption(item) {
            //add option to the selector
            var option = new Option(item, item);

            select.add(option);
        }
    };
};

function addMeal(){
    $.ajax({
        url: 'rest.php',
        data: {
            action: 'addMeal'
        },
        type: 'post',
        success: function (output) {
            alert(output);

        }
    });

}

